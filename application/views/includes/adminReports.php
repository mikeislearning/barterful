<?php if($new): ?>
<h1>Outstanding Reports:</h1>

<table>
<tr>
	<th>User</th>
	<th>Comment</th>
	<th>Date</th>
	<th></th>
	<th></th>
</tr>
<?php foreach($new as $r): ?>
	<tr>
		<td><a href='<?php echo base_url() . "index.php/profiles/viewprofile/" . $r->p_id; ?>'><?=$r->m_username ?></a></td>
		<td><?=$r->rep_description ?></td>
		<td><?=$r->rep_date ?></td>
		<td><input type="button" value="Ignore" onclick='subignore(<?=$r->rep_id ?>)' /></td>
		<td><input type="button" value="Deactivate User Profile" onclick='subdeactivate(<?=$r->rep_id ?>)' /></td>
	</tr>
<?php endforeach; echo "<table />"; else: ?>
	<h1>No Unreviewed Reports Exist!</h1>
<?php endif; ?>


<?php if($old): ?>
<h1>Reviewed Reports:</h1>

<table>
<tr>
	<th>User</th>
	<th>Comment</th>
	<th>Date</th>
	<th>Action Taken</th>
	<th></th>
</tr>
<?php foreach($old as $r): ?>
	<tr>
		<td><a href='<?php echo base_url() . "index.php/profiles/viewprofile/" . $r->p_id; ?>'><?=$r->m_username ?></a></td>
		<td><?=$r->rep_description ?></td>
		<td><?=$r->rep_date ?></td>
		<td><?=$r->action ?></td>
		<td><input type="button" value="Re-Open Report" onclick='subreopen(<?=$r->rep_id ?>)' /></td>
	</tr>
<?php endforeach; echo "<table />"; else:?>
<h1>No Reviewed Reports Exist!</h1>
<?php endif; ?>
