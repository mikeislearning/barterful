<?php if($row) foreach ($row as $r):?>
	            
	<article class="profile">
		<section class="info">

		    <p><?php echo $r->sender ?> offers <?php echo $r->s_from ?> (<?php echo $r->mes_from_unit ?>) for <?php echo $r->s_to ?> (<?php echo $r->mes_to_unit ?>)</p>
		    <p><?php echo $r->mes_date ?></p>
		    <p>"<?php echo $r->mes_message ?>"</p>
		    <input name="sender" id="sender" type="hidden" value='<?php echo $r->mes_from ?>' />
		    <p><a href="#" id="seemore">See full conversation</a></p>
		    </form>
		</section>
	</article>
<?php endforeach; ?>

<?php if(!$row) echo "There are no messages to display"; ?>

<script>
	$(document).ready(function(e)
	{

		$('#seemore').click(function(e)
		{
			senderid = $('#sender').val();
			seeConversation(senderid);
		});

		function seeConversation(senderid){
  			var send_url = '<?=base_url()?>' + 'index.php/ajax/conversation';

			$.post(send_url, { sender: senderid }).done(function(msg){
	                    $('main').html(msg);
	                }).fail(function(){$('#listing').html('Could not load!');});
  		}
	})
</script>