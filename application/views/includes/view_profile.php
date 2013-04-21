<?php

	$select = "";
	foreach($skill_list as $sl)
	{
		$select .= "<option value='" . $sl->s_id . "'>$sl->s_name</option>";
	}

	?>

<!--This view is loaded from views/profile_form and is only included if profile information has already been set -->
<div id="edit-background" style="width:100%;height:100%;background-color:grey;opacity:0.7;position:fixed;top:0;left:0;z-index:10;display:none;">
</div>
<div id="edit-box" style="width:50%;margin:0 auto;position:fixed;z-index:20;background-color:white;display:none;padding:20px;">
</div>
<?php
	if(isset($profile)) foreach ($profile as $p):?>           
<h1>Your Profile</h1>
<?php
if(isset($error)){echo $error; } //checks if there is an error in an update.
echo '<img src="../../uploads/original/' .$p->p_img .'"/>' . '<br/>';

echo "Username: " .$this->session->userdata('username') ."<br/>";

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
echo anchor('Profile_crud/edit', 'edit');?>	 
<br />

<h2 style="font-weight:bold;padding:5px;font-size:18pt;">Skills</h2>
<?php if(isset($skills)) foreach($skills as $s): ?>
	<?php
		$params = "\"$s->sp_id\",\"$s->sp_heading\",\"$s->s_id\",\"$s->sp_keywords\",\"$s->sp_details\"";
	?>
	<form id="p_skills" name="p_skills" style="border:2px solid black;padding:10px;margin:5px;background-color:gray;">
		<h3><?=$s->sp_heading ?></h3>
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		<input id="editskill" name="editskill" type="button" onClick='showEdit(<?=$params?>)' value="Edit" />
	</form>
	
<?php endforeach; ?>

<h2 style="font-weight:bold;padding:5px;font-size:18pt;">Wants</h2>
<?php if(isset($wants)) foreach($wants as $s): ?>
	<form id="p_wants" name="p_wants" action="showEdit()" style="border:2px solid black;padding:10px;margin:5px;background-color:gray;">
		<h3><?=$s->sp_heading ?></h3>
		<input type="hidden" value="<?=$s->sp_id ?>" />
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		<input id="editwant" name="editwant" type="submit" value="Edit" />
	</form>
	
<?php endforeach; ?>

<h2 style="font-weight:bold;padding:5px;font-size:18pt;">Projects</h2>
<?php if(isset($projects)) foreach($projects as $s): ?>
	<form id="p_projects" name="p_projects" action="showEdit()" style="border:2px solid black;padding:10px;margin:5px;background-color:gray;">
		<h3><?=$s->sp_heading ?></h3>
		<input type="hidden" value="<?=$s->sp_id ?>" />
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		<input id="editwant" name="editwant" type="submit" value="Edit" />
	</form>
	
<?php endforeach; ?>
	
<!--if the profile doesn't exist redirect them to the profile form page--> 
<?php if(!$profile) redirect($this->load->view('profile_form')); ?>

<script>

	

		function showEdit(id,heading,skill,keywords,details)
		{

			$('#edit-background').css('display','block');
			$('#edit-box').css('display','block');
			$('#edit-box').append("<form id='skilledit' name='skilledit'></form>");
			$('#skilledit').append("<input type='hidden' id='sp_id' name='sp_id' value='" + id + "' />");
			$('#skilledit').append("Heading: <input type='text' id='sp_heading' name='sp_heading' value='" + heading + "' />");
			$('#skilledit').append("Skill:<br /><select id='s_id' name='s_id'></select><br />");
			$('#s_id').append("<?=$select ?>");
			$('#skilledit').append("Keywords: <input type='text' id='sp_keywords' name='sp_keywords' value='" + keywords + "' />");
			$('#skilledit').append("Details: <textarea id='sp_details' name='sp_details'>" + details + "</textarea>");
			$('#skilledit').append("<input type='button' id='btnsubmit' name='btnsubmit' value='Submit' />");
			$('#skilledit').append("<input type='button' id='btncancel' name='btncancel' value='Cancel' />");
			$('#skilledit').append("</form>");
			bindButtons();
		}

		function bindButtons(){

			$('#btnsubmit').bind('click', function() {
				var spid = $('#sp_id').val();
				var heading = $('#sp_heading').val();
				var skill = $('#s_id').val();
				var keywords = $('#sp_keywords').val();
				var details = $('#sp_details').val();

				runAJAX(spid,heading,skill,keywords,details);
			});

			$('#btncancel').bind('click', function() {
				$('#edit-box').html("");
				$('#edit-background').css('display','none');
				$('#edit-box').css('display','none');
			});
		}

		function runAJAX(spid,heading,skill,keywords,details)
		{		
			//determine which call to used based on whether user is logged in or not
			ext_url = 'index.php/ajax/editSkill';

			//base_url us a php function to get to the root of the site, then add the extended url
			var send_url = '<?=base_url()?>' + ext_url;

			//send the variables through
			$.post(send_url, { sp_id: spid, s_id: skill, sp_heading: heading, sp_keywords: keywords, sp_details: details }).done(function(msg){
					$('#edit-box').html("");
					$('#edit-background').css('display','none');
					$('#edit-box').css('display','none');
					location.reload();
                }).fail(function(){$('#edit-box').html('Could not load!');});
		}
</script>