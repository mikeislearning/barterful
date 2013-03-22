<!-- ************************ Header ************************** -->
<!-- This is the header that shows up when you are logged in -->

	<div class="bgWrapper">
	<section class="mainWrapper">
		<header class="row">
		    
			<fieldset>
		     		<?php echo form_open('') ?>
		     		<input type="text" placeholder="Search" name="search" id="search" value="<?php echo set_value('search');?>">
		     		
		     		<button type="submit" id="search">
		     		<i class="general foundicon-search"> </i> </button>
		     				     	
		     		<?php echo form_close(); ?>
		    		</fieldset>
		    <h1> <a href="<?php echo base_url()?>" class="logo">Barterful</a> </h1>
		    		
			<nav>
			    <ul>
			    	<li><?php echo anchor('members/inbox','Inbox', 'class="button1"');?> </li>
			       <li><?php echo anchor('members','Profile','class="button1"');?> </li>
			       <li> <?php echo anchor('login/logout','Logout','class="button1"');?></li>
			    </ul>
			</nav>
		</header>
	</section><!-- mainWrapper -->
	</div><!-- bgWrapper -->
	