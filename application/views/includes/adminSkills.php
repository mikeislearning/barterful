<table>
	<tr>
		<td>Skill</td>
		<td></td>
		<td></td>
	</tr>

<?php foreach($row as $r): ?>
<tr>
	<form id="form_update_<?=$r->s_id?>" name="form_update_<?=$r->s_id?>" action='<?=base_url()?>index.php/superuser/updateSkill' method="POST">
		<td>
			<input type="hidden" id="hdf_id" name="hdf_id" value="<?=$r->s_id ?>" />
			<input type="text" id="txt_name" name="txt_name" value="<?=$r->s_name ?>" />
		</td>
		<td><input type="submit" value="Update" /></td>
	</form>

		<td><input type="button" value="Delete" onclick='subdelete(<?=$r->s_id ?>)' /></td>
</tr>
<?php endforeach; ?>
</table>

<script>
	function subdelete(sid)
	{
		if(!confirm('Are you sure you want to delete this skill?'))
		{
			return;
		}

		//determine which call to used based on whether user is logged in or not
		ext_url = 'index.php/superuser/deleteSkill';

		//base_url us a php function to get to the root of the site, then add the extended url
		var send_url = '<?=base_url()?>' + ext_url;
		
		//send the variables through, and display appropriate success or error messages
		$.post(send_url, { sid: sid}).done(function(msg){
				$('#manageContent').html('<span style="color:red;font-size:1.5em;" >Skill was deleted successfully</span>' + msg);
            }).fail(function(){
            	alert("Unable to delete. Please try again later.");
            });
	}		

</script>