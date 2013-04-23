<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This controller was created because AJAX calls can only be made to public functions.
*	The members controller is currently not public
*
* This controller includes:
*   - re-sort for the skill listings shown to logged-in users
*	- display all messages in the inbox (and re-load this view for sent messages as well)
*	- show the entire conversation between 2 users
*	- reply to a message
*/

class profiles extends CI_Controller {
	 
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
	 
 public function viewprofile()
 {
 	//get current users id

   	//get the array of id's (there should just be one in the array)
	$myid = $this->session->userdata('userid');
	//get the id value from the first pair in the array
	$myid = $myid[0]->m_id;


 	$id = "";

 	//get the user's id out of the url
	if ($this->uri->segment(3) === FALSE)
	{
	    $id = $myid;
	}
	else
	{
	    $id = $this->uri->segment(3);
	}

	//if the user clicked on their own profile, take them to their own profile view
   if($this->session->userdata('logged_in') && $myid == $id)
	 {
		$baseurl = base_url();
		$url = $baseurl . "index.php/members/profile";
		redirect($url, 'refresh');
	 }	

	$this->load->model('listings_model');
	$this->load->model('profile_model');
	$this->data['profile'] = $this->profile_model->getProfile($id);
	$this->data['reasons'] = $this->profile_model->getReportReasons();
	$this->data['skills'] = $this->listings_model->listAll("skills","sp_id","all",$id);
	$this->data['wants'] = $this->listings_model->listAll("wants","sp_id","all",$id);
	$this->data['projects'] = $this->listings_model->listAll("projects","sp_id","all",$id);
	$this->data['skill_list'] = $this->listings_model->skillList();

	$this->data['main_content'] = 'publicProfile';
	$this->load->view('includes/template', $this->data);

 }

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

	$this->load->model('profile_model');

	$type = "";
 	$spid="";

	if(isset($_POST['type']))
	{
		$type = $_POST['type'];
	} 

 	if(isset($_POST['sp_id']))
	{
		$spid = $_POST['sp_id'];
	} 

	if($this->session->userdata('logged_in'))
	 {
		//get their own id
		$myid = $this->session->userdata('userid');
		$myid = $myid[0]->m_id;

		$this->load->model('profile_model');
		$this->load->model('listings_model');
		$this->data['profile'] = $this->profile_model->deleteSP($spid,$type);

		$this->data['reasons'] = $this->profile_model->getReportReasons();
		$this->data['skills'] = $this->listings_model->listAll("skills","sp_id","all",$myid);
		$this->data['wants'] = $this->listings_model->listAll("wants","sp_id","all",$myid);
		$this->data['projects'] = $this->listings_model->listAll("projects","sp_id","all",$myid);
		$this->data['skill_list'] = $this->listings_model->skillList();
		
		$this->data['main_content'] = 'profile_form';
		$this->load->view('includes/template', $this->data);
	 }	

 }

 public function editSkill()
 {

	$this->load->model('profile_model');

	$type = "";
 	$spid="";
 	$sid="";
 	$spheading="";
 	$spdetails="";
 	$spkeywords="";
 	$expiry = "";

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
		$this->load->model('listings_model');

		$this->data['reasons'] = $this->profile_model->getReportReasons();
		$this->data['profile'] = $this->profile_model->updateSP($spid,$sid,$spheading,$spdetails,$expiry,$spkeywords,$myid,$type);
		$this->data['skills'] = $this->listings_model->listAll("skills","sp_id","all",$myid);
		$this->data['wants'] = $this->listings_model->listAll("wants","sp_id","all",$myid);
		$this->data['projects'] = $this->listings_model->listAll("projects","sp_id","all",$myid);
		$this->data['skill_list'] = $this->listings_model->skillList();
		
		$this->data['main_content'] = 'profile_form';
		$this->load->view('includes/template', $this->data);
	 }	
 }

 public function report()
 {

 	$p_id="";
 	$desc="";
 	$reason="";

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

	$this->load->model('profile_model');
	$this->load->model('listings_model');	

	$this->profile_model->reportUser($p_id,$reason,$desc);

	$this->data['reasons'] = $this->profile_model->getReportReasons();
	$this->data['profile'] = $this->profile_model->getProfile($p_id);
	$this->data['skills'] = $this->listings_model->listAll("skills","sp_id","all",$p_id);
	$this->data['wants'] = $this->listings_model->listAll("wants","sp_id","all",$p_id);
	$this->data['projects'] = $this->listings_model->listAll("projects","sp_id","all",$p_id);
	$this->data['skill_list'] = $this->listings_model->skillList();
	
	$this->data['main_content'] = 'publicProfile';
	$this->load->view('includes/template', $this->data);
 }
	
	
}