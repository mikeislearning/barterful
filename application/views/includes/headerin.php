<!-- ************************ Header ************************** -->
<!-- This is the header that shows up when you are logged in -->


<?php
	//here we obtain a variable to represent the unread messages in the user's inbox that will be displayed next to the inbox icon
	if($count_inbox > 0)
		$count_inbox = "(" . $count_inbox . ")";
	else $count_inbox = "";
?>

<!-- this section displays only if the user's account has been deactivated, letting them know that this is the case -->
<?php if(!$this->session->userdata('active')): ?>
	<div style="width:90%;z-index:100;background-color:red;height:50px;color:black;font-size:1em;font-weight:bold;opacity:0.9;text-align:center;padding:1% 5%;">
			Your account had been deactivated by our site administrators due to reports of offensive and/or inappropriate behaviour. Your postings will not be visible to other users.
	</div>
<?php endif; ?>



	<div class="bgWrapper">
	<section class="mainWrapper">
		<header class="row">
		    
		    <!--search section -->
			<fieldset>
		     		<?php echo form_open('search/redir'); ?>
		     		<input type="text" required="required" placeholder="Search" name="txt_search" id="txt_search">
		     		<button type="submit"id="btn_search" name="btn_search" class="searchButton"><i class="general foundicon-search"></i></button>
		     	</input>
		     		<span id="btn_clear"></span>
		     		<?php echo form_close(); ?>
		     		
		    </fieldset>
		    <h1> <a href="<?php echo base_url()?>" class="logo">Barterful</a> </h1>

			<!-- navigation -->		    		
			<nav>
			    <ul>
			    	
			       <li><?php echo anchor('members/profile',$this->session->userdata('username')."  "."<i class='social foundicon-torso'></i>",'class="button1"');?> </li>
			       <li><?php echo anchor('members/inbox', "<i class='general foundicon-mail'></i> " . $count_inbox, 'class="button1"');?> 

			       </li>
			       <li><a href="#" class="general foundicon-settings button1" style="padding-bottom:10px;" ></a>


				    	<ul>
				    		<?php echo anchor('Profile_crud/edit','<li>Edit Profile</li>','class="button1"');?>
				    		<?php echo anchor('members/changePassword','<li>Change Password</li>','class="button1"');?>
				    		
				    		<?php echo anchor('site/about','<li>About Us</li>','class="button1"');?>
			    		<?php echo anchor('site/contact','<li>Contact Us</li>','class="button1"');?>
			    		<?php echo anchor('geo/index','<li>Location</li>','class="button1"');?>
			    		<?php echo anchor('login/logout','<li>Logout</li>','class="button1"');?>
			    		
				    	</ul>
				     </li>
			       
			    </ul>
			</nav>
		</header>
	</section><!-- mainWrapper -->
	</div><!-- bgWrapper -->
	