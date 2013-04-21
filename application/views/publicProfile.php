<?php
	$logged_in = $this->session->userdata('logged_in');
			 
				 if(!isset($logged_in) || $logged_in != true)
				 {
					 $logged_in = false;
				 }
				 else $logged_in = true;

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
	if(isset($profile)) foreach ($profile as $p):?>           
<h1 style="padding:30px;font-weight:bold;font-size:24pt;"><?=$p->m_username?>'s Profile</h1>
<?php echo '<img src="../../uploads/original/' .$p->p_img .'"/>' . '<br/>'; ?>

<?php endforeach; ?>

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

		function sendOffer(toid,toskill,type)
		{
			$('#edit-background').css('display','block');
			$('#edit-box').css('display','block');

			var loggedin = '<?=$logged_in ?>';

			if(loggedin != '1')
			{
                	$('#edit-box').html('Please log in or create an account to send a message.');
                	$('#edit-box').append("<br /><input type='button' id='btncancel' name='btncancel' value='Close' />");
                	$('#edit-box').append(loggedin);
					bindButtons();
					return;
			}

			$('#edit-box').append("<form id='sendmsg' name='sendmsg'></form>");
			$('#sendmsg').append("<input type='hidden' id='m_id' name='m_id' value='" + toid + "' />");
			$('#sendmsg').append("I'd like <input type='text' id='to_unit' name='to_unit' />");
			$('#sendmsg').append("of <select id='to_s_id' name='to_s_id'></select><br />");
			$('#to_s_id').append("<?=$select ?>");
			$('#sendmsg').append("and I'm offering <input type='text' id='from_unit' name='from_unit' />");
			$('#sendmsg').append("of <select id='from_s_id' name='from_s_id'></select><br />");
			$('#from_s_id').append("<?=$select ?>");
			$('#sendmsg').append("Message: <textarea id='message' name='message'></textarea>");
			$('#sendmsg').append("<input type='button' id='btnsubmit' name='btnsubmit' value='Send Offer' />");
			$('#sendmsg').append("<input type='button' id='btncancel' name='btncancel' value='Cancel' />");
			$('#sendmsg').append("</form>");
			if(type=="skill") $("#to_s_id").val(toskill);
			else $("#from_s_id").val(toskill);
			bindButtons();
		}

		//NOTICE! Since these buttons and inputs did not exist when the page loaded, the bind has to occur AFTER 
		//the elements were created!!
		function bindButtons(){
			$('#btnsubmit').bind('click', function() {
				var toid = $('#m_id').val();
				var toskill = $('#to_s_id').val();
				var tounit = $('#to_unit').val();
				var fromskill = $('#from_s_id').val();
				var fromunit = $('#from_unit').val();
				var message = $('#message').val();

				runAJAX(toid, toskill, tounit, fromskill, fromunit, message);
			});

			$('#btncancel').bind('click', function() {
				$('#edit-box').html("");
				$('#edit-background').css('display','none');
				$('#edit-box').css('display','none');
			});
		}

		function runAJAX(toid, toskill, tounit, fromskill, fromunit, message)
		{
			//determine which call to used based on whether user is logged in or not
			ext_url = 'index.php/ajax/sendmessage';

			//base_url us a php function to get to the root of the site, then add the extended url
			var send_url = '<?=base_url()?>' + ext_url;

			//send the variables through
			$.post(send_url, { to: toid, to_skill: toskill, to_unit: tounit, from_skill: fromskill, from_unit: fromunit, message: message, response: 'offer' }).done(function(msg){
					$('#edit-box').html('Your message has been sent.');
                	$('#edit-box').append("<br /><input type='button' id='btncancel' name='btncancel' value='Close' />");
					bindButtons();
					
                }).fail(function(){
                	$('#edit-box').html('Could not send!');
                	$('#edit-box').append("<br /><input type='button' id='btncancel' name='btncancel' value='Close' />");
					bindButtons();
                });
		}

</script>