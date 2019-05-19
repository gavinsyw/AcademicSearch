<body>
<div class="pure-menu pure-menu-horizontal">
    <a href="#" class="pure-menu-heading">Search Scholar<br / >Published Paper</a>
    <ul class="pure-menu-list">
        <li class="pure-menu-item"><a href="<?php echo site_url('page/create');?>" class="pure-menu-link">Home</a></li>
        <li class="pure-menu-item pure-menu-selected"><a href="#" class="pure-menu-link">Paper</a></li>
    </ul>
</div>       
            <?php
            echo "<div class='posts' style='margin-left:115px'>
                        <section class='post'>
                            <header class='post-header'>";

            echo "<h2 class='post-title' style='font-size:28px'>".$Title."</h2>";

            echo "<p class='post-meta' style='font-size:20px'>By ";

            echo "<a href=\"";
            echo site_url("page/show_author_page?authorId=".$thispaper['AUTHORIDS'][0]."&authorName=".$thispaper['AUTHORNAMES'][0])."\">".$thispaper['AUTHORNAMES'][0]."</a>";

            for ($j = 1; $j < count($thispaper['AUTHORNAMES']); $j++)
                echo ",<a href=\"";
                echo site_url("page/show_author_page?authorId=".$thispaper['AUTHORIDS'][0]."&authorName=".$thispaper['AUTHORNAMES'][0])."\">".$thispaper['AUTHORNAMES'][0]."</a>";

            echo ".</p></header><div class='post-description' style='font-size:20px'><p>Published on ".$thispaper['CONFERENCENAME'].", ".$thispaper['PUBLISHYEAR'].".</p></div>";

            echo "<div class='post-description'> <p>";

            echo "</p></div></section><h1 class='content-subhead' style='font-size:18px'>You may also like</h1></div>"; ?>
    </h1>
</div>

<div class="1-content" style="margin-left:60px;">
<div class="information pure-g">
<?php
foreach  ($recommended as $row)
{
    $recommendid = $row["recommendID"];
    $title = $row["title"];
    $title[0] = strtoupper($title[0]);
    $recommendPublishYear = $row["publishyear"];
    $recommendConferenceID = $row["conferenceID"];
    echo "<div class='pure-u-1 pure-u-md-1-1'><div class='1-box'>";
    echo "<h3 class='information-head'>".$title."</h3>";
    echo "<p>ID: ".$recommendid.".<br / >Published at ".$recommendPublishYear.".<br / >conferenceID: ".$recommendConferenceID.".<br / >";
    echo "<a href=\"";
                echo site_url("page/show_more_paper?paperId=".$row['recommendID']."&Title=".$row['title'])
                ."\" style='color:#1f8dd6'>Learn more</a> about this paper.</p></div></div>";
}
?>
</div>
</div>
