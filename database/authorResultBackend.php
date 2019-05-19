<html>

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>Responsive Side Menu &ndash; Layout Examples &ndash; Pure</title>
    
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">
    
    
    
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
        <![endif]-->
        <!--[if gt IE 8]><!-->
            <link rel="stylesheet" href="css/layouts/side-menu.css">
        <!--<![endif]-->
</head>

<?php 

$name = $_GET["scholarName"]; 
$pageIndex = $_GET["pageIndex"];
$startPoint = ($pageIndex-1)* 10;

$connect = mysqli_connect("localhost:3306", "root", "");
if (!$connect)
{
	die ('Could not connect: '.mysqli_connect_error());
}

mysqli_select_db($connect, "academicrecord");

$result = mysqli_query($connect, "SELECT AUTHORID FROM authors WHERE AUTHORNAME LIKE'%".$name."%'");
?>

<body>

<?php
if ($result)
{
	$authorIds = array();
	while ($row = mysqli_fetch_assoc($result))
	{
		array_push($authorIds, "'".$row["AUTHORID"]."'");
	}
	$total = count($authorIds);
	$authorIds = join(",", $authorIds);
	$result = mysqli_query($connect, "SELECT 
                                          paaffiliation.AUTHORID, authors.AUTHORNAME, COUNT(paaffiliation.AUTHORID)
                                      FROM
                                          academicrecord.paaffiliation
								      JOIN
                                          academicrecord.authors ON authors.AUTHORID = paaffiliation.AUTHORID
                                      WHERE
                                          paaffiliation.AUTHORID IN ($authorIds)
                                      GROUP BY paaffiliation.AUTHORID
                                      ORDER BY COUNT(paaffiliation.AUTHORID) DESC LIMIT ".$startPoint.", 10
                                      ");

	while ($row = mysqli_fetch_assoc($result))
	{
		$authorId = $row["AUTHORID"];
		$authorName = $row["AUTHORNAME"];

		// convert all the first letter of the author name to upper case
		$authorName = ucwords($authorName);

		$countPaper = $row["COUNT(paaffiliation.AUTHORID)"];
		$affiliationName = mysqli_query($connect, "SELECT 
                                                    AFFILIATIONNAME
                                                FROM
                                                    academicrecord.affiliations
                                                JOIN
                                                    academicrecord.paaffiliation ON paaffiliation.AFFILIATIONID = affiliations.AFFILIATIONID
                                                WHERE
                                                    paaffiliation.authorid = '".$authorId."'
                                                GROUP BY paaffiliation.AFFILIATIONID
                                                ORDER BY COUNT(paaffiliation.AFFILIATIONID) DESC
                                                ");
	    $affiliationName = mysqli_fetch_row($affiliationName)[0];
		echo "<div class='content'>
			<h2 class='content-subhead'>".$authorName."</h2>
			<p>
				ID:".$authorId."<br>
				Number of paper published: ".$countPaper."<br>
				Affiliation: ".$affiliationName."<br>
				<a href='author.php?authorId=".$authorId."&authorName=".$authorName."' target=_blank style='color:#1f8dd6'>Learn more</a> about him.
			</p>
			</div>";
	}
}
else
	echo "Author Not found";

mysqli_close($connect);
/*
if ($cnt != 0)
	echo "<a href='result.php?scholarName=".$name."&cnt=".($cnt-10)."' style='text-align:middle; font-size:18px'><button id='button1'>previous</button></a>";	

echo "  ";

echo "<a href='result.php?scholarName=".$name."&cnt=".($cnt+10)."' style='color:#AAFF88; font-size:18px'><button id='button2'>next</button></a>";
*/
?>

<div class="navigation" align="center">
	<?php if ($startPoint >= 10) echo "<button class='previous' onclick='previous()'>Previous</button>";
	if(($total-$startPoint)>10) echo "<button class='next' onclick='next()'>Next</button>";
	?>
</div><br / >
<center><select id="select">
	<?php for($i=1;$i<=($total / 10);$i++){
	if ($i == $pageIndex)
		echo "<option value=".$i." selected>Page ".$i."</option>";
	else
  		echo "<option value=".$i.">Page ".$i."</option>";}?>
</select>
<input id="page" type="button" value="Turn to" onclick="page()"/></center>

</body>
</html>