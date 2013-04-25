<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Geo extends CI_Controller {
	 
	 function __construct()
	 {
		 parent::__construct();
		 $this->logged_in();
		 
	 }
	 
var $data;
	 
	 public function logged_in(){
		 $logged_in = $this->session->userdata('logged_in');
		 
		 if(!isset($logged_in)|| $logged_in != true)
		 {
			 //echo 'You do not have permission to access this page.';
			 $this->data['header_content'] = 'includes/headerout';
		 }
		 else{

			$type = $this->session->userdata('usertype');
			//get the id value from the first pair in the array
			$type = $type[0]->m_type;

			if(isset($type) && $type == 'superuser')
			{
				$this->data['header_content'] = 'includes/headeradmin';
			}
			else
			{
				 $this->data['header_content'] = 'includes/headerin';
				 $this->load->model('inbox_model');
			   	//get the array of id's (there should just be one in the array)
				$id = $this->session->userdata('userid');
				//get the id value from the first pair in the array
				$id = $id[0]->m_id;

			   	$this->data['count_inbox'] = $this->inbox_model->countUnread($id);
		   }
		 }
	 }
	 
	 
function index(){
// Load the library and initalize the map
$this->load->library('googlemaps');

//get barterspots
$result = $this->db->get('barterspot');
$add = $result->result_array();

//load the map with the center focused at this lat & longitude
$config['center']="43.682373, -79.509167";
$config['zoom'] = 'auto';
$this->googlemaps->initialize($config);


//gets latitude and longitude for the first location
$latlng = $add[0]['lat'].',' . $add[0]['lng'];
//gets the address of the second location
$location2 =  "'". $add[1]['spot_address'] . "'";


//creates a marker on the map, with a content window when you click on it
$marker = array();	
$marker['position'] = $latlng;
$marker['infowindow_content'] = "<h1>This is Humber College North, Barterful's headquarters and original barterspot.</h1>";
$this->googlemaps->add_marker($marker);


//same as above
$marker = array();	
$marker['position'] = $location2;
$marker['infowindow_content'] = "<h1>This is Humber Lakeshore Campus. It's not as cool, but it tries.</h1>";
$this->googlemaps->add_marker($marker);

//get barterspot Array
$infoLocation = $this->getBarterspot();

//get user location based on ip
$lngUser = $infoLocation['user']['lng'];
$latUser = $infoLocation['user']['lat'];

//marker for the user
$marker = array();	
$marker['position'] = $latUser.','.$lngUser;
$marker['infowindow_content'] = 'This is you!';
$marker['icon']= "http://1.gravatar.com/avatar/b357aaf387437314ec4dac6ba60ea871?s=38&d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D38&r=G";
$this->googlemaps->add_marker($marker);

//creates the map
$this->data['map'] = $this->googlemaps->create_map();

// Load our view, passing the map data that has just been created
$this->data['main_content'] = 'location';
$this->data['barterspot'] = $infoLocation;
$this->load->view('includes/template',$this->data);


}


function getBarterspot(){	 
	//include below to get info based on ip address//
		$baseurl = base_url();
	
	include_once($baseurl."geo/geoip.inc");
	include($baseurl."/geo/geoipcity.inc");
	//("./geo/geoipregionvars.php");
	$gi = geoip_open($baseurl . './geo/GeoLiteCity.dat', GEOIP_STANDARD);

	//when we put this on the server we have to change ti to SERVER_ADDR
	$rsGeoData = geoip_record_by_addr($gi, '184.147.234.239');
	
	
	//get variables from the $rsGeoData object that stores IP location info
	$center_lat = $rsGeoData->latitude;
	$center_lng = $rsGeoData->longitude;
	//10 mile radius from a hotspot
	$radius = 200;
	
	$barterSpots = array();
	$barterSpots['user']['lat'] = $center_lat;
	$barterSpots['user']['lng'] = $center_lng;

	//query that gets the closest barterpot in 10 mile radius
	$query = sprintf("SELECT spot_name, lat, lng, ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM barterspot HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
	 $center_lat,
	 $center_lng,
	 $center_lat, 
	 $radius);

	 //get the results based on the radius specified above
	 $result = $this->db->query($query);
	 $barterspot = $result->result_array();
	
	 $num = $result->num_rows;
	 
	 //if there is are two barterspots within the raidus
	 if($num == 2){
		$barterSpots['num'] =  "You have $num barterspot locations near you <br/>";
		
		//get each sepearte barterspot
		$spot1 = $barterspot[0];
		$spot2 = $barterspot[1];
		
		//this array is accessed in the view location.php
		$barterSpots['spot1'] = $spot1;
		$barterSpots['spot2'] = $spot2;
		
		
		//get the distances of the barterspots
		$distance1 = $barterspot[0]['distance'];
		$distance2 = $barterspot[1]['distance'];
		
		//compare the distance between the two results
		if($distance1 > $distance2)
		{
			//save the name of the closer one
			$barterSpots['closest'] = $spot2['spot_name'];
		}
		
		else{
			$barterSpots['closest'] = $spot1['spot_name'];
		}	
		//initalize the index
		$barterSpots['far'] = "";
		$barterSpots['nameFar'] = "";
		
		//for the number of rows returned get the following info
		for ($row = 0; $row < $num; $row++){
	    $barterSpots['nameFar']  .=  "<br/>" . $barterspot[$row]["spot_name"]." is approximately ". round($barterspot[$row]["distance"]) . " miles away from you ";
	    
	    $barterSpots['far'] = round($barterspot[$row]["distance"]);
	    
	    return $barterSpots; 
	    }	    
}
    //if there is one barterspot within 10miles
    else if($num == 1){
		$barterSpots['num'] = "There is $num barterspot near you and it is ". $barterspot[0]		['spot_name'] . '. It is approximately ' . round($barterspot[0]['distance']) . ' miles away from you.';
    
	}
	//if there are no results
	else{
		$barterSpots['num'] = "There don't seem to be any barterspots near you. How unfortunate. ";
		return $barterSpots;
	}
	
	return $barterSpots;
}





}