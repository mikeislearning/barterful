<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
<h1>Update Your Profile</h1>
<?php
echo form_open('members/create_profile');
echo form_input('first_name', set_value('first_name', ''),'placeholder="First Name"');
echo form_input('last_name', set_value('last_name', ''),'placeholder="Last Name"');
echo form_submit('submit', 'Update Profile');
echo validation_errors('<p class="error">');
echo form_close();
	
?>

            
            </main>
 