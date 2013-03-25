  <?php $this->load->view('includes/sortListings.php'); ?>
       
<!-- ************************ Main Content ************************** -->    
        <div class="bgWrapper">
        <section class="mainWrapper">
         
          <div class="row">
            <main>     
            	<?php 
					echo "Welcome to ".$this->session->userdata('username')."'s profile";
					$id = $this->session->userdata('userid');

		//get the id value from the first pair in the array
		$id = $id[0]->m_id;
		echo $id;
		
				?>

              <!-- **************************************************************************************************
               Why load another view? The AJAX function returns a view from the controller in HTML form (in this case
                sortListings), which is then written to the <main> element with jQuery .done. If there is any 
                formatting in the view returned to AJAX, the <main> tag ends up with duplicate wrappers/styling
                ************************************************************************************************** -->               
            	<?php $this->load->view('includes/listPostings.php'); ?>
            
            </main>   
<!-- ************************ Side Bar ************************** -->