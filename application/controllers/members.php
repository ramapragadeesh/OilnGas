<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class members extends CI_Controller {

	/**
	 * Index Page for this controller.
	 **/

	public function __construct() {
		parent::__construct();

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
	function _remap($parameter) {

        $this->index($parameter);

}
}