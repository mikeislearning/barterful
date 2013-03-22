<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//--------------------------------------------------------------------------//

//--------------NOTE: THIS CONTROLLER IS NOT CURRENTLY IN USE!!!-------------//

//--------------------------------------------------------------------------//

class Members_area extends CI_Controller {

	//wait until this is actually called to make mods to it
	public function index()
	{
		$data['main_content'] = 'members_area';
		$data['header_content'] = 'includes/headerout';
		$id = $this->session->userdata('userid');
		$this->load->model('listings_model');
		$data['idu'] = "THIS IS AN ID";
		$data['row'] = $this->listings_model->listLoggedIn($id);
		$this->load->view('includes/template', $this->data);
	}
}
