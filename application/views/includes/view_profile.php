<?php
	//this populates the drop down lists later when adding or editing a posting
	$select = "";
	foreach($skill_list as $sl)
	{
		$select .= "<option value='" . $sl->s_id . "'>$sl->s_name</option>";
	}

	?>

<!--This view is loaded from views/profile_form and is only included if profile information has already been set -->
<div id="edit-background">
</div>
<div id="edit-box">
</div>

<!--make sure the profiles array exists (there should only be one row since it matches the member id)-->
<?php if(isset($profile)) foreach ($profile as $p):?>           
<div id="user_info">
<!-- display a page header -->  
<h2>Your Profile</h2>

<?php
	
	//this is stored in case the posting is new, and the p_id needs to be inserted into a new skill or want posting
	$profileid = $p->p_id;

	//checks if there is an error in an update.
	if(isset($error)){echo $error; } 

	//display the profile image
	echo "<img src='../../uploads/original/" . $p->p_img . "' /><br />";

	//display the username and other profile data
	echo "Username: " . $p->m_username ."<br/>";

	if(!empty($p->p_fname)){
		echo "First Name: " .$p->p_fname ."<br/>";
	};
	if(!empty($p->p_lname)){
		echo "Last: Name: " .$p->p_lname ."<br/>";
	};
	if(!empty($p->m_email)){
		echo "Email: " . $p->m_email . "<br/>";
	};
	if(!empty($p->m_sex)){
		echo "Gender: " . $p->m_sex . "<br/>";
	};

	endforeach; 

	//this takes you to the edit function of the profile
	echo anchor('Profile_crud/edit', 'edit profile',"class='btn btnyellow'"); 

?>	 
<br />
</div> <!-- /end #user_info-->


<div id="tabs">

    <ul>
      <li><a href="#tab-1">Offering</a></li>
      <li><a href="#tab-2">Wanting</a></li>
      <li><a href="#tab-3">Projects</a></li>
    </ul>


<div id="tab-1">

<!-- create a button that opens a modal box to add a new skill profile. The onClick function sends through a 
special paramater instead of the sp_id... this paramater starts with "new", which indicates to the model that it should be 
inserting a record rather than updating one. The paramater ends with the profile id of the user that it will add into the 
new skill profile (on an update this would be left out since the posting already contains a profile id) -->
<input type="button" id="btn_new_skill" class="btn btngreen" name="btn_new_skill" value="Add New" onClick="showEdit('new<?=$profileid?>','','','','','','skills')" />

<!-- if there are skills, display each one. The $params string is used to send parameters through the showEdit function on submit -->
<?php if(isset($skills)) foreach($skills as $s): ?>
	<?php
		$params = "\"$s->sp_id\",\"$s->sp_heading\",\"$s->s_id\",\"$s->sp_keywords\",\"\",\"$s->sp_details\",\"skills\"";
	?>
	<form class="p_skills" name="p_skills">
		<h3><?=$s->sp_heading ?></h3>
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		<input id="editskill" class="btn btnyellow" name="editskill" type="button" onClick='showEdit(<?=$params?>)' value="Edit" />
	</form>
	
<?php endforeach; 

//if no skills exist, suggest that the user adds one
else echo "<br />You have no offers, add one now!";?>

</div><!-- end #tab-1 -->

<div id="tab-2">

<!-- create a button that opens a modal box to add a new want profile. The onClick function sends through a 
special paramater instead of the sp_id... this paramater starts with "new", which indicates to the model that it should be 
inserting a record rather than updating one. The paramater ends with the profile id of the user that it will add into the 
new want profile (on an update this would be left out since the posting already contains a profile id) -->
<input type="button" id="btn_new_skill" class="btn btngreen" name="btn_new_skill" value="Add New" onClick="showEdit('new<?=$profileid?>','','','','','','wants')" />

