<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_crud extends CI_Controller {
	 
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

			   	$this->data['count_inbox'] = $this->inbox_model->countUnread($id);
		   }
		 }
}
	 
	 
function index(){
   if($this->session->userdata('logged_in')){
		$newdata = $this->session->userdata('logged_in');
		$session_data['username'] = $newdata['username'];
		$id = $this->session->userdata('userid');

		$this->load->model('profile_model');
		$this->data['main_content'] = 'profile_form';
		$this->load->view('includes/template', $this->data);
    }
   else{
       session_destroy();
        //If no session, redirect to login page
       redirect('login', 'refresh');
   }
}

	//loads the edit view from profile_form
function edit()
{
   $this->load->helper('url');  
   //is the post 
   if($this->input->post('edit') === FALSE){
   ////need this to get the profile info
		$id = $this->session->userdata('userid');
		$this->load->model('profile_model');
		$this->data['profile'] = $this->profile_model->getProfile($id);
		//we will probably need to insert memebers here too
		///end need this 
		//load the edit view
		$this->data['main_content'] = 'includes/update_profile';
		$this->load->view('includes/template', $this->data);
	}
   
}

 
 }
