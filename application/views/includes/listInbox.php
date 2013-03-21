<?php if($row) foreach ($row as $r):?>

<?php 
	//reformat the mySQL DateTime so that it shows the time is AM/PM format
	$datetime = strtotime($r->date);
	$newdate = date("m/d/y g:i A", $datetime);
?>
	            
	<article class="profile">
		<section class="info">

		    <p><?php echo $r->sender ?> 
		    	offers 
		    	<?php echo $r->s_from ?> 
		    	(<?php echo $r->mes_from_unit ?>) 
		    	for 
		    	<?php echo $r->s_to ?> 
		    	(<?php echo $r->mes_to_unit ?>)
		    	from
		    	<?php echo $r->receiver ?>
		    </p>
		    <p><?=$newdate ?></p>
		    <p>Message: <?php echo $r->mes_message ?></p>

		    <!-- This form stores the sender and receiver id of each message so that when the conversation is opened the right
		    variables are sent regardless of whether the current view is inbox or outbox. The controller checks these against the 
		    current user id to determine who the conversation is with -->
		    <form id="seemore" name="seemore" action='<?=base_url()?>index.php/ajax/conversation' method="post">
			    <input name="sender" id="sender" type="hidden" value='<?php echo $r->mes_from ?>' />
			    <input name="receiver" id="receiver" type="hidden" value='<?php echo $r->mes_to ?>' />
			    <input type="submit" value="See full conversation" />
			</form>
		</section>
	</article>
<?php endforeach; ?>

<?php if(!$row) echo "There are no messages to display"; ?>