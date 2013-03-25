<?php 
class Membership_model extends CI_Model {
	
	function validate(){
		$this->db->where('m_username', $this->input->post('username'));
		$this->db->where('m_password', md5($this->input->post('password')));
		$query = $this->db->get('members');
		
		
		if($query->num_rows == 1) {
			
			return true;
		}
	}

	//uses the username to get the user id
	function getID(){
		$query = $this->db->query('SELECT m_id from members where m_username ="' . $this->input->post('username') . '"');
		if($query->num_rows == 1){
			foreach($query->result() as $key => $row){
				$user[]=$row;
			}
			return $user;
		}
	}
	
	function create_member() {
		//getting the username from the post array storing it in username and getting the data ready to insert
		$username = $this->input->post('username');
		
		$new_member_insert_data = array (
		//'first_name' => $this->input->post('first_name'),
		//'last_name' => $this->input->post('last_name'),
		'm_username' => $this->input->post('username'),
		'm_email' => $this->input->post('email'),
		'm_sex' => $this->input->post('sex'),
		//we run the md5 function so we can store 32 bit hash in our database
		'm_password' => md5($this->input->post('password'))
		);
		//doing our insert
		$insert = $this->db->insert('members', $new_member_insert_data);
		return $insert;
		
	}
	
	function check_if_username_exists($username) {
	$this->db->where('m_username', $username);
	$result = $this->db->get('members');
	
	if($result->num_rows() > 0 ){
		
		return FALSE; //username tkane
		}
		else
		{
		return TRUE; //username can be reg'd
		
		}
		
	}
	
	function check_if_email_exists($email) {
		$this->db->where('m_email', $email);
		$result = $this->db->get('members');
		
		if($result->num_rows() > 0 ){
		
		return FALSE; //username tkane
		}
		else
		{
		return TRUE; //username cna be reg'd
		
		}
		
	}
}