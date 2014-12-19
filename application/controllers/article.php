<?php
class article extends CI_Controller {
	public function __construct() {
		parent::__construct();

	}

	public function index() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$id = -1;
		if (is_numeric($this->input->get('id')) == true) {
			$id = $this->input->get('id');
		}

		// load the language module
		$this->load->model('ablang');
		$data = array();

		$ulogged = false;
		$uname   = "guest";

		// check whether the user is already logged inet_ntop
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
			$uname   = $this->session->userdata('user_name');
		}
		$data['ulogset']      = $ulogged;
		$data['usernamesses'] = $uname;

		$ld = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");

		$data['infoheader_holder'] = $ld;

		// load the article_module
		$this->load->model('article_model');
		$ad                     = $this->article_model->get_article_details($id);
		$data['article_holder'] = $ad;

		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view("article/article_full", $data);
		$this->load->view("footer");

	}
	public function article_search() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}

		// load the language module
		$this->load->model('ablang');
		$data = array();
		$ldh  = $this->ablang->get_infoarray($this->session->userdata('default_language'), "home_page");

		$data['usrseslang']      = $this->session->userdata('default_language');
		$data['homepage_holder'] = $ldh;

		$articlestartdate     = "";
		$articleenddate       = "";
		$sarticle_language    = "";
		$sartcile_title       = "";
		$sarticle_regcomp     = "";
		$sarticle_regcompcoun = "";

		$articlestartdate     = $this->input->post('articlestartdate');
		$articleenddate       = $this->input->post('articleenddate');
		$sarticle_language    = $this->input->post('sarticle_language');
		$sartcile_title       = $this->input->post('sartcile_title');
		$sarticle_regcomp     = $this->input->post('sarticle_regcomp');
		$sarticle_regcompcoun = $this->input->post('sarticle_regcompcoun');
		$sarticle_content     = $this->input->post('sartcile_content');

		$sarticle_lang         = $this->input->post('sartcile_lang');
		$data['sarticle_lang'] = $sarticle_lang;
		$particle              = 0;
		$earticle              = 0;

		if ($this->input->post('particle') == 1 or $this->input->post('particle') == 0) {
			$particle = $this->input->post('particle');
		}
		if ($this->input->post('earticle') == 1 or $this->input->post('earticle') == 0) {
			$earticle = $this->input->post('earticle');
		}
		$initlang = "0";

		$sarticle_link = $this->input->post('slink');

		$initlang = $this->input->post('einit');
		// load the article_module
		$this->load->model('article_model');
		$data['sful']           = $sarticle_link;
		$ad                     = $this->article_model->article_search($articlestartdate, $articleenddate, $sarticle_language, $sartcile_title, $sarticle_regcomp, $sarticle_regcompcoun, $sarticle_content, $particle, $earticle, $sarticle_lang);
		$data['article_holder'] = $ad;
		if ($initlang == "1") {
			$this->load->view("article/article_search", $data);
		} else {
			$this->load->view("article/article_search_lang", $data);

		}

	}

	public function article_search_new() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$searchdata = json_decode($_POST['searchForm']);

		// load the language module
		$this->load->model('ablang');
		$data = array();
		$ldh  = $this->ablang->get_infoarray($this->session->userdata('default_language'), "home_page");

		$data['userLanguage']        = $this->session->userdata('default_language');
		$data['homePageTranslation'] = $ldh;

		$paidArticle = 0;
		$eArticle    = 0;

		if ($searchdata->paidArticle == true) {
			$paidArticle = 1;
		}
		if ($searchdata->editorialArticle == true) {
			$eArticle = 1;
		}

		// load the article_module
		$this->load->model('article_model');
		$itemsPerPage              = 8;
		$searchResultEmpty         = true;
		$ad                        = $this->article_model->article_search_new($searchdata->displayLanguage, $searchdata->searchText, $paidArticle, $eArticle, $searchdata->start, $searchdata->end, $itemsPerPage, $searchResultEmpty);
		$data['articleData']       = $ad;
		$data['p']                 = $searchdata->start;
		$data['lastPage']          = $searchdata->end;
		$data['displayLanguage']   = $searchdata->displayLanguage;
		$data['searchResultEmpty'] = $searchResultEmpty;
		$this->load->helper('url');
		$this->load->view("article/article_search_lang", $data);

	}

	public function article_search_advanced() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$searchdata = json_decode($_POST['searchForm']);

		// load the language module
		$this->load->model('ablang');
		$data = array();
		$ldh  = $this->ablang->get_infoarray($this->session->userdata('default_language'), "article_view");

		$data['userLanguage']        = $this->session->userdata('default_language');
		$data['homePageTranslation'] = $ldh;

		$paidArticle = 0;
		$eArticle    = 0;

		if ($searchdata->paidArticle == true) {
			$paidArticle = 1;
		}
		if ($searchdata->editorialArticle == true) {
			$eArticle = 1;
		}

		// load the article_module
		$this->load->model('article_model');
		$itemsPerPage      = 1;
		$searchResultEmpty = true;

		$ad                      = $this->article_model->article_search_advanced($searchdata->displayLanguage, $searchdata->searchTextTitle, $searchdata->searchTextContent, $paidArticle, $eArticle, $searchdata->start, $searchdata->end, $itemsPerPage, $searchdata->startDate, $searchdata->endDate, $searchdata->articleId, $searchResultEmpty);
		$data['articleData']     = $ad;
		$data['p']               = $searchdata->start;
		$data['lastPage']        = $searchdata->end;
		$data['displayLanguage'] = $searchdata->displayLanguage;
		$singleArticle           = false;
		if ($searchdata->articleId != "") {
			$singleArticle = true;
		}
		$data['singleArticle']     = $singleArticle;
		$data['searchResultEmpty'] = $searchResultEmpty;
		$this->load->helper('url');

		$this->load->view("article/article_search_advanced", $data);

	}
	public function view() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}

		$this->load->model('ablang');
		$data = array();

		$ulogged   = false;
		$uname     = "guest";
		$articleId = "";

		$headerLanguageInfo      = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$articleViewLanguageInfo = $this->ablang->get_infoarray($this->session->userdata('default_language'), "article_view");

		// check whether the user is already logged in
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
			$uname   = $this->session->userdata('user_name');
		}
		$data['ulogset']             = $ulogged;
		$data['usernamesses']        = $uname;
		$data['articleLanguageInfo'] = $articleViewLanguageInfo;
		$data['infoheader_holder']   = $headerLanguageInfo;
		$data['articleId'] = $this->input->get("articleId");
		$this->load->helper('url');

		$this->load->view("header_aw", $data);
		$this->load->view("article/article_show_id", $data);
		$this->load->view("footer");
		

	}
	public function advanced_view() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}

		$this->load->model('ablang');
		$data = array();

		$ulogged   = false;
		$uname     = "guest";
		$articleId = "";

		$headerLanguageInfo      = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$articleViewLanguageInfo = $this->ablang->get_infoarray($this->session->userdata('default_language'), "article_view");

		// check whether the user is already logged in
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
			$uname   = $this->session->userdata('user_name');
		}
		$data['ulogset']             = $ulogged;
		$data['usernamesses']        = $uname;
		$data['articleLanguageInfo'] = $articleViewLanguageInfo;
		$data['infoheader_holder']   = $headerLanguageInfo;
		$this->load->helper('url');

		$this->load->view("header_aw", $data);
		$this->load->view("article/article_view", $data);
		$this->load->view("footer");

	}

}