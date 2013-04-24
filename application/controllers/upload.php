<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload extends CI_Controller {

function __construct()
{
	parent::__construct();
	$this->logged_in();
	//$this->load->helper(array('form', 'url'));
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
 

function index(){
	$this->load->model('profile_model');
	if($query = $this->input->post('upload')){
		$this->profile_model->do_upload(); 
	}
	$this->data['main_content']='profile_form';
	$this->load->view('includes/template',$this->data);	
}

//---------------------------------------------------------------------------------//
//this section uploads the user's profile picture
//---------------------------------------------------------------------------------//
function do_upload_profile(){

	//get the array of id's (there should just be one in the array)
	$id = $this->session->userdata('userid');

	//get the id value from the first pair in the array
	$id = $id[0]->m_id;
		
	$this->load->model('profile_model');
	 if($this->input->post('upload')){//checks if the upload is coming from the upload form
		if (!$this->profile_model->do_upload_profile()){ //if upload is unsuccessful
			$this->data['error'] = "unsuccessful";
			//$this->load->view('profile_form', $data);
			$this->data['main_content']='profile_form';
			$this->data['main_content']='includes/update_profile';
		 	$this->load->view('includes/template', $this->data);
		 	return;
	 	}
	 	
	 }
	$this->load->model('listings_model');
	$this->load->model('profile_model');
	$this->data['profile'] = $this->profile_model->getProfile($id);
	$this->data['skills'] = $this->listings_model->listAll("skills","sp_id","all",$id);
	$this->data['wants'] = $this->listings_model->listAll("wants","sp_id","all",$id);
	$this->data['projects'] = $this->listings_model->listAll("projects","sp_id","all",$id);
	$this->data['skill_list'] = $this->listings_model->skillList();
	$this->data['main_content']='profile_form';
 	$this->load->view('includes/template',$this->data);
/*COPIED FROM HERE	$this->data['profile'] = $this->profile_model->getProfile();
	$this->data['member'] = $this->profile_model->getMemberInfo();
	$this->load->library('upload', $config);
	if (!$this->upload->do_upload())
	{
		//$error = array('error' => $this->upload->display_errors());
		$this->data['error'] = "usuccessful";
		//$this->load->view('profile_form', $data);
		$this->data['main_content']='profile_form';
	 	$this->load->view('includes/template',$this->data);		
	}
	else{
	$this->load->library('image_lib');
	$data = array('upload_data' => $this->upload->data());			
	if($query = $this->profile_model->do_upload_profile($data)){
	
	$this->data['profile_updated'] = "Your profile has been updated";
	//$this->load->view('upload_success');
	//$this->load->view('profile_form', $data); COPIED FORM HERE*/
}


function display_errors(){
		echo "you broke it!";
}

//---------------------------------------------------------------------------------//
//do_upload() is not currently in use --Anja
//---------------------------------------------------------------------------------//

function do_upload(){
	$id = $this->session->userdata('userid');
	$id = $id[0]->m_id;
				 
		
	$config['upload_path'] = './uploads/';
	$config['allowed_types'] = 'gif|jpg|png';
	$config['max_size']	= '100';
	$config['max_width']  = '1024';
	$config['max_height']  = '768';
	$config['file_name'] = $id. '_'.'file_name';
	
	$this->load->library('upload', $config);

	if ( !$this->upload->do_upload())
	{
		$error = array('error' => $this->upload->display_errors());

		$this->load->view('profile_form', $error);
	}
	else{
		$this->load->library('image_lib');
		$data = array('upload_data' => $this->upload->data());		
		//$this->load->view('profile_form', $data);	
	}
}
	
	



}
