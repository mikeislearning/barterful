<?php

class inbox_model extends CI_Model
{

function listAll($id, $view = 'inbox', $to = "")
	{
		$date = 'MAX(mes_date) as max_date,';
		if($view == 'inbox')
			{$view = 'mes_to=' . $id . " GROUP BY mes_from";}
		else if($view == 'outbox')
			{$view = 'mes_from=' . $id . " GROUP BY mes_to";}
		else 
		{
			$view = 'mes_to=' . $id . ' AND mes_from=' . $to . ' OR mes_to=' . $to . ' AND mes_from=' . $id;
			$date = 'mes_date,';
		}
		
		$query = $this->db->query("
			SELECT mes_from, mes_to, mes_message, " . $date . " mes_date as date, sk.s_name as s_from, mes_from_s, mes_from_unit, mes_to_unit, mes_to_s, s.s_name as s_to, pr.p_fname as receiver, p.p_fname as sender
				FROM messages mes
				JOIN skills s ON mes.mes_to_s = s.s_id
				JOIN skills sk ON mes.mes_from_s = sk.s_id
				JOIN profiles pr ON mes.mes_to = pr.p_id
				JOIN profiles p ON mes.mes_from = p.p_id
				where " . $view . "
				ORDER BY date DESC;
			");

		////////////////////GoodQuery////////////////////////
		/*
		SELECT mes_id, mes_from, mes_to, mes_message, mes_date, sk.s_name as s_from, mes_from_s, mes_from_unit, mes_to_unit, mes_to_s, s.s_name as s_to, pr.p_fname as receiver, p.p_fname as sender
		FROM messages mes
		JOIN skills s ON mes.mes_to_s = s.s_id
		JOIN skills sk ON mes.mes_from_s = sk.s_id
		JOIN profiles pr ON mes.mes_to = pr.p_id
		JOIN profiles p ON mes.mes_from = p.p_id
		where mes_date IN
			(
	        SELECT MAX(mes_date) FROM messages
	         WHERE mes_to = 1
	         GROUP BY mes_from
	         )
		ORDER BY mes_date DESC;
		*///////////////////////////////////////////////////

		if($query->num_rows > 0)
		{
			foreach($query->result() as $k=>$r)
			{
				$inboxitem[]=$r;
			}

			return $inboxitem;
		}
		else{return "";}
	}



	function sendMessage($id,$to,$to_skill,$to_unit,$from_skill,$from_unit,$message,$response)
	{		
		$date = date('Y-m-d H:i:s');

		$this->db->set('mes_from', $id);
		$this->db->set('mes_to', $to);
		$this->db->set('mes_date', $date);
		$this->db->set('mes_from_s', $from_skill);
		$this->db->set('mes_to_s', $to_skill);
		$this->db->set('mes_from_unit', $from_unit);
		$this->db->set('mes_to_unit', $to_unit);
		$this->db->set('mes_message', $message);
		$this->db->set('mes_status', $response);
		$this->db->insert('messages'); 
		
		return $this->listAll($id,'inbox','');
	}

}

?>