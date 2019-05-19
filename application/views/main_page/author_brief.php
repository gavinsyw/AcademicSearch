<table>
		<?php foreach ($authors as $a): ?>
		<tr>
    		<?php echo "<div class='content'>
			<h2 class='content-subhead'>".$a['AUTHORNAME']."</h2>
			<p>
				ID:".$a['AUTHORID']."<br>
				Number of paper published: ".$a['COUNT(paaffiliation.AUTHORID)']."<br>
				Affiliation: ".$a['AFFILIATIONNAME']."<br>
				<a href=\"";
				echo site_url("page/show_more_author?authorId=".$a['AUTHORID']."&authorName=".urlencode($a['AUTHORNAME']))
					."\" target=_blank style='color:#1f8dd6'>Learn more</a> about him.
			</p>
			</div>";?>
    	</tr>
		<?php endforeach; ?>
</table>
	