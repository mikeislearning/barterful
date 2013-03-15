<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ajax extends CI_Controller {

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

	public function re_sort()
	{

		if($this->session->userdata('logged_in'))
		   {

			//load the postings
				$this->load->model('listings_model');

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

				//get the array of id's (there should just be one in the array)
				$id = $this->session->userdata('userid');
				//get the id value from the first pair in the array
				$id = $id[0]->m_id;

				$this->data['row'] = $this->listings_model->listLoggedIn($id,$type,$sortset,$category);

				$this->load->view('includes/listPostings',$this->data);
		     
		   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
	}

	public function inbox()
 {
	 if($this->session->userdata('logged_in'))
	   {		
		$this->load->model('inbox_model');

		$view = 'inbox';
		if(isset($_POST['view']))
		{
			$view = $_POST['view'];
		}
		//---------------------------------------------------------------------------------//
		//this section loads the listings displayed based on the user's id in the session
		//---------------------------------------------------------------------------------//
		//get the array of id's (there should just be one in the array)
		$id = $this->session->userdata('userid');
		//get the id value from the first pair in the array
		$id = $id[0]->m_id;
		//send the id through to the query function

		$this->data['row'] = $this->inbox_model->listAll($id,$view,'');

		$this->load->view('includes/listInbox', $this->data);
	     
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
 }

 public function conversation()
 {
	 if($this->session->userdata('logged_in'))
	   {		
		$this->load->model('inbox_model');

			$with = "";

			$senderid = $_POST['sender'];
			$receiverid = $_POST['receiver'];
			//get the current user id
			$id = $this->session->userdata('userid');
			$id = $id[0]->m_id;
			//Check the id of the participants in the conversation selected against the current 
			//user id to send the right variables to the controller
			if($senderid == $id)
				{$with = $receiverid;}
			else{$with = $senderid;}

		//---------------------------------------------------------------------------------//
		//this section loads the listings displayed based on the user's id in the session
		//---------------------------------------------------------------------------------//
		//get the array of id's (there should just be one in the array)
		$id = $this->session->userdata('userid');
		//get the id value from the first pair in the array
		$id = $id[0]->m_id;

		//send the id through to the query function

		$this->data['row'] = $this->inbox_model->listAll($id,'conversation',$with);

		//send a list of skills for the dropdown function
		$this->load->model('listings_model');
		$this->data['skills'] = $this->listings_model->skillList();

		$this->data['main_content'] = 'includes/message_view';
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

 public function sendmessage()
 {
	 if($this->session->userdata('logged_in'))
	   {		
		$this->load->model('inbox_model');

		$info = [];
		$to = "";
		$to_skill = "";
		$to_unit = "";
		$from_skill = "";
		$from_unit = "";
		$message = "-";
		$response = "";

		if(isset($_POST['to']))
		{
			$to = $_POST['to'];
		}

		if(isset($_POST['to_skill']))
		{
			$to_skill = $_POST['to'];
		}

		if(isset($_POST['to_unit']))
		{
			$to_unit = $_POST['to_unit'];
		}

		if(isset($_POST['from_skill']))
		{
			$from_skill = $_POST['from_skill'];
		}

		if(isset($_POST['from_unit']))
		{
			$from_unit = $_POST['from_unit'];
		}

		if(isset($_POST['message']))
		{
			$message = $_POST['message'];
		}

		if(isset($_POST['response']))
		{
			$response = $_POST['response'];
		}
		//---------------------------------------------------------------------------------//
		//this section loads the listings displayed based on the user's id in the session
		//---------------------------------------------------------------------------------//
		//get the array of id's (there should just be one in the array)
		$id = $this->session->userdata('userid');
		//get the id value from the first pair in the array
		$id = $id[0]->m_id;
		//send the id through to the query function

		$this->data['row'] = $this->inbox_model->sendMessage($id,$to,$to_skill,$to_unit,$from_skill,$from_unit,$message,$response);

		//send a list of skills for the dropdown function
		$this->load->model('listings_model');
		$this->data['skills'] = $this->listings_model->skillList();

		$this->load->view('includes/listInbox', $this->data);
	     
	   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
 }
	
	
}