<!--this view displays the messages sent or received by the user -->
<?php 

		$id = $this->session->userdata('userid');
		//get the id value from the first pair in the array
		$id = $id[0]->m_id;
		?>
<article class="inbox">
<table>
			<thead>
				<!-- show "to" or "from" based on if this is an inbox or outbox -->
				<th><?php if($row) {if($row[0]->mes_from == $id) echo "To";} else echo "From"; ?> </th>
				<th> Offer</th>
				<th>Sent</th>
			</thead>
			<tbody>

<?php if($row) foreach ($row as $r):?>

<?php 
	//reformat the mySQL DateTime so that it shows the time is AM/PM format
	$datetime = strtotime($r->date);
	$newdate = date("m/d/y g:i A", $datetime);
?>
	            
<tr class="inbox_long">
	<!-- first td is the name of the other person -->
<td class="inbox_sender">


<!-- show "to" or "from" based on if this is an inbox or outbox -->
<?php
		if($id == $r->mes_from)
			echo $r->receiver;
		else echo $r->sender; ?>
</td>
		<td ><form id="seemore" name="seemore" action='<?=base_url()?>index.php/mail/conversation' method="post">
			    <input name="sender" id="sender" type="hidden" value='<?php echo $r->mes_from ?>' />
			    <input name="receiver" id="receiver" type="hidden" value='<?php echo $r->mes_to ?>' />
			    <input type="submit" class="inbox_message" value="<?php echo "Offering " . $r->s_from . " " . $r->mes_from_unit . " for " . $r->s_to . " " . $r->mes_to_unit ?> " />
			</form>
		    </td>

<td><?=$newdate ?></td>
		    	

		    <!-- This form stores the sender and receiver id of each message so that when the conversation is opened the right
		    variables are sent regardless of whether the current view is inbox or outbox. The controller checks these against the 
		    current user id to determine who the conversation is with -->
		    

</tr>

<?php endforeach; ?>



			</tbody>
		</table>
	</article>

<?php if(!$row) echo "There are no messages to display"; ?>