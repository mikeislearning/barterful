<div class="bgWrapper">
    <section class="mainWrapper">
     <a href="#" id="inbox">Inbox</a> --- <a href='#' id="sent">Sent</a>
      	
      <div class="row">
      	
        <main>                    

        	<!-- **********************************************************************************************
           Why load another view? The AJAX function returns a view from the controller in HTML form (in this case
            listInbox), which is then written to the <main> element with jQuery .done. If there is any 
            formatting in the view returned to AJAX, the <main> tag ends up with duplicate wrappers/styling
            *********************************************************************************************** -->

        	<?php $this->load->view('includes/listInbox.php'); ?>
        
        </main>  

<script>
	$(document).ready(function(e)
		{
			//check which view the user selected, then send it to the AJAX function
			$('#inbox').click(function(e)
			{
				switchview('inbox');
			});

			$('#sent').click(function(e)
			{
				switchview('outbox');
			});

			function switchview(type){
      			var send_url = '<?=base_url()?>' + 'index.php/ajax/inbox';

				$.post(send_url, { view: type }).done(function(msg){
		                    $('main').html(msg);
		                }).fail(function(){$('main').html('Could not load!');});
      		}
		})
	
	</script>