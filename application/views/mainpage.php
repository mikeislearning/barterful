
  <?php $this->load->view('includes/sortListings.php'); ?>
       
<!-- ************************ Main Content ************************** -->    
        <div class="bgWrapper">
        <section class="mainWrapper" id="mainContent">
         
          <div class="row">
            <main>     

              <!-- **************************************************************************************************
               Why load another view? The AJAX function returns a view from the controller in HTML form (in this case
                sortListings), which is then written to the <main> element with jQuery .done. If there is any 
                formatting in the view returned to AJAX, the <main> tag ends up with duplicate wrappers/styling
                ************************************************************************************************** -->               
            	<?php $this->load->view('includes/listSearch.php'); ?>
            
            </main>   
<!-- ************************ Side Bar ************************** -->

	        
	           
	      

        
