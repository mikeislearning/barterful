<!-- This administrative section deals with the display and actions taken against reported users. 
	Each report can either be ignored, or dealt with by deactivating that user's account -->

<!-- these two elements act as a modal display for actions taken on the page and are populated dynamically -->
<div id="edit-background" >
</div>
<div id="edit-box" style="width:80%;">
</div>

<?php if($new): ?>
<h1>Outstanding Reports:</h1>

<table>
<tr>
	<th>User</th>
	<th>Reason</th>
	<th>Comment</th>
	<th>Date</th>
	<th></th>
	<th></th>
	<th></th>
</tr>
<?php foreach($new as $r): ?>
	<tr>
		<td><a href='<?php echo base_url() . "index.php/profiles/viewprofile/" . $r->p_id; ?>'><?=$r->m_username ?></a></td>
		<td><?=$r->rr_name ?></td>
		<td><?=$r->rep_description ?></td>
		<td><?=$r->rep_date ?></td>
		<td><input type="button" value="See Messages" onclick='subMessages(<?=$r->p_id ?>)' /></td>
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

		//this function allows administrators to re-open previously dealt with reports and change their actions toward them
		function subreopen(id, action, userid)
		{

			//determine which call to used based on whether user is logged in or not
			ext_url = 'index.php/superuser/reopen';

			//base_url us a php function to get to the root of the site, then add the extended url
			var send_url = '<?=base_url()?>' + ext_url;

			//re-opening a report may mean reactivating that user if the previous action was deactivating them
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

		//this is what the administrator decided to do about the report
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

		//this function displays a list of messages sent by the selected user to help in the decision process
		function subMessages(id)
		{
			//determine which call to used based on whether user is logged in or not
			ext_url = 'index.php/superuser/getMessages';

			//base_url us a php function to get to the root of the site, then add the extended url
			var send_url = '<?=base_url()?>' + ext_url;

			//send the variables through, actually loading another view into the modal box
			$.post(send_url, { id:id}).done(function(msg){
					showBox('show');
					$('#edit-box').html(msg);
					$('#edit-box').append("<input type='button' id='btncancel' class='btn btnyellow' name='btncancel' value='Close' />");
					$('#btncancel').bind('click', function() {
						showBox('hide');
					});
                }).fail(function(){
                	$('#manageContent').html("<span style='color:red;'>Unable to re-open report!</span>");
                });
		}

		//this function shows and hides the modal box
		function showBox(choice)
		{
			switch(choice)
			{
				case "show":
				$('#edit-background').show("fast");
				$('#edit-box').show("fast");
				break;

				case "hide":
				$('#edit-box').html("");
				$('#edit-background').hide("fast");
				$('#edit-box').hide("fast");
				break;
			}
		}

</script>
