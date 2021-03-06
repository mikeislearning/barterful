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

	function index()
	{
		//direct logged in users to the main site page, and others to the log in page
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

		//this determines if the user's account is set to active or if it has been deactivated by admin
		$active = $this->membership_model->getType();
		if($active != "") $active = $active[0]->m_active;

		if($query)//if the user's credentials validated..
			{

			//add data to the session that is retrievable on any age
			$newdata = array(
				'username'=> $this->input->post('username'),
				'userid'=> $this->membership_model->getID(),
				'usertype' => $this->membership_model->getType(),
				'active' => $active,
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
		//$this->load->helper('captcha');
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

	function send_recovery_email()
	{
		$temp_pass = md5(uniqid());
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
			
            //send email with #temp_pass as a link

			$useremail = $this->input->post('email');

            $this->load->library('email', array('mailtype'=>'html'));

            $this->email->set_newline("\r\n");//prevents an error in CI for sending an email

            $this->email->from('info@barterful.com', "Barterful Password Reset");
            $this->email->to($useremail,'Some user guy');
            $this->email->subject("Reset your Password");

           

            $message = "<p>This email has been sent as a request to reset our password</p>";
            $message .= "<p><a href='".base_url()."login/reset/$temp_pass.'>Click here </a>if you want to reset your password, if not, then ignore</p>";
            $this->email->message($message);

            if($this->email->send())
            {
            	$this->load->model('membership_model');
            	$this->membership_model->set_temp_pass($temp_pass,$useremail);

            	$this->data['main_content']='contact_thanks';
				$this->load->view('includes/template', $this->data);
            }
            else{
            	show_error($this->email->print_debugger());
            }
		}
	}

	function reset(){
		$this->data['main_content'] = 'reset_password';
		$this->load->view('includes/template', $this->data);
	}

	
 public function reset_password($temp_pass){
    $this->load->model('membership_model');
    if($this->membership_model->is_temp_pass_valid($temp_pass)){

        $this->load->view('reset_password');

    }
    else{
        echo "the key is not valid bitch!";    
    }

}

 function resetPasswordProcess(){

	$this->load->library('form_validation');

	$temp_pass = $this->input->post('temp_password');
	$new_pass = $this->input->post('new_password');

	$this->form_validation->set_rules('temp_password','Temporary Password','trim|required|min_length[4]|max_length[50]');
	$this->form_validation->set_rules('new_password','New Password','trim|required|min_length[4]|max_length[32]');
	$this->form_validation->set_rules('confirm_password','New Password Confirmation','trim|required|min_length[4]|max_length[32]|matches[new_password]');

	if ($this->form_validation->run() == FALSE)
        {
        	echo "validation failed sir.";
            $this->reset();

        }
    else
    {
        $this->load->model('membership_model');

        if($this->membership_model->is_temp_pass_valid($temp_pass))
        {
            $this->membership_model->temp_reset_password($new_pass,$temp_pass);
        	echo "change successful bitch!";
            $this->reset();
        }
        else
        {
        	echo "change not at all successful bitch!";
        	$this->reset();
        }
    }
        
        
    }



 

}
?>