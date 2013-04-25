<div>
<?php echo $map['js']; ?>
</div>


<div>

<div class="bgWrapper" style="width:60em; margin:0 auto; background-color:rgba(255,​ 255,​ 255,​ 0.9)">
<?php 
//if there is more than one barterspot
if(isset($barterspot['closest'])){
echo "<h4>" . $barterspot['closest'] .  " is the closest location to you</h4>";
echo "It is approximately " . $barterspot['far'] . " miles away from you!"; 

//how far the barterspot is
echo $barterspot['num'];
}

else
{
if(isset($barterspot['num'])){
	echo $barterspot['num'];
}
}



?>

</h2>
</div><div>

<?php
//$infoLocation;
echo $map['html']; ?>
</div>
 </section>
<div>
