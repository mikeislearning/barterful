<!-- ************************ Header ************************** -->
<!-- This is the header that shows up when you are logged out -->

	<div class="bgWrapper">
	<section class="mainWrapper">
		<header class="row">
		    <h1> <a href="<?php echo base_url()?>" class="logo">Barterful</a> </h1>

		     		<?php echo form_open('') ?>
		     		<input type="text" placeholder="Search" name="search" id="search" value="<?php echo set_value('search');?>">
		     		
		     		<button type="submit" id="submit">
		     		<i class="general foundicon-heart"> </i> </button>
		     				     	
		     		<?php echo form_close(); ?>
	
			<nav>
			    <ul>
			       <li> <a href="login.php" class="button1">Log in </a> </li>
			       <li> <a href="signup.php" class="button1">Sign up</a> </li>
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