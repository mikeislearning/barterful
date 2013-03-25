<?php 
class profile_model extends CI_Model {
	
function getProfile(){

}

function create_profile() {
	$this->load->helper('date');
	
$id = $this->session->userdata('userid');

//gets the time to be inserted into daabase
//$datestring = "%Y-%m-%d %h:%i:";
//$time = time();


$time =  date('Y-m-d H:i:s');

echo $time;


		//get the id value from the first pair in the array
		$id = $id[0]->m_id;
		//getting the username from the post array storing it in username and getting the data ready to insert
		$username = $this->input->post('username');
		
		$new_profile_insert_data = array (
		'p_fname' => $this->input->post('first_name'),
		'p_lname' => $this->input->post('last_name'),
		'm_id' => 	$id,
		'p_last_updated' => $time		
		//'m_username' => $this->input->post('username'),
		//'m_email' => $this->input->post('email'),
		//'m_sex' => $this->input->post('sex'),
		//we run the md5 function so we can store 32 bit hash in our database
		//'m_password' => md5($this->input->post('password'))
		);
		//doing our update
		
//gets the id and updates the profile according to the m_id foreign key
$this->db->where('m_id', $id);
$this->db->update('profiles', $new_profile_insert_data); 
	}

	}