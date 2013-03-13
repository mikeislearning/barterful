<?php include_once ('includes/sort.php'); ?>
<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>
            
	<?php 
		echo "Welcome to ".$this->session->userdata('username')."'s profile";
	?>

	<?php foreach ($row as $r): ?>
	            <article class="profile">
            <img src="<?php echo base_url('refs/_img/irrelephant.jpg');?>" class="left clearfix" alt="elephant" width="100" height="100" />
	            <section class="info">
	            
		            <p><?php echo $r->sp_heading ?></p>
		            <a href="#">User Rating: <?php echo $r->p_avg_rating*100 . "%" ?> </a><br/>
		            <button>Contact <?php echo $r->p_fname ?> </button>
	            </section>
	        </article>
    <?php endforeach; ?>
	
	<br />

	
            </main>