<h1>Add New Skill:</h1>
<input type="text" id="txt_new" name="txt_new" /><input type="button" value="Add Skill" onclick='newskill()' />

<h1>Skills:</h1>

<?php foreach($row as $r): ?>
	<form id='form_update_<?=$r->s_id?>' name='form_update_<?=$r->s_id?>' action='<?=base_url()?>superuser/updateSkill' method="POST">
			<input type="hidden" id="hdf_id" name="hdf_id" value="<?=$r->s_id ?>" />
			<input type="text" id="txt_name" name="txt_name" value="<?=$r->s_name ?>" />
		
		<input type="submit" value="Update" />
	</form>

<input type="button" value="Delete" onclick='subdelete(<?=$r->s_id ?>)' />
<br />
<?php endforeach; ?>


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
				$('#manageContent').html('<span style="color:red;font-size:1.2em;" >Skill was deleted successfully</span>' + msg);
            }).fail(function(){
            	alert("Unable to delete. Please try again later.");
            });
	}		

	function newskill()
	{
		var name = $('#txt_new').val();
		//determine which call to used based on whether user is logged in or not
		ext_url = 'index.php/superuser/newSkill';

		//base_url us a php function to get to the root of the site, then add the extended url
		var send_url = '<?=base_url()?>' + ext_url;
		
		//send the variables through, and display appropriate success or error messages
		$.post(send_url, { name: name}).done(function(msg){
				$('#manageContent').html('<span style="color:red;font-size:1.2em;" >Skill was added successfully</span>' + msg);
            }).fail(function(){
            	$('#manageContent').prepend('<span style="color:red;font-size:1.2em;" >Unable to insert skill. Please try again later.</span>');
            });
	}	

</script>