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
		<td><?=$r->rr_name ?></td>
		<td><?=$r->rep_description ?></td>
		<td><?=$r->rep_date ?></td>
		<td><input type="button" value="Ignore" onclick='subaction(<?=$r->rep_id ?>, "ignore")' /></td>
		<td><input type="button" value="Deactivate User Profile" onclick='subaction(<?=$r->rep_id ?>, "deactivate", <?=$r->p_id ?>)' /></td>
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
		<td><?=$r->rep_action ?></td>
		<td><input type="button" value="Re-Open Report" onclick='subreopen(<?=$r->rep_id ?>,"<?=$r->rep_action ?>",<?=$r->p_id ?>)' /></td>
	</tr>
<?php endforeach; echo "<table />"; else:?>
<h1>No Reviewed Reports Exist!</h1>
<?php endif; ?>

<script>

		function subreopen(id, action, userid)
		{

			//determine which call to used based on whether user is logged in or not
			ext_url = 'index.php/superuser/reopen';

			//base_url us a php function to get to the root of the site, then add the extended url
			var send_url = '<?=base_url()?>' + ext_url;

			if(action != "ignore")
			{
				if(confirm('Are you sure? This will reactivate this user\'s account.'))
				{
					//send the variables through
					$.post(send_url, { id:id, action:action, userid:userid }).done(function(msg){
							$('#manageContent').html(msg);
		                }).fail(function(){
		                	$('#manageContent').html("<span style='color:red;'>Unable to re-open report!</span>");
		                });

				}
			}
			else
			{
				//send the variables through
				$.post(send_url, { id:id, action:action, userid:userid }).done(function(msg){
						$('#manageContent').html(msg);
	                }).fail(function(){
	                	$('#manageContent').html("<span style='color:red;'>Unable to re-open report!</span>");
	                });
            }
		}

		function subaction(id, action, userid)
		{
			//determine which call to used based on whether user is logged in or not
			ext_url = 'index.php/superuser/reportAction';

			//base_url us a php function to get to the root of the site, then add the extended url
			var send_url = '<?=base_url()?>' + ext_url;

			//send the variables through
			$.post(send_url, { id:id, action:action, userid:userid }).done(function(msg){
					$('#manageContent').html(msg);
                }).fail(function(){
                	$('#manageContent').html("<span style='color:red;'>Unable to re-open report!</span>");
                });
		}

	$(document).ready(function(){

	})

</script>
