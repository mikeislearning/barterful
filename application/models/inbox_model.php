<?php

class inbox_model extends CI_Model
{

function listAll($id, $view = 'inbox', $to = "")
	{
		/*
		this entire function is used to display all the messages in conversation view as well as in the inbox and sent messages.
		the $view variable determines what sort of output is required and changes the query as needed.
		THERE IS A PROBLEM HERE... in inbox/outbox view the messages are/were grouped by conversation so that there are not 10 
		messages in a row to/from the same person. These are ordered by date. The issue is that while the order shows correctly, the
		actual message data shown as the most recent message is from an earlier message (this is a problem with using GROUP BY in mySQL)
		Right now I commented out the first section below and replaced it with one that doesnt group the messages to avoid this problem. 
		It may make more sense to get rid of the inbox/outbox functionality if conversations are grouped already.
		*/



		////////////////////////////////////////////////
		//This is the section that groups the messages
		///////////////////////////////////////////////
		/*

		//find the highest date
		$date = 'MAX(mes_date) as max_date,';

		//if this is an inbox view, the messages must be sent to the current user id, group by sender
		if($view == 'inbox')
			{$view = 'mes_to=' . $id . " GROUP BY mes_from";}

		//if outbox view, messages sent FROM the current user id, group by receiver
		else if($view == 'outbox')
			{$view = 'mes_from=' . $id . " GROUP BY mes_to";}

		//if conversation, the message must either be from the current user to the selected one or vice versa
		else 
		{
			$view = 'mes_to=' . $id . ' AND mes_from=' . $to . ' OR mes_to=' . $to . ' AND mes_from=' . $id;

			//the max date is not a concern here since all messages are displayed
			$date = 'mes_date,';
		}
		*/


		////////////////////////////////////////////////////////
		//This is the section that  DOES NOT groups the messages
		////////////////////////////////////////////////////////

		//if this is an inbox view, the messages must be sent to the current user id
		if($view == 'inbox')
			{$view = 'mes_to=' . $id;}

		//if outbox view, messages sent FROM the current user id
		else if($view == 'outbox')
			{$view = 'mes_from=' . $id;}

		//if conversation, the message must either be from the current user to the selected one or vice versa
		else 
		{
			$view = 'mes_to=' . $id . ' AND mes_from=' . $to . ' OR mes_to=' . $to . ' AND mes_from=' . $id;
		}
		

		$query = $this->db->query("
			SELECT mes_from, mes_to, mes_message, mes_date as date, sk.s_name as s_from, mes_from_s, mes_from_unit, mes_to_unit, mes_to_s, s.s_name as s_to, pr.p_fname as receiver, p.p_fname as sender
				FROM messages mes
				JOIN skills s ON mes.mes_to_s = s.s_id
				JOIN skills sk ON mes.mes_from_s = sk.s_id
				JOIN profiles pr ON mes.mes_to = pr.p_id
				JOIN profiles p ON mes.mes_from = p.p_id
				where " . $view . "
				ORDER BY date DESC;
			");

		//add each row to the Array and return
		if($query->num_rows > 0)
		{
			foreach($query->result() as $k=>$r)
			{
				$inboxitem[]=$r;
			}

			return $inboxitem;
		}
	}



	function sendMessage($id,$to,$to_skill,$to_unit,$from_skill,$from_unit,$message,$response)
	{		
		//set the timezone so that the time inputs correctly
		date_default_timezone_set('America/New_York');
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