<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Members extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 function __construct()
	 {
	   parent::__construct();
	 }
	 
	 function index()
	 {
	 
	   if($this->session->userdata('logged_in'))
	   {
	   $newdata = $this->session->userdata('logged_in');
		$session_data['username'] = $newdata['username'];
		
	     $data['main_content'] = 'members_area';
		$data['header_content'] = 'includes/headerout';
		$data['aside_content'] = 'includes/aside';
		$this->load->view('includes/template', $data);

	     
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