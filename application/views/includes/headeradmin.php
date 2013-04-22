<!-- ************************ Header ************************** -->

<!-- This is the header that shows up when you are logged in -->
	<div class="bgWrapper">
	<section class="mainWrapper">
		<header class="row">
		    
			<fieldset>
				<?php echo form_open('search/redir') ?>
		     		<input type="text" required="required" placeholder="Search" name="txt_search" id="txt_search" />
		     		<input type="submit" id="btn_search" name="btn_search" class="general foundicon-search" value="Search" />
		     		<span id="btn_clear"></span>

		     		<?php echo form_close(); ?>
    		</fieldset>
		    <h1> <a href="<?php echo base_url() . 'members'; ?>" class="logo">Barterful</a> </h1>
		    		
			<nav>
			    <ul>
			    	<li><?php echo anchor('superuser','Admin','class="button1"');?> </li>
			       <li> <?php echo anchor('superuser/logout','Logout','class="button1"');?></li>
			    </ul>
			</nav>
		</header>
	</section><!-- mainWrapper -->
	</div><!-- bgWrapper -->
	