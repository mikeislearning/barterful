<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Members extends CI_Controller {

	 
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
			 $this->data['header_content'] = 'includes/headerin';
		 }
	 }
	 
	 function index()
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

		$this->load->model('listings_model');
		//send the id through to the query function
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
 
function profile()
	 {
		 if($this->session->userdata('logged_in'))
		   {
		   $newdata = $this->session->userdata('logged_in');
		   $session_data['username'] = $newdata['username'];

//this section loads the profile displayed based on the user's id in the session
//get array of id's	
$id = $this->session->userdata('userid');

		//get the id value from the first pair in the array
		$id = $id[0]->m_id;	 
		$this->load->model('profile_model');
		$this->data['main_content'] = 'profile_form';
		$this->load->view('includes/template', $this->data);
		
		
		 }
	 }
	 
	

	function create_profile()
	{
		$this->load->library('form_validation');
		$this->load->helper('captcha');
		
			$id = $this->session->userdata('userid');

		//get the id value from the first pair in the array
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

		if($this->form_validation->run() == FALSE)//didn't validate
			{
			$this->profile();

		}

		else
		{
			$this->load->model('profile_model');
			if($query = $this->profile_model->create_profile())
			{
				//you make a data variable in this block
				$this->data['profile_created'] = 'Your profile has been updated. <br/>';
				$this->profile();
			}
			else
			{
				$this->profile();
			}
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

		//send the id through to the query function
		$this->data['row'] = $this->inbox_model->listAll($id,'inbox','');

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

 }
?>