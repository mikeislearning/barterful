<?php if($row) foreach ($row as $r):?>
	            
	            <article class="profile">
            <img src="<?php echo base_url('refs/_img/irrelephant.jpg');?>" class="left clearfix" alt="elephant" width="100" height="100" />
	            <section class="info">
	            
		            <p><?php echo $r->sp_heading ?></p>
		            <p><?php echo $r->s_name ?></p>
		            <a href="#">User Rating: <?php echo $r->p_avg_rating*100 . "%" ?> </a><br/>
		            <button>Contact <?php echo $r->p_fname ?> </button>
	            </section>
	        </article>
	            <?php endforeach; ?>

<?php if(!$row) echo "There is no one matching that description!"; ?>