<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Members extends CI_Controller {

	 //run the login function automatically
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
	 
	 function index()
	 {
	 	//check that the user is logged in
	   if($this->session->userdata('logged_in'))
	   {
	    $newdata = $this->session->userdata('logged_in');
		$session_data['username'] = $newdata['username'];
		
		//---------------------------------------------------------------------------------//
		//this section loads the listings displayed based on the user's id in the session
		//---------------------------------------------------------------------------------//
		//get the array of id's (there should just be one in the array)
		$id = $this->session->userdata('userid');
		//get the id value from the first pair in the array
		$id = $id[0]->m_id;

		$this->load->model('listings_model');

		//send the id through to the query function to get a list of postings that are relevant to the logged-in user
		$this->data['row'] = $this->listings_model->listLoggedIn($id,'skills','p_fname', 'all');

		//get a list of the skills and their id to allow for sorting
		$this->data['skills'] = $this->listings_model->skillList();

	    $this->data['main_content'] = 'members_area';
		$this->load->view('includes/template', $this->data);
		
	     
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
 }
 
function createProfile(){
	$this->load->library('form_validation');
	$this->load->helper('captcha');
	$this->load->helper('date');
		
	$id = $this->session->userdata('userid');
	$id = $id[0]->m_id;
	$this->load->model('profile_model');
		
	//validation rules
	//don't need first_name and last_Name to signup
	$this->form_validation->set_rules('first_name', 'Name', 'trim|required');
	$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		//$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|callback_check_if_email_exists');
		//$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|callback_check_if_username_exists');
		//$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		//$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|required|matches[password]');
		//didn't validate
	if($this->form_validation->run() == FALSE){
		$this->profile();
	}
	else {
		$this->load->model('profile_model');
		
		if($query = $this->profile_model->createProfile()){
			//you make a data variable in this block
			$this->data['profile_created'] = 'Your profile has been created. <br/>';
			$this->profile();
		}
		else {
			$this->profile();
		}
	}
	
}
	
//updates the profile information for a user
function updateProfile(){
	$this->load->library('form_validation');
	$this->load->helper('captcha');
	$this->load->helper('date');
	
	//get the id value from the first pair in the array	
	$id = $this->session->userdata('userid');
	$id = $id[0]->m_id;
	$this->load->model('profile_model');
	
	//needed to view update profile correctly
	$this->data['profile'] = $this->profile_model->getProfile($id);	
	$this->data['member'] = $this->profile_model->getMemberInfo($id);
	
	//validation rules
	$this->form_validation->set_rules('first_name', 'Name', 'trim|required');
	$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');

	if($this->form_validation->run() == FALSE){ //didn't validate
		$this->data['main_content'] = 'includes/update_profile';
		$this->load->view('includes/template', $this->data);
		return;//keep this to exit function
	}

	else {
	//checks if the page is postback or on submit click
		if($this->input->post('submit', TRUE)){	
			//if profile_model is updated
			if($query = $this->profile_model->updateProfile()){
				//you make a data variable in this block
				$this->data['profile_updated'] = 'Your profile has been updated. <br/>';
				$this->profile();
			}
		}
		else{
		
			$this->profile();
		}
	}

}
	
//loads the profile from headerin
function profile() {
	 if($this->session->userdata('logged_in')){
		$newdata = $this->session->userdata('logged_in');
		$session_data['username'] = $newdata['username'];
		
		//get the id value from the first pair in the userdata array set in the session
		$id = $this->session->userdata('userid');
		$id = $id[0]->m_id;
		
		//the profile requires data on that user, as well as a list of the skills, wants, and projects listed by that user
		$this->load->model('listings_model');
		$this->load->model('profile_model');
		$this->data['profile'] = $this->profile_model->getProfile($id);
		$this->data['skills'] = $this->listings_model->listAll("skills","sp_id","all",$id);
		$this->data['wants'] = $this->listings_model->listAll("wants","sp_id","all",$id);
		$this->data['projects'] = $this->listings_model->listAll("projects","sp_id","all",$id);

		//getting a list of skills allows for populating drop down lists in update/new posting forms
		$this->data['skill_list'] = $this->listings_model->skillList();
		
		$this->data['main_content'] = 'profile_form';
		$this->load->view('includes/template', $this->data);
			
	 }
 }

	
	 function inbox()
 {
	 if($this->session->userdata('logged_in'))
	   {
	    $newdata = $this->session->userdata('logged_in');
		$session_data['username'] = $newdata['username'];
		
		//---------------------------------------------------------------------------------//
		//this section loads the listings displayed based on the user's id in the session
		//---------------------------------------------------------------------------------//
		
		//get the array of id's (there should just be one in the array)
		$id = $this->session->userdata('userid');

		//get the id value from the first pair in the array
		$id = $id[0]->m_id;


		$this->load->model('inbox_model');

		//send the id through to the query function to load all messages received by that user
		$this->data['row'] = $this->inbox_model->listAll($id,'inbox','');

		//set all messages in the inbox to read
		$this->inbox_model->readMessages($id);

	    $this->data['main_content'] = 'inbox';
		$this->load->view('includes/template', $this->data);
	     
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
 }

 function changePassword(){
 	$this->data['main_content'] = 'change_password';
 	$this->load->view('includes/template', $this->data);
 }

 function changePasswordProcess(){

$this->load->library('form_validation');

$this->form_validation->set_rules('old_password','Old Password','trim|required|min_length[4]|max_length[32]');
$this->form_validation->set_rules('new_password','New Password','trim|required|min_length[4]|max_length[32]');
$this->form_validation->set_rules('confirm_password','New Password Confirmation','trim|required|min_length[4]|max_length[32]|matches[new_password]');

if ($this->form_validation->run() == FALSE)
        {
            $this->changePassword();

        }
        else {
            $this->load->model('membership_model');
            $query=$this->membership_model->change_password();

            $this->data['main_content'] ='change_password';
            $this->data['query']=$query;
            
            $this->load->view('includes/template',$this->data);
        }
 }



 }
