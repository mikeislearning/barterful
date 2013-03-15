<?php if($row) foreach ($row as $r):?>
	            
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
		    <p><?=$r->date ?></p>
		    <p>Message: <?php echo $r->mes_message ?></p>
		    <form id="seemore" name="seemore" action='<?=base_url()?>index.php/ajax/conversation' method="post">
			    <input name="sender" id="sender" type="hidden" value='<?php echo $r->mes_from ?>' />
			    <input name="receiver" id="receiver" type="hidden" value='<?php echo $r->mes_to ?>' />
			    <input type="submit" value="See full conversation" />
			</form>
		</section>
	</article>
<?php endforeach; ?>

<?php if(!$row) echo "There are no messages to display"; ?>