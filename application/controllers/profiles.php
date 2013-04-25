<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This controller deals with user profiles and content on the site
*
* This controller includes:
*   - viewprofile as a public profile view
*	- redirect (redirects to the profile view, adding the profile id to the url)
*	- delete/edit skill (new skills are shared with the edit skill function)
*	- report a user for bad behaviour
*/

class profiles extends CI_Controller {
	 
	 function __construct()
	 {
		 parent::__construct();
		 $this->logged_in();
		 
		 
	 }
	 
	 //initialize the data variable
	 var $data;

	public function logged_in(){
		 
		//set a variable to represent the log in status of the user
		$logged_in = $this->session->userdata('logged_in');
		 

		 //if the user is logged out, show the public header
		 if(!isset($logged_in)|| $logged_in != true)
		 {
			 //echo 'You do not have permission to access this page.';
			 $this->data['header_content'] = 'includes/headerout';
		 }
		 else{

		 	//get the type of user from the type array
			$type = $this->session->userdata('usertype');
			//get the type value from the first set in the array
			$type = $type[0]->m_type;

			//load the admin header for admin users
			if(isset($type) && $type == 'superuser')
			{
				$this->data['header_content'] = 'includes/headeradmin';
			}
			else
			{	//load the logged in header
				 $this->data['header_content'] = 'includes/headerin';

				 //get a count of how many unread messages that user has in their inbox
				 $this->load->model('inbox_model');
			   	//get the array of id's (there should just be one in the array)
				$id = $this->session->userdata('userid');
				//get the id value from the first pair in the array
				$id = $id[0]->m_id;

			   	$this->data['count_inbox'] = $this->inbox_model->countUnread($id);
		   }
		 }
	 }
	 
 public function viewprofile()
 {
 	//-------NOTE: this function is received by redir() below it --------//

 	//the default value for each of these is an empty string
 	$myid = "";
 	$usertype= "";

 	
 	//---get current users id---//

   	//get the array of id's (there should just be one in the array)
	$myid = $this->session->userdata('userid');
	//get the id value from the first pair in the array
	$myid = $myid[0]->m_id;

	//get the user type (to determine how the profile is viewed)
	$usertype = $this->session->userdata('usertype');
	$usertype = $usertype[0]->m_type;
 	
 	//this represents the id of the profile owner
 	$id = "";

 	//get the requested user's profile id out of the url
	if ($this->uri->segment(3) === FALSE)
	{
		//redirect to the home page if no id is found in the url
	    redirect('site');
	}
	else
	{
		//the id of the profile's owner
	    $id = $this->uri->segment(3);
	}

	//if the user clicked on their own profile, take them to their own profile view
   if($this->session->userdata('logged_in') && $myid == $id)
	 {
		$baseurl = base_url();
		$url = $baseurl . "index.php/members/profile";
		redirect($url, 'refresh');
	 }	

	 //load the user's profile data, their skill, want, and project postings, as well as a list of skills and reasons to report a user for drop down lists
	$this->load->model('listings_model');
	$this->load->model('profile_model');
	$this->data['profile'] = $this->profile_model->getProfile($id);
	$this->data['reasons'] = $this->profile_model->getReportReasons();
	$this->data['skills'] = $this->listings_model->listAll("skills","sp_id","all",$id);
	$this->data['wants'] = $this->listings_model->listAll("wants","sp_id","all",$id);
	$this->data['projects'] = $this->listings_model->listAll("projects","sp_id","all",$id);
	$this->data['skill_list'] = $this->listings_model->skillList();

	//if the user is a superuser, display the profile in edit format, otherwise display the public view
	if($this->session->userdata('logged_in') && $usertype == 'superuser')
	{
		$this->data['main_content'] = 'profile_form';
	}
	else
	{
		$this->data['main_content'] = 'publicProfile';
	}
	$this->load->view('includes/template', $this->data);

 }

 //send the posted id to the viewprofile page with the id in the url in order to allow for refresh (mimic a GET request)
 public function redir()
 {
 	if(isset($_POST['p_id']))
	{
		$id = $_POST['p_id'];
	} 

 	redirect("profiles/viewprofile/{$id}");
 }

 public function deleteSkill()
 {

	//initialize the type and profile id variables
	$type = "";
 	$spid="";

 	//get the posted values
	if(isset($_POST['type']))
	{
		$type = $_POST['type'];
	} 

 	if(isset($_POST['sp_id']))
	{
		$spid = $_POST['sp_id'];
	} 

	$this->load->model('profile_model');
	$this->load->model('listings_model');

	//send the values through to the model for deleting
	$this->data['profile'] = $this->profile_model->deleteSP($spid,$type);

	//this is an ajax function and thus does not return anything
	echo true;
 }

 public function editSkill()
 {

	//initialize the variables
	$type = "";
 	$spid="";
 	$sid="";
 	$spheading="";
 	$spdetails="";
 	$spkeywords="";
 	$expiry = "";


 	//receive the value of each of the above variables from the POST method
	if(isset($_POST['type']))
	{
		$type = $_POST['type'];
	} 

 	if(isset($_POST['sp_id']))
	{
		$spid = $_POST['sp_id'];
	} 

	if(isset($_POST['s_id']))
	{
		$sid = $_POST['s_id'];
	} 

	if(isset($_POST['sp_heading']))
	{
		$spheading = $_POST['sp_heading'];
	} 

	if(isset($_POST['sp_details']))
	{
		$spdetails = $_POST['sp_details'];
	} 

	if(isset($_POST['expiry']))
	{
		$expiry = $_POST['expiry'];
	} 

	if(isset($_POST['sp_keywords']))
	{
		$spkeywords = $_POST['sp_keywords'];
	} 

	if($this->session->userdata('logged_in'))
	 {
		//get their own id
		$myid = $this->session->userdata('userid');
		$myid = $myid[0]->m_id;

		$this->load->model('profile_model');

		//update the posting
		$this->data['profile'] = $this->profile_model->updateSP($spid,$sid,$spheading,$spdetails,$expiry,$spkeywords,$myid,$type);

		echo true;
	 }	
 }

//this controller sends a report regarding the behaviour of a user
 public function report()
 {
 	//initialize variables
 	$p_id="";
 	$desc="";
 	$reason="";

 	//get values from post
	if(isset($_POST['reason']))
	{
		$reason = $_POST['reason'];
	} 

 	if(isset($_POST['id']))
	{
		$p_id = $_POST['id'];
	} 

 	if(isset($_POST['details']))
	{
		$desc = $_POST['details'];
	} 

	//load the data models
	$this->load->model('profile_model');
	$this->load->model('listings_model');	

	//send the report
	$this->profile_model->reportUser($p_id,$reason,$desc);

	//this is an ajax call -> does not need a return message
	echo true;
 }
	
	
}