<!-- if there are wants, display each one. The $params string is used to send parameters through the showEdit function on submit -->
<?php if(isset($wants)) foreach($wants as $s): ?>
	<?php
		$params = "\"$s->sp_id\",\"$s->sp_heading\",\"$s->s_id\",\"$s->sp_keywords\",\"$s->wp_expiry\",\"$s->sp_details\",\"wants\"";
	?>
	<form class="p_skills" name="p_skills" >
		<h3><?=$s->sp_heading ?></h3>
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		<?php if($s->wp_expiry) echo "Required by: " . $s->wp_expiry . "<br />"; ?>
		<input id="editskill" class="btn btnyellow" name="editskill" type="button" onClick='showEdit(<?=$params?>)' value="Edit" />
	</form>
	
<?php endforeach; 

//if no wants exist, suggest that the user adds one
else echo "<br />You have no wants, add one now!"; ?>

</div> <!-- end wanting -->

<div id="tab-3">

<!-- create a button that opens a modal box to add a new want profile. The onClick function sends through a 
special paramater instead of the sp_id... this paramater starts with "new", which indicates to the model that it should be 
inserting a record rather than updating one. The paramater ends with the profile id of the user that it will add into the 
new want profile (on an update this would be left out since the posting already contains a profile id) -->
<input type="button" id="btn_new_skill" class="btn btngreen" name="btn_new_skill" value="Add New" onClick="showEdit('new<?=$profileid?>','','','','','','wants')" />

<!-- if there are projects, display each one. The $params string is used to send parameters through the showEdit function on submit -->
<?php if(isset($projects)) foreach($projects as $s): ?>
	<?php
		$params = "\"$s->sp_id\",\"$s->sp_heading\",\"$s->s_id\",\"$s->sp_keywords\",\"$s->wp_expiry\",\"$s->sp_details\",\"wants\"";
	?>
	<form class="p_skills" name="p_skills">
		<h3><?=$s->sp_heading ?></h3>
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		Required by: <?=$s->wp_expiry ?><br />
		<input id="editskill" class="btn btnyellow" name="editskill" type="button" onClick='showEdit(<?=$params?>)' value="Edit" />
	</form>
	
<!--if no skills exist, suggest that the user adds one-->
<?php endforeach; else echo "<br />You have no projects, add one now!";?>
</div><!-- end #tab3 -->
</div><!-- end #tabs -->

<!--if the profile doesn't exist redirect them to the profile form page--> 
<?php if(!$profile) redirect($this->load->view('profile_form')); ?>

