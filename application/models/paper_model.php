<?php
class paper_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }


    public function count_papers($name){
        $query = $this->db->query("SELECT paperID FROM papers WHERE title LIKE'%".$name."%'");
        return $query->num_rows();
    }


    public function get_papers($name,$page=0){
        $startPoint = $page* 10;
        $query = $this->db->query("SELECT paperID FROM papers WHERE title LIKE'%".$name."%'");
        if ($query->num_rows()!=0)
        {
          $paperIds = array();
          foreach ($query->result_array() as $row)
          {
            array_push($paperIds, "'".$row["paperID"]."'");
          }
          $total = count($paperIds);
          $paperIds = join(",", $paperIds);
          $result = $this->db->query("SELECT 
                                          papers.paperID,papers.conferenceID,papers.publishyear,papers.title, COUNT(paperreference.referenceID)
                                      FROM
                                          academicrecord.papers
                                      LEFT JOIN
                                          academicrecord.paperreference ON papers.paperID = paperreference.referenceID
                                      WHERE
                                          papers.paperID IN ($paperIds)
                                      GROUP BY papers.paperID
                                      ORDER BY COUNT(paperreference.referenceID) DESC LIMIT ".$startPoint.", 10
                                      ");

          return $result->result_array();
        }
        else
        {
          $result=array();
          return $result;
        }
    }


    public function get_more_detail($paperid){
        $query = $this->db->query( "
                SELECT 
                    CONFERENCENAME, TITLE, authors.AUTHORNAME, authors.AUTHORID, papers.PAPERID, papers.PUBLISHYEAR
                FROM
                    academicrecord.papers
                JOIN
                    academicrecord.paaffiliation ON papers.PAPERID = paaffiliation.PAPERID
                JOIN
                    academicrecord.authors ON paaffiliation.AUTHORID = authors.AUTHORID
                JOIN
                    academicrecord.conferences ON papers.CONFERENCEID = conferences.CONFERENCEID
                WHERE
                    paaffiliation.PAPERID = '".$paperid."'
                ORDER BY AUTHORSEQUENCE");
            $AuthorNames = array();
            $AuthorIDs = array();
            $result=$query->row_array();
            foreach ($query->result_array() as $row)
            {
                //$row["TITLE"] = strtoupper($row["TITLE"]);
                //$PublishYear = $row["PUBLISHYEAR"];
                array_push($AuthorNames, ucwords($row["AUTHORNAME"]));
                array_push($AuthorIDs, $row["AUTHORID"]);
            }
            $result['AUTHORNAMES']=$AuthorNames;
            $result['AUTHORIDS']=$AuthorIDs;
            return $result;
    }


    public function get_paper_recommended($paperid){
          $query = $this->db->query("
                    SELECT 
                            recommendID, title, publishyear, conferenceID
                    FROM
                            paper_recommendation
                    JOIN
                            papers ON recommendID = papers.paperid
                    WHERE
                            paper_recommendation.paperID ='".$paperid."'");
          return $query->result_array();
    }
}