<!-- ************************ Header ************************** -->
<!-- This is the header that shows up when you are logged out -->

	<div class="bgWrapper">
	<section class="mainWrapper">
		<header class="row">
		<fieldset>
		     		<?php echo form_open('search/redir') ?>
		     		<input type="text" required="required" placeholder="Search" name="txt_search" id="txt_search">
		     		<button type="submit"id="btn_search" name="btn_search" class="searchButton"><i class="general foundicon-search"></i></button>
		     		</input>
		     		<span id="btn_clear"></span>
		     		<?php echo form_close(); ?>
		     		
		    </fieldset>
		    
		    <h1> <a href="<?php echo base_url()?>" class="logo">Barterful</a> </h1>
		    
		    <nav>
			    <ul>

			    <li> <?php echo anchor('login','Log in','class="button1"');?> </li>
			    <li> <?php echo anchor('login/signup','Sign up','class="button1"');?> </li>
			    <li> <a href="#" class="general foundicon-settings button1" style="padding-bottom:10px;" ></a>
			    	<ul>
			    		<?php echo anchor('site/about','<li>About Us</li>','class="button1"');?>
			    		<?php echo anchor('site/contact','<li>Contact Us</li>','class="button1"');?>
			    	</ul>
			     </li>

			    </ul>
			</nav>
		</header>
	</section><!-- mainWrapper -->
	</div><!-- bgWrapper -->
