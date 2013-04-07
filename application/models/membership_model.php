<?php 
class Membership_model extends CI_Model {
	
	function validate(){
		//validates the users login with |user input| vs |database username and encrypted password|
		$this->db->where('m_username', $this->input->post('username'));
		$this->db->where('m_password', md5($this->input->post('password')));
		//accesses the members table in the varible $query
		$query = $this->db->get('members');
		
		//$query runs the num_rows function to see if it has any of the requested data
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
		'm_username' => $this->input->post('username'),
		'm_email' => $this->input->post('email'),
		//we run the md5 function so we can store 32 bit hash in our database
		'm_password' => md5($this->input->post('password'))
		);
		//doing our insert into the members table in the database
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