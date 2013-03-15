<!-- ************************ Sort Section ************************** -->
<div class="bgWrapper">
    <section class="mainWrapper">
    	<div class="row" id="dropdown">
	      	<form>
	      		<!-- These do nothing, these is currently only one barterspot -->
		       <fieldset>
		             <label>Barterspot</label>
		             <select id = "barterspot">
		               <option value = "Humber College">Humber</option>
		               <option value = "UofT">U of T</option>
		               <option value = "Queens">Queens</option>
		               <option value = "York">York</option>
		             </select>
		       </fieldset>
		    </form>
		    <form>
		    	<!-- Populated from a list of existing skills -->
		       <fieldset>
		             <label>Categories</label>
		             <select id = "category">
		             	<option value="all">All</option>
		             	<?php foreach($skills as $r): ?>
			               <option value=<?php echo "'" . $r->s_name . "'"; ?>><?php echo $r->s_name; ?></option>
		           		<?php endforeach; ?>
		             </select>		          
		       </fieldset>
		    </form>
		    <form>
		       <fieldset>
		             <label>Sorted by</label>
		             <select id = "sortedby">
		               <option value = "default">Smart Sort</option>
		               <option value = "p_avg_rating">Top Rated</option>
		               <option value = "p_last_updated">Most Recent</option>
		             </select>
		       </fieldset>
	    	</form>
		    <form>
			    <input id="viewtype1" name="viewtype" value="skills" type="radio" checked="checked">Offering</input>
			    <input id="viewtype2" name="viewtype" value="wants" type="radio">Wanting</input>
		    </form>
   		</div><!-- dropdown -->
	</section>  
</div><!-- /end dropdown bgWrapper -->

<script>
	$(document).ready(function(e)
	{
		
		//if any of the sort options are changed, get their values and pass them to the AJAX function
		$('input[name=viewtype]:radio, #sortedby, #category').change(function(e)
		{
			sortset = $('#sortedby').val();
			category = $('#category').val();
			listtype = $('input[name=viewtype]:checked').val();
			runAJAX(sortset,category,listtype);

		});

		function runAJAX(listsortset,listcategory,listtype)
		{		
			//determine which call to used based on whether user is logged in or not
			var logstatus = '<?=$this->session->userdata('logged_in')?>';  
			if(logstatus == 1) {ext_url = 'index.php/ajax/re_sort';}
			else{ext_url = 'index.php/site/sortListings';}

			//base_url us a php function to get to the root of the site, then add the extended url
			var send_url = '<?=base_url()?>' + ext_url;

			//send the variables through
			$.post(send_url, { type: listtype, category: listcategory, sortset: listsortset }).done(function(msg){
                    $('main').html(msg);
                }).fail(function(){$('main').html('Could not load!');});
		}
	})
</script>