<?php include_once ('includes/sort.php'); ?>
<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
	<?php 
		echo "Welcome to ".$this->session->userdata('username')."'s profile";
	?>

	<?php require_once ('includes/list.php'); ?>
            
	
	<br />

	
            </main>