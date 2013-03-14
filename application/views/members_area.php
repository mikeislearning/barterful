<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
	<?php echo "Welcome to ".$this->session->userdata('username')."'s profile"; 
		print_r($this->session->all_userdata());
		
	?>
	
	<br />

	
            </main>