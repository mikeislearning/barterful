<h1> Users </h1>

<table>
	<tr>
		<th>Active</th>
		<th>Username</th>
		<th>Email</th>
		<th>Sex</th>
		<th>Join Date</th>
		<th></th>
	</tr>

<?php if($row) foreach($row as $r): ?>
	<tr>
		<td><input type="checkbox" checked='<?=$r->m_active ?>' class="actives" id='<?=$r->m_id ?>' /></td>
		<td><?=$r->m_username ?></td>
		<td><?=$r->m_email ?></td>
		<td><?=$r->m_sex ?></td>
		<td><?=$r->m_join_date ?></td>
		<td>
			<form id="btn_msg_user" name="btn_msg_user" method="POST" action='<?=base_url()?>index.php/profiles/redir'>
       			<input type="hidden" id="p_id" name="p_id" value='<?=$r->m_id ?>' />
       			<input type="submit" class="btn btngreen" value="See/Edit Profile" />
       		</form>
       	</td>

	</tr>

<?php endforeach; ?>

</table>

<script>
	$(document).ready(function(){

		$('.actives').change(function()
		{
			alert(this.val());
		})
	})
</script>
