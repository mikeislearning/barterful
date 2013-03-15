<!--display the most recent message (the array is already sorted by date DESC) -->
<article class="profile">
	<section class="info">
	    <p><?=$row[0]->sender ?> offers <?=$row[0]->s_from ?> (<?=$row[0]->mes_from_unit ?>) for <?=$row[0]->s_to ?> (<?=$row[0]->mes_to_unit ?>)</p>
	    <p><?=$row[0]->mes_date ?></p>
	    <p>"<?=$row[0]->mes_message ?>"</p>
	</section>
</article>

<!-- NOTE!!!!! REMOVE INLINE STYLING!!! -->

<table>
	<tr>
		<td><input type="radio" name="response" id="response_accept" value="accept" style="display:inline;" /></td>
		<td>Accept this offer</td>
	</tr>
	<tr>
		<td><input type="radio" name="response" id="response_counter" value="counter" style="display:inline;" /></td>
		<td>Make a counter-offer</td>
	</tr>
	<tr>
		<td><input type="radio" name="response" id="response_reject" value="reject" style="display:inline;" /></td>
		<td>Reject offer</td>
	</tr>
</table>

<script>
	$(document).ready(function(){
		$('input[name=response]:radio').change(function(){
			if($('input[name=response]:checked').val() == 'counter')
				{$('#counteroffer').slideDown('slow');}
			else
				{$('#counteroffer').hide('fast');}
		})
	})
</script>

<div id="counteroffer" style="display:none;">
	<form name="sendmessage" id="sendmessage" action='<?=base_url() . "index.php/ajax/conversation" ?>' method="post" >
		I offer:
		<input type="text" id="unit_from" name="unit_from" value="<?=$row[0]->mes_to_unit ?>" />
		of
		<select id="from_skill" name="from_skill">
			<?php if($skills) foreach($skills as $s): ?>
			<option value='<?=$s->s_id ?>'
				<?php if($s->s_id == $row[0]->mes_to_s){echo " selected";} else{echo "";} ?>
				><?=$s->s_name ?></option>
			<?php endforeach; ?>
		</select>

		in exchange for
		<input type="text" id="unit_to" name="unit_to" value="<?=$row[0]->mes_from_unit ?>" />
		of
		<select id="to_skill" name="to_skill">
			<?php if($skills) foreach($skills as $s): ?>
			<option value='<?=$s->s_id ?>'
				<?php if($s->s_id == $row[0]->mes_from_s){echo " selected";} else{echo "";} ?>
				><?=$s->s_name ?></option>
			<?php endforeach; ?>
		</select>
		
		<textarea id="message" name="message"></textarea>

	</form>
</div>

<input id="send" name="send" type="button" value="Send Response" />
<script>
	
	$('#send').click(function(){
		to = '<?php echo $row[0]->mes_from; ?>';
		to_skill = $('#to_skill').val();
		to_unit = $('#unit_to').val();
		from_skill = $('#from_skill').val();
		from_unit = $('#unit_from').val();
		message = $('#message').val();
		response = $('input[name=response]:checked').val();

		sendMessage(to,to_skill,to_unit,from_skill,from_unit,message,response);
	})

	function sendMessage(to,to_skill,to_unit,from_skill,from_unit,message,response)
	{	
		url = '<?=base_url()?>index.php/ajax/sendmessage';
		$.post(url, { 	to:to,
						to_skill:to_skill,
						to_unit:to_unit, 
						from_skill:from_skill,
						from_unit:from_unit,
						message:message,
						response:response
					}).done(function(msg){
                    $('main').html('<p>Your message has been sent!</p>' + msg);
                }).fail(function(){alert('Could not send!');});
	}


</script>

<div id="listing">  

	<!-- array_slice cuts out the first row in the array since it is already shown above -->
	<?php if($row) foreach (array_slice($row,1) as $r):?>

		<article class="profile">
			<section class="info">
			    <p><?=$r->sender ?> offers <?=$r->s_from ?> (<?=$r->mes_from_unit ?>) for <?=$r->s_to ?> (<?=$r->mes_to_unit ?>)</p>
			    <p><?=$r->mes_date ?></p>
			    <p>"<?=$r->mes_message ?>"</p>
			</section>
		</article>
	<?php endforeach; ?>

	<?php if(!$row) echo "There are no messages to display"; ?>
</div>
