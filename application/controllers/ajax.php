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

class ajax extends CI_Controller {
	 
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

	 //sort the listings displayed to logged-in users
	public function re_sort()
	{
		//check that the user is logged in
		if($this->session->userdata('logged_in'))
		   {

				//load the postings
				$this->load->model('listings_model');

				//set default values
				$type = "skills";
				$sortset = "p_fname";
				$category = "all";


				//if these values are provided, set these variables accordingly
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

		//the default view is inbox for incoming messages
		$view = 'inbox';

		//check if an alternative value for view was provided and set it if so
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

			//initialize the with variable
			$with = "";

			//the following is used to determine who the conversation is with. We know that one 
			// 		user is the logged-in user, so the other user will have a different id

			// why do we need to do this? because if the current view is of sent messages, the message displayed 
			//		will be FROM the logged in user, but if inbox then the opposite will be true

			//get the id of the two conversation participants
			$senderid = $_POST['sender'];
			$receiverid = $_POST['receiver'];

			//get the array of id's (there should just be one in the array)
			$id = $this->session->userdata('userid');
			//get the id value from the first pair in the array (current user's id)
			$id = $id[0]->m_id;

			//Check the id of the participants in the conversation selected against the current 
			//user id to send the right variables to the controller
			if($senderid == $id)
				{$with = $receiverid;}
			else{$with = $senderid;}

		//---------------------------------------------------------------------------------//
		//this section loads the listings displayed based on the user's id in the session
		//---------------------------------------------------------------------------------//
	
		//send the id through to the query function
		$this->data['row'] = $this->inbox_model->listAll($id,'conversation',$with);

		//send a list of skills for the dropdown function
		$this->load->model('listings_model');
		$this->data['skills'] = $this->listings_model->skillList();

		$this->data['main_content'] = 'includes/message_view';
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

 	//------------------------------------------------------------------------------------------------------------//
 	//	I'd like to be able to come back here and send all these variables through more efficiently (in an array) //
 	//------------------------------------------------------------------------------------------------------------//

		$to = "";
		$to_skill = "";
		$to_unit = "";
		$from_skill = "";
		$from_unit = "";
		$message = "-";
		$response = "";

		//check that each value has been provided and assign it to a variable
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

 public function searchPostings()
 {	
 	if(!$this->session->userdata('logged_in'))
		 {
			 //echo 'You do not have permission to access this page.';
			 $this->data['header_content'] = 'includes/headerout';
		 }
	 else{
			 $this->data['header_content'] = 'includes/headerin';
		 }

	$this->load->model('listings_model');
	$term = "";

	if(isset($_POST['term']))
	{
		$term = $_POST['term'];
	}

	//send the id through to the query function
	$this->data['row'] = $this->listings_model->simpleSearch($term);

	//send a list of skills for the dropdown function
	$this->data['skills'] = $this->listings_model->skillList();

	$this->data['main_content'] = 'searchResults';

	$this->load->view('includes/template', $this->data);

 }

 public function viewprofile()
 {
	$this->load->model('profile_model');

	$id = "";
	$myid = "";

	//check that each value has been provided and assign it to a variable
	if(isset($_POST['p_id']))
	{
		$id = $_POST['p_id'];
	} 

   if(!$this->session->userdata('logged_in'))
	 {
		 //echo 'You do not have permission to access this page.';
		 $this->data['header_content'] = 'includes/headerout';
	 }
 	else
	 {
		$this->data['header_content'] = 'includes/headerin';

		//if the user clicked on their own profile, take them to their own profile view

		//get their own id
		$myid = $this->session->userdata('userid');
		$myid = $myid[0]->m_id;

		if($myid == $id)
		{
			$baseurl = base_url();
			$url = $baseurl . "index.php/members/profile";
			redirect($url, 'refresh');
		}
	 }	

	//$this->data['row'] = $this->inbox_model->newMsg($p_id);
	$this->data['row'] = $this->profile_model->getProfile($id);

	$this->data['main_content'] = 'publicProfile';

	$this->load->view('includes/template', $this->data);

 }

 public function editSkill()
 {

	$this->load->model('profile_model');

 	$spid="";
 	$sid="";
 	$spheading="";
 	$spdetails="";
 	$spkeywords="";

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
		$this->data['profile'] = $this->profile_model->updateSP($spid,$sid,$spheading,$spdetails,$spkeywords,$myid,"skill");
		$this->data['skills'] = $this->listings_model->listAll("skills","sp_id","all",$myid);
		$this->data['wants'] = $this->listings_model->listAll("wants","sp_id","all",$myid);
		$this->data['projects'] = $this->listings_model->listAll("projects","sp_id","all",$myid);
		$this->data['skill_list'] = $this->listings_model->skillList();
		
		$this->data['main_content'] = 'profile_form';
		$this->load->view('includes/template', $this->data);
	 }	
 }
	
	
}