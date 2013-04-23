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

	//populate the drop down list of reasons to report a user
	$report_reasons = "<option value=''>Select</option>";

	if($reasons)
	{
		foreach($reasons as $r)
		{
			$report_reasons .= "<option value='" . $r->rr_id . "'>" . $r->rr_name . "</option>";
		}
	}

	?>

<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
<!--This view is loaded from views/profile_form and is only included if profile information has already been set -->



<div id="edit-background" >
</div>
<div id="edit-box">
</div>

<div id="user_info">
<?php
//make sure the profiles array exists (there should only be one row since it matches the member id)
	if(isset($profile)) foreach ($profile as $p):?>         

<!-- display the username as a page header -->  
<h2><?=$p->m_username?>'s Profile</h1>
<?php $pid = $p->p_id; ?>
<!--user's profile image -->
<img src="../../uploads/original/<?=$p->p_img?>" />

<?php endforeach; ?>

</div>

<!-- each of the following sections displays a list of the user's skill, want, and project postings. Each also has a button
	allowing the user to send an offer in relation to that posting. The sendOffer function (triggered by the send offer button)
	sends paramaters (the $params string) relating to that posting that help populate the message form -->

<!-- check that the user has posted skills and display those, otherwise suggest that they add one -->


<div id="tabs">

    <ul>
      <li><a href="#tab-1">Offering</a></li>
      <li><a href="#tab-2">Wanting</a></li>
      <li><a href="#tab-3">Projects</a></li>
    </ul>

<?php if(isset($profile)) foreach ($profile as $p): ?>
    <input type="button" id="editskill" name="editskill" onClick='reportUser(<?=$pid ?>)' value="Report User" />
<?php endforeach ?>

<div id="tab-1">
<?php if(isset($skills)): ?>
<?php foreach($skills as $s): ?>
	<?php
		$params = "\"$s->m_id\",\"$s->s_id\",\"skill\"";
	?>
	<form class="p_skills" name="p_skills">
		<h3><?=$s->sp_heading ?></h3>
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		<input id="editskill" name="editskill" type="button" onClick='sendOffer(<?=$params?>)' value="Send Offer" />
	</form>
	
<?php endforeach; endif; ?>
</div>
<!-- check that the user has posted wants and display those, otherwise suggest that they add one -->
<div id="tab-2">
<?php if(isset($wants)): ?>
<?php foreach($wants as $s): ?>
	<?php
		$params = "\"$s->m_id\",\"$s->s_id\",\"want\"";
	?>
	<form class="p_skills" name="p_skills" >
		<h3><?=$s->sp_heading ?></h3>
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		<?php if($s->wp_expiry) echo "Required by: " . $s->wp_expiry . "<br />"; ?>
		<input id="editskill" name="editskill" type="button" onClick='sendOffer(<?=$params?>)' value="Send Offer" />
	</form>
	
<?php endforeach; endif; ?>
</div>
<!-- check that the user has posted projects and display those, otherwise suggest that they add one -->
<div id="tab-3">
<?php if(isset($projects)): ?>
<?php foreach($projects as $s): ?>
	<?php
		$params = "\"$s->m_id\",\"$s->s_id\",\"project\"";
	?>
	<form class="p_skills" name="p_skills" >
		<h3><?=$s->sp_heading ?></h3>
		Skill: <?=$s->s_name ?><br />
		Keywords: <?=$s->sp_keywords ?><br />
		Details: <?=$s->sp_details ?><br />
		Required by: <?=$s->wp_expiry ?><br />
		<input id="editskill" name="editskill" type="button" onClick='sendOffer(<?=$params?>)' value="Send Offer" />
	</form>
	
<?php endforeach; endif; ?>
</div>



</div> <!-- end #tabs -->



<!--if the profile doesn't exist redirect them to the profile form page--> 
<?php if(!$profile || $profile[0] == "") redirect($this->load->view('includes/listPostings')); ?>


            </main>
            </div><!-- end div with class row from mainpage -->
		</section><!-- end section thing -->
        </div> <!-- end bgWrapper from mainpage -->
        
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

	function reportUser(userid)
	{
		//show the modal box
		showBox("show");

		//here we dynamically create a form that lets the user create a message. This form also stores the id of
		//the user receiving the message
		$('#edit-box').append("<form id='reportuser' name='reportuser'></form>");
		$('#reportuser').append("<input type='hidden' id='m_id' name='m_id' value='" + userid + "' />");
		$('#reportuser').append("Please select one: <select id='report_reason' name='report_reason'></select><br />");
		$('#report_reason').append("<?=$report_reasons ?>");
		$('#reportuser').append("Description:<br /><textarea id='report_details' name='report_details'></textarea>");
		$('#reportuser').append("<input type='button' id='send_report' name='send_report' value='Send Report' />");
		$('#reportuser').append("<input type='button' id='btncancel' name='btncancel' value='Cancel' />");
		$('#reportuser').append("</form>");

		//now that the button elements have been created, bind them to their respective functions
		bindButtons();
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

		if($('#btnsubmit').length)
		{//when the submit button is clicked, submit the form values using AJAX
			$('#btnsubmit').bind('click', function() {
				var toid = $('#m_id').val();
				var toskill = $('#to_s_id').val();
				var tounit = $('#to_unit').val();
				var fromskill = $('#from_s_id').val();
				var fromunit = $('#from_unit').val();
				var message = $('#message').val();

				runAJAX(toid, toskill, tounit, fromskill, fromunit, message);
			});
		}

		if($('#send_report').length)
		{
			//when the submit button is clicked, submit the form values using AJAX
			$('#send_report').bind('click', function() {
				var mid = $('#m_id').val();
				var dets = $('#report_details').val();
				var reason = $('#report_reason').val();
				sendReport(mid,reason,dets);
			});
		}

		//when the cancel button is clicked, hide the modal box
		$('#btncancel').bind('click', function() {
			location.reload();
		});
	}

	//this function sends the message to the controller and then into the database
	function runAJAX(toid, toskill, tounit, fromskill, fromunit, message)
	{
		//determine which call to used based on whether user is logged in or not
		ext_url = 'index.php/mail/sendmessage';

		//base_url us a php function to get to the root of the site, then add the extended url
		var send_url = '<?=base_url()?>' + ext_url;

		//send the variables through, and display appropriate success or error messages
		$.post(send_url, { to: toid, to_skill: toskill, to_unit: tounit, from_skill: fromskill, from_unit: fromunit, message: message, response: 'offer' }).done(function(msg){
				displayMsg('Your message has been sent!');
				
            }).fail(function(){
            	displayMsg('Oops! Your message could not be sent. Please try again later.');
            });
	}

	//this function sends the message to the controller and then into the database
	function sendReport(id,reason,details)
	{
		//determine which call to used based on whether user is logged in or not
		ext_url = 'index.php/profiles/report';

		//base_url us a php function to get to the root of the site, then add the extended url
		var send_url = '<?=base_url()?>' + ext_url;

		//send the variables through, and display appropriate success or error messages
		$.post(send_url, { id: id, reason: reason, details: details}).done(function(msg){
				displayMsg('Thank you');
				
            }).fail(function(){
            	displayMsg('Oops! Your report could not be processed. Please try again later.');
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