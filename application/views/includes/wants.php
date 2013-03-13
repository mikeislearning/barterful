<?php foreach ($wrow as $r): ?>
	            
	            <article class="profile">
            <img src="<?php echo base_url('refs/_img/irrelephant.jpg');?>" class="left clearfix" alt="elephant" width="100" height="100" />
	            <section class="info">
	            
		            <p><?php echo $r->wp_description ?></p>
		            <a href="#">User Rating: <?php echo $r->p_avg_rating*100 . "%" ?> </a><br/>
		            <button>Contact <?php echo $r->p_fname ?> </button>
	            </section>
	        </article>
	            <?php endforeach; ?>