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

	//uses the username to get the user id
	function getType(){
		$query = $this->db->query('SELECT m_type from members where m_username ="' . $this->input->post('username') . '"');
		if($query->num_rows == 1){
			foreach($query->result() as $key => $row){
				$user[]=$row;
			}
			return $user;
		}
	}
	
	function create_member() {
		date_default_timezone_set('America/New_York');
		$date = date('Y-m-d H:i:s');
		//getting the username from the post array storing it in username and getting the data ready to insert
		$username = $this->input->post('username');
		$new_member_insert_data = array (
		'm_username' => $this->input->post('username'),
		'm_email' => $this->input->post('email'),
		//we run the md5 function so we can store 32 bit hash in our database
		'm_password' => md5($this->input->post('password')),
		'm_join_date' => $this->input->post($date)
		);
		//doing our insert into the members table in the database
		$insert = $this->db->insert('members', $new_member_insert_data);
		return $insert;
		
	}
	
	function check_if_username_exists($username) {
	$this->db->where('m_username', $username);
	$result = $this->db->get('members');
	
	if($result->num_rows() > 0 ){
		
		return FALSE; //username taken
		}
		else
		{
		return TRUE; //username can be registered
		
		}
		
	}
	
	function check_if_email_exists($email) {
		$this->db->where('m_email', $email);
		$result = $this->db->get('members');
		
		if($result->num_rows() > 0 ){
		
		return FALSE; //username taken
		}
		else
		{
		return TRUE; //username cna be registered
		
		}
		
	}

	function change_password(){
		//SELECT m_id FROM members WHERE m_username = session-username AND m_password=posted-old-password
		$this->db->select('m_id');
		$this->db->where('m_username',$this->session->userdata('username'));
		$this->db->where('m_password',md5($this->input->post('old_password')));
		$query=$this->db->get('members');

		//if such a row exists
		if ($query->num_rows() > 0)
		{
			//stores the found row in the variable $row
			$row=$query->row();
	
			//if the id of the found row is equal to the session id
			if($row->m_id === $this->session->userdata('userid')[0]->m_id)
            {
            		//stores the value of the new password in an array
                    $data = array(
                      'm_password' => md5($this->input->post('new_password'))
                     );
               //UPDATE members SET m_password to new_password WHERE the next two statements are true
               $this->db->where('m_username',$this->session->userdata('username'));
               $this->db->where('m_password',md5($this->input->post('old_password')));
               if($this->db->update('members', $data)) 
               {
               echo "Password Changed Successfully";
               }
               else
               {
                echo "Something Went Wrong, Password Not Changed";
               }
            }
            else
            {
            echo "Something Went Super Wrong, Password Not Changed";//unable to match up with session data
            }


        }
        else{
        echo "Wrong Old Password";//incorrect old password
        }



	}








}