<!-- this view shows the administrator all users on the site, allowing them to change each user's active 
status and visit their profile to make changes to their profile and/or postings. IT IS IMPORTANT to note that administrators can never
delete a user - this would result in missing links on the site since there may be content posted associated with that user (such as messages) -->

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
		<td><input type="checkbox" <?php if($r->m_active == true) echo "checked" ?> class="actives" id='<?=$r->m_id ?>' /></td>
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

		//change the active status of the user
		$('.actives').change(function()
		{
			var id = ($(this).attr("id"));
			var status = this.checked;

			//determine which call to used based on whether user is logged in or not
			ext_url = 'index.php/superuser/memActive';

			//base_url us a php function to get to the root of the site, then add the extended url
			var send_url = '<?=base_url()?>' + ext_url;

			//send the variables through
			$.post(send_url, { id:id, status:status }).done(function(msg){
					$('#manageContent').html(msg);
                }).fail(function(){
                	if(!$('#result').length)
                	$('#manageContent').prepend("<span id='result' style='color:red;margin:0 10px;'>Unable to change status!</span>");
                });
		})
	})
</script>
