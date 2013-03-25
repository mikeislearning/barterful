<?php foreach ($member as $m):?>
<?php foreach ($profile as $p):?>
<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
<h1>Update Your Profile</h1>



<?php



echo '<img src="../../uploads/' .$p->p_img .'"/>' . '<br/>';
?>

<?php echo form_open_multipart('upload/do_upload_profile');?>
Upload a new image: 
<input type="file" name="userfile" size="20" />
				<br /><br />

<input type="submit" value="upload" />

</form>
<?php
echo "Username: " .$this->session->userdata('username') ."<br/>";
echo "First Name: " .$p->p_fname ."<br/>";
echo "Last Name: " .$p->p_lname ."<br/>";
echo "Gender: " . $m->m_sex . "<br/>";

/*foreach ($profile as $p)
{ 
echo "Username: " .$this->session->userdata('username') ."<br/>";
echo "First Name: ".$p->p_fname . "<br/>";
echo "Last Name: ".$p->p_lname . "<br/>";
}*/


/*foreach ($query->result() as $row)
{
   echo $row->p_id;
   echo $row->p_fname;
   echo $row->p_lname;
}
*/
//print_r($profile);

//echo $profile->p_id;

echo form_open('members/create_profile');
echo form_input('first_name', set_value('first_name', ''),'placeholder="First Name"');
echo form_input('last_name', set_value('last_name', ''),'placeholder="Last Name"');
echo form_submit('submit', 'Update Profile');
echo validation_errors('<p class="error">');
echo form_close();
	
?>

            
            </main>
 <?php endforeach; 
	 endforeach; ?>