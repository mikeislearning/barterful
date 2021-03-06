<!-- this displays for the administrator all messages sent by a specific user. This is a viewing page 
	only and is only meant to aid in the decision-making process regarding user reports -->

<article class="inbox">
<table>
	<thead>
		<th> From </th>
		<th> Offer</th>
		<th> Message</th>
		<th>Sent</th>
	</thead>
	<tbody>

		<?php if($row) foreach ($row as $r):?>

		<?php 
			//reformat the mySQL DateTime so that it shows the time is AM/PM format
			$datetime = strtotime($r->date);
			$newdate = date("m/d/y g:i A", $datetime);
		?>
			            
		<tr class="inbox_long">
			<!-- first td is the name of the other person -->
			<td class="inbox_sender">
			<?php echo $r->sender ?> 
			</td>
			<td  ><form id="seemore" name="seemore" action=''>
				    <input name="sender" id="sender" type="hidden" value='<?php echo $r->mes_from ?>' />
				    <input name="receiver" id="receiver" type="hidden" value='<?php echo $r->mes_to ?>' />
				    <input type="submit" class="inbox_message" value="<?php echo "Offering " . $r->s_from . " " . $r->mes_from_unit . " for " . $r->s_to . " " . $r->mes_to_unit ?> " />
				</form>
			</td>
			<td>	
				<?=$r->mes_message ?>

			</td>

			<td><?=$newdate ?></td>	    

		</tr>

		<?php endforeach; ?>



		</tbody>
	</table>
</article>

<?php if(!$row) echo "There are no messages to display"; ?>