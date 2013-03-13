<!-- ************************ Drop down list ************************** -->
        <div class="bgWrapper">
        <section class="mainWrapper">
        <div class="row" id="dropdown">
          <form>
		       <fieldset>
		             <label>Barterspot</label><!-- this should be populated with php -->
		             <select id = "barterspot">
		               <option value = "Humber College">Humber</option>
		               <option value = "UofT">U of T</option>
		               <option value = "Queens">Queens</option>
		               <option value = "York">York</option>
		             </select>
		       </fieldset>
		    </form>
		    <form>
		       <fieldset>
		             <label>Categories</label><!-- this should be populated with php -->
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
		             <label>Sorted by</label><!-- this should be populated with php -->
		             <select id = "sortedby">
		               <option value = "default">Smart Sort</option>
		               <option value = "p_avg_rating">Top Rated</option>
		               <option value = "p_last_updated">Most Recent</option>
		             </select>
		       </fieldset>
		    </form>
		    <form>
		    	<script>
		    		$(document).ready(function(e)
		    		{

		    			$('input[name=viewtype]:radio').change(function(e)
		    			{
		    				sortset = $('#sortedby').val();
		    				category = $('#category').val();
		    				listtype = $('input[name=viewtype]:checked').val();
		    				runAJAX(sortset,category,listtype);

		    			});

		    			$('#sortedby').change(function(e)
		    			{
		    				sortset = $('#sortedby').val();
		    				category = $('#category').val();
		    				listtype = $('input[name=viewtype]:checked').val();
		    				runAJAX(sortset,category,listtype);

		    			});

		    			$('#category').change(function(e)
		    			{
		    				sortset = $('#sortedby').val();
		    				category = $('#category').val();
		    				listtype = $('input[name=viewtype]:checked').val();
		    				runAJAX(sortset,category,listtype);
		    			});

		    			function runAJAX(listsortset,listcategory,listtype)
		    			{		    		

		    				var base_url = '<?=base_url()?>';
						     $.ajax({
					            url: base_url + 'index.php/site/ajax',
					            type:'POST',
					            data: {type: listtype, category: listcategory, sortset: listsortset}
					        }).done(function(msg){
					                    $('main').html(msg);
					                    $('main').removeClass('bgWrapper');
					                    $('main').removeClass('mainWrapper');
					                }); // End of ajax call 
		    			}
		    		})
		    	</script>
			    <input id="viewtype1" name="viewtype" value="skills" type="radio" checked="checked">Offering</input>
			    <input id="viewtype2" name="viewtype" value="wants" type="radio">Wanting</input>
		    </form>
       
       </div>
    </section>  
    </div><!-- /end dropdown bgWrapper -->