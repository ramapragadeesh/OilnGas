<?php
class my_article extends CI_Controller {
	public function __construct() {
		parent::__construct();

	}

	public function index($cat = "in") {

		try

		{
			$this->load->library('session');
		}
		 catch (Exception $e) {
		}

		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		if ($this->session->userdata('signedinuser') == true) {

		} else {
			$this->load->helper('url');
			$this->load->view("redirect");
			return;
		}
		//$_SESSION["scw_home"]
		if (session_id() == '') {
			session_start();
		}

		if (isset($_SESSION["isLoggedIn"]) == false) {
			$this->load->helper('url');
			$this->load->view("redirect");
			return;
		}
		$ad          = "";
		$ised        = 0;
		$article_new = true;
		$this->load->model('article_model');
		$this->load->model('account_model');
		if (isset($_GET['article_id'])) {
			// load the article_module
			//save the article data
			$ad   = $this->article_model->get_article_details($_GET['article_id']);
			$ised = 1;
		}

		$adu    = $this->article_model->get_userarticle_group($this->session->userdata('usernumid'));
		$artel  = $this->article_model->article_elap($this->session->userdata('usernumid'));
		$userid = $this->session->userdata('usernumid');
		//save the article data
		$aued = $this->article_model->get_user_emails($userid);

		if (isset($_GET['article_new'])) {
			if ($_GET['article_new'] == "false") {
				$article_new = false;
			}
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

		$data['aeholder']  = $ad;
		$data['isedit']    = $ised;
		$data['a_new']     = $article_new;
		$data['arteldata'] = $artel;
		$data['umedata']   = $this->account_model->subs_options($userid);

		$ldh = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$ld  = $this->ablang->get_infoarray($this->session->userdata('default_language'), "article_page");

		$data['info_holder']       = $ld;
		$data['infoheader_holder'] = $ldh;

		$data['usergroupinfo']    = $adu;
		$data['uemaildata']       = $aued;
		$data['ussersessionlang'] = $this->session->userdata('default_language');
		$data['user_id_info']     = $this->session->userdata('usernumid');
		;

		$this->load->helper('url');

		$this->load->view("header_aw", $data);
		$this->load->view("account/view_myarticle", $data);
		$this->load->view("footer");

	}

	public function admin_auth() {

		try

		{
			$this->load->library('session');
		}
		 catch (Exception $e) {
		}

		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		if ($this->session->userdata('signedinuser') == true) {

		} else {
			$this->load->helper('url');
			$this->load->view("redirect");
			return;
		}
		//$_SESSION["scw_home"]
		if (session_id() == '') {
			session_start();
		}

		if (isset($_SESSION["isLoggedIn"]) == false) {
			$this->load->helper('url');
			$this->load->view("redirect");
			return;
		}
		$ad          = "";
		$ised        = 0;
		$article_new = true;
		$this->load->model('article_model');
		$this->load->model('account_model');
		if (isset($_GET['article_id'])) {
			// load the article_module
			//save the article data
			$ad   = $this->article_model->get_article_details($_GET['article_id']);
			$ised = 1;
		}

		$adu    = $this->article_model->get_userarticle_group($this->session->userdata('usernumid'));
		$artel  = $this->article_model->article_elap($this->session->userdata('usernumid'));
		$userid = $this->session->userdata('usernumid');

		//save the article data
		$aued = $this->article_model->get_user_emails($userid);

		if (isset($_GET['article_new'])) {
			if ($_GET['article_new'] == "false") {
				$article_new = false;
			}
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

		$rgp = $this->article_model->art_group_list($ad[0]->article_target_group);

		$data['rgp'] = $rgp;

		$data['ulogset']      = $ulogged;
		$data['usernamesses'] = $uname;

		$data['aeholder']  = $ad;
		$data['isedit']    = $ised;
		$data['a_new']     = $article_new;
		$data['arteldata'] = $artel;
		$data['umedata']   = $this->account_model->subs_options($userid);

		$ldh = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$ld  = $this->ablang->get_infoarray($this->session->userdata('default_language'), "article_page");

		$data['info_holder']       = $ld;
		$data['infoheader_holder'] = $ldh;

		$data['usergroupinfo']    = $adu;
		$data['uemaildata']       = $aued;
		$data['ussersessionlang'] = $this->session->userdata('default_language');
		$data['user_id_info']     = $this->session->userdata('usernumid');
		;

		$this->load->helper('url');

		$this->load->view("header_aw", $data);
		$this->load->view("account/article_auth_send", $data);
		$this->load->view("footer");

	}
	public function auth_notification($artemail, $artid, $arttitle, $a) {

		if ($a == false) {
			return;
		}
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
		} else {
			exit;
		}

		$rfqsender = $this->session->userdata('user_id');

		$user_id = "";
		$this->load->helper('url');
		$config['protocol']  = 'sendmail';
		$config['wordwrap']  = TRUE;
		$config['validate']  = TRUE;
		$config['mailtype']  = "html";
		$config['charset']   = "UTF-8";
		$config['mailpath']  = "/usr/sbin/sendmail -t -i";
		$config['smtp_host'] = "relay-hosting.secureserver.net";
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$rfqsenderbody       = "";
		$data                = array();

		$data['body']      = "";
		$data['sender']    = $rfqsender;
		$data['art_id']    = $artid;
		$data['art_title'] = $arttitle;

		try
		{
			$this->load->library('email', $config);
			$this->email->from($artemail, 'Abrasivesworld');
			$this->email->to("support@abrasivesworld.com");
			$this->email->subject("Abrasivesworld Group Article Approval Required: ".$arttitle);
			$this->email->message($this->load->view('template/art_send_request', $data, true));
			$this->email->send();
			// log the transaction
			//   $this->article_model->email_sentbox($rfqid,$v,"","Abrasivesworld Bidding Information: ".$rfqtitle);
			//echo $this->email->print_debugger();
		}
		 catch (Exception $err) {
			echo $err;
		}

	}

	public function disapprove_artemail() {
	}
	public function approve_artemail() {
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
		} else {
			exit;
		}
		$artid   = "";
		$user_id = "";
		// load the article_module
		$artid = $_GET['artid'];
		$this->load->model('article_model');
		$article_data    = $this->article_model->get_article_details($artid);
		$artdata         = array();
		echo $artid;
		var_dump($article_data);
		$articleto_email = $article_data[0]->article_target_email;
		$article_title   = $article_data[0]->article_title;
		$article_detail  = $article_data[0]->article_details;
		$article_active  = $article_data[0]->article_ready;
		$article_uinfo   = $this->article_model->get_article_userinfo($article_data[0]->user_id);
		$rgp             = $this->article_model->art_group_list($article_data[0]->article_target_group);

		echo "Listed Emails : "."<br/><br/><br/>";
		if ($article_active == 1) {
		} else {
			echo "Article is not active";
			exit;
		}
		if (strlen($articleto_email) > 5) {
			$artdata = explode(",", trim($articleto_email));
		}
		$config['protocol']  = 'sendmail';
		$config['wordwrap']  = TRUE;
		$config['validate']  = TRUE;
		$config['mailtype']  = "html";
		$config['charset']   = "UTF-8";
		$config['mailpath']  = "/usr/sbin/sendmail -t -i";
		$config['smtp_host'] = "relay-hosting.secureserver.net";
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$fedata              = array();
		foreach ($rgp as &$v) {
			if (filter_var($v['user_email'], FILTER_VALIDATE_EMAIL)) {
				$feddata[] = $v['user_email'];
				echo "<br/>".$v['user_email'];
			}
		}
		if (count($feddata) > 0) {} else {
			echo "No valid emails";
			exit;
		}

		$data           = array();
		$footer         = '';
		$data['body']   = $article_detail.$footer;
		$data['sender'] = $article_uinfo[0]->user_email;
		foreach ($feddata as &$v) {
			try
			{

				$this->load->library('email', $config);
				$this->email->from('news@abrasivesworld.com', 'Abrasivesworld');
				$this->email->to($v);
				//$this->email->to("ram.praximo@gmail.com");
				$this->email->cc($article_uinfo[0]->user_email);
				$this->email->subject("Abrasivesworld news: ".$article_title);
				$this->email->message($this->load->view('template/email', $data, true));
				$this->email->send();
				// log the transaction
				$this->article_model->email_sentbox($artid, $v, "", "Abrasivesworld news: ".$article_title);

			}
			 catch (Exception $err) {

			}
		}
		echo "<br/><br/>"."Emails have been sent.";

	}
	public function download_article() {
		$this->load->library('session');
		$this->load->helper('url');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$id = $_GET['article_id'];
		$this->load->model('article_model');
		$ra = $this->article_model->download_article_byid($id);
		$this->load->helper('docx_helper');
		$fds = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>';
		$fdd = "</body></html>";
		if (isset($ra['article_details']) == true) {
			docx_create($ra['article_details'], "My_Article");
		} else {
			echo "<b>Please save the article before downloading.</b>";
		}
	}
	public function save_article() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$article_id     = $this->input->post('scw_articleid');
		$article_title  = $this->input->post('scw_arttitle');
		$article_date   = $this->input->post('scw_artdate');
		$article_author = $this->input->post('scw_artauthor');

