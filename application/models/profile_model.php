<?php 
class Profile_model extends CI_Model {
	
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
  
//this is from April 13th uploader test//
/*function do_upload(){
	$config = array(
	'allowed_types'=> 'jpg|jpeg|gif|png', // this is required
	'upload_path'=> $this->original_path //so is this
	);
	
	$this->load->library('upload', $config);
	//below is the upload function of the upload library
	$this->upload->do_upload();	return TRUE;
	
}*/
	
  //end April 13th uploader test//  
function getProfile($id){

	//get this own users id
	$myid = $this->session->userdata('userid');
	$myid = $myid[0]->m_id;

//get the profile info based on the member
$queryProfile = $this->db->query("
				Select p.p_id, p_fname, p_lname, p_img, p_last_updated, m.m_sex as m_sex, m.m_email as m_email, m.m_username as m_username
				FROM profiles p
				JOIN members m ON p.m_id = m.m_id
				WHERE m.m_id =".$id);
		/*$queryProfile = $this->db->query("
				Select p.p_id, p_fname, p_lname, p_img, p_last_updated
				FROM profiles p
				JOIN members m on p.m_id = m.m_id
				WHERE m.m_id =".$id);*/
	
	//if the user has already created a profile return their profile info
	if($queryProfile->num_rows == 1) {
			
			
		foreach($queryProfile->result() as $k=>$r)
		{
			$profile[]=$r;
		}
		

		return $profile;
	}
		
		//if they don't have a profile created yet
	else if ($id == $myid)
	$this->createProfile();
	else 
	{
		return "";
	}

			
		
}	
//createProfile	
function createProfile() {
	$this->load->helper('date');
	
//gets user id fmor session array	
$id = $this->session->userdata('userid');
$id = $id[0]->m_id;

//get the current time
date_default_timezone_set('America/New_York');
$time =  date('Y-m-d H:i:s');
//getting the username from the post array storing it in username and getting the data ready to insert
		$username = $this->input->post('username');
		
		$new_profile_insert_data = array (
		'p_fname' => $this->input->post('first_name'),
		'p_lname' => $this->input->post('last_name'),
		'm_id' => 	$id,
		'p_id' => $id,
		'p_last_updated' => $time		
				);
		//doing our update
		
//gets the id and updates the profile according to the m_id foreign key
$this->db->where('m_id', $id);
$this->db->insert('profiles', $new_profile_insert_data); 

redirect('members/profile', 'refresh');
}
	
	
	
function getMemberInfo() {
//gets member info for the includes/profile view
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


function updateProfile() {
$this->load->helper('date');
$id = $this->session->userdata('userid');
$id = $id[0]->m_id;

//gets the time to be inserted into daabase
//$datestring = "%Y-%m-%d %h:%i:";
//$time = time();
date_default_timezone_set('America/New_York');
$time =  date('Y-m-d H:i:s');

		
		//getting the username from the post array storing it in username and getting the data ready to insert
		$username = $this->input->post('username');
	
		$update_profile_insert_data = array (
		'p_fname' => $this->input->post('first_name'),
		'p_lname' => $this->input->post('last_name'),
		//'m_id' => 	$id,
		'p_last_updated' => $time		
				);
		//doing our update
		
//gets the id and updates the profile according to the m_id foreign key
$this->db->where('m_id', $id);
if($this->db->update('profiles', $update_profile_insert_data))
{ return TRUE; 
}
}


	/*upload profile image*/
function do_upload_profile(){
//$this->data['profile'] = $this->profile_model->getProfile();
//$this->data['member'] = $this->profile_model->getMemberInfo();

	$id = $this->session->userdata('userid');
	$id = $id[0]->m_id;
	
	//get the posted file name and change it before uploaded
	$newFileName = $_FILES['userfile']['name'];

	
	$filename = 'p_'.$id.'_'.$newFileName;
	

	
	$config = array(
				'allowed_types' => 'jpg|jpeg|gif|png',
				'upload_path' => $this->original_path,
				'max_size' => 1000,
				'max_width' => 1024,
				'max_height' => 768,
				'file_name' => $filename
				);
	//load the upload library with the config options 		
	$this->load->library('upload', $config);
	//do the upload and check if it successful
if(!$this->upload->do_upload()){
		return FALSE;
	}
else{
	$image_data = $this->upload->data();
	
	$config = array(
	'source_image'=> $image_data['full_path'],
	'new_image' => $this->resized_path,
	'maintain_ration' => true,
	'width' => 150,
	'height' => 100
	);
	$this->load->library('image_lib', $config);
	$this->image_lib->resize();
		
	//$this->load->library('upload', $config);
				

	/*if (!$this->upload->do_upload()){
		//$error = array('error' => $this->upload->display_errors());
		$this->data['error'] = "usuccessful";
		//$this->load->view('profile_form', $data);
		$this->data['main_content']='profile_form';
	 	$this->load->view('includes/template', $this->data);
	 	return;
	 	}
	 	
	else{ 
		$this->load->library('image_lib');
		
		$data = array('upload_data' => $this->upload->data());			
		//if($query = $this->profile_model->do_upload_profile($data)){
		$this->data['profile_updated'] = "Your profile has been updated";
		$this->data['main_content']='profile_form';
	 	$this->load->view('includes/template', $this->data);
		} */
		//$this->load->view('upload_success');
		//$this->load->view('profile_form', $data);

///////////////////

/*echo $filename;
$id = $this->session->userdata('userid');
$id = $id[0]->m_id;
	 //echo $file_name;

    $this->load->library('image_lib');
    $config = array(
    'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
    'max_size'          => 2048, //2MB max
    'upload_path'       => $this->original_path, //upload directory
    ); 
    */
   	 //get the time for the current update
		date_default_timezone_set('America/New_York');
   		 $time =  date('Y-m-d H:i:s');
		//getting the username from the post array storing it in username ready to insert
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
$update = $this->db->where('m_id', $id);
$update = $this->db->update('profiles', $update_profile_insert_data); 
//leave this so that controller knows if it was successful
return TRUE;
	}
    }

    public function deleteSP($spid,$table)
    {
		//set the timezone so that the time inputs correctly
		date_default_timezone_set('America/New_York');
		$date = date('Y-m-d H:i:s');

		switch($table)
		{
			case "skills":
				$table = 'skill_profiles';
				$id = 'sp_id';
			break;
			case "wants":
				$table = 'want_profiles';
				$id = 'wp_id';
			break;
			case "projects":
				$table = 'want_profiles';
				$id = 'wp_id';
			break;
		}

		$this->db->where($id, $spid);
		$this->db->delete($table);

    }

	public function updateSP($spid,$sid,$spheading,$spdetails,$expiry,$spkeywords,$myid,$table)
	{
		//set the timezone so that the time inputs correctly
		date_default_timezone_set('America/New_York');
		$date = date('Y-m-d H:i:s');

		$expiry = date('Y-m-d H:i:s', strtotime($expiry));

		switch($table)
		{
			case "skills":
				$table = 'skill_profiles';
				$id = 'sp_id';
				$data = array(
		           's_id' => $sid,
		           'sp_heading' => $spheading,
		           'sp_details' => $spdetails,
		           'sp_keywords' => $spkeywords
		        );
			break;
			case "wants":
				$table = 'want_profiles';
				$id = 'wp_id';
				$data = array(
		           's_id' => $sid,
		           'wp_heading' => $spheading,
		           'wp_details' => $spdetails,
		           'wp_keywords' => $spkeywords,
		           'wp_expiry' => $expiry
		        );
			break;
			case "projects":
				$table = 'want_profiles';
				$id = 'wp_id';
				$data = array(
		           's_id' => $sid,
		           'wp_heading' => $spheading,
		           'wp_details' => $spdetails,
		           'wp_keywords' => $spkeywords,
		           'wp_expiry' => $expiry
		        );
			break;
		}

		if(substr($spid, 0, 3) != "new")
		{
			$this->db->where($id, $spid);
			$this->db->update($table, $data);
		}
		else
		{
			$this->db->set('p_id', substr($spid,3));
			$this->db->insert($table, $data);
		}

		$pdata = array(
           'p_last_updated' => $date
        );

		$this->db->where('m_id', $myid);
		$this->db->update('profiles', $pdata);
		
		return $this->getProfile($myid);
	}

	function reportUser($id,$reas,$desc)
	{
		//set the timezone so that the time inputs correctly
		date_default_timezone_set('America/New_York');
		$date = date('Y-m-d H:i:s');

		$this->db->set('p_id', $id);
		$this->db->set('rr_reason', $reas);
		$this->db->set('rep_description', $desc);
		$this->db->set('rep_date', $date);
		$this->db->set('rep_read', false);
		
		return $this->db->insert('reports'); 
	}

	function getReportReasons()
	{
		$query = $this->db->query("Select * FROM report_reasons");
	
		//if the user has already created a profile return their profile info
		if($query->num_rows > 0) {
				
				
			foreach($query->result() as $r)
			{
				$reasons[]=$r;
			}
			

			return $reasons;
		}
		else 
		{
			return "";
		}
	}

	function countUnreviewed()
	{
		$this->db->where('rep_read', false);
		$this->db->from('reports');
		return $this->db->count_all_results();
	}
}	

	 
