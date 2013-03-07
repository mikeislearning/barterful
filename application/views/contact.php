

    <div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
        
            <?php echo form_open('email/send'); //this creates the following <form method="post" action="http://codeigniter/index.php/email/send"/> ?><?php
                 $message_data=array(
                    'name'=> 'message',
                    'id'=>'message',
                    'value'=>set_value('message')
                 );  ?><!-- this input uses an array to pass get its data -->

            <p><label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?php echo set_value('email');?>">
            </p>

            <p><label for="message">Message:</label> 
            <textarea type="text" name="message" id="message" value="<?php echo 							set_value('message'); ?>">
            </textarea> <!--<p> <label for="message">Message:</label><?php echo form_input($message_data); ?> </p>-->
             <!-- this input inputs the information directly --></p>

            <p><?php echo form_submit('submit', 'Submit');//two parameters refer to name and value ?></p><?php echo form_close(); ?><?php echo validation_errors('<p class="error">'); ?><!-- Print out the validation errors -->
            
            </main>
            </div>
        </section>
    </div>

