<?php

class listings_model extends CI_Model{
		
	//USED FOR SORTING BY A SPECIFIED COLUMN
	//http://cyrilmazur.com/2008/11/sort-array-dataset-in-php.html
	public static function sortDataset($dataset,$sortby,$order = 'ASC') { 
		$columns = array(); 
	  
		foreach ($dataset as $key => $row) { 
			foreach($row as $k => $v) { 
				$columns[$k][$key] = $v; 
			} 
		} 
	  
		if (array_key_exists($sortby,$columns)) {
			$params = array(); 
	  
			$params[] = &$columns[$sortby]; 
			$params[] = constant('SORT_'.$order); 
	  
			foreach($columns as $key => $column) { 
				if ($key != $sortby) { 
					$params[] = &$column; 
					$params[] = SORT_ASC; 
				} 
			} 
	  
			$params[] = &$dataset; 
	  
			call_user_func_array('array_multisort',$params); 
		} 
	  
		return $dataset; 
	}
	
	//Get all skill profiles posted for users not logged in
	function listAll(){
		$query = $this->db->query("
			Select p_fname, p_last_updated, p_avg_rating, s_name, sp_heading, s.s_id
			FROM skill_profiles sp
			JOIN profiles p on sp.p_id = p.p_id
			JOIN members m on p.m_id = m.m_id
			JOIN skills s on sp.s_id = s.s_id
			WHERE m_active = TRUE;
			");
		if($query->num_rows > 0){
			foreach($query->result() as $key => $row){
				
				//give sort value based on date added
				$now = strtotime(date("Y-m-d"));
				$then = strtotime($row->p_last_updated);
				$date_diff = abs($now - $then);
				$days_diff = floor($date_diff/(60*60*24));
				$row->sort =  max(10-round($days_diff/7), 0);
				
				//give sort value based on rating
				$row->sort += round($row->p_avg_rating * 5);
				
				$listing[]=$row;
			}
			//array_multisort($sort, SORT_DESC, $listing);
			//uasort($listing, array($this, 'cmp'));
			$listing = $this->sortDataset($listing, 'sort', 'DESC');
			return $listing;
		}
		
	}
	
	//Get all skill profiles that match the user logged in
	function listLoggedIn($userid){
		//query that displays results
		$query = $this->db->query("
			Select p.p_id, p_fname, p_last_updated, p_avg_rating, s_name, sp_heading
			FROM profiles p
			JOIN members m on p.m_id = m.m_id
			JOIN skill_profiles sp on p.p_id = sp.p_id
			JOIN skills s on sp.s_id = s.s_id
			WHERE m_active = TRUE AND p.p_id !=" . $userid . ";");	
			
		//query to compare wants
		$currentUserWants = $this->db->query("
			Select p.p_id, wp.s_id as w_id
			FROM profiles p
			JOIN want_profiles wp on p.p_id = wp.p_id
			WHERE p.p_id = $userid;
			");
		
		//query to compare skills
		$currentUserSkills = $this->db->query("
			Select p.p_id, sp.s_id as s_id
			FROM profiles p
			JOIN skill_profiles sp on p.p_id = sp.p_id
			WHERE p.p_id = $userid;
			");
		
		//go through each row, add a sort rating and send the data
		if($query->num_rows > 0){
			foreach($query->result() as $key => $row){
				$row->sort = 0;
				
				//give sort value based on date added
				$now = strtotime(date("Y-m-d"));
				$then = strtotime($row->p_last_updated);
				$date_diff = abs($now - $then);
				$days_diff = floor($date_diff/(60*60*24));
				$row->sort += max(10-round($days_diff/7), 0);
				
				//give sort value based on rating
				$row->sort += round($row->p_avg_rating * 8);
				
				//give sort value based on matching wants to needs
				foreach($currentUserWants->result() as $keyUW => $rowUW)
				{
					//the id of the user of this row in the dataset
					$userID = $row->p_id;
					$querySkills = $this->db->query("
					Select p.p_id, sp.s_id as s_id, wp.s_id as w_id
					FROM profiles p
					JOIN members m on m.m_id = p.m_id
					JOIN skill_profiles sp on p.p_id = sp.p_id
					JOIN want_profiles wp on p.p_id = wp.p_id
					WHERE m_active = TRUE AND p.p_id = " . $userID . ";");
					
					//compare the wants of the user logged in to the skills of the user in this row
					foreach($querySkills->result() as $keyID => $rowID)
					{
						if($rowUW->w_id == $rowID->s_id)
						{
							$row->sort += 3;
						}
					}
					
				}
				
				//compare the skills of the user logged in to the wants of the user in this row
				foreach($currentUserSkills->result() as $keyUS => $rowUS)
				{
					$userID = $row->p_id;
					$querySkills = $this->db->query("
					Select p.p_id, sp.s_id as s_id, wp.s_id as w_id
					FROM profiles p
					JOIN members m on m.m_id = p.m_id
					JOIN skill_profiles sp on p.p_id = sp.p_id
					JOIN want_profiles wp on p.p_id = wp.p_id
					WHERE m_active = TRUE AND p.p_id = " . $userID . ";");
					foreach($querySkills->result() as $keyID => $rowID)
					{
						if($rowUS->s_id == $rowID->w_id)
							{
								$row->sort += 3;
							}
					}
				}
				
				$listing[]=$row;
			}
			$listing = $this->sortDataset($listing, 'sort', 'DESC');
			return $listing;
		}
		
	}
}

?>