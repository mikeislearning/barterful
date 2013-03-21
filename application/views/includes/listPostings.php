<?php if($row) foreach ($row as $r):?>

<div id="adContainer">
	<div class="paper">
	<span class="tape"></span>
	<span class"red-line first"></span>
	<span class="red-line"></span>
	<ul id="lines">

         <li>   <img src="<?php echo base_url('refs/_img/irrelephant.jpg');?>" class="left clearfix" alt="elephant" width="100" height="100" /></li>

	            	<li></li>
		            <li><?php echo $r->sp_heading ?></li>
		            <li><?php echo $r->s_name ?></li>
		            <li></li>
		            <li><a href="#">User Rating: <?php echo $r->p_avg_rating*100 . "%" ?> </a></li>
		            <li></li>
		           <li> <button>Contact <?php echo $r->p_fname ?> </button></li>
		           <li></li>
	</ul>
	<span class="left-shadow"></span><span class="right-shadow"></span>
	        
	</div>
</div>
	        
	            <?php endforeach; ?>

<?php if(!$row) echo "There is no one matching that description!"; ?>