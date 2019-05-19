<?php foreach ($items as $i): ?>
<?php 
	echo "<div class='posts'>
			<h1 class='content-subhead'>Published Paper</h1>
				<section class='post'>
					<header class='post-header'>";

	echo "<h2 class='post-title' style='font-size:27px'>".$i['TITLE']."</h2>";

	echo "<p class='post-meta'>By ";

	echo "<a href=\""; 
	echo site_url("page/show_author_page?authorId=".$i['AUTHORID'][0]."&authorName=".urlencode($i['AUTHORNAME'][0]))."\">".$i['AUTHORNAME'][0]."</a>";
	//echo count($i['AUTHORNAME']);
	for ($j = 1; $j < count($i['AUTHORNAME']); $j++){
		echo ",<a href=\""; 
		echo site_url("page/show_author_page?authorId=".$i['AUTHORID'][$j]."&authorName=".urlencode($i['AUTHORNAME'][$j]))."\">".$i['AUTHORNAME'][$j]."</a>";}
	echo ".</p></header>";

	echo "<div class='post-description'> <p>";

	echo "ID: ".$i['PAPERID'].".<br / >Referenced by ".$i['REFERENCENUM']." times.<br / >Published on ".$i['CONFERENCENAME'].".<br / >";

	echo "<a href='/webpage/paper.php?paperId=".$i['PAPERID']."&Title=".$i['TITLE']."'>Learn more</a> about the paper.";

	echo "</p></div></section></div>";
?>
<?php endforeach; ?>