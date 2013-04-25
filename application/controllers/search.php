<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This controller deals with search and listings on the index page of the site
*
* This controller includes:
*   - re-sort for the skill listings shown to logged-in users
*	- redirect (redirects to the re-sort, adding the search term to the url)
*	- search posts which takes search terms and redirects them to the listings model
*/

class search extends CI_Controller {
	 
	 function __construct()
	 {
		 parent::__construct();
		 $this->logged_in();
		 
		 
	 }
	 
	 //initialize data variable
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
				$term = "";


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

				if(isset($_POST['term']))
				{
					$term = $_POST['term'];
					$term = explode(' ',$term);
					$term = implode('00',$term);
				}
				else if($this->uri->segment(3) !== FALSE)
				{
				    $term = $this->uri->segment(3);
				}

				//get the array of id's (there should just be one in the array)
				$id = $this->session->userdata('userid');
				//get the id value from the first pair in the array
				$id = $id[0]->m_id;

				//send the data to the search function if any terms were listed in the search bar, otherwise just get a listing
				if($term != "")
				{
					$this->data['row'] = $this->listings_model->complexSearch($term,$type,$sortset,$category);
				}
				else
				{
					$this->data['row'] = $this->listings_model->listLoggedIn($id,$type,$sortset,$category);
				}

				$this->load->view('includes/listPostings',$this->data);
		     
		   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
	}

//since codeigniter doesn't enable GET requests, I mimicked one by manually placing the search terms in the url
 public function redir()
 {
 	if(isset($_POST['txt_search']))
	{
		$terms = $_POST['txt_search'];
	} 

	$terms = explode(" ", $terms);
	$terms = implode('00',$terms);

 	redirect("search/searchPosts/{$terms}");
 }

 public function searchPosts()
 {

	$this->load->model('listings_model');
	$term = "";

	//get the user's id out of the url
	if ($this->uri->segment(3) === FALSE)
	{
	    redirect("site/index");
	}
	else
	{
	    $term = $this->uri->segment(3);
	}

	//send the id through to the query function
	$this->data['row'] = $this->listings_model->complexSearch($term);

	//send a list of skills for the dropdown function
	$this->data['skills'] = $this->listings_model->skillList();

	$this->data['main_content'] = 'searchResults';

	$this->load->view('includes/template', $this->data);
 }

 public function test()
 {
 	$this->load->view('test');
 }
	
}