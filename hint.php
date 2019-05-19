<?php

$connect = mysqli_connect("localhost:3306", "root", "");
if (!$connect)
{
    die ('Could not connect: '.mysqli_connect_error());
}

mysqli_select_db($connect, "academicrecord");

$keywords=$_GET['term'];
$myrs=mysqli_query($connect, "
SELECT 
    DISTINCT authors.AUTHORNAME, COUNT(paaffiliation.AUTHORID)
FROM
    academicrecord.paaffiliation
JOIN
    academicrecord.authors ON authors.AUTHORID = paaffiliation.AUTHORID
WHERE AUTHORNAME LIKE'%".$keywords."%' 
GROUP BY paaffiliation.AUTHORID
ORDER BY COUNT(paaffiliation.AUTHORID) DESC
LIMIT 3");
 if($myrs)
{
    while($row=mysqli_fetch_array($myrs))
    {
        $authorName = $row["AUTHORNAME"];

        // convert all the first letter of the author name to upper case
        $authorName = ucwords($authorName);

        $result[] = array(
        'id' => $row["COUNT(paaffiliation.AUTHORID)"].' papers',
        'label' => $authorName,
        'category' => 'Author'
        );
    }
}

$myrs=mysqli_query($connect, "
SELECT 
    DISTINCT papers.TITLE, COUNT(paperreference.REFERENCEID)
FROM
    academicrecord.papers
JOIN
    academicrecord.paperreference ON papers.PAPERID = paperreference.REFERENCEID
WHERE
    TITLE LIKE '%".$keywords."%' 
GROUP BY paperreference.REFERENCEID
ORDER BY COUNT(paperreference.REFERENCEID) DESC
LIMIT 3");

if($myrs)
{
    while($row=mysqli_fetch_array($myrs))
    {
        $title = $row["TITLE"];

        // convert all the first letter of the author name to upper case
        $title[0] = strtoupper($title[0]);
        $title = $title;
        $result[] = array(
        'id' => 'cited '.$row["COUNT(paperreference.REFERENCEID)"].' times',
        'label' => $title,
        'category' => 'Paper'
        );
    }
}

echo json_encode($result);

?>