<?php

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index()
	{
		$this->load->view('upload_form', array('error' => ' mooo' ));
	}
	
/*$id = $this->session->userdata('userid');
				//get the id value from the first pair in the array
				$id = $id[0]->m_id;*/

		//this is my attempt ANJA march 24//
		
function do_upload_profile()
	{
	$id = $this->session->userdata('userid');

		//get the id value from the first pair in the array
		$id = $id[0]->m_id;
			
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['file_name'] = "p".$id. '_'.'file_name';
		

		
		
		
		
		$this->load->model('profile_model');
		$this->data['profile'] = $this->profile_model->getProfile($id);
		
		
		$this->load->library('upload', $config);
		
		
		//////////

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('profile_form', $error);
		}
		else
		{
		$this->load->library('image_lib');
		$data = array('upload_data' => $this->upload->data());	
		
		
		$this->profile_model->do_upload_profile($data);
		
		
		
		//$this->load->model('profile_model');
		$this->load->view('upload_success', $data);
		}
		
		/*
		//not needed
		$this->data['profile'] = $this->profile_model->getProfile($id);//*/
		
			
	}
	
	//////////////////////////// ORIGINAL DONT CHANGE 	////////////////

	function do_upload()
	{
	
						
						$id = $this->session->userdata('userid');

		//get the id value from the first pair in the array
		$id = $id[0]->m_id;
					 
			
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['file_name'] = $id. '_'.'file_name';
		

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $error);
		}
		else
		{
		$this->load->library('image_lib');
		
		
		
			$data = array('upload_data' => $this->upload->data());
			

			$this->load->view('upload_success', $data);
			
			
						
		}
		}
		
		



}
