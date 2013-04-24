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

	</tr>
<?php endforeach; ?>

</table>