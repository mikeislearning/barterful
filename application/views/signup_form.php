<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
<h1>Create an Account!</h1>
<?php
echo form_open('login/create_member');
echo form_input('first_name', set_value('first_name', ''),'placeholder="First Name"');
echo form_input('last_name', set_value('last_name', ''),'placeholder="Last Name"');
echo form_input('email', set_value('email', ''),'placeholder="Email Address"');
echo form_input('username', set_value('username', ''),'placeholder="Username"');
echo form_password('password', '', 'placeholder="Password" class="password"');
echo form_password('password_confirm', '', 'placeholder="Confirm Password" class="password_confirm"');
echo form_submit('submit', 'Create Account');
echo validation_errors('<p class="error">');
echo form_close();
	
?>

            
            </main>
 