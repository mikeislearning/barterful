<<<<<<< HEAD
<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
<h1>Create an Account!</h1>
<?php
echo form_open('login/create_member');?>
<div id="username">
	<label for="username">Username </label>
<? echo form_input('username', set_value('username', ''),'placeholder="Username"'); ?>

</div>

<div id="email">
	<label for="email">Email Address </label>
<? echo form_input('email', set_value('email', ''),'placeholder="Email Address", '); ?>
</div>
<div id="password">
	<label for="password">Password </label>
<? echo form_password('password', '', 'placeholder="Password" class="password"'); ?>
</div>
<div id="password_confirm">
	<label for="password_confirm">Confirm Password </label>
<? echo form_password('password_confirm', '', 'placeholder="Confirm Password" class="password_confirm"');
echo form_submit('submit', 'Create Account');?>
</div>
<?php
echo validation_errors('<p class="error">');
echo form_close();
	
?>

            
            </main>
            </div><!-- end div with class row from mainpage -->
		</section><!-- end section thing -->
        </div> <!-- end bgWrapper from mainpage -->
 
 <script type="text/javascript">

//$("#email").hide().before("some shit");





 </script>
=======
<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
<h1>Create an Account!</h1>
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
>>>>>>> 2cb8a308a536e9f41afa31f59f5591c4452d26e1
