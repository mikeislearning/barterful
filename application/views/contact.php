<<<<<<< HEAD


    <div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
            <h1> Contact Us</h1><br />
        
            <?php echo form_open('email/send'); //this creates the following <form method="post" action="http://codeigniter/index.php/email/send"/> ?><?php
            //these arrays provide the inputs with data
            	$name_data=array('name'=>'name',
            	'id'=>'name',
            	'value'=>set_value('name'),
            	'placeholder'=>'Name goes here'
            	);
            	$email_data=array('name'=>'email',
            	'id'=>'email',
            	'value'=>set_value('email'),
            	'placeholder'=>'Email goes here'
            	);
            
                 $message_data=array(
                    'name'=> 'message',
                    'id'=>'message',
                    'value'=>set_value('message'),
                    'cols'=>30,
                    'rows'=>10,
                    'placeholder'=>'Message goes here'
                 );  ?><!-- this input uses an array to pass get its data -->

            <p><label for="email">Name:</label></p>
            <?php echo form_input($name_data);?>
            <p><label for="email">Email:</label></p>
            <?php echo form_input($email_data);?>
            <p><label for="message">Message:</label> </p>
            <?php echo form_textarea($message_data);?>
            

            <p><?php echo form_submit('submit', 'Submit','id="submit"');//two parameters refer to name and value ?></p><?php echo form_close(); ?><?php echo validation_errors('<p class="error">'); ?><!-- Print out the validation errors -->
            
            </main>
            
            <script type="text/javascript">
            
            $('#submit').click(function(){
            	var form_data ={
	            	name:$('#name').val(),
	            	email:$('#email').val(),
	            	message:$('#message').val(),
	            	ajax:'1'
	            	};
	            	
	            $.ajax({
		        	url:"<?php echo site_url('email/send');?>",
		        	type: 'POST',
		        	data: form_data,
		        	success: function(){
		        		$('main').html("Thank you");
		        	} 
	            });
	            return false;
            });
            
            
            
            </script>
         

=======


    <div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
            <h1> Contact Us</h1><br />
        
            <?php echo form_open('email/send'); //this creates the following <form method="post" action="http://codeigniter/index.php/email/send"/> ?><?php
            //these arrays provide the inputs with data
            	$name_data=array('name'=>'name',
            	'id'=>'name',
            	'value'=>set_value('name'),
            	'placeholder'=>'Name goes here'
            	);
            	$email_data=array('name'=>'email',
            	'id'=>'email',
            	'value'=>set_value('email'),
            	'placeholder'=>'Email goes here'
            	);
            
                 $message_data=array(
                    'name'=> 'message',
                    'id'=>'message',
                    'value'=>set_value('message'),
                    'cols'=>30,
                    'rows'=>10,
                    'placeholder'=>'Message goes here'
                 );  ?><!-- this input uses an array to pass get its data -->

            <p><label for="email">Name:</label></p>
            <?php echo form_input($name_data);?>
            <p><label for="email">Email:</label></p>
            <?php echo form_input($email_data);?>
            <p><label for="message">Message:</label> </p>
            <?php echo form_textarea($message_data);?>
            

            <p><?php echo form_submit('submit', 'Submit','id="submit"');//two parameters refer to name and value ?></p><?php echo form_close(); ?><?php echo validation_errors('<p class="error">'); ?><!-- Print out the validation errors -->
            
            </main>
            
            <script type="text/javascript">
            
            /*$('#submit').click(function(){
            	var form_data ={
	            	name:$('#name').val(),
	            	email:$('#email').val(),
	            	message:$('#message').val(),
	            	ajax:'1'
	            	};
	            	
	            $.ajax({
		        	url:"<?php echo site_url('email/send');?>",
		        	type: 'POST',
		        	data: form_data,
		        	success: function(msg){
		        		alert(msg);
		        	} 
	            });
	            return false;
            });
            */
            
            
            </script>
         

>>>>>>> master
