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
		$this->data['aside_content'] = 'includes/aside';

		//load the postings
		$this->load->model('listings_model');

		$type = "skills";
		//$type = $this->input->get('type');
		if(isset($_POST['type']))
		{
			echo ('in the controller');
			$type = $_POST['type'];
		}

		$this->data['row'] = $this->listings_model->listAll($type);
		$this->data['skills'] = $this->listings_model->skillList();

		$this->load->view('includes/template',$this->data);
	}
	
	public function contact()
	{
		$this->data['main_content'] = 'contact';
		$this->data['aside_content'] = 'includes/aside';
		$this->load->view('includes/template', $this->data);
	}
	
	
}