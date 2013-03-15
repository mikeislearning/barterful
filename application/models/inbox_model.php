<?php

class inbox_model extends CI_Model
{

function listAll($id, $view = 'inbox', $to = "")
	{
		if($view == 'inbox')
			{$view = 'mes_to=' . $id;}
		else if($view == 'outbox')
			{$view = 'mes_from=' . $id;}
		else {$view = 'mes_to=' . $id . ' AND mes_from=' . $to . ' OR mes_to=' . $to . ' AND mes_from=' . $id;}
		
		$query = $this->db->query("
			SELECT mes_from, mes_to, mes_message, mes_date, sk.s_name as s_from, mes_from_s, mes_from_unit, mes_to_unit, mes_to_s, s.s_name as s_to, pr.p_fname as receiver, p.p_fname as sender
				FROM messages mes
				JOIN skills s ON mes.mes_to_s = s.s_id
				JOIN skills sk ON mes.mes_from_s = sk.s_id
				JOIN profiles pr ON mes.mes_to = pr.p_id
				JOIN profiles p ON mes.mes_from = p.p_id
				where " . $view . "
				ORDER BY mes_date DESC;
			");
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
		$date = date('Y-m-d');

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