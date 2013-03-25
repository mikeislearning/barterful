<?php 
class profile_model extends CI_Model {
	
	  var $original_path;
  var $resized_path;
  var $thumbs_path;
 
  //initialize the path where you want to save your images
  function __construct(){
    parent::__construct();
    //return the full path of the directory
    //make sure these directories have read and write permessions
    $this->original_path = realpath(APPPATH.'../uploads/original');
    $this->resized_path = realpath(APPPATH.'../uploads/resized');
    $this->thumbs_path = realpath(APPPATH.'../uploads/thumbs');
  }
  
function getProfile(){

$id = $this->session->userdata('userid');

		//get the id value from the first pair in the array
		$id = $id[0]->m_id;

//get the profile info based on the member
		$queryProfile = $this->db->query("
				Select p.p_id, p_fname, p_lname, p_img, p_last_updated
				FROM profiles p
				JOIN members m on p.m_id = m.m_id
				WHERE m.m_id =".$id);
				
				
		foreach($queryProfile->result() as $k=>$r)
		{
			$profile[]=$r;
		}

		return $profile;
		
		
	}	
	
function getMemberInfo() {
$id = $this->session->userdata('userid');

		//get the id value from the first pair in the array
		$id = $id[0]->m_id;
		
	$queryMember = $this->db->get_where('members', array('m_id'=>$id));
		
		foreach ($queryMember->result() as $k=>$r)
		{
			$member[]=$r;
		}
		
		return $member;
		
}	


function create_profile() {
	$this->load->helper('date');
	
$id = $this->session->userdata('userid');
$id = $id[0]->m_id;

//gets the time to be inserted into daabase
//$datestring = "%Y-%m-%d %h:%i:";
//$time = time();


$time =  date('Y-m-d H:i:s');

echo $time;


		//get the id value from the first pair in the array
		
		//getting the username from the post array storing it in username and getting the data ready to insert
		$username = $this->input->post('username');
		
		$new_profile_insert_data = array (
		'p_fname' => $this->input->post('first_name'),
		'p_lname' => $this->input->post('last_name'),
		'm_id' => 	$id,
		'p_last_updated' => $time		
				);
		//doing our update
		
//gets the id and updates the profile according to the m_id foreign key
$this->db->where('m_id', $id);
$this->db->update('profiles', $new_profile_insert_data); 
	}

	
	
	/*upload profile image*/
function do_upload_profile($data){


$upload_data = $data['upload_data'];
print_r($upload_data);
			
$filename = $upload_data['file_name'];



$id = $this->session->userdata('userid');
$id = $id[0]->m_id;
	 //echo $file_name;

    $this->load->library('image_lib');
    $config = array(
    'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
    'max_size'          => 2048, //2MB max
    'upload_path'       => $this->original_path, //upload directory
    'id' => $id
    );
    
    
    
    //get the time for the current update
    $time =  date('Y-m-d H:i:s');

//echo $time;


		//get the id value from the first pair in the array
		
		//getting the username from the post array storing it in username and getting the data ready to insert
		$username = $this->input->post('username');
		
		
		$update_profile_insert_data = array (
		'p_img'=> $filename,
		'm_id' => 	$id,
		'p_last_updated' => $time		
		//'m_username' => $this->input->post('username'),
		//'m_email' => $this->input->post('email'),
		//'m_sex' => $this->input->post('sex'),
		//we run the md5 function so we can store 32 bit hash in our database
		//'m_password' => md5($this->input->post('password'))
		);
		//doing our update
		
//gets the id and updates the profile according to the m_id foreign key
$this->db->where('m_id', $id);
$this->db->update('profiles', $update_profile_insert_data); 
	}
    
    
 }
 /*not sure if this is necessary
    $config = array(
    'file_name' =>  $id.$img_data['file_name'],
    'source_image'      => $image_data['full_path'], //path to the uploaded image
    'new_image'         => $this->resized_path, //path to
    'maintain_ratio'    => true,
    'width'             => 128,
    'height'            => 128
    );
 */
    //this is the magic line that enables you generate multiple thumbnails
    //you have to call the initialize() function each time you call the resize()
    //otherwise it will not work and only generate one thumbnail
    /*$this->image_lib->initialize($config);
    $this->image_lib->resize();
 
    $config = array(
    'source_image'      => $image_data['full_path'],
    'new_image'         => $this->thumbs_path,
    'maintain_ratio'    => true,
    'width'             => 36,
    'height'            => 36
    );*/
    //here is the second thumbnail, notice the call for the initialize() function again
   /* $this->image_lib->initialize($config);
    $this->image_lib->resize();
  }
*/

	 
