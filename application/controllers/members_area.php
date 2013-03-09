<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function index()
	{
		$data['main_content'] = 'members_area';
		$data['header_content'] = 'includes/headerout';
		$data['aside_content'] = 'includes/aside';
		$this->load->view('includes/template', $data);
	}
}
