<?php
	
	//check if the user is logged in - this determines if the user can send a message later
	$logged_in = $this->session->userdata('logged_in');
			 
				 if(!isset($logged_in) || $logged_in != true)
				 {
					 $logged_in = false;
				 }
				 else $logged_in = true;

	//this populates the drop down lists later when sending an offer
	$select = "<option value=''></option>";
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
//make sure the profiles array exists (there should only be one row since it matches the member id)
	if(isset($profile)) foreach ($profile as $p):?>         

<!-- display the username as a page header -->  
<h1 style="padding:30px;font-weight:bold;font-size:24pt;"><?=$p->m_username?>'s Profile</h1>

<!--user's profile image -->
<?php echo '<img src="../../uploads/original/' .$p->p_img .'"/>' . '<br/>'; ?>

<?php endforeach; ?>



<!-- each of the following sections displays a list of the user's skill, want, and project postings. Each also has a button
	allowing the user to send an offer in relation to that posting. The sendOffer function (triggered by the send offer button)
	sends paramaters (the $params string) relating to that posting that help populate the message form -->

<!-- check that the user has posted skills and display those, otherwise suggest that they add one -->
<?php if(isset($skills)): ?>
<h2 style="font-weight:bold;padding:5px;font-size:18pt;">Skills</h2>
<?php foreach($skills as $s): ?>
	<?php
		$params = "\"$s->m_id\",\"$s->s_id\",\"skill\"";
	?>
	<form id="p_skills" name="p_skills" style="border:2px solid black;padding:10px;margin:5px;background-color:gray;">
		<h3><?=$s->sp_heading ?></h3>
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		<input id="editskill" name="editskill" type="button" onClick='sendOffer(<?=$params?>)' value="Send Offer" />
	</form>
	
<?php endforeach; endif; ?>

<!-- check that the user has posted wants and display those, otherwise suggest that they add one -->
<?php if(isset($wants)): ?>
<h2 style="font-weight:bold;padding:5px;font-size:18pt;">Wants</h2>
<?php foreach($wants as $s): ?>
	<?php
		$params = "\"$s->m_id\",\"$s->s_id\",\"want\"";
	?>
	<form id="p_skills" name="p_skills" style="border:2px solid black;padding:10px;margin:5px;background-color:gray;">
		<h3><?=$s->sp_heading ?></h3>
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		<?php if($s->wp_expiry) echo "Required by: " . $s->wp_expiry . "<br />"; ?>
		<input id="editskill" name="editskill" type="button" onClick='sendOffer(<?=$params?>)' value="Send Offer" />
	</form>
	
<?php endforeach; endif; ?>

<!-- check that the user has posted projects and display those, otherwise suggest that they add one -->
<?php if(isset($projects)): ?>
<h2 style="font-weight:bold;padding:5px;font-size:18pt;">Projects</h2>
<?php foreach($projects as $s): ?>
	<?php
		$params = "\"$s->m_id\",\"$s->s_id\",\"project\"";
	?>
	<form id="p_skills" name="p_skills" style="border:2px solid black;padding:10px;margin:5px;background-color:gray;">
		<h3><?=$s->sp_heading ?></h3>
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		Required by: <?=$s->wp_expiry ?><br />
		<input id="editskill" name="editskill" type="button" onClick='sendOffer(<?=$params?>)' value="Send Offer" />
	</form>
	
<?php endforeach; endif; ?>
	
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

	//when the user presses "send offer" and parameters are sent to this function
	function sendOffer(toid,toskill,type)
	{
		//show the modal box
		showBox("show");

		//determine whether the user is logged in
		var loggedin = '<?=$logged_in ?>';

		//if the user is not logged in, they cannot send a message and so they are presented 
		//with instructions to create an account or log in
		if(loggedin != '1')
		{
            	displayMsg("Please log in or create an account to send a message.");
				return;
		}

		//here we dynamically create a form that lets the user create a message. This form also stores the id of
		//the user receiving the message
		$('#edit-box').append("<form id='sendmsg' name='sendmsg'></form>");
		$('#sendmsg').append("<input type='hidden' id='m_id' name='m_id' value='" + toid + "' />");
		$('#sendmsg').append("I'd like <input type='text' id='to_unit' name='to_unit' />");
		$('#sendmsg').append("of <select id='to_s_id' name='to_s_id'></select><br />");
		$('#to_s_id').append("<?=$select ?>");
		$('#sendmsg').append("and I'm offering <input type='text' id='from_unit' name='from_unit' />");
		$('#sendmsg').append("of <select id='from_s_id' name='from_s_id'></select><br />");

		//this populates the dropdown list using the variable created in php at the top of the page
		$('#from_s_id').append("<?=$select ?>");

		$('#sendmsg').append("Message: <textarea id='message' name='message'></textarea>");
		$('#sendmsg').append("<input type='button' id='btnsubmit' name='btnsubmit' value='Send Offer' />");
		$('#sendmsg').append("<input type='button' id='btncancel' name='btncancel' value='Cancel' />");
		$('#sendmsg').append("</form>");

		//set the selected skill in the dropdown list to the one chosen on the users profile
		if(type=="skill") $("#to_s_id").val(toskill);
		else $("#from_s_id").val(toskill);

		//now that the button elements have been created, bind them to their respective functions
		bindButtons();
	}

	//NOTICE! Since these buttons and inputs did not exist when the page loaded, the bind has to occur AFTER 
	//the elements were created!!
	function bindButtons(){

		//when the submit button is clicked, submit the form values using AJAX
		$('#btnsubmit').bind('click', function() {
			var toid = $('#m_id').val();
			var toskill = $('#to_s_id').val();
			var tounit = $('#to_unit').val();
			var fromskill = $('#from_s_id').val();
			var fromunit = $('#from_unit').val();
			var message = $('#message').val();

			runAJAX(toid, toskill, tounit, fromskill, fromunit, message);
		});

		//when the cancel button is clicked, hide the modal box
		$('#btncancel').bind('click', function() {
			showBox("hide");
		});
	}

	//this function sends the message to the controller and then into the database
	function runAJAX(toid, toskill, tounit, fromskill, fromunit, message)
	{
		//determine which call to used based on whether user is logged in or not
		ext_url = 'index.php/ajax/sendmessage';

		//base_url us a php function to get to the root of the site, then add the extended url
		var send_url = '<?=base_url()?>' + ext_url;

		//send the variables through, and display appropriate success or error messages
		$.post(send_url, { to: toid, to_skill: toskill, to_unit: tounit, from_skill: fromskill, from_unit: fromunit, message: message, response: 'offer' }).done(function(msg){
				displayMsg('Your message has been sent!');
				
            }).fail(function(){
            	displayMsg('Oops! Your message could not be sent. Please try again later.');
            });
	}

	function displayMsg(msg)
	{
    	$('#edit-box').html(msg).hide().fadeIn(1500);;
    	$('#edit-box').append("<br /><input type='button' id='btncancel' name='btncancel' value='Close' />");
		bindButtons();
	}

</script>