<!--This view is loaded from views/profile_form and is only included if profile information has already been set -->
<?php if(isset($member)) foreach ($member as $m): 
if(isset($profile)) foreach ($profile as $p):?>           
<h1>Your Profile</h1>
<?php
if(isset($error)){echo $error; } //checks if there is an error in an update.
echo '<img src="../../uploads/original/' .$p->p_img .'"/>' . '<br/>';

echo "Username: " .$this->session->userdata('username') ."<br/>";

if(!empty($p->p_fname)){
	echo "First Name: " .$p->p_fname ."<br/>";
};
if(!empty($p->p_fname)){
	echo "Last: Name: " .$p->p_lname ."<br/>";
};
if(!empty($p->p_fname)){
	echo "Gender: " . $m->m_sex . "<br/>";
};

endforeach; 
endforeach; 
	//this takes you to the edit function of the profile
echo anchor('Profile_crud/edit', 'edit');?>	 
	
<!--if the profile doesn't exist redirect them to the profile form page--> 
<?php if(!$member) redirect($this->load->view('profile_form'));
 if(!$profile) redirect($this->load->view('profile_form'));