<script>

	//this function shows the modal display for sending messages
	function showBox(choice)
	{
		switch(choice)
		{
			case "show":
			$('#edit-background').show("fast");
			$('#edit-box').show("fast");
			break;

			case "hide":
			$('#edit-box').html("");
			$('#edit-background').hide("fast");
			$('#edit-box').hide("fast");
			break;
		}
	}

		function showEdit(id,heading,skill,keywords,expiry,details,type)
		{
			//show the modal box
			showBox("show");

			//create a form that allows the user to add or edit a posting
			$('#edit-box').append("<form id='skilledit' name='skilledit'></form>");

			//hide the id of the skill profile/profile id (based on if its a new posting) in the form, as well as whether this 
			//is a skill or a want posting
			$('#skilledit').append("<input type='hidden' id='sp_id' name='sp_id' value='" + id + "' />");
			$('#skilledit').append("<input type='hidden' id='type' name='type' value='" + type + "' />");

			//create and populate (if applicable) the input fields
			$('#skilledit').append("Heading: <input required='required' type='text' id='sp_heading' name='sp_heading' value='" + heading + "' style='width:50%;' />");
			$('#skilledit').append("Skill:<br /><select id='s_id' name='s_id'></select><br />");

			//add options to the dropdown list using the list of options created in php at the top of the page
			$('#s_id').append("<?=$select ?>");

			//add more input fields
			$('#skilledit').append("<form>");
			$('#skilledit').append("Keywords: <input type='text' required='required' id='sp_keywords' name='sp_keywords' value='" + keywords + "' />");
			$('#skilledit').append("Details: <textarea id='sp_details' required='required' name='sp_details' style='width:75%;height:100px;'>" + details + "</textarea>");
			
			//allow the user to add or edit the date needed by if this is a want (or project) posting
			if(type == "wants")
			{
				$('#skilledit').append("Required by: <input type='date' id='wp_expiry' name='wp_expiry' value='" + expiry + "' placeholder='yyyy/mm/dd' /><br />");
			}

			//add the butttons
			$('#skilledit').append("<input type='submit' class='btn btngreen' id='btnsubmit' name='btnsubmit' value='Submit' />");
			$('#skilledit').append("<input type='button' id='btncancel' class='btn btnyellow' name='btncancel' value='Cancel' />");
			$('#skilledit').append("</form>");
			//"new" has been appended to the id variable if this is a new posting. If its not a new posting, display a delete option
			if(id.substring(0,3) != "new")
			{
				$('#skilledit').append("<input type='button' class='btn btnred' id='btndelete' name='btndelete' value='Delete' style='float:right;position:relative;'/>");
			}
			$('#skilledit').append("</form>");

			//set the skill selected in the dropdown list to the skill of the selected record (if this is an edit)
			$("#s_id").val(skill);

			//bind functions to the newly added buttons
			bindButtons();
		}

		//NOTICE! Since these buttons and inputs did not exist when the page loaded, the bind has to occur AFTER 
		//the elements were created!!
		function bindButtons(){
			$('#btnsubmit').bind('click', function() {
				var expiry = "";
				var spid = $('#sp_id').val();
				var heading = $('#sp_heading').val();
				var skill = $('#s_id').val();
				var keywords = $('#sp_keywords').val();
				var details = $('#sp_details').val();
				var type = $('#type').val();
				if(type == "wants")
					expiry = $('#wp_expiry').val();

				runAJAX(spid,heading,skill,keywords,details,expiry,type);
			});

			//this button clears and hides the modal box
			$('#btncancel').bind('click', function() {
				location.reload();
			});

			//bind the delete button to a function where on click the record is deleted (after confirmation)
			$('#btndelete').bind('click', function() {

				//confirm deletion from the user
				if(!confirm("Are you sure you want to delete this posting?")) return;

				//get the id of the posting and determine whether it is in the skill_profiles or want_profiles table
				var spid = $('#sp_id').val();
				var type = $('#type').val();

				//determine which call to used based on whether user is logged in or not
				ext_url = 'index.php/profiles/deleteSkill';

				//base_url us a php function to get to the root of the site, then add the extended url
				var send_url = '<?=base_url()?>' + ext_url;

				//send the variables through
				$.post(send_url, { sp_id: spid, type: type }).done(function(msg){
						displayMsg("Your posting has been successfully removed.");
	                }).fail(function(){
	                	displayMsg('Oops! Our computers could not delete this posting. Please try again later.');
	                });
			});
		}

		function runAJAX(spid,heading,skill,keywords,details,expiry,type)
		{		
			//determine which call to used based on whether user is logged in or not
			ext_url = 'index.php/profiles/editSkill';

			//base_url us a php function to get to the root of the site, then add the extended url
			var send_url = '<?=base_url()?>' + ext_url;

			//send the variables through
			$.post(send_url, { sp_id: spid, s_id: skill, sp_heading: heading, sp_keywords: keywords, sp_details: details, expiry: expiry, type: type }).done(function(msg){
					displayMsg("Your changes have been saved.")
                }).fail(function(){
                	displayMsg("Oops! Your changes could not be saved. Please try again later.")
                });
		}

		//show a result message in the modal box and add a close button
		function displayMsg(msg)
		{
	    	$('#edit-box').html(msg).hide().fadeIn(1500);;
	    	$('#edit-box').append("<br /><input type='button' id='btncancel' name='btncancel' value='Close' />");
			bindButtons();
		}

</script>