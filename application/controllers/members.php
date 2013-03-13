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
		$this->data['skills'] = $this->listings_model->skillList();

	    $this->data['main_content'] = 'members_area';
		$this->data['aside_content'] = 'includes/aside';
		$this->load->view('includes/template', $this->data);
	     
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }

	   function ajax()
	 {
	 
	   if($this->session->userdata('logged_in'))
	   {
	    $newdata = $this->session->userdata('logged_in');
		$session_data['username'] = $newdata['username'];

		$type = "skills";
		$sortset = "p_fname";
		$category = "all";
		//$type = $this->input->get('type');
		if(isset($_POST['type']))
		{
			$type = $_POST['type'];
		}

		if(isset($_POST['sortset']) AND $_POST['sortset'] != 'default')
		{
			$sortset = $_POST['sortset'];
		}

		if(isset($_POST['category']))
		{
			$category = $_POST['category'];
		}
		
		//---------------------------------------------------------------------------------//
		//this section loads the listings displayed based on the user's id in the session
		//---------------------------------------------------------------------------------//
		//get the array of id's (there should just be one in the array)
		$id = $this->session->userdata('userid');
		//get the id value from the first pair in the array
		$id = $id[0]->m_id;
		$this->load->model('listings_model');
		//send the id through to the query function
		$this->data['row'] = $this->listings_model->listLoggedIn($id,$type,$sortset,$category);

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
 
 function profile()
	 {
		 if($this->session->userdata('logged_in'))
		   {
		 
		 }
	 }
 
 }
?>