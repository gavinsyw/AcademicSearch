<?php
class conference_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }


    public function count_conferences($name){
        $query = $this->db->query("SELECT conferenceID FROM conferences");
        return $query->num_rows();
    }


    public function get_conferences($name,$page=0){
        $startPoint = $page* 10;
        $query = $this->db->query("SELECT conferenceID FROM conferences");
        if ($query->num_rows()!=0)
        {
          $conferenceIds = array();
          foreach ($query->result_array() as $row)
          {
            array_push($conferenceIds, "'".$row["conferenceID"]."'");
          }
          $conferenceIds = join(",", $conferenceIds);
          $result = $this->db->query("SELECT 
                                          conferences.conferenceID,conferences.conferenceName,conferences.briefIntro, COUNT(papers.paperID)
                                      FROM
                                          academicrecord.conferences
                                      LEFT JOIN
                                          academicrecord.papers ON papers.conferenceID = conferences.conferenceID
                                      WHERE
                                          conferences.conferenceID IN ($conferenceIds)
                                      GROUP BY conferences.conferenceID
                                      ORDER BY COUNT(papers.paperID) DESC LIMIT ".$startPoint.", 10
                                      ");
          return $result->result_array();
        }
        else
        {
          $result=array();
          return $result;
        }
    }


    public function get_num_of_papers($conferenceID){
          $query = $this->db->query("
                            SELECT 
                                  COUNT(*)
                            FROM
                                  papers
                            WHERE
                                  CONFERENCEID = '".$conferenceID."'");

          return $query->row_array()['COUNT(*)'];
    }


    public function get_graph_information($conferenceID){ 
          $query=$this->db->query("SELECT count(paperID),publishyear 
              from papers inner join conferences 
              using(conferenceID) where papers.conferenceID='".$conferenceID."'
              group by papers.publishyear 
              order by papers.publishyear;");
          /*$query2=$this->db->query("select conferenceName from conferences where conferenceID='".$conferenceID."      ';")
          $name=$query2->row_array()["conferenceName"];
          echo $name;*/
          $data = array();
          foreach ($query->result_array() as $row3){
            $publishyear = $row3["publishyear"];
            array_push($data, [$publishyear,$row3["count(paperID)"]]);
          }
          return $data;
    }


    public function count_conference_paper($conferenceID){
          $query=$this->db->query("
            SELECT 
              papers.paperID, COUNT(referenceID) AS num
            FROM papers LEFT JOIN paperreference 
            ON papers.paperID = paperreference.referenceID
            WHERE conferenceID = '".$conferenceID."'
            GROUP BY papers.paperID
            ORDER BY COUNT(referenceID) DESC
            ");
          return $query->num_rows();
    }


    public function get_conference_paper($conferenceID,$page=0){
        $startPoint = $page* 10;
        $paperids = array();
        $referenceNums = array();

        $query=$this->db->query("
            SELECT 
              papers.paperID, COUNT(referenceID) AS num
            FROM papers LEFT JOIN paperreference 
            ON papers.paperID = paperreference.referenceID
            WHERE conferenceID = '".$conferenceID."'
            GROUP BY papers.paperID
            ORDER BY COUNT(referenceID) DESC
            ");

        foreach ($query->result_array() as $row)
        {
          $paperID = $row['paperID'];
          $paperID['0'] = strtoupper($paperID['0']);
          array_push($paperids, $paperID);
          array_push($referenceNums, $row['num']);
        }

        $total = count($paperids);
        $item=array();
        $result=array();

        for ($i = $startPoint; $i<$startPoint + min(10, count($paperids)); $i++)
        {
          $query2 = $this->db->query( "SELECT 
                CONFERENCENAME, TITLE, authors.AUTHORNAME, authors.AUTHORID, papers.PAPERID
              FROM academicrecord.papers
              JOIN academicrecord.paaffiliation ON papers.PAPERID = paaffiliation.PAPERID
              JOIN academicrecord.authors ON paaffiliation.AUTHORID = authors.AUTHORID
              JOIN academicrecord.conferences ON papers.CONFERENCEID = conferences.CONFERENCEID
              WHERE paaffiliation.PAPERID = '".$paperids[$i]."'ORDER BY AUTHORSEQUENCE");
          $item['REFERENCENUM']=$referenceNums[$i];
          $item['TITLE']=strtoupper($query2->row_array()['TITLE']);
          $item['CONFERENCENAME']=$query2->row_array()['CONFERENCENAME'];
          $item['PAPERID']=$paperids[$i];

          $AuthorNames = array();
          $AuthorIDs = array();
          foreach ($query2->result_array() as $row)
          {
            array_push($AuthorNames, ucwords($row["AUTHORNAME"]));
            array_push($AuthorIDs, $row["AUTHORID"]);
          }
          $item['AUTHORIDS']=$AuthorIDs;
          $item['AUTHORNAMES']=$AuthorNames;
        }

        array_push($result,$item);
    }


    public function get_conference_author($conferenceID,$page=0){
        $startPoint = $page* 10;
        $query=$this->db->query("SELECT 
            paaffiliation.AUTHORID,
            authors.AUTHORNAME,
            COUNT(paaffiliation.AUTHORID) AS num
            FROM paaffiliation JOIN papers 
            ON papers.paperID = paaffiliation.paperid
            JOIN authors ON authors.authorid = paaffiliation.authorid
            WHERE conferenceID = '".$conferenceID."'
            GROUP BY paaffiliation.authorID
            ORDER BY num DESC LIMIT 500");

        $authorids = array();
        $authornames = array();
        $authorPapers = array();
        foreach ($query->result_array() as $row)
        {
          $authorId = $row["AUTHORID"];
          $authorName = $row["AUTHORNAME"];

          // convert all the first letter of the author name to upper case
          $authorName = ucwords($authorName);

          $countPaper = $row["num"];
          array_push($authorids, $authorId);
          array_push($authornames, $authorName);
          array_push($authorPapers, $countPaper);
        }

        $total = count($authorids);
        $item=array();
        $result=array();

        for ($i = $startPoint; $i<$startPoint + min(10, $total); $i++)
        {
            $query2 = $this->db->query("SELECT AFFILIATIONNAME
                                                FROM
                                                    academicrecord.affiliations
                                                JOIN
                                                    academicrecord.paaffiliation ON paaffiliation.AFFILIATIONID = affiliations.AFFILIATIONID
                                                WHERE
                                                    paaffiliation.authorid = '".$authorids[$i]."'
                                                GROUP BY paaffiliation.AFFILIATIONID
                                                ORDER BY COUNT(paaffiliation.AFFILIATIONID) DESC
                                                ");
            $item['AUTHORIDS']=$authorids[$i];
            $item['AUTHORNAMES']=$authornames[$i];
            $item['AUTHORPAPERS']=$authorpapers[$i];
            $item['AFFILIATIONNAME'] = ucwords($query2->row_array()['AFFILIATIONNAME']);

            if (strcmp($item['AFFILIATIONNAME'],"Ibm ") == 0){
                $item['AFFILIATIONNAME'] = "IBM";
            }
        }
        return $result;
    }
}