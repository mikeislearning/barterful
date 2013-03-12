<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
	<?php 
		echo "Welcome to ".$this->session->userdata('username')."'s profile"; 
		$id = $this->session->userdata('userid');
			echo "<br />This user's id is: " . $id[0]->m_id;
	?>
	
	<br />

	
            </main>