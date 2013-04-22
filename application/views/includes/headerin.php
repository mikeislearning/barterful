<!-- ************************ Header ************************** -->
<?php
	if($count_inbox > 0)
		$count_inbox = "(" . $count_inbox . ")";
	else $count_inbox = "";
?>
<!-- This is the header that shows up when you are logged in -->
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
			    	
			       <li><?php echo anchor('members/profile',$this->session->userdata('username')."  "."<i class='social foundicon-torso'></i>",'class="button1"');?> </li>
			       <li><?php echo anchor('members/inbox', $count_inbox . "<i class='general foundicon-mail'></i>", 'class="button1"');?> 

			       </li>
			       <li><?php echo anchor('Profile_crud/edit',"<i class='general foundicon-settings button1' style='padding-bottom:10px'></i>"); ?>

				    	<ul>
				    		<?php echo anchor('Profile_crud/edit','<li>Edit Profile</li>','class="button1"');?>
				    		<?php echo anchor('members/changePassword','<li>Change Password</li>','class="button1"');?>
				    		<?php echo anchor('login/logout','<li>Logout</li>','class="button1"');?>
				    	</ul>
				     </li>
			       
			    </ul>
			</nav>
		</header>
	</section><!-- mainWrapper -->
	</div><!-- bgWrapper -->
	