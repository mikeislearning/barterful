<!-- ************************ Header ************************** -->
<!-- This is the header that shows up when you are logged in -->

	<div class="bgWrapper">
	<section class="mainWrapper">
		<header class="row">
		    
			<fieldset>
		     		<?php echo form_open('site/textSearch') ?>
		     		<input type="text" required="required" placeholder="Search" name="txt_search" id="txt_search" />
		     		<input type="submit" id="btn_search" name="btn_search" class="general foundicon-search" value="Search" />

		     		<?php echo form_close(); ?>
		    		</fieldset>
		    <h1> <a href="<?php echo base_url()?>" class="logo">Barterful</a> </h1>
		    		
			<nav>
			    <ul>
			    	<li><?php echo anchor('members/inbox',$this->session->userdata('username')."'s Inbox", 'class="button1"');?> </li>
			       <li><?php echo anchor('members/profile','Profile','class="button1"');?> </li>
			       <li> <?php echo anchor('login/logout','Logout','class="button1"');?></li>
			    </ul>
			</nav>
		</header>
	</section><!-- mainWrapper -->
	</div><!-- bgWrapper -->
	