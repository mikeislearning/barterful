<div id="messages">

	<h1>Messages</h1>
	<table style="font-size:0.8em;">
		<tr>
			<th></th>
			<th>To</th>
			<th>From</th>
			<th>Date</th>
			<th>Skill Offered</th>
			<th>Unit Offered</th>
			<th>Skill Requested</th>
			<th>Unit Requested</th>
			<th>Response Type</th>
			<th>Message</th>
		</tr>
	<?php foreach($row as $r): ?>
		<tr>
			<td><input type="button" value="Delete" onclick="subdelete(<?=$r->mes_id ?>)" /></td>
			<td><?=$r->userto ?></td>
			<td><?=$r->userfrom ?></td>
			<?php 
				$datetime = strtotime($r->date);
				$newdate = date("m/d/y g:i A", $datetime); ?>
			<td><?=$newdate ?></td>
			<td><?=$r->s_from ?></td>
			<td><?=$r->mes_from_unit ?></td>
			<td><?=$r->s_to ?></td>
			<td><?=$r->mes_to_unit ?></td>
			<td><?=$r->mes_status ?></td>
			<td style="text-align:left;"><?=$r->mes_message ?></td>
		</tr>
	<?php endforeach; ?>
	</table>

</div>

<script>

function subdelete(mid)
	{
		if(!confirm('Are you sure you want to delete this message?'))
		{
			return;
		}

		//determine which call to used based on whether user is logged in or not
		ext_url = 'index.php/superuser/deleteMessage';

		//base_url us a php function to get to the root of the site, then add the extended url
		var send_url = '<?=base_url()?>' + ext_url;
		
		//send the variables through, and display appropriate success or error messages
		$.post(send_url, { mid: mid}).done(function(msg){
				$('#messages').html(msg);
				if(!$('#output').length)
				$('#messages').prepend('<span id="output" style="color:green;font-size:1.2em;" >Message was deleted successfully</span>');
				else 
					{
						$('#output').css('color','green');
						$('#output').html("Message was deleted successfully");
					}
            }).fail(function(){
            	if(!$('#output').length)
				$('#messages').prepend('<span id="output" style="color:red;font-size:1.2em;" >Unable to delete. Please try again later.</span>');
				else 
					{
						$('#output').css('color','red');
						$('#output').html("Unable to delete. Please try again later.");
					}
            });
	}		
</script>