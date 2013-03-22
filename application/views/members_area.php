<<<<<<< HEAD
<?php include_once ('includes/sort.php'); ?>
<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
<<<<<<< HEAD
	<?php echo "Welcome to ".$this->session->userdata('username')."'s profile"; 
		print_r($this->session->all_userdata());
		
	?>
=======
	<?php 
		echo "Welcome to ".$this->session->userdata('username')."'s profile";
	?>

	<?php require_once ('includes/list.php'); ?>
            
>>>>>>> ilanaBranch
	
	<br />

	
            </main>
=======
  <?php $this->load->view('includes/sortListings.php'); ?>
       
<!-- ************************ Main Content ************************** -->    
        <div class="bgWrapper">
        <section class="mainWrapper">
         
          <div class="row">
            <main>     
            	<?php 
					echo "Welcome to ".$this->session->userdata('username')."'s profile";
				?>

              <!-- **************************************************************************************************
               Why load another view? The AJAX function returns a view from the controller in HTML form (in this case
                sortListings), which is then written to the <main> element with jQuery .done. If there is any 
                formatting in the view returned to AJAX, the <main> tag ends up with duplicate wrappers/styling
                ************************************************************************************************** -->               
            	<?php $this->load->view('includes/listPostings.php'); ?>
            
            </main>   
<!-- ************************ Side Bar ************************** -->
>>>>>>> master