		$usernumid = $this->session->userdata('usernumid');
		$userid    = $this->session->userdata('user_id');
		$userorg   = $this->session->userdata('user_orgname');
		//$article_user=$this->input->post('');
		$article_user    = $userid;
		$article_details = $this->input->post('newarticledata');
		$article_lang    = $this->input->post('scw_artlang');
		$ph              = $this->input->post('posthome');
		$pha             = 0;
		$aha             = 0;
		$ah              = $this->input->post('activateart');
		if ($ph == "posthome") {
			$pha = 1;
		}
		if ($ah == "activateart") {
			$aha = 1;
		}
		$article_email = $this->input->post('newarticleemail');
		if (preg_match('/'.preg_quote(',', '/').'$/', $article_email) == true) {
		} else {
			$article_email .= ",";
		}
		$article_category     = "";
		$article_categorytemp = $this->input->post('artgroup');

		if (is_array($article_categorytemp) == 1) {

			foreach ($article_categorytemp as &$value) {
				$article_category .= $value.",";
			}
		}
		if (strlen($article_category) > 1) {
			$article_category = substr($article_category, 0, -1);
		}
		// load the article_module
		$this->load->model('article_model');
		//save the article data
		$ad                         = $this->article_model->new_article_details($article_id, $article_title, $article_date, $article_author, $article_user, $article_details, $pha, $article_lang, $usernumid, $userorg, $article_email, $article_category, $aha);
		$_SESSION["scw_arttitle"]   = $article_title;
		$_SESSION["scw_artdate"]    = $article_date;
		$_SESSION["scw_artauthor"]  = $article_author;
		$_SESSION["newarticledata"] = $article_details;
		if ($aha == 1) {
			// update the last article info
			$this->article_model->update_user_article($usernumid);
			$this->auth_notification($this->session->userdata('user_id'), $article_id, $article_title, $this->input->post('artgroup'));
			$this->process_emails($article_id);
			echo json_encode(1);

		} else {
			echo json_encode(2);
		}

	}
	public function trans_data() {
		$sid = "en";
		$did = "zh-cn";
		$sid = $this->input->post('scw_artlang');
		$did = $this->input->post('dlanguage');
		if ($sid == $did) {
			echo "choose different language for translation";
			exit;
		}
		$transdata = $this->input->post('newarticledata');
		$this->load->helper('t');
		$text   = 'Translate this text.';
		$toLang = '';//or any other language - http://code.google.com/apis/language/translate/v2/using_rest.html#language-params

		echo t($transdata, $sid, $did);
	}
	public function trans_data_old() {
		$sid = "en";
		$did = "zh-cn";
		$sid = $this->input->post('scw_artlang');
		$did = $this->input->post('dlanguage');
		if ($sid == $did) {
			echo "choose different language for translation";
			exit;
		}
		$transdata = $this->input->post('newarticledata');
		// load the article_module
		$this->load->model('article_model');
		$rtd = $this->article_model->google_translator($sid, $did, $transdata);
		echo $rtd;

	}

	public function process_emails($artidi) {
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
		} else {
			exit;
		}
		$artid   = "";
		$user_id = "";
		// load the article_module

		//$artidi=$this->input->get('article_id');

		$artid = $artidi;
		$this->load->model('article_model');
		$article_data    = $this->article_model->get_article_details($artid);
		$artdata         = array();
		$articleto_email = $article_data[0]->article_target_email;
		$article_title   = $article_data[0]->article_title;
		$article_detail  = $article_data[0]->article_details;
		$article_active  = $article_data[0]->article_ready;
		$article_uinfo   = $this->article_model->get_article_userinfo($article_data[0]->user_id);

		if ($article_active == 1) {
		} else {
			exit;
		}
		if (strlen($articleto_email) > 5) {
			$artdata = explode(",", str_replace(" ", "", trim($articleto_email)));
		}
		$config['protocol']  = 'sendmail';
		$config['wordwrap']  = TRUE;
		$config['validate']  = TRUE;
		$config['mailtype']  = "html";
		$config['charset']   = "UTF-8";
		$config['mailpath']  = "/usr/sbin/sendmail -t -i";
		$config['smtp_host'] = "relay-hosting.secureserver.net";
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$feddata             = array();
		foreach ($artdata as &$value) {
			if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
				$feddata[] = $value;
			}
		}
		if (count($feddata) > 0) {} else {
			return;
		}

		$data           = array();
		$footer         = '';
		$data['body']   = $article_detail.$footer;
		$data['sender'] = $article_uinfo[0]->user_email;
		foreach ($feddata as &$v) {
			try
			{
				$this->load->library('email', $config);
				$this->email->from('news@abrasivesworld.com', 'Abrasivesworld');
				$this->email->to($v);
				$this->email->cc($article_uinfo[0]->user_email);
				$this->email->subject("Abrasivesworld news: ".$article_title);
				$this->email->message($this->load->view('template/email', $data, true));
				$this->email->send();
				// log the transaction
				$this->article_model->email_sentbox($artid, $v, "", "Abrasivesworld news: ".$article_title);
			}
			 catch (Exception $err) {

			}
		}
	}
	public function json_article() {

		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$uid = $this->session->userdata('usernumid');

		// load the article_module
		$this->load->model('article_model');
		//get the article data
		$data['article_list'] = $this->article_model->getall_article_details($uid);
		echo json_encode($data['article_list']);

	}

	public function delete_article() {

		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}

		// load the article_module
		$this->load->model('article_model');
		//get the article data
		$id                   = $this->input->post('id');
		$data['article_list'] = $this->article_model->delete_article_details($id);
		echo json_encode(1);

	}

	public function update_article_status() {

		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}

		// load the article_module
		$this->load->model('article_model');
		//get the article data
		$id = $this->input->post('id');
		$as = 0;
		if ($this->input->post('activestatus') == "1") {
			$as = $this->input->post('activestatus');
		}
		$data['article_list'] = $this->article_model->update_article_status($id, $as);
		echo json_encode(1);

	}
	public function get_email_list() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}

		// load the article_module
		$this->load->model('article_model');
		$userid = $this->session->userdata('usernumid');
		//save the article data
		$ad = $this->article_model->get_user_emails($userid);
		echo json_encode($ad);

	}
	public function update_article() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$id             = $this->input->post('art_id');
		$article_title  = $this->input->post('scw_arttitle');
		$article_date   = $this->input->post('scw_artdate');
		$article_author = $this->input->post('scw_artauthor');
		$article_status = $this->input->post('scw_artstatus');

		//$article_user=$this->input->post('');

		$article_details = $this->input->post('newarticledata');

		// load the article_module
		$this->load->model('article_model');
		//save the article data
		$ad = $this->article_model->update_articles_details($id, $article_title, $article_date, $article_author, $article_details, $article_status);

	}
	public function article_translate($id = "") {
		$data = array();
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$id = $this->input->get('id');
		// load the article_module
		$this->load->model('article_model');
		//get the article data
		$ad                  = $this->article_model->get_article_byid($id);
		$data['lang_holder'] = $ad;
		$this->load->view("article/translate.php", $data);
	}

}