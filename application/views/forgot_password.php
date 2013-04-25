<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main class="textInputArea">
            
<?php if(isset($account_created)) { ?>
<h3><?php echo $account_created; ?></h3>
<?php } else {  ?>
	<h2>Reset Your Password</h2>

	<?php
	}
	echo form_open('login/recover_process');?>
	<label for="email">Email Address </label>
	<?php echo form_input('email', '','placeholder="email"'); ?>

	<?php 
	echo form_submit('submit','Reset Password',"class='btn btngreen'");
	echo validation_errors('<p class="error">');

	
	echo form_close();
	?>

            </main>
            </div><!-- end div with class row from mainpage -->
		</section><!-- end section thing -->
        </div> <!-- end bgWrapper from mainpage -->