<table>
		<?php foreach ($papers as $p): ?>
		<tr>
    		<?php echo "<div class='content'>
            <h2 class='content-subhead'>".$p['title']."</h2>
            <p>
                ID:".$p['paperID']."<br>
                Number of reference: ".$p['COUNT(paperreference.referenceID)']."<br>
                conferenceID: ".$p['conferenceID']."<br>
                <a href=\"";
                echo site_url("page/show_more_paper?paperId=".$p['paperID']."&Title=".$p['title'])
                ."\" target=_blank style='color:#1f8dd6'>Learn more</a> about this paper.
            </p>
            </div>";?>
    	</tr>
		<?php endforeach; ?>
</table>
	