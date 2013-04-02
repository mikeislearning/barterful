<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
<?php if(isset($account_created)) { ?>
<h3><?php echo $account_created; ?></h3>
<?php } else {  ?>
	<h1>Login, please.</h1>
	<?php }?>
	<?php
	echo form_open('login/validate_credentials');
	echo form_input('username', '','placeholder="Username"');
	echo form_password('password', '', 'placeholder="Password" class="password"');
	echo form_submit('submit','Login');
	//echo validation_errors('<p class="error">');
	echo anchor('login/signup', 'Create Account');
	
	echo form_close();
	?>

            </main>
            </div><!-- end div with class row from mainpage -->
		</section><!-- end section thing -->
        </div> <!-- end bgWrapper from mainpage -->