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
		           <li> 
		           		<form id="btn_msg_user" name="btn_msg_user" method="POST" action='<?=base_url()?>index.php/profiles/redir'>
		           			<input type="hidden" id="p_id" name="p_id" value='<?=$r->m_id ?>' />
		           			<input type="submit" class="btn btngreen" value="More about <?=$r->p_fname ?>" />
		           		</form>
		           </li>
		           <li></li>
	</ul>
	<span class="left-shadow"></span><span class="right-shadow"></span>
	        
	</div>
</div>
	        
	            <?php endforeach; ?>
<?php if(!$row) :?>

<img src="<?php echo base_url('refs/_img/grumpy.jpg');?>" title="grumpy" id="grumpy">

	<?php endif;?>