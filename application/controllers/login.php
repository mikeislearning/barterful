<?php 
class login extends CI_Controller {
	function index()
	{
	
		$data['main_content'] = 'login_form';
		$data['header_content'] = 'includes/headerout';
		$data['aside_content'] = 'includes/aside';
		$this->load->view('includes/template', $data);
		
	
		
	}
	
	function validate_credentials() {
		$this->load->model('membership_model');
		$query = $this->membership_model->validate();
		
		if($query)//if the user's creddentials validated..
		{
			$newdata = array(
			'username'=> $this->input->post('username'), 
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
		$data['main_content'] = 'signup_form';
		$data['header_content'] = 'includes/headerout';
		$data['aside_content'] = 'includes/aside';
		$this->load->view('includes/template', $data);
		
	}
	
	function create_member()
	{
		$this->load->library('form_validation');
		//validation rules
		
		$this->form_validation->set_rules('first_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|callback_check_if_email_exists');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|callback_check_if_username_exists');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|required|matches[password]');
		
		if($this->form_validation->run() == FALSE)//didn't validate
		{
			$data['main_content'] = 'signup_form';
			$data['header_content'] = 'includes/headerout';
			$data['aside_content'] = 'includes/aside';
			$this->load->view('includes/template', $data);
			
		}
		
		else
		{
			$this->load->model('membership_model');
			if($query = $this->membership_model->create_member())
			{
			//you make a data variable in this block
				$data['account_created'] = 'Your account has been created. <br/><br/>You may now login';
				$data['main_content'] = 'login_form';
				$data['header_content'] = 'includes/headerout';
				$data['aside_content'] = 'includes/aside';
				$this->load->view('includes/template', $data);
				
				//not sure if this will work
				
					/*$this->load->view('includes/header');
					//we pass it you may now login
					$this->load->view('login_form', $data);
					$this->load->view('includes/footer');*/
			}
			else
			{
			//if it fails we go back to the signup form
			$data['main_content'] = 'signup_form';
			$data['header_content'] = 'includes/headerout';
			$data['aside_content'] = 'includes/aside';
			$this->load->view('includes/template', $data);
				
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
    
    /*$this->load->view('login_form');
    $this->session->unset_userdata('logged_in');
    session_destroy();
    */
  }

}
?>