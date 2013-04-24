<?php
class superuser extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->logged_in();

	}

	//this whole section checks to see if you're logged in, and loads the appropriate stuff
	var $data;//this variable is declared so all functions can make use of it

	public function logged_in(){

		$logged_in = $this->session->userdata('logged_in');

		if($logged_in)
			{
				$type = $this->session->userdata('usertype');
				//get the id value from the first pair in the array
				$type = $type[0]->m_type;
			}

		if(isset($type) && $type == 'superuser')
		{
			$this->data['header_content'] = 'includes/headeradmin';
		}
		 
		 else
		 {
			 //echo 'You do not have permission to access this page.';
			 redirect('site');
		 }
	}

	function index()
	{
		if($this->session->userdata('logged_in'))
	   {
	    $newdata = $this->session->userdata('logged_in');
		$session_data['username'] = $newdata['username'];
		$this->load->model('profile_model');
		$this->data['count_unreviewed'] = $this->profile_model->countUnreviewed();
	    $this->data['main_content'] = 'adminHome';
		$this->load->view('includes/template', $this->data);
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
	}

	function skills()
	{
		if($this->session->userdata('logged_in'))
	   {
		$this->load->model('listings_model');
	    $this->data['row'] = $this->listings_model->skillList();
		$this->load->view('includes/adminSkills', $this->data);
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
	}

	function deleteSkill()
	{
		if($this->session->userdata('logged_in'))
	   {
			$sid = "";

			if(isset($_POST['sid']))
			{
				$sid = $_POST['sid'];
			}

			$this->load->model('listings_model');
		    $this->data['row'] = $this->listings_model->deleteSkill($sid);
			$this->load->view('includes/adminSkills', $this->data);
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
	}

	function newSkill()
	{
		if($this->session->userdata('logged_in'))
	   {
			$name = "";

			if(isset($_POST['name']))
			{
				$name = $_POST['name'];
			}

			$this->load->model('listings_model');
		    $this->data['row'] = $this->listings_model->addSkill($name);
			$this->load->view('includes/adminSkills', $this->data);
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
	}

	function updateSkill()
	{
		if($this->session->userdata('logged_in'))
	   {
			$sid = "";
			$sname = "";

			if(isset($_POST['hdf_id']))
			{
				$sid = $_POST['hdf_id'];
			}

			if(isset($_POST['txt_name']))
			{
				$sname = $_POST['txt_name'];
			}

			$this->load->model('listings_model');
			$this->listings_model->updateSkill($sid,$sname);
			$this->index();
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
	}

	function reports()
	{
		if($this->session->userdata('logged_in'))
	   {
		$this->load->model('profile_model');
	    $this->data['new'] = $this->profile_model->getNewReports();
	    $this->data['old'] = $this->profile_model->getOldReports();
		$this->load->view('includes/adminReports', $this->data);
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		redirect('members');
	}

}
?>