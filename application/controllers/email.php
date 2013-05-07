<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* SEND EMAIL WITH GMAIL */

class Email extends CI_Controller
{
	
	
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
		$this->load->view('landingpage');
	}

	//this function creates a rule for the captcha, so it can go with the other validation rules
	function captcha_check()
	{
		 
		 $privatekey = "6LdvIN8SAAAAAGcMHLQ0L_KlowuZTf6BeslFu6GR";
		 $resp = recaptcha_check_answer ($privatekey,
		                                 $_SERVER["REMOTE_ADDR"],
		                                 $_POST["recaptcha_challenge_field"],
		                                 $_POST["recaptcha_response_field"]);

		 if($resp->is_valid){
		 	return TRUE;
		 }
		 else
		 {
		 	return FALSE;
		 	
		 }


	}
	
	function send()
	{
		//$echo 'hello from send'; die();
		
		$this->load->library('form_validation');
		$this->load->view('recaptchalib');
		//can set 3 parameters: field name, error message, validation rules separated by |'s
		$this->data['main_content'] = 'contact';

		$this->form_validation->set_message('captcha_check', "The reCAPTCHA wasn't entered correctly. Captcha's suck. We know. Please try again.");
		
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('message','Message','required');
		
		$this->form_validation->set_rules('recaptcha_challenge_field','reCAPTCHA','callback_captcha_check');

		//ZIS is the recaptcha check! yayyyyy!!!!
	
		if($this->form_validation->run()==FALSE){
		echo "Validation Error!";
		
		$this->load->view('includes/template', $this->data);		
		}
		
		else
		{	
			//validation passed
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$message = $this->input->post('message');
			$this->load->library('email');
			
			
			
			$this->email->set_newline("\r\n");//prevents an error in CI for sending an email
			
			$this->email->from($email);
			$this->email->to('barterful@gmail.com','Team Barterful');
			$this->email->subject('From our newest fan '.$name);
			$this->email->message($message);
			

			if($this->email->send())
			{	

				//$this->data['main_content']='contact_thanks';
				//$this->load->view('includes/template', $this->data);	
				echo "send success!";
				
				
			}
			else
			{
				//$this->load->view('includes/template', $this->data);	
				echo 'Send failed. Sorry :( ' ;
				show_error($this->email->print_debugger());
			}
		
		}
	}
}
