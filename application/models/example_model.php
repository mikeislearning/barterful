<?php

class Main_model extends CI_Model{
	
	function getAll(){
		$query = $this->db->get('barterful');
		//gets everything from the test table
		
		if($query->num_rows()>0){
			
			foreach ($query->result() as $row)
			{
			   $data[] = $row;
			}
		
		return $data;
		}
	}
}