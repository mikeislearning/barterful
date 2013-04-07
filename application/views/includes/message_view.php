<div class="bgWrapper">
    <section class="mainWrapper">
     <a href="#" id="inbox">Inbox</a> --- <a href='#' id="sent">Sent</a>
      	
      	<div class="row">
      	
        <main> 
            

<!--display the most recent message (the array is already sorted by date DESC) -->
<article class="profile">
	<section class="info">

<?php 
	//convert mySQL DateTime to AM/PM
	$datetime = strtotime($row[0]->date);
	$newdate = date("m/d/y g:i A", $datetime);
?>
	    <p>
	    	<!-- Display the most recent message at the top of the page. Messages are ordered by date DESC, so row[0] 
	    	is the most recent message -->
	    	<?=$row[0]->sender ?> 
	    	offers 
	    	<?=$row[0]->s_from ?> 
	    	(<?=$row[0]->mes_from_unit ?>) 
	    	for 
	    	<?=$row[0]->s_to ?> 
	    	(<?=$row[0]->mes_to_unit ?>)
	    	from
	    	<?=$row[0]->receiver ?>
	    </p>
	    <p><?=$newdate ?></p>
	    <p>Message: <?=$row[0]->mes_message ?></p>
	</section>
</article>

<!-- /////////////////////////////////////// -->
<!-- NOTE!!!!! REMOVE INLINE STYLING!!! -->
<!-- //////////////////////////////////// -->
<div id="panel_response" style="display:none;">
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

	<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
	<!-- This section is hidden unless counteroffer is selected above, allowing the user to make changes to the offer given to them -->
	<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
	<div id="counteroffer" style="display:none;">
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
			
	</div><!-- counteroffer -->
	<textarea id="message" name="message"></textarea>

	<input id="send" name="send" type="button" value="Send Response" />
</div><!-- panel_response -->


<!-- display the remaining messages -->
<div id="listing">  

	<!-- array_slice cuts out the first row in the array since it is already shown above -->
	<?php if($row) foreach (array_slice($row,1) as $r):?>
	<?php 
		$datetime = strtotime($r->date);
		$newdate = date("m/d/y g:i A", $datetime);
	?>

		<article class="profile">
			<section class="info">
			    <p><?=$r->sender ?> 
			    	offers 
			    	<?=$r->s_from ?> 
			    	(<?=$r->mes_from_unit ?>) 
			    	for 
			    	<?=$r->s_to ?> 
			    	(<?=$r->mes_to_unit ?>)
			    	from
			    	<?=$r->receiver ?>
			    </p>
			    <p><?=$newdate ?></p>
			    <p>Message: <?=$r->mes_message ?></p>
			</section>
		</article>
	<?php endforeach; ?>

	<?php if(!$row) echo "There are no messages to display"; ?>
</div><!-- listing -->

</main>
</div><!-- end div with class row from mainpage -->
</section><!-- end section thing -->
</div> <!-- end bgWrapper from mainpage -->

<!-- ********************************************************** -->
<!-- **************         JavaScript            *************** -->
<!-- *********************************************************** -->
<script>
	$(document).ready(function(){

	//this section checks to see if there is a message awaiting a response
	to = "";
	//get the id of the user who sent the latest message
	sender = '<?php echo $row[0]->mes_from; ?>';
	//get the current user id
	myid = '<?php $id = $this->session->userdata("userid");
			$id = $id[0]->m_id;
			echo $id; ?>';
	
	//show the input panel if the most recent message was not sent by the other member
	if(sender != myid)
		{$('#panel_response').show();}

	//switch the view between inbox and sent messages based on user input
	$('#inbox').click(function()
	{
		switchview('inbox');
	});

	$('#sent').click(function()
	{
		switchview('outbox');
	});

	function switchview(type){
	//AJAX function sends a request for the data to fill the new view
		var send_url = '<?=base_url()?>' + 'index.php/ajax/inbox';

		$.post(send_url, { view: type }).done(function(msg){
                $('main').html(msg);
            }).fail(function(){$('main').html('Could not load!');});
		
	}		

	//show the response input section if the user selects counteroffer
	$('input[name=response]:radio').change(function(){
		if($('input[name=response]:checked').val() == 'counter')
			{$('#counteroffer').slideDown('slow');}
		else
			{$('#counteroffer').hide('fast');}
	})

	//send the message
	$('#send').click(function(){
		//validation to ensure that a response type was checked off
		if(!$('input[name=response]:checked').val())
			{alert('Please select your response')}
		else
		{
			//determine who the message is to, based on the sender and receiver of the most 
			//recent message (whoever doesnt match the logged-in user)
			to = "";
			to_id = '<?php echo $row[0]->mes_from; ?>';
			from_id = '<?php echo $row[0]->mes_to; ?>';
			//get the current user id
			myid = <?php $id = $this->session->userdata('userid');
					$id = $id[0]->m_id;
					echo $id; ?>;
			//Check the id of the participants in the conversation selected against the current 
			//user id to send the right variables to the controller
			if(to_id == myid)
				{to = from_id;}
			else{to = to_id;}

			to_skill = $('#to_skill').val();
			to_unit = $('#unit_to').val();
			from_skill = $('#from_skill').val();
			from_unit = $('#unit_from').val();
			message = $('#message').val();
			response = $('input[name=response]:checked').val();

			sendMessage(to,to_skill,to_unit,from_skill,from_unit,message,response);
		}
	})

	//AJAX function to send data
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
})
      	
</script>
