<!-- ************************ Header ************************** -->
<!-- This is the header that shows up when you are logged out -->

	<div class="bgWrapper">
	<section class="mainWrapper">
		<header class="row">
		    <h1> <a href="<?php echo base_url()?>" class="logo">Barterful</a> </h1>

		     		<?php echo form_open('') ?>
		     		<input type="text" placeholder="Search" name="txt_search" id="txt_search" />
		     		
		     		<button type="button" id="btn_search" name="btn_search">
		     		<i class="general foundicon-heart"> </i> </button>
		     				     	
		     		<?php echo form_close(); ?>
	
			<nav>
			    <ul>
				    <li> <?php echo anchor('login','Log in','class="button1"');?> </li>
				    <li> <?php echo anchor('login/signup','Sign up','class="button1"');?> </li>
			    </ul>
			</nav>
		</header>
	</section><!-- mainWrapper -->
	</div><!-- bgWrapper -->
	
	<!-- ************************ Hero Unit ************************** -->

		<div class="bgWrapper" id="heroWrapper" >
	        <section class="mainWrapper">
	        	<article class="row">
		            <h2>So what are you good at? </h2>
		            
		            <h3>Barterful is a network of online bartering communities. </h3>
		            
		            <a href="#">Learn More </a>
	        	</article>
	        </section>
		</div>

<script>
	$(document).ready(function(){
		$('#btn_search').click(function(){
			var term = $('#txt_search').val();
			var send_url = '<?=base_url()?>' + 'index.php/ajax/searchPostings';

			//send the variables through
			$.post(send_url, { term:term }).done(function(msg){
                    document.write(msg);
                }).fail(function(){$('main').html('Could not load!');});
		});

	})

</script>