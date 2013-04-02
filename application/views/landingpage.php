<!DOCTYPE html>
<html>
    <head>
           <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0 "/>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700|Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css' />
        <style>
        
        #container{
	        width:100%;
	        margin:0 auto;
	        text-align:center;
	        color:#1BA7D8;
        }
        label{display:block;}
        
        form{width:300px;
        margin:0 auto;}

        .error{
	        color:red;
        }
        body,h1,h3{
            font-family:'Open Sans', Helvetica, Arial, serif;
            font-weight: 100;
       background-color:#ECE6D6;
       }

       input{
        text-align: center;
       }
        </style>
       
        
        <title>Welcome to Barterful</title>
        
    </head>
    <body>
    
    <div id="container">
        
        <h1> So what are you good at?</h1>
        <h3> Barterful is coming</h3>
	    
       <iframe width="420" height="315" src="http://www.youtube.com/embed/brIczGe1uJo" frameborder="0" allowfullscreen></iframe>
       
       <h3> Any Questions? </h3>
       
       
	<?php echo form_open('email/send'); //this creates the following <form method="post" action="http://codeigniter/index.php/email/send"/> ?>
	 
	 <?php
	 $message_data=array(
	 	'name'=> 'message',
	 	'id'=>'message',
	 	'value'=>set_value('message')
	 );	 ?>
	 <!-- this input uses an array to pass get its data -->
   <p> <label for="email">Name:</label><input required="required" type="text" name="name" id="name" value="<?php echo set_value('name');?>"> </p>
	 <p> <label for="email">Email:</label><input required="required" type="email" name="email" id="email" value="<?php echo set_value('email');?>"> </p>
	 <p><label for="message">Message:</label> <textarea required="required" type="text" name="message" id="message"
	 value="<?php echo set_value('message'); ?>" ></textarea>
	 
   <?php
      require_once('recaptchalib.php');
      $publickey = "6LdvIN8SAAAAAAaYK6YYeBk7eIMmWJPLWDOFHxHO"; // You got this from the signup page.
      echo recaptcha_get_html($publickey);
    ?>

	 <p> <?php echo form_submit('submit', 'Submit');//two parameters refer to name and value ?></p>
	
	<?php echo form_close(); ?>
	

<?php echo validation_errors('<p class="error">'); ?><!-- Print out the validation errors -->
	
	
       
       
          
    </div>
          
           </body>
    
    
    <!-- including javascript stuff -->
<!-- including javascript stuff -->
    <script src="<?php echo base_url('refs/_js/jquery-1.9.0.min.js');?>"></script>
    <script src="<?php echo base_url('refs/_js/modernizr.js');?>"></script>
    <script src="<?php echo base_url('refs/_js/main.js');?>"></script>
</html>
