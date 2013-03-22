<?php

class listings_model extends CI_Model{
		
	////////////////////////////////////////////////////////////////////////////
	//USED FOR SORTING BY A SPECIFIED COLUMN IN PHP - THIS SNIPPET IS AWESOME!!!
	//http://cyrilmazur.com/2008/11/sort-array-dataset-in-php.html
	////////////////////////////////////////////////////////////////////////////
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
					$params[] = SORT_DESC; 
				} 
			} 
	  
			$params[] = &$dataset; 
	  
			call_user_func_array('array_multisort',$params); 
		} 
	  
		return $dataset; 
	}
	////////////////////////////////////////////////
	//END - SNIPPET I BORROWED AND DO NOT UNDERSTAND
	/////////////////////////////////////////////////

	
	//Get all skill profiles posted for users not logged in
	function listAll($type, $sortset, $category){

		// if a custom filter variable was provided, apply it to the query
		if($category == 'all')
		{
			$category = "";
		}
		else
		{
			$category = " AND s_name = '" . $category . "'";
		}

		//based on whether the user wants to see skills profiles or wants profiles
		switch($type)
		{
			case "skills":
				$query = $this->db->query("
				Select p_fname, p_last_updated, p_avg_rating, s_name, sp_heading, s.s_id
				FROM skill_profiles sp
				JOIN profiles p on sp.p_id = p.p_id
				JOIN members m on p.m_id = m.m_id
				JOIN skills s on sp.s_id = s.s_id
				WHERE m_active = TRUE" . $category . " ORDER BY " . $sortset . " DESC;
				");
				break;
			case "wants":
				$query = $this->db->query("
				Select p_fname, p_last_updated, p_avg_rating, s_name, wp_expiry, wp_description as sp_heading, s.s_id
				FROM want_profiles wp
				JOIN profiles p on wp.p_id = p.p_id
				JOIN members m on p.m_id = m.m_id
				JOIN skills s on wp.s_id = s.s_id
				WHERE m_active = TRUE" . $category . " 
				AND (wp_expiry IS NULL OR wp_expiry > CURDATE()) 
				ORDER BY " . $sortset . " DESC;
				");
				break;
			case "projects":
				$query = $this->db->query("
				Select p_fname, p_last_updated, p_avg_rating, s_name, wp_expiry, wp_description as sp_heading, s.s_id
				FROM want_profiles wp
				JOIN profiles p on wp.p_id = p.p_id
				JOIN members m on p.m_id = m.m_id
				JOIN skills s on wp.s_id = s.s_id
				WHERE m_active = TRUE" . $category . " 
				AND wp_expiry IS NOT NULL AND wp_expiry > CURDATE() 
				ORDER BY " . $sortset . " DESC;
				");
				break;

		}
		
		if($query->num_rows > 0){
			foreach($query->result() as $key => $row){
				
				//////////////////////////////////////
				//give sort value based on date added
				///////////////////////////////////////

				//get the number of days between now and the last updated date
				$now = strtotime(date("Y-m-d"));
				$then = strtotime($row->p_last_updated);
				$date_diff = abs($now - $then);
				$days_diff = floor($date_diff/(60*60*24));

				//note that the $row->sort is a new column in the record/table
				//starting at 10, reduce the "score" of this factor by 1 per week old, min score is 0
				$row->sort =  max(10-round($days_diff/7), 0);
				
				//add to the sort score based on rating
				//the average rating is a decimal value (percentage)
				//a rating of 100% would raise the sort rating by 5
				//therefore rating is worth half of the recency of a post
				$row->sort += round($row->p_avg_rating * 5);
				
				//add $row to the array, including the newly created sort column
				$listing[]=$row;
			}

			//send the array to this AMAZING sort function, sending with it the column to sort by
			$listing = $this->sortDataset($listing, $sortset, 'DESC');
			return $listing;
		}
		
	}
	
	//Get all skill profiles that match the user logged in
	function listLoggedIn($userid,$type,$sortset,$category){

		// if a custom filter variable was provided, apply it to the query
		if($category == 'all')
		{
			$category = "";
		}
		else
		{
			$category = " AND s_name = '" . $category . "'";
		}

		//based on whether the user wants to see skills profiles or wants profiles
		switch($type)
		{
			case "skills":
				$query = $this->db->query("
				Select p.p_id, p_fname, p_last_updated, p_avg_rating, s_name, sp_heading
				FROM profiles p
				JOIN members m on p.m_id = m.m_id
				JOIN skill_profiles sp on p.p_id = sp.p_id
				JOIN skills s on sp.s_id = s.s_id
				WHERE m_active = TRUE" . $category . " ORDER BY " . $sortset . " DESC;
				");
				break;
			case "wants":
				$query = $this->db->query("
				Select p.p_id, p_fname, p_last_updated, p_avg_rating, s_name, wp_description as sp_heading
				FROM profiles p
				JOIN members m on p.m_id = m.m_id
				JOIN want_profiles wp on p.p_id = wp.p_id
				JOIN skills s on wp.s_id = s.s_id
				WHERE m_active = TRUE" . $category . " 
				AND (wp_expiry IS NULL OR wp_expiry > CURDATE()) 
				ORDER BY " . $sortset . " DESC;
				");
				break;
			case "projects":
				$query = $this->db->query("
				Select p.p_id, p_fname, p_last_updated, p_avg_rating, s_name, wp_expiry, wp_description as sp_heading
				FROM profiles p
				JOIN members m on p.m_id = m.m_id
				JOIN want_profiles wp on p.p_id = wp.p_id
				JOIN skills s on wp.s_id = s.s_id
				WHERE m_active = TRUE" . $category . " 
				AND wp_expiry IS NOT NULL AND wp_expiry > CURDATE() 
				ORDER BY " . $sortset . " DESC;
				");
				break;

		}
		
		//query that displays results
		/*$query = $this->db->query("
			Select p.p_id, p_fname, p_last_updated, p_avg_rating, s_name, sp_heading
			FROM profiles p
			JOIN members m on p.m_id = m.m_id
			JOIN skill_profiles sp on p.p_id = sp.p_id
			JOIN skills s on sp.s_id = s.s_id
			WHERE m_active = TRUE AND p.p_id !=" . $userid . ";");	*/
			
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

				//initialize a new sort column in the record
				$row->sort = 0;
				
				//////////////////////////////////////
				//give sort value based on date added
				///////////////////////////////////////

				//get the number of days between now and the last updated date
				$now = strtotime(date("Y-m-d"));
				$then = strtotime($row->p_last_updated);
				$date_diff = abs($now - $then);
				$days_diff = floor($date_diff/(60*60*24));
				$row->sort += max(10-round($days_diff/7), 0);
				
				//note that the $row->sort is a new column in the record/table
				//starting at 10, reduce the "score" of this factor by 1 per week old, min score is 0
				$row->sort += round($row->p_avg_rating * 8);
				
				/////////////////////////////////////////////////
				//give sort value based on matching wants to needs
				//////////////////////////////////////////////////

				//logged-in user(wants) to row(user) skills
				foreach($currentUserWants->result() as $keyUW => $rowUW)
				{
					//the id of the user of this row in the dataset
					$userID = $row->p_id;

					//the logged-in users own wants
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
							//each match adds 2 to the sort score
							$row->sort += 2;
						}
					}
					
				}
				
				//logged-in user(skills) to row(user) wants
				foreach($currentUserSkills->result() as $keyUS => $rowUS)
				{
					//the id of the user of this row in the dataset
					$userID = $row->p_id;

					//the logged-in users own skills
					$querySkills = $this->db->query("
					Select p.p_id, sp.s_id as s_id, wp.s_id as w_id
					FROM profiles p
					JOIN members m on m.m_id = p.m_id
					JOIN skill_profiles sp on p.p_id = sp.p_id
					JOIN want_profiles wp on p.p_id = wp.p_id
					WHERE m_active = TRUE AND p.p_id = " . $userID . ";");

					//compare the skills of the user logged in to the wants of the user in this row
					foreach($querySkills->result() as $keyID => $rowID)
					{
						if($rowUS->s_id == $rowID->w_id)
							{
								//each match adds 2 to the sort score
								$row->sort += 2;
							}
					}
				}
				
				//add the newly modified record to include the sort column to the array
				$listing[]=$row;
			}

			//send the array to this AMAZING sort function, sending with it the column to sort by
			$listing = $this->sortDataset($listing, $sortset, 'DESC');
			return $listing;
		}
		
	}

	//get all the possible skills to populate the sort bar
	function skillList()
	{
		
		$skillList = $this->db->query("
			SELECT s_id, s_name FROM skills;
			");

		foreach($skillList->result() as $k=>$r)
		{
			$skills[]=$r;
		}

		return $skills;
		
	}

	function simpleSearch($term)
	{
		
		$query = $this->db->query("
		Select p_fname, p_last_updated, p_avg_rating, s_name, sp_heading, s.s_id, sp_description, sp_keywords
		FROM skill_profiles sp
		JOIN profiles p on sp.p_id = p.p_id
		JOIN members m on p.m_id = m.m_id
		JOIN skills s on sp.s_id = s.s_id
		WHERE m_active = TRUE AND 
		(s_name like '%" . $term . "%' 
			OR sp_heading like '%" . $term . "%' 
			OR sp_description like '%" . $term . "%' 
			OR sp_keywords like '%" . $term . "%');
		");
		
		if($query->num_rows > 0){
			foreach($query->result() as $key => $row){
				
				//////////////////////////////////////
				//give sort value based on date added
				///////////////////////////////////////

				//get the number of days between now and the last updated date
				$now = strtotime(date("Y-m-d"));
				$then = strtotime($row->p_last_updated);
				$date_diff = abs($now - $then);
				$days_diff = floor($date_diff/(60*60*24));

				//note that the $row->sort is a new column in the record/table
				//starting at 10, reduce the "score" of this factor by 1 per week old, min score is 0
				$row->sort =  max(10-round($days_diff/7), 0);
				
				//add to the sort score based on rating
				//the average rating is a decimal value (percentage)
				//a rating of 100% would raise the sort rating by 5
				//therefore rating is worth half of the recency of a post
				$row->sort += round($row->p_avg_rating * 5);
				
				//add $row to the array, including the newly created sort column
				$listing[]=$row;
			}

			//only return $listing if there were rows in the dataset
			//send the array to this AMAZING sort function, sending with it the column to sort by
			$listing = $this->sortDataset($listing, 'p_fname', 'DESC');
			return $listing;
		}
	}
}

?>