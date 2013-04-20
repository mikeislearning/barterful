<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>

            	<h1>Change your password</h1><br />
<?=form_open('members/changePasswordProcess');?>

	<label for="old_password">Old Password </label>
<?=form_password('old_password', set_value('old_password', ''),'placeholder="Old Password" '); ?>
	<label for="new_password">New Password </label>
<?=form_password('new_password', set_value('old_password', ''),'placeholder="New Password" '); ?>

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