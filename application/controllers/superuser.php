<?php
class superuser extends CI_Controller {
	/**
* This controller deals with functions the administrative user would need
*
* This controller includes:
*   - index as the home page for the admin user
*	- skills to get a list of skills available for user selection
*	- delete, new, and update skills for managing the skills available
*	- reports displaying a list of new and reviewed reports filed by users
*		-report action and reopen pertain to dealing with reports
*	- getMessages displays a list of barter offers sent by user that was reported
*	-users displays all users and their active status on the site
*	- memactive changes the active status of a user
*	-messages displays all barter offers exchanged on the site for review
*/

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

			$default = "";

			if(isset($_POST['ndefault']))
			{
				$default = $_POST['ndefault'];
			}

			$this->load->model('listings_model');
		    $this->data['row'] = $this->listings_model->addSkill($name, $default);
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
			$default = "";

			if(isset($_POST['hdf_id']))
			{
				$sid = $_POST['hdf_id'];
			}

			if(isset($_POST['txt_name']))
			{
				$sname = $_POST['txt_name'];
			}

			if(isset($_POST['txt_default']))
			{
				$default = $_POST['txt_default'];
			}

			$this->load->model('listings_model');
			$this->listings_model->updateSkill($sid,$sname,$default);
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

	function reportAction()
	{
		$id="";
		
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
		}

		$action="";
		
		if(isset($_POST['action']))
		{
			$action = $_POST['action'];
		}

		$userid="";
		
		if(isset($_POST['userid']))
		{
			$userid = $_POST['userid'];
		}

		$this->load->model('profile_model');
		$this->profile_model->reportAction($id, $action, $userid);

		$this->reports();
	}

	function reopen()
	{
		$id="";
		
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
		}

		$action="";
		
		if(isset($_POST['action']))
		{
			$action = $_POST['action'];
		}

		$userid="";
		
		if(isset($_POST['userid']))
		{
			$userid = $_POST['userid'];
		}

		$this->load->model('profile_model');
		$this->profile_model->reOpen($id, $action, $userid);

		$this->reports();

	}

	function getMessages()
	{
		$id="";
		
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
		}

		$this->load->model('inbox_model');
		$this->data['row'] = $this->inbox_model->listAll($id, 'outbox');
		$this->load->view('includes/outboxAdmin', $this->data);
	}

	function users()
	{
		if($this->session->userdata('logged_in'))
	   {
		$this->load->model('membership_model');
	    $this->data['row'] = $this->membership_model->getUsers();
		$this->load->view('includes/adminUsers', $this->data);
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
	}

	function memActive()
	{
		$id="";
		
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
		}

		$status="";
		
		if(isset($_POST['status']))
		{
			$status = $_POST['status'];
		}

		$this->load->model('profile_model');
		$this->profile_model->reportAction($id, $status, "");

		$this->users();
	}

	function messages()
	{
		if($this->session->userdata('logged_in'))
	   {
	   	$id="";
		
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
		}

		$to="";
		
		if(isset($_POST['to']))
		{
			$to = $_POST['to'];
		}

		$this->load->model('inbox_model');
	    $this->data['row'] = $this->inbox_model->listAll($id,'conversation',$to);
		$this->load->view('includes/adminMessages', $this->data);
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	   }
	}

	function deleteMessage()
	{
		$id="";
		
		if(isset($_POST['mid']))
		{
			$id = $_POST['mid'];
		}

		$this->load->model('inbox_model');
		$this->inbox_model->deleteMessage($id);

		$this->messages();
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		redirect('members');
	}

}
?>