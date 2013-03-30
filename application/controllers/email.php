
<?php

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
			 $this->data['header_content'] = 'includes/headerin';
		 }
	 }

	
	function index()
	{
		$this->load->view('landingpage');
	}
	
	function send()
	{
		//$echo 'hello from send'; die();
		
		$this->load->library('form_validation');
		
		//can set 3 parameters: field name, error message, validation rules separated by |'s
		$this->data['main_content'] = 'contact';
		
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('message','Message','required');
		//id name, name it prints out, the rules

		//ZIS is the recaptcha check! yayyyyy!!!!
		$this->load->view('recaptchalib');
		 $privatekey = "6LdvIN8SAAAAAGcMHLQ0L_KlowuZTf6BeslFu6GR";
		 $resp = recaptcha_check_answer ($privatekey,
		                                 $_SERVER["REMOTE_ADDR"],
		                                 $_POST["recaptcha_challenge_field"],
		                                 $_POST["recaptcha_response_field"]);
		
		
		if($this->form_validation->run()==FALSE){
		
		$this->load->view('includes/template', $this->data);		
		}
		elseif(!$resp->is_valid){
			$this->load->view('includes/template', $this->data);
			//this error message doesn't load in the way I want it to, which is unfortunate
			echo "The reCAPTCHA wasn't entered correctly. Go back and try it again." .
		        "(reCAPTCHA said: " . $resp->error . ")";
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
			
			//$path = $this->config->item('server_root');//creates a proper both on how you'd find a newsletter

			if($this->email->send())
			{	
				//if($this->input->post('ajax')){
				//attempting ajax here
				//$this->data['main_content']='contact_thanks';
				//}
				$this->data['main_content']='contact_thanks';
				$this->load->view('includes/template', $this->data);	
				
				
			}
			else
			{
				$this->load->view('includes/template', $this->data);	
				echo 'Send failed. Sorry :( ' ;
				show_error($this->email->print_debugger());
			}
		
		}
	}
}
