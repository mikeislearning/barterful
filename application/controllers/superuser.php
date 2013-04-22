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

		$type = $this->session->userdata('usertype');
		//get the id value from the first pair in the array
		$type = $type[0]->m_type;

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

	function validate_credentials() {
		$this->load->model('membership_model');
		$query = $this->membership_model->validate();

		if($query)//if the user's credentials validated..
			{
			$newdata = array(
				'username'=> $this->input->post('username'),
				'userid'=> $this->membership_model->getID(),
				'logged_in' => true
			);
			/*leave this!*/
			$this->session->set_userdata($newdata);

			redirect('members');

		}
		else //incorrect username or password
			{
			echo "invalid login";
			$this->index();

		}
	}

	function signup()
	{
		$logged_in = $this->session->userdata('logged_in');
		if(!isset($logged_in)|| $logged_in != true){
			$this->data['main_content'] = 'signup_form';
		}
		else{
			redirect('site');
		}
		$this->load->view('includes/template', $this->data);

	}

	function create_member()
	{
		$this->load->library('form_validation');
		$this->load->helper('captcha');
		//validation rules

		$this->form_validation->set_message('check_if_username_exists', "This Username is sadly already taken. Nice try though!.");

		$this->form_validation->set_message('check_if_email_exists', "Someone has already signed up with this email address. Our sincerest apologies!.");

//don't need first_name and last_Name to signup
	//	$this->form_validation->set_rules('first_name', 'Name', 'trim|required');
	//	$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|callback_check_if_email_exists');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|callback_check_if_username_exists');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|required|matches[password]');

		if($this->form_validation->run() == FALSE)//didn't validate
			{
			$this->signup();

			}

		else
		{
			$this->load->model('membership_model');
			if($query = $this->membership_model->create_member())
			{
				//you make a data variable in this block
				$this->data['account_created'] = 'Your account has been created. <br/><br/>You may now login';
				$this->index();
			}
			else
			{
				$this->signup();
			}
		}
	}

	function check_if_username_exists($requested_username) { //custom callback function

		$this->load->model('membership_model');
		$username_available = $this->membership_model->check_if_username_exists($requested_username);
		if($username_available)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function check_if_email_exists($requested_email) { //custom callback functin

		$this->load->model('membership_model');

		$email_available = $this->membership_model->check_if_email_exists($requested_email);
		if($email_available)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}

	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		redirect('members');
	}

}
?>