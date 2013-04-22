<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main class="textInputArea">
            
<h2>Create an Account</h2>
<?php echo form_open('login/create_member');?>
	<label for="username">Username </label>
<?=form_input('username', set_value('username', ''),'placeholder="Username"'); ?>
	<label for="email">Email Address </label>
<?=form_input('email', set_value('email', ''),'placeholder="Email Address"'); ?>
	<label for="password">Password </label>
<?=form_password('password', '', 'placeholder="Password" class="password"'); ?>
	<label for="password_confirm">Confirm Password </label>
<?php echo form_password('password_confirm', '', 'placeholder="Confirm Password" class="password_confirm"');
echo form_submit('submit', 'Create Account');
echo validation_errors('<p class="error">');
echo form_close();
	
?>

            
</main>
</div><!-- end div with class row from mainpage -->
</section><!-- end section thing -->
</div> <!-- end bgWrapper from mainpage -->
