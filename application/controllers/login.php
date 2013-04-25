<?php
class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->logged_in();

	}

	//this whole section checks to see if you're logged in, and loads the appropriate stuff
	var $data;//this variable is declared so all functions can make use of it

	public function logged_in(){
		$logged_in = $this->session->userdata('logged_in');
		 
		 if(!isset($logged_in)|| $logged_in != true)
		 {
			 //echo 'You do not have permission to access this page.';
			 $this->data['header_content'] = 'includes/headerout';
		 }
		 else{

			$type = $this->session->userdata('usertype');
			//get the id value from the first pair in the array
			$type = $type[0]->m_type;

			if(isset($type) && $type == 'superuser')
			{
				$this->data['header_content'] = 'includes/headeradmin';
			}
			else
			{
				 $this->data['header_content'] = 'includes/headerin';
				 $this->load->model('inbox_model');
			   	//get the array of id's (there should just be one in the array)
				$id = $this->session->userdata('userid');
				//get the id value from the first pair in the array
				$id = $id[0]->m_id;

			   	$this->data['count_inbox'] = $this->inbox_model->countUnread($id);
		   }
		 }
	}

	function index()
	{
		$logged_in = $this->session->userdata('logged_in');
		if(!isset($logged_in)|| $logged_in != true){
			$this->data['main_content'] = 'login_form';
		}
		else{
			redirect('site');
		}

		$this->load->view('includes/template', $this->data);
	}

	function validate_credentials() {
		$this->load->model('membership_model');
		$query = $this->membership_model->validate();

		if($query)//if the user's credentials validated..
			{

			$newdata = array(
				'username'=> $this->input->post('username'),
				'userid'=> $this->membership_model->getID(),
				'usertype' => $this->membership_model->getType(),
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

	function check_if_email_reset($requested_email) { //custom callback functin

		$this->load->model('membership_model');

		$email_available = $this->membership_model->check_if_email_exists($requested_email);
		if($email_available)
		{
			return FALSE;
		}
		else {
			return TRUE;
		}

	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		redirect('members');
	}

	function recover(){
		$this->data['main_content'] = 'forgot_password';
		$this->load->view('includes/template', $this->data);
	}

	function recover_password()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_message('check_if_email_reset', "That email does not seem to be in our database!");
		$this->form_validation->set_rules('email','Email Address','xss_clean|required|valid_email|callback_check_if_email_reset');

		if($this->form_validation->run() == FALSE)
		{
			$this->data['main_content'] = 'forgot_password';
			$this->load->view('includes/template', $this->data);
		}
		else
		{
			$temp_pass = md5(uniqid());
            //send email with #temp_pass as a link

			$useremail = $this->input->post('email');

            $this->load->library('email');
			$config['useragent']           = "CodeIgniter";
			$config['mailpath']            = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
			$config['protocol']            = "mail";
			$config['smtp_host']           = "localhost";
			$config['smtp_user']           = "";
			$config['smtp_pass']           = "";
			$config['smtp_port']           = "25";

        	$this->email->initialize($config);

            $this->email->set_newline("\r\n");//prevents an error in CI for sending an email

            $this->email->from('info@barterful.com', "Barterful Password Reset");
            $this->email->to($useremail,'Some user guy');
            $this->email->subject("Reset your Password");

           

            $message = "<p>This email has been sent as a request to reset our password</p>";
            //$message .= "<p><a href='".base_url()."login/recover/$temp_pass.'>Click here </a>if you want to reset your password, if not, then ignore</p>";
            $this->email->message($message);

            if($this->email->send())
            {
            	echo $this->input->post('email');
            	echo 'Please check your email to reset the password';
            	$this->data['main_content']='contact_thanks';
				$this->load->view('includes/template', $this->data);
            }
            else{
            	show_error($this->email->print_debugger());
            }
		}
	}

}
?>