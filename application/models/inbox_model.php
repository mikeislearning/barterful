<?php

class inbox_model extends CI_Model{

function listAll($id)
	{
		
		$query = $this->db->query("
			SELECT mes_from, mes_to, mes_message, mes_date, sk.s_name as s_from, mes_from_unit, mes_to_unit, s.s_name as s_to, pr.p_fname as receiver, p.p_fname as sender
				FROM messages mes
				JOIN skills s ON mes.mes_to_s = s.s_id
				JOIN skills sk ON mes.mes_from_s = sk.s_id
				JOIN profiles pr ON mes.mes_to = pr.p_id
				JOIN profiles p ON mes.mes_from = p.p_id
				where mes_to=" . $id . ";
			");
		if($query->num_rows > 0){
			foreach($query->result() as $k=>$r)
			{
				$inboxitem[]=$r;
			}

			return $inboxitem;
		}
		
	}

}

?>