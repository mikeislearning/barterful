<div class="bgWrapper">
        <section class="mainWrapper">
        	<div class="row">
            <main>

<h1>showing rows in order...</h1>
<table rules="all" cellpadding="5">
<thead>
	<tr>
    	<th>Sort Value</th>
        <th>Name</th>
        <th>Last Updated</th>
        <th>Skill</th>
        <th>Skill Description</th>
        <th>Average Rating</th>
    </tr>
<?php

	foreach ($row as $r)
		{
			echo '<tr><th>' . $r->sort . '</th><td>' . $r->p_fname . '</td><td>' . $r->p_last_updated . '</td><td>' . $r->s_name . '</td><td>' . $r->sp_heading . '</td><td>' . $r->p_avg_rating * 100 . '%</td></tr>' ;
		}

?>
</table>

	</main>