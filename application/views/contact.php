<!-- ************************ Hero Unit ************************** -->

		<div id="heroWrapper">
	        <section id="heroUnit">
	        	<article class="titleText">
		            <h1>So what are you good at? </h1>
		            
		            <h3>Barterful is a network of online bartering communities. <a href="#">Learn More </a> </h3>
		            <div id="inputWrapper">
		            	<input type="text"  placeholder="Search"/>
		            	<a href="#" class="general foundicon-trash"></a>
		            </div>
	        	</article>
	        </section>
	
		</div>
		
<div id="contentWrapper" class="push">

<?php echo form_open('email/send'); //this creates the following <form method="post" action="http://codeigniter/index.php/email/send"/> ?>
	 
	 <?php
	 $message_data=array(
	 	'name'=> 'message',
	 	'id'=>'message',
	 	'value'=>set_value('message')
	 );	 ?>
	 <!-- this input uses an array to pass get its data -->

	 <p> <label for="email">Email:</label><input type="text" name="email" id="email" value="<?php echo set_value('email');?>"> </p>
	 <p><label for="message">Message:</label> <textarea type="text" name="message" id="message"
	 value="<?php echo set_value('message'); ?>" ></textarea>
	 <!--<p> <label for="message">Message:</label><?php echo form_input($message_data); ?> </p>-->
	 <!-- this input inputs the information directly -->
	 <p> <?php echo form_submit('submit', 'Submit');//two parameters refer to name and value ?></p>
	
	<?php echo form_close(); ?>
	

<?php echo validation_errors('<p class="error">'); ?><!-- Print out the validation errors -->
	
	 </div>