<?php
class Page extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('author_model');
        $this->load->model('paper_model');
        $this->load->model('conference_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }


    public function create(){
        $this->form_validation->set_rules('keyWord', 'KeyWord', 'required');
        if ($this->form_validation->run() === FALSE){
            $this->load->view('home/home');
        }
        else{
            $keyWord=$this->input->post('keyWord');
            $data['keyWord']=$keyWord;
            $this->load->view('main_page/mainpage',$data);
        }
    }


    public function show_authors(){
            $name = $this->input->post("scholarName");
            $page=$this->input->post("pageIndex"); 
            $data['pageIndex']=$page;
            $page=$page-1;
            $data['total']=$this->author_model->count_authors($name);
            $data['authors'] = $this->author_model->get_authors($name,$page);
            $data['title'] = 'authors';
            $data['name']=$name;
            $data['startPoint']=$page*10;
            
            $this->load->view('main_page/author_brief',$data);
            $this->load->view('main_page/buttons',$data);
    }


    public function show_papers(){
        $name=$this->input->post("paperName");
        $page=$this->input->post('pageIndex');
        $data['pageIndex']=$page;
        $page=$page-1;
        $data['total']=$this->paper_model->count_papers($name);
        $data['papers']=$this->paper_model->get_papers($name,$page);
        $data['name']=$name;
        $data['startPoint']=$page*10;

        $this->load->view('main_page/paper_brief',$data);
        $this->load->view('main_page/buttons',$data);
    }


    public function show_conferences(){
        $name=$this->input->post("conferenceName");
        $page=$this->input->post('pageIndex');
        $data['pageIndex']=$page;
        $page=$page-1;
        $data['total']=$this->conference_model->count_conferences($name);
        $data['conferences']=$this->conference_model->get_conferences($name,$page);
        $data['name']=$name;
        $data['startPoint']=$page*10;

        $this->load->view('main_page/conference_brief',$data);
        $this->load->view('main_page/buttons',$data);
    }


    public function show_donate(){
        $this->load->view('main_page/donate');
    }


    public function show_donate_home(){
        $this->load->view('home/donate');
    }
    

    public function show_index($keyWord){
        $data['keyWord']=$keyWord;
        $this->load->view('main_page/results',$data);
    }


    public function show_more_author(){
        $authorName=$this->input->get('authorName');
        $authorId=$this->input->get('authorId');
        $data['authorId']=$authorId;
        $data['authorName']=$authorName;
        $data['affiliationName']=$this->author_model->get_affiliation($authorId);
        $this->load->view('author_page/header',$data);
        $this->load->view('author_page/sidebar',$data);
        $this->load->view('author_page/author_paper_script',$data);
    }


    public function show_author_paper(){
        $authorName=$this->input->post('authorName');
        $authorId=$this->input->post('authorId');
        $page=$this->input->post('pageIndex');
        $data['pageIndex']=$page;
        $page=$page-1;
        $data['startPoint']=$page*10;
        $data['total']=$this->author_model->count_author_paper($authorId);
        $data['items']=$this->author_model->get_author_paper($authorId,$authorName,$page);
        $data['authorName']=$authorName;
        $data['authorId']=$authorId;
        $data['affiliationName']=$this->author_model->get_affiliation($authorId);

        $this->load->view('author_page/author_paper',$data);
        $this->load->view('main_page/buttons',$data);
    }


    public function show_author_student(){
        $authorName=$this->input->get('authorName');
        $authorId=$this->input->get('authorId');
        $data['authorName']=$authorName;
        $data['authorId']=$authorId;
        $data['affiliationName']=$this->author_model->get_affiliation($authorId);

        $this->load->view('author_page/header',$data);
        $this->load->view('author_page/sidebar',$data);
        $this->load->view('author_page/author_student',$data);
    }


    public function get_author_student_backend(){
        $authorName=$this->input->post('authorName');
        $authorId=$this->input->post('authorId');
        $this->author_model->get_author_student($authorId,$authorName);
    }


    public function show_author_cooperator(){
        $authorName=$this->input->get('authorName');
        $authorId=$this->input->get('authorId');
        $data['authorName']=$authorName;
        $data['authorId']=$authorId;
        $data['affiliationName']=$this->author_model->get_affiliation($authorId);

        $this->load->view('author_page/header',$data);
        $this->load->view('author_page/sidebar',$data);
        $this->load->view('author_page/author_cooperator',$data);
    }


    public function get_author_cooperator_backend(){
        $authorName=$this->input->post('authorName');
        $authorId=$this->input->post('authorId');
        $this->author_model->get_author_cooperator($authorId);
    }


    public function show_more_paper(){
        $Title=$this->input->get('Title');
        $paperid=$this->input->get('paperId');
        $data['Title']=$Title;
        $data['paperid']=$paperid;
        $data['thispaper']=$this->paper_model->get_more_detail($paperid);
        $data['recommended']=$this->paper_model->get_paper_recommended($paperid);
        $this->load->view('paper_page/header');
        $this->load->view('paper_page/more_paper',$data);
        $this->load->view('paper_page/footer');
    }


    public function show_more_conference(){
        $conferenceID=$this->input->get('conferenceID');
        $conferenceName=$this->input->get('conferenceName');
        $data['conferenceID']=$conferenceID;
        $data['conferenceName']=$conferenceName;
        $data['paperNumber']=$this->conference_model->get_num_of_papers($conferenceID);
        $this->load->view('conference_page/index',$data);
    }


    public function show_conference_graph(){
        $conferenceID=$this->input->post('conferenceID');
        $data['conferenceID']=$conferenceID;
        $data['information']=$this->conference_model->get_graph_information($conferenceID);
        $this->load->view('conference_page/graph',$data);
    }


    public function show_conference_paper(){
        $conferenceID=$this->input->post('conferenceID');
        $page=$this->input->post('pageIndex');
        $data['conferenceID']=$conferenceID;
        $data['pageIndex']=$page;
        $page=$page-1;
        $data['startPoint']=$page*10;
        $data['total']=$this->conference_model->count_conference_paper($conferenceID);
        $data['items']=$this->conference_model->get_conference_paper($conferenceID,$page);

        $this->load->view('conference_page/conference_paper',$data);
        $this->load->view('conference_page/buttons',$data);
    }


    public function show_conference_author(){
        $conferenceID=$this->input->post('conferenceID');
        $page=$this->input->post('pageIndex');
        $data['conferenceID']=$conferenceID;
        $data['pageIndex']=$page;
        $page=$page-1;
        $data['startPoint']=$page*10;
        $data['items']=$this->conference_model->get_conference_author($conferenceID,$page);

        $this->load->view('conference_page/conference_author',$data);
        $this->load->view('conference_page/buttons',$data);
    }
}