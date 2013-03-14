<?php if($row) foreach ($row as $r):?>
	            
	            <article class="profile">
                <section class="info">
	            
		            <p><?php echo $r->sender ?> offers <?php echo $r->s_from ?> (<?php echo $r->mes_from_unit ?>) for <?php echo $r->s_to ?> (<?php echo $r->mes_to_unit ?>)</p>
		            <p><?php echo $r->mes_date ?></p>
		            <p>"<?php echo $r->mes_message ?>"</p>
	            </section>
	        </article>
	            <?php endforeach; ?>

				<?php if(!$row) echo "There are no messages to display"; ?>