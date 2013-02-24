<!-- ************************ Header ************************** -->
<!-- This is the header that shows up when you are logged out -->

	<div class="wrapper" >
		<header class="section">
			<section>
		    <h1> <a href="<?php echo base_url('index.php/site/realhome');?>" class="logo">barterful</a> </h1>

		     		<?php echo form_open('') ?>
		     		<input type="text" placeholder="Search" name="search" id="search" value="<?php echo set_value('search');?>">
		     		
		     		<button type="submit" id="submit">
		     		<i class="general foundicon-heart"> </i> </button>
		     				     	
		     		<?php echo form_close(); ?>
		  </section>
			<nav>
			    <ul>
			       <li> <a href="login.php" class="button1">Log in </a> </li>
			       <li> <a href="signup.php" class="button1">Sign up</a> </li>
			    </ul>
			</nav>
		</header>
	</div>