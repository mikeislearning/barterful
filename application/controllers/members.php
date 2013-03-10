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
		
	    $this->data['main_content'] = 'members_area';
		//$data['header_content'] = 'includes/headerout';
		$this->data['aside_content'] = 'includes/aside';
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