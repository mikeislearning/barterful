<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
<?php if(isset($account_created)) { ?>
<h3><?php echo $account_created; ?></h3>
<?php } else {  ?>
	<h1>Login, please.</h1><br />

	<?php
	}
	echo form_open('login/validate_credentials');?>
	<label for="username">Username </label>
	<?php echo form_input('username', '','placeholder="Username"'); ?>
	<label for="password">Password </label>
	<?php echo form_password('password', '', 'placeholder="Password" class="password"');
	echo form_submit('submit','Login');
	//echo validation_errors('<p class="error">');
	echo anchor('login/signup', 'Create Account');
	
	echo form_close();
	?>

            </main>
            </div><!-- end div with class row from mainpage -->
		</section><!-- end section thing -->
        </div> <!-- end bgWrapper from mainpage -->