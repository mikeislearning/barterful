<div class="bgWrapper">
        <section class="mainWrapper">
         <a href="#" id="inbox">Inbox</a> --- <a href='#' id="sent">Sent</a>
          	<script>
          	$(document).ready(function(e)
		    		{
		    			$('#inbox').click(function(e)
		    			{
		    				switchview('inbox');
		    			});

		    			$('#sent').click(function(e)
		    			{
		    				switchview('sent');
		    			});

		    			function switchview(type){
		          			var send_url = '<?=base_url()?>' + 'index.php/ajax/inbox';

		    				$.post(send_url, { view: type }).done(function(msg){
					                    $('main').html(msg);
					                }).fail(function(){$('main').html('Could not load!');});
		          		}
		    		})
          	
          	</script>
          <div class="row">
          	
            <main>                    

            	<?php require_once ('includes/listInbox.php'); ?>
            
            </main>  