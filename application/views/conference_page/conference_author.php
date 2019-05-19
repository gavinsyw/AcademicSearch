<table>
		<?php foreach ($items as $item): ?>
		<tr>
    		<?php echo "<div class='posts'>
		        <h1 class='content-subhead'>Active Author</h1>
		            <section class='post'>
		                <header class='post-header'>";

		    echo "<h2 class='post-title' style='font-size:27px'>".$item['AUTHORNAMES']."</h2>";

		    echo "<p class='post-meta'>With ".$item['AUTHORPAPERS']." papers in this conference.</p></header>";

		    echo "<div class='post-description'> <p>";

		    echo "ID: ".$item['AUTHORIDS'].".<br / >Working at: ".$item['AFFILIATIONNAME'].".<br / >";

		    echo "<a href=\"";
            echo site_url("page/show_author_page?authorId=".$item['AUTHORIDS']."&authorName=".$item['AUTHORNAMES'])."\">Learn more</a> about him.";

		    echo "</p></div></section></div>";?>
    	</tr>
		<?php endforeach; ?>
</table>
	