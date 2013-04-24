<?php
	if($count_unreviewed > 0)
		$count_unreviewed = "(" . $count_unreviewed . ")";
	else $count_unreviewed = "";
?>

<div class="bgWrapper">
    <section class="mainWrapper">
    	<div class="row">
            <main>

            	<h1>Welcome to the Admin Panel, <?=$this->session->userdata('username') ?></h1>

				<h2>What would you like to do?</h2>

				<ul>
					<li><input type="submit" id="btn_reports" name="btn_reports" value="Manage Reported Profiles <?=$count_unreviewed ?>" class="button1" /></li>
					<li><input type="submit" id="btn_skills" name="btn_skills" value="Manage Skills" class="button1" /></li>
					<li><input type="submit" id="btn_users" name="btn_users" value="Manage Users" class="button1" /></li>
					<li><input type="submit" id="btn_messages" name="btn_messages" value="Manage Messages" class="button1" /></li>
			    </ul>

			    <div id="manageContent">
			    </div>

			</main>
		</div><!-- row -->
	</section><!--mainWrapper-->
</div> <!-- bgWrapper -->

<script>

	$(document).ready(function(){

		$('#btn_skills').bind('click', function() {

				//determine which call to used based on whether user is logged in or not
				ext_url = 'index.php/superuser/skills';

				//base_url us a php function to get to the root of the site, then add the extended url
				var send_url = '<?=base_url()?>' + ext_url;

				//send the variables through, and display appropriate success or error messages
				$.post(send_url, {}).done(function(msg){
						$('#manageContent').html(msg);
						
		            }).fail(function(){
		            	$('#manageContent').html("Unable to load content. Please try again later.");
		            });
			});

		$('#btn_reports').bind('click', function() {

				//determine which call to used based on whether user is logged in or not
				ext_url = 'index.php/superuser/reports';

				//base_url us a php function to get to the root of the site, then add the extended url
				var send_url = '<?=base_url()?>' + ext_url;

				//send the variables through, and display appropriate success or error messages
				$.post(send_url, {}).done(function(msg){
						$('#manageContent').html(msg);
						
		            }).fail(function(){
		            	$('#manageContent').html("Unable to load content. Please try again later.");
		            });
			});

	})

</script>
        