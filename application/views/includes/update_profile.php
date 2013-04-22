<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
<?php 
//open the upload form
if(isset($error)){echo $error; }
if(isset($profile)) foreach ($profile as $p): 

echo '<img src="../../uploads/original/' .$p->p_img .'"/>' . '<br/>';
endforeach; 

echo form_open_multipart('upload/do_upload_profile');?>

Upload a new image: <br/>
<input type="file" name="userfile" size="20" />
<?php echo form_submit('upload', 'Upload');
echo form_close();
?>
<!--<input type="upload" value="upload" />   

</form>-->

<?php echo anchor('members/changePassword','Change Password', 'class="button1"'); ?>

<?php
$fname ="";
$lname="";

if(isset($p->p_fname) and (!empty($p->p_fname)))
{
$fname= $p->p_fname;
}
if(isset($p->p_lname) and (!empty($p->p_lname)))
{
$lname = $p->p_lname;
}

echo form_open('members/updateProfile');
echo form_input('first_name', set_value('first_name', $fname),'placeholder="First Name"');
echo form_input('last_name', set_value('last_name', $lname),'placeholder="Last Name"');
echo form_submit('submit', 'Update Profile');
echo validation_errors('<p class="error">');
echo form_close();
?>


            
            </main>
            </div><!-- end div with class row from mainpage -->
		</section><!-- end section thing -->
        </div> <!-- end bgWrapper from mainpage -->
        