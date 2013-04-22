<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

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
			 $this->load->model('inbox_model');
		   	//get the array of id's (there should just be one in the array)
			$id = $this->session->userdata('userid');
			//get the id value from the first pair in the array
			$id = $id[0]->m_id;

		   	$this->data['count_inbox'] = $this->inbox_model->countUnread($id);
		 }
	 }
	 
	 
	public function landing()
	{
		$this->load->view('landingpage');//I AM TESTING ZIS THING
	}
	
	public function index()
	{	
		$this->data['main_content'] = 'mainpage';
		//$data['header_content'] = 'includes/headerout';

		//load the postings
		$this->load->model('listings_model');

		$this->data['row'] = $this->listings_model->listAll('skills','p_fname', 'all');
		$this->data['skills'] = $this->listings_model->skillList();

		$this->load->view('includes/template',$this->data);

	}

	public function sortListings()
	{

		//load the postings
		$this->load->model('listings_model');

		//set the default values to send through to the sort function
		$type = "skills";
		$sortset = "p_fname";
		$category = "all";
		$term = "";

		//check if these values were sent through and assign them to the variables
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
		}

		if ($term != "")
		{
		    $this->data['row'] = $this->listings_model->complexSearch($term,$type,$sortset,$category);
		}
		else
		{
			$this->data['row'] = $this->listings_model->listAll($type,$sortset,$category);
		}

		$this->load->view('includes/listPostings',$this->data);
	}
	
	public function contact()
	{
		$this->data['main_content'] = 'contact';
		$this->load->view('includes/template', $this->data);
	}
	
	public function deadLink(){
		$this->data['main_content']='nobodyhere';
		$this->load->view('includes/template', $this->data);
	}
	
	
}