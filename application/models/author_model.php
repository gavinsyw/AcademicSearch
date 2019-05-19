<?php
class author_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }



    public function count_authors($name){
      
      $query = $this->db->query("SELECT AUTHORID FROM authors WHERE AUTHORNAME LIKE'%".$name."%'");
      return $query->num_rows();
    }


    public function get_authors($name,$page=0){
        $startPoint = $page* 10;
        $query = $this->db->query("SELECT AUTHORID FROM authors WHERE AUTHORNAME LIKE'%".$name."%'");
        if ($query->num_rows()!=0)
        {
            $authorIds = array();
            foreach ($query->result_array() as $row)
            {
                array_push($authorIds, "'".$row["AUTHORID"]."'");
            }
            $total = count($authorIds);
            $authorIds = join(",", $authorIds);
            $query = $this->db->query("SELECT 
                                          paaffiliation.AUTHORID, authors.AUTHORNAME, COUNT(paaffiliation.AUTHORID)
                                      FROM
                                          academicrecord.paaffiliation
                                      JOIN
                                          academicrecord.authors ON authors.AUTHORID = paaffiliation.AUTHORID
                                      WHERE
                                          paaffiliation.AUTHORID IN ($authorIds)
                                      GROUP BY paaffiliation.AUTHORID
                                      ORDER BY COUNT(paaffiliation.AUTHORID) DESC LIMIT $startPoint, 10
                                      ");
            $result=$query->result_array();
            foreach ($result as &$row)
            {
              $authorId = $row["AUTHORID"];
              $query2 = $this->db->query("SELECT 
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
              $affiliationName = $query2->row_array()['AFFILIATIONNAME'];
              $row['AFFILIATIONNAME']=$affiliationName;
            }
            return $result;
        }
        else
        {
          $result=array();
          return $result;
        }
    }


    public function get_affiliation($authorId){
        $query = $this->db->query("SELECT 
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
        $affiliationName = $query->row_array()['AFFILIATIONNAME'];
        return $affiliationName;
    }


    public function count_author_paper($authorId){
        $query = $this->db->query("SELECT PAPERID FROM academicrecord.paaffiliation WHERE
                                          AUTHORID = '".$authorId."'");
        return $query->num_rows();
    }


    public function get_author_paper($authorId,$authorName,$page=0){
        $startPoint = $page* 10;
        $paperidResult = $this->db->query("SELECT PAPERID FROM academicrecord.paaffiliation WHERE
                                          AUTHORID = '".$authorId."'");

        $paperids = array();
        $referenceNums = array();
        foreach ($paperidResult->result_array() as $row)
        {
          $paperid = $row["PAPERID"];
          array_push($paperids, $paperid);
          $query3 = $this->db->query("SELECT COUNT(REFERENCEID) FROM academicrecord.paperreference
                                            WHERE REFERENCEID = '".$paperid."'");
          $referenceNum = $query3->row_array()['COUNT(REFERENCEID)'];
          array_push($referenceNums, $referenceNum);
        }
        //$total = count($paperids);

        //排序
        for ($i=0; $i<count($paperids); $i++)
          for ($j=0; $j < count($paperids)-1; $j++)
            if ($referenceNums[$j] < $referenceNums[$j+1])
            {
              $temp = $referenceNums[$j];
              $referenceNums[$j] = $referenceNums[$j+1];
              $referenceNums[$j+1] = $temp;
              $temp = $paperids[$j];
              $paperids[$j] = $paperids[$j+1];
              $paperids[$j+1] = $temp;
            }

        $result=array();
        for ($i = $startPoint; $i<$startPoint + min(10, count($paperids)); $i++)
        {
            $item=array();
            $query2 = $this->db->query("SELECT 
                                        CONFERENCENAME, TITLE, authors.AUTHORNAME, authors.AUTHORID, papers.PAPERID
                                      FROM
                                          academicrecord.papers
                                      JOIN
                                          academicrecord.paaffiliation ON papers.PAPERID = paaffiliation.PAPERID
                                      JOIN
                                          academicrecord.authors ON paaffiliation.AUTHORID = authors.AUTHORID
                                      JOIN
                                          academicrecord.conferences ON papers.CONFERENCEID = conferences.CONFERENCEID
                                      WHERE
                                          paaffiliation.PAPERID = '".$paperids[$i]."'
                                          ORDER BY AUTHORSEQUENCE");
          $item['CONFERENCENAME']=$query2->row_array()['CONFERENCENAME'];
          $item['TITLE']=$query2->row_array()['TITLE'];
          $item['TITLE'][0] = strtoupper($item['TITLE'][0]);
          $item['PAPERID']=$paperids[$i];
          $item['REFERENCENUM']=$referenceNums[$i];

          $AuthorNames = array();
          $AuthorIDs = array();

          foreach ($query2->result_array() as $row)
          {
            array_push($AuthorNames, ucwords($row["AUTHORNAME"]));
            array_push($AuthorIDs, $row["AUTHORID"]);
          }

          $item['AUTHORID']=$AuthorIDs;
          $item['AUTHORNAME']=$AuthorNames;
            
          array_push($result,$item);
        }
        return $result;
    }


    public function get_author_student($teacher,$teacherName){
        $total = 0;
                    $sql1 = "SELECT DISTINCT bID, AUTHORNAME FROM
                    academicrecord.if_teacher JOIN academicrecord.authors
                    ON if_teacher.bID = authors.AUTHORID WHERE
                    aID = '".$teacher."'";
                    $result1 = $this->db->query($sql1);
                    $middle_id = array();
                    $middle_name = array();
                    foreach ($result1->result_array() as $row1)
                    {
                        array_push($middle_id, $row1["bID"]);
                        array_push($middle_name, ucwords($row1["AUTHORNAME"]));
                    }
                    /*$sql2 = "SELECT  DISTINCT table1.bID, if_teacher.bID 
                    FROM academicrecord.if_teacher 
                    JOIN 
                    (SELECT if_teacher.bID 
                    FROM academicrecord.if_teacher 
                    WHERE aID = '$teacher') AS table1
                    ON table1.bID = if_teacher.aID";
                    $result2 = mysql_query($connect, $sql2);
                    $row2 = mysql_fetch_array($result2);
                    */
                    $filename = "resources/tmp.json";
                    $content = "[{
                        \"name\":\"".$teacherName."\",
                        \"parent\":\"null\",
                        \"value\":15,
                        \"type\":\"black\",
                        \"level\":\"steelblue\",
                        \"children\":[";
                    $handle = fopen($filename, "w");
                    $str = fwrite($handle, $content);
                    $len1 = sizeof($middle_id);
                    for($i=0;$i<$len1;$i++)
                    {
                        $sql = "SELECT DISTINCT bID, AUTHORNAME FROM academicrecord.if_teacher
                                JOIN academicrecord.authors ON if_teacher.bID = authors.AUTHORID
                                WHERE aID = '".$middle_id[$i]."'";
                        $result = $this->db->query($sql);
                        $bottom_id = array();
                        $bottom_name = array();
                        foreach ($result->result_array() as $row)
                        {
                            array_push($bottom_id, $row["bID"]);
                            array_push($bottom_name, ucwords($row["AUTHORNAME"]));   
                        }
                        $len2 = sizeof($bottom_id);
                        if($len2 != 0)
                        {
                            if($i!=$len1-1)
                            {
                                $content = "
                                    {
                                        \"name\":\"".$middle_name[$i]."\",
                                        \"parent\":\"".$teacher."\",
                                        \"value\":12,
                                        \"type\":\"grey\",
                                        \"level\":\"red\",
                                        \"children\":[";
                                $str = fwrite($handle, $content);
                                for($j=0;$j<$len2;$j++)
                                {
                                    if($j!=$len2-1)
                                    {
                                        $content = "
                                                {
                                                    \"name\":\"".$bottom_name[$j]."\",
                                                    \"parent\":\"".$middle_name[$i]."\",
                                                    \"value\":6,
                                                    \"type\":\"steelblue\",
                                                    \"level\":\"orange\"
                                                },";
                                        $str = fwrite($handle, $content);
                                        $total += 1;
                                    }
                                    if($j==$len2-1)
                                    {
                                        $content = "
                                                {
                                                    \"name\":\"".$bottom_name[$j]."\",
                                                    \"parent\":\"".$middle_name[$i]."\",
                                                    \"value\":6,
                                                    \"type\":\"steelblue\",
                                                    \"level\":\"orange\"
                                                }
                                              ]";
                                        $str = fwrite($handle, $content);
                                        $total += 1;
                                    }
                                }
                                $content = "},";
                                $str = fwrite($handle, $content);
                            }
                            if($i==$len1-1)
                            {
                                $content = "
                                    {
                                        \"name\":\"".$middle_name[$i]."\",
                                        \"parent\":\"".$teacher."\",
                                        \"value\":12,
                                        \"type\":\"grey\",
                                        \"level\":\"red\",
                                        \"children\":[";
                                $str = fwrite($handle, $content);
                                for($j=0;$j<$len2;$j++)
                                {
                                    if($j!=$len2-1)
                                    {
                                        $content = "
                                                {
                                                    \"name\":\"".$bottom_name[$j]."\",
                                                    \"parent\":\"".$middle_id[$i]."\",
                                                    \"value\":6,
                                                    \"type\":\"steelblue\",
                                                    \"level\":\"orange\"
                                                },";
                                        $str = fwrite($handle, $content);
                                    }
                                    if($j==$len2-1)
                                    {
                                        $content = "
                                                {
                                                    \"name\":\"".$bottom_name[$j]."\",
                                                    \"parent\":\"".$middle_id[$i]."\",
                                                    \"value\":6,
                                                    \"type\":\"steelblue\",
                                                    \"level\":\"orange\"
                                                }
                                              ]";
                                        $str = fwrite($handle, $content);
                                    }
                                    $total += 1;
                                }
                                $content = "
                                }
                              ]";
                                $str = fwrite($handle, $content);
                            }
                        }
                        if($len2 == 0)
                        {
                            if($i!=$len1-1)
                            {
                                $content = "
                                    {
                                        \"name\":\"".$middle_name[$i]."\",
                                        \"parent\":\"".$teacher."\",
                                        \"value\":9,
                                        \"type\":\"grey\",
                                        \"level\":\"green\"
                                    },";
                                $str = fwrite($handle, $content);
                            }
                            if($i==$len1-1)
                            {
                                $content = "
                                    {
                                        \"name\":\"".$middle_name[$i]."\",
                                        \"parent\":\"".$teacher."\",
                                        \"value\":9,
                                        \"type\":\"grey\",
                                        \"level\":\"green\"
                                    }
                                  ]";
                                $str = fwrite($handle, $content);
                            }
                        }
                    } 
                    $content = "
                    }]";
                    $str = fwrite($handle, $content);
                    fclose($handle);
                    session_start();
                    $_SESSION["total"] = $total;
    }


    public function get_author_cooperator($s_n){
      $sql = "SELECT AuthorName FROM authors WHERE AuthorID='".$s_n."';";
      echo $s_n;
      $result = $this->db->query($sql);
      $row=$result->row_array();
      $array = array();
      $arrayid=array();
      $label1=array();
      $label2=array();

      $sql1="SELECT Author2,Name2,Label1,Label2 FROM co_relation WHERE Author1='".$s_n."';";
      $result1 = $this->db->query($sql1);
      foreach ($result1->result_array() as $row1)
      {
        array_push($arrayid,$row1["Author2"]);
        array_push($array,$row1["Name2"]);
        array_push($label1,$row1["Label1"]);
        array_push($label2,$row1["Label2"]);
      }

      $sql2="SELECT AuthorName FROM authors WHERE AuthorID='" . $s_n . "';";
      $result2 = $this->db->query($sql2);
      $row2=$result2->row_array();

      $len=sizeof($arrayid);

      $filename = "resources/tmp1.json";
      $handle=fopen($filename,"w");
      $content="{
        \"nodes\":[";
      $str=fwrite($handle,$content);
      fclose($handle);

      $handle=fopen($filename,"a+");
      for($i=0;$i<$len;$i++)
      {
        if((int)$label1[$i]==1 and (int)$label2[$i]==0)
        {
          $content="    {\"id\":\"".$array[$i]." ".$arrayid[$i]."\",\"group\":2},";
          $str=fwrite($handle,$content);
        }

        if((int)$label1[$i]==0 and (int)$label2[$i]==1)
        {
          $content="    {\"id\":\"".$array[$i]." ".$arrayid[$i]."\",\"group\":3},";
          $str=fwrite($handle,$content);
        }

        if(((int)$label1[$i]==0 and (int)$label2[$i]==0) or (int)$label1[$i]==1 and (int)$label2[$i]==1)
        {
          $content="    {\"id\":\"".$array[$i]." ".$arrayid[$i]."\",\"group\":4},";
          $str=fwrite($handle,$content);
        }
      }

      $content="    {\"id\":\"".$row2["Author2"]." ".$s_n."\",\"group\":1}";
      $str=fwrite($handle,$content);
      $content="  ],
        \"links\":[
        ";
      $str=fwrite($handle,$content);
      for($i=0;$i<$len;$i++)
      {
        $content="    {\"source\":\"".$row["Author2"]." ".$s_n."\",\"target\":\"".$array[$i]." ".$arrayid[$i]."\",\"value\":1},";
        $str=fwrite($handle,$content);
      }


      for($i=0;$i<$len;$i++)
      {
        $sql3 = "SELECT Author2,Name2 FROM co_relation WHERE Author1='" . $arrayid[$i] . "';";
        $result3 = $this->db->query($sql3);
        foreach ($result3->result_array() as $row3)
        {
          if(in_array($row3["Author2"],$arrayid))
          {
            $content="    {\"source\":\"".$array[0]." ".$arrayid[0]."\",\"target\":\"".$row3["Name2"]." ".$row3["Author2"]."\",\"value\":1}";
            $str=fwrite($handle,$content);
            break;
          }
        }
        if($row3)
        {
          if(in_array($row3["Author2"],$arrayid))
            {break;}
        }
      }

      for($i=0;$i<$len;$i++)
      {
        $sql3 = "SELECT Author2,Name2 FROM co_relation WHERE Author1='" . $arrayid[$i] . "';";
        $result3 = $this->db->query($sql3);
        foreach ($result3->result_array() as $row3)
        {
          if(in_array($row3["Author2"],$arrayid))
          {
            $content=",
                {\"source\":\"".$array[$i]." ".$arrayid[$i]."\",\"target\":\"".$row3["Name2"]." ".$row3["Author2"]."\",\"value\":1}";
            $str=fwrite($handle,$content);
          }

        }
        unset($arrayid[$i]);
      }

      $content="
        ]
        }";
      $str=fwrite($handle,$content);

      fclose($handle);
    }
}