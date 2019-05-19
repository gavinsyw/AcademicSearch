<table>
		<?php foreach ($conferences as $c): ?>
		<tr>
    		<?php echo "<div class='content'>
            <h2 class='content-subhead'>".$c['conferenceName']."</h2>
            <p>
                conferenceID: ".$c['conferenceID']."<br>
                Number of papers (total) : ".$c['COUNT(papers.paperID)']."<br>
                Brief introduction:".$c['briefIntro'] ."<br>
                <a href=\"";
                echo site_url("page/show_more_conference?conferenceID=".$c['conferenceID']."&conferenceName=".$c['conferenceName'])."\" target=_blank style='color:#1f8dd6'>Learn more</a> about him.
            </p>
            </div>";?>
    	</tr>
		<?php endforeach; ?>
</table>
	