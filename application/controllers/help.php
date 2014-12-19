<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class help extends CI_Controller {

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
		$memberTranslationInfo = $this->ablang->get_infoarray($this->session->userdata('default_language'), "help");
		$abrasivesUsers		   = $this->ablang->get_abusers();
		$data['infoheader_holder']  = $ld;
		$data['memberLanguageInfo'] = $memberTranslationInfo;
		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view("account/help", $data);
		$this->load->view("footer");
	}
}