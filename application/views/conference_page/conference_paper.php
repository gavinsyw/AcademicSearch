<table>
		<?php foreach ($items as $item): ?>
		<tr>
		<?php
			echo "<div class='posts'>
					<h1 class='content-subhead'>Published Paper</h1>
						<section class='post'>
							<header class='post-header'>";

			echo "<h2 class='post-title' style='font-size:27px'>".$item['TITLE']."</h2>";

			echo "<p class='post-meta'>By ";

			echo "<a href=\"";
            echo site_url("page/show_author_page?authorId=".$item['AUTHORIDS'][0]."&authorName=".$item['AUTHORNAMES'][0])."\">".$item['AUTHORNAMES'][0]."</a>";

			for ($j = 1; $j < count($item['AUTHORNAMES']); $j++)
				echo ",<a href=\"";
            	echo site_url("page/show_author_page?authorId=".$item['AUTHORIDS'][$j]."&authorName=".$item['AUTHORNAMES'][$j])."\">".$item['AUTHORNAMES'][$j]."</a>";

			echo ".</p></header>";

			echo "<div class='post-description'> <p>";

			echo "ID: ".$item['PAPERID'].".<br / >Referenced by ".$item['REFERENCENUM']." times.<br / >Published on ".$item['CONFERENCENAME'].".<br / >";

			echo "<a href=\"";
                echo site_url("page/show_more_paper?paperId=".$item['PAPERID']."&Title=".$item['TITLE'])
                ."\" style='color:#1f8dd6'>Learn more</a> about the paper.";

			echo "</p></div></section></div>";
		?>
    	</tr>
		<?php endforeach; ?>
</table>
	