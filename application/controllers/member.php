<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class member extends CI_Controller {

	/**
	 * Index Page for this controller.
	 **/

	public function __construct() {
		parent::__construct();

	}
	public function search() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
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

		$ld                    = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$memberTranslationInfo = $this->ablang->get_infoarray($this->session->userdata('default_language'), "member_search,profile_page,basic_account,common_page");
		$abrasivesUsers		   = $this->ablang->get_abusers();
		$data['infoheader_holder']  = $ld;
		$data['memberLanguageInfo'] = $memberTranslationInfo;
		$data['abrasivesUsers']     = $abrasivesUsers;
		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view("member/member_view", $data);
		$this->load->view("footer");
	}

	public function member_search_advanced() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
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
		$searchdata = json_decode($_POST['searchForm']);

		// load the member_module
		$this->load->model('member_model');
		$itemsPerPage      = 8;
		$searchResultEmpty = true;


		$memberList = $this->member_model->member_search_advanced($searchdata->memberTypes, $searchdata->abrasivesUsersTypes, $searchdata->orgName, $searchdata->countryName, $searchdata->start, $searchdata->end, $itemsPerPage, $searchResultEmpty);
		
		$memberTranslationInfo = $this->ablang->get_infoarray($this->session->userdata('default_language'), "member_search,common_page");		
		$data['memberLanguageInfo'] = $memberTranslationInfo;
		$data['memberList'] = $memberList;
		$data['p']               = $searchdata->start;
		$data['lastPage']        = $searchdata->end;
		$data['searchResultEmpty'] = $searchResultEmpty;
		$data['userWebContent'] = $this->member_model->getWebsiteContentAll();
		$this->load->helper('url');
		$this->load->view("member/member_search_advanced", $data);
		
	}
	public function index($orgName=""){
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}		
		$this->load->model('user_model');
		// load the language module
		$this->load->model('ablang');

		$this->load->model('account_model');
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

			$uid = $this->account_model->getUID(urldecode($orgName));
		
		
		$accountDetails = $this->account_model->get_account_details($uid);
		if ($this->user_model->isUserWebsiteContentExist($uid) == false) {
			exit;
		}
		$menuLabel = $this->user_model->getWebsiteMenu($uid);
		$webContent = $this->user_model->getWebsiteContent($uid);
		$data['websiteLanguageInfo'] = $this->ablang->get_infoarray($this->session->userdata('default_language'), "member,common_page");
		$data['homeContent'] = $webContent[0]->home;
		$data['servicesContent'] = $webContent[0]->services;
		$data['aboutusContent'] = $webContent[0]->about_us;
		$data['contactusContent'] = $webContent[0]->contact_us;
		$data['uid'] = $uid;
		$data['labelHome'] = $menuLabel[0]->home;
		$data['labelServices'] = $menuLabel[0]->services;
		$data['labelAboutus'] = $menuLabel[0]->about_us;
		$data['labelContactus'] = $menuLabel[0]->contact_us;
		$data['orgName'] = $accountDetails[0]->user_orgname;
		$data['showInfo'] = false;
		// check whether the user is already logged inet_ntop
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
			$uname   = $this->session->userdata('user_name');
		}
		$this->load->helper('url');
		$this->load->view("account/user_websitepreview", $data);
		$this->load->view("footer");

	}
	public function mini_profile($orgName="",$uid="") {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$this->load->model('ablang');
		$this->load->model('account_model');
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

		$ld                    = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$memberTranslationInfo = $this->ablang->get_infoarray($this->session->userdata('default_language'), "basic_account,profile_page,common_page");

		$data['infoheader_holder']  = $ld;
		$data['memberLanguageInfo'] = $memberTranslationInfo;
		if ($uid == "") {
			$uid = $this->account_model->getUID(urldecode($orgName));
		}

		$data['abUsers'] = $this->ablang->get_abusers();
		$data['accountOptions'] = $this->account_model->account_options($uid);
		$data['accountDetails'] =  $this->account_model->get_account_details($uid);
		$data['accountSubscription']  = $this->account_model->subs_options($uid);
		$data['SubscriptionCondition'] = $this->account_model->is_subs_options($uid);
		$userDesc = " Main Foucs";
		$isOrg = true;

		foreach ($data['accountOptions'] as &$value) {
			if ($value->selection == 'F') {
				$userDesc = " is a end user";
				$isOrg =false;
			}
		}
		$data['userDesc'] = $userDesc;
		$data['isOrg'] = $isOrg;
		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view("member/member_profile", $data);
		$this->load->view("footer");

	}
}