<!-- ************************ Drop down list ************************** -->
        <div class="bgWrapper">
        <section class="mainWrapper">
        <div class="row" id="dropdown">
          <form>
		       <fieldset>
		             <label>Barterspot</label><!-- this should be populated with php -->
		             <select id = "barterspot">
		               <option value = "1">Humber</option>
		               <option value = "2">U of T</option>
		               <option value = "3">Queens</option>
		               <option value = "4">York</option>
		             </select>
		       </fieldset>
		    </form>
		    <form>
		       <fieldset>
		             <label>Categories</label><!-- this should be populated with php -->
		             <select id = "categories">
		               <option value = "1">Design</option>
		               <option value = "2">Web Development</option>
		               <option value = "3">Clothing</option>
		               <option value = "4">Food</option>
		             </select>		          
		       </fieldset>
		    </form>
		      <form>
		       <fieldset>
		             <label>Sorted by</label><!-- this should be populated with php -->
		             <select id = "sortedby">
		               <option value = "1">All</option>
		               <option value = "2">Top Rated</option>
		               <option value = "3">Popularity</option>
		               <option value = "4">Most Recent</option>
		             </select>
		       </fieldset>
		    </form>
		    <form>
			    <input id="offering" type="radio" checked="checked">Offering</input>
			    <input id="wanting" type="radio">Wanting</input>
		    </form>
       
       </div>
    </section>  
    </div><!-- /end dropdown bgWrapper -->