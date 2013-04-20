
<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
<?php 
//if the profile infromation is set load the profile view or else load the rest
if(isset($profile)){

//if an error is set echo it
if(isset($error)){echo $error; }
//if the profile is updated, echo this
if(isset($profile_updated)) { ?>
<h3><?php echo $profile_updated; }?></h3>
<?php $this->load->view('includes/view_profile.php'); ?>


<?php
//echo '<img src="../../uploads/' .$p->p_img .'"/>' . '<br/>';
?>

<?php 

//ANJA ATTEMPT APRIL 13
/*	echo form_open_multipart('upload'); //should go to index...
	echo form_upload('userfile'); //expects userfile by default
	ec-echo form_close();*/
?>
<!-- ANJA COMMENTED OUT APRIL 13TH TO TRY NEW UPLOAD -->

<?php 
}
else { 
if(isset($error)){echo $error; }
//open the upload form
echo form_open_multipart('upload/do_upload_profile');?>
Upload a new image: 
<input type="file" name="userfile" size="20" />
<?php echo form_submit('upload', 'Upload');
echo form_close();
?>
<!--<input type="upload" value="upload" />   

</form>-->

<?php echo anchor('members/changePassword','Change Password', 'class="button1"'); ?>

<?php

echo form_open('members/updateProfile');
echo form_input('first_name', set_value('first_name', ''),'placeholder="First Name"');
echo form_input('last_name', set_value('last_name', ''),'placeholder="Last Name"');
echo form_submit('submit', 'Update Profile');
echo validation_errors('<p class="error">');
echo form_close();
?>

 <?php
};?>


            
            </main>
            </div><!-- end div with class row from mainpage -->
		</section><!-- end section thing -->
        </div> <!-- end bgWrapper from mainpage -->
        