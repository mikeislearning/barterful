<?php

/* SEND EMAIL WITH GMAIL */

class Email extends CI_Controller
{
	
	
function __construct()
	{
		parent::__construct();
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
		
		
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('message','Message','required');
		//id name, name it prints out, the rules
		
		if($this->form_validation->run()==FALSE){
			$this->load->view('landingpage');		
		}
		
		else
		{	
			//validation passed
			
			$email = $this->input->post('email');
			$message = $this->input->post('message');
			$this->load->library('email');
			
			$this->email->set_newline("\r\n");//prevents an error in CI for sending an email
			
			$this->email->from($email);
			$this->email->to('barterful@gmail.com','Team Barterful');
			$this->email->subject('A Barterful fan');
			$this->email->message($message);
			
			//$path = $this->config->item('server_root');//creates a proper both on how you'd find a newsletter

			if($this->email->send())
			{	
				
				$this->load->view('index');	
				echo 'Send is successful!';
				//$this->load->view('signup_confirmation_view');
			}
			else
			{
				$this->load->view('index');	
				echo 'Send failed. Sorry :( ' ;
				show_error($this->email->print_debugger());
			}
		
		}
	}
}
