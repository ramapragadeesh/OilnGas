<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class user extends CI_Controller {

	/**
	 * Index Page for this controller.
	 **/

	public function __construct() {
		parent::__construct();

	}
	public function index() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}

		if (session_id() == '') {
			session_start();
		}
		if (isset($_SESSION["isLoggedIn"]) == false) {
			$this->load->helper('url');
			$this->load->view("redirect");
			return;
		}

		// load the language module
		$this->load->model('ablang');
		$this->load->model('user_model');

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

		$uid = $this->session->userdata('usernumid');
		$data['labelHome'] = "Home";
		$data['labelServices']  = "Services";
		$data['labelAboutus'] = "About Us";
		$data['labelContactus'] = "Contact Us";

		if ( $this->user_model->isUserWebsiteContentExist($uid) == false ) {
			$data['homeContent'] = "";
			$data['servicesContent'] = "";
			$data['aboutusContent'] = "";
			$data['contactusContent'] = "";

		} else {
			$designData = $this->user_model->getWebsiteContent($uid);
			$menuLabel = $this->user_model->getWebsiteMenu($uid);
			$data['homeContent'] = $designData[0]->home;
			$data['servicesContent'] = $designData[0]->services;
			$data['aboutusContent'] = $designData[0]->about_us;
			$data['contactusContent'] = $designData[0]->contact_us;
			$data['labelHome'] = $menuLabel[0]->home;
			$data['labelServices']  = $menuLabel[0]->services;
			$data['labelAboutus'] = $menuLabel[0]->about_us;
			$data['labelContactus'] = $menuLabel[0]->contact_us;

		}
		

		$ld                    = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$memberTranslationInfo = $this->ablang->get_infoarray($this->session->userdata('default_language'), "mini_website");
		$abrasivesUsers		   = $this->ablang->get_abusers();
		$data['infoheader_holder']  = $ld;
		$data['websiteLanguageInfo'] = $memberTranslationInfo;
		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view("account/user_miniwebsite", $data);
		$this->load->view("footer");
	}

	public function save(){
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
		$data['showInfo'] = true;
		$uid = $this->session->userdata('usernumid');
		
		$labelHome = "Home";
		$labelServices  = "Services";
		$labelAboutus = "About Us";
		$labelContactus = "Contact Us";

		if (trim($this->input->post('labelHome')) != "" ) {
			$labelHome = $this->input->post('labelHome');
		}
		if (trim($this->input->post('labelServices')) != "" ) {
			$labelServices = $this->input->post('labelServices');
		}
		if (trim($this->input->post('labelAboutus')) != "" ) {
			$labelAboutus = $this->input->post('labelAboutus');
		}
		if (trim($this->input->post('labelContactus')) != "" ) {
			$labelContactus = $this->input->post('labelContactus');
		}

		if ($this->input->post("preview") != "1" ) { 
			if ( $this->user_model->isUserWebsiteContentExist($uid) == false ) {
				$this->user_model->insertWebsiteContent($uid,$this->input->post("homeContent"),$this->input->post("servicesContent"),$this->input->post("aboutusContent"),$this->input->post("contactusContent"));
			} else {
				$this->user_model->updateWebsiteContent($uid,$this->input->post("homeContent"),$this->input->post("servicesContent"),$this->input->post("aboutusContent"),$this->input->post("contactusContent"));
			}
			$this->user_model->deleteWebsiteMenu($uid);
			$this->user_model->insertWebsiteMenu($uid,$labelHome,$labelServices,$labelAboutus,$labelContactus);
			
		}
		$data['showInfo'] = true;
		$accountDetails = $this->account_model->get_account_details($uid);
		$menuLabel = $this->user_model->getWebsiteMenu($uid);
		$data['websiteLanguageInfo'] = $this->ablang->get_infoarray($this->session->userdata('default_language'), "member");
		
		$data['uid'] = $uid;
		if ($this->input->post("preview") != "1" ) { 
		$data['labelHome'] = $menuLabel[0]->home;
		$data['labelServices'] = $menuLabel[0]->services;
		$data['labelAboutus'] = $menuLabel[0]->about_us;
		$data['labelContactus'] = $menuLabel[0]->contact_us;
		$data['orgName'] = $accountDetails[0]->user_orgname;
		$data['homeContent'] = $this->input->post("homeContent");
		$data['servicesContent'] = $this->input->post("servicesContent");
		$data['aboutusContent'] = $this->input->post("aboutusContent");
		$data['contactusContent'] = $this->input->post("contactusContent");

		} else {
		$data['labelHome'] = $labelHome;
		$data['labelServices'] = $labelServices;
		$data['labelAboutus'] = $labelAboutus;
		$data['labelContactus'] = $labelContactus;
		$data['orgName'] = $accountDetails[0]->user_orgname;
		$data['homeContent'] = $this->input->post("homeContent");
		$data['servicesContent'] = $this->input->post("servicesContent");
		$data['aboutusContent'] = $this->input->post("aboutusContent");
		$data['contactusContent'] = $this->input->post("contactusContent");

		}
		
		
		// check whether the user is already logged inet_ntop
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
			$uname   = $this->session->userdata('user_name');
		}
		$this->load->helper('url');
		$this->load->view("account/user_websitepreview", $data);
		$this->load->view("footer");

	}


}