<?php

class Data_model extends CI_Model{
	
/* THIS IS THE MOST BASIC VERSION OF A SELECT ALL
	function getAll(){
		$query = $this->db->query("SELECT * FROM news");
		if($query->num_rows > 0){
			foreach($query->result() as $row){
				$data[]=$row;
			}
			return $data;
		}
		
	}
*/
	
/* THIS VERSION USES A GET REQUEST
	function getAll(){
		$q = $this->db->get('news');//equivalent of the upper bit, with limits included for the 2nd and 3rd parameters (optional)
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $row){
				$data[]=$row;
			}
			return $data;
		}
		
	}
	
*/
/* THIS VERSION ALLOWS YOU TO SELECT ONLY CERTAIN FIELDS OF THE TABLE

	function getAll(){
		$this->db->select('title,text');
		$q = $this->db->get('news');
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $row){
				$data[]=$row;
			}
			return $data;
		}
	}
*/
/* THIS VERSION IS LIKE A PREPARED STATEMENT, TO PROTECT AGAINST SQL INJECTION 
	function getAll(){
		$sql = "SELECT title, slug, text FROM news WHERE id = ? AND title = ?";//the ? replaced with whatever we bind to it in the query parameter
		$q = $this->db->query($sql, array(3,'titleer'));//you create an array where you use multiple ? marks in the select statement
		
				if($q->num_rows() > 0){
			foreach($q->result() as $row){
				$data[]=$row;
			}
			return $data;
		}
	}
	*/


/* THIS VERSION SEPARATE EACH SQL STATEMENT INTO A SEPARATE $THIS STATEMENT */
	function getAll(){
		$this->db->select('title, text');
		$this->db->from('news');
		$this->db->where('id',1);
		
		$q = $this->db->get();
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $row){
				$data[]=$row;
			}
			return $data;
		}
	}
	

}











?>