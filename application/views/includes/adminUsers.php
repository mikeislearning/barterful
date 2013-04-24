<h1> Users </h1>

<table>
	<tr>
		<th>Active</th>
		<th>Username</th>
		<th>Email</th>
		<th>Sex</th>
		<th>Join Date</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>

<?php if($row) foreach($row as $r): ?>
	<tr>
		<td><input type="checkbox" checked='<?=$r->m_active ?>' /></td>
		<td><?=$r->m_username ?></td>
		<td><?=$r->m_email ?></td>
		<td><?=$r->m_sex ?></td>
		<td><?=$r->m_join_date ?></td>

	</tr>
<?php endforeach; ?>

</table>