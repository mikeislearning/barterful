<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>

            	<h1>Reset your password</h1><br />
<?=form_open('login/resetPasswordProcess');?>
2
<?=form_hidden('temp_password', set_value('temp_password', '$this->uri->segment(3)'),'placeholder="Temporary Password" '); ?>
	<label for="new_password">New Password </label>
<?=form_password('new_password', set_value('new_password', ''),'placeholder="New Password" '); ?>

	<label for="confirm_password">Confirm New Password </label>
<?php echo form_password('confirm_password', '', 'placeholder="Password" ');

echo form_submit('submit', 'Change Password');
echo validation_errors('<p class="error">');
echo form_close();
	
?>



            </main>
            </div><!-- end div with class row from mainpage -->
		</section><!-- end section thing -->
    </div> <!-- end bgWrapper from mainpage -->