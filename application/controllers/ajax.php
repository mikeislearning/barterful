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

				$this->load->view('includes/list',$this->data);
		     
		   }
	   else
	   {
	       session_destroy();
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    
	   }
	}
	
	
}