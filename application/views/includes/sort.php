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
		             <select id = "categories">
		             	<?php foreach($skills as $r): ?>
			               <option value=<?php echo $r->s_id; ?>><?php echo $r->s_name; ?></option>
		           		<?php endforeach; ?>
		             </select>		          
		       </fieldset>
		    </form>
		      <form>
		       <fieldset>
		             <label>Sorted by</label><!-- this should be populated with php -->
		             <select id = "sortedby">
		               <option value = "sort">Smart Sort</option>
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
		    				//var type = $('input[name=viewtype]:checked').val();

		    				/*$.post('<?php echo base_url().'site/index';?>',
						      	{ type:type }).done(function()
						      	{alert('success!');});*/
		    				
		    				var base_url = '<?=base_url()?>';
						     $.ajax({
					            url: base_url + 'list/index',
					            type:'POST',
					            data: {type: '1'}
					        }).fail(function(){
					                    alert('fail');
					                }); // End of ajax call 
					        
					        //alert($('input[name=viewtype]:checked').val());

		    				/*$.ajax({
								type: "GET",
								url: "mainpage.php",
								data: { type: list },
								error: function(){alert('there was an error');}
								}).done(function() {
								alert(list);
								});*/
		    			});
		    		})
		    	</script>
			    <input id="viewtype1" name="viewtype" value="skills" type="radio" checked="checked">Offering</input>
			    <input id="viewtype2" name="viewtype" value="wants" type="radio">Wanting</input>
		    </form>
       
       </div>
    </section>  
    </div><!-- /end dropdown bgWrapper -->