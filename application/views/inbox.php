<div class="bgWrapper">
        <section class="mainWrapper">
         
          <div class="row">
            <main>                    

            	<?php if($row) foreach ($row as $r):?>
	            
	            <article class="profile">
                <section class="info">
	            
		            <p><?php echo $r->sender ?> offers <?php echo $r->s_from ?> for <?php echo $r->s_to ?></p>
		            <p><?php echo $r->mes_date ?></p>
		            <p>"<?php echo $r->mes_message ?>"</p>
	            </section>
	        </article>
	            <?php endforeach; ?>

				<?php if(!$row) echo "There are no messages in your inbox!"; ?>
            
            </main>  