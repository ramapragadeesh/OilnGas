<?php
class ipad extends CI_Controller
{
public function __construct()
	{
		parent::__construct();

	}	
	
	public function index() {
	$this->load->library('session');
	if (!isset($this->session->userdata))
	{
	$this->session->set_userdata('default_language', 'en');
	}
	
	// load the language module
	$this->load->model('ablang');
	$data = array();
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"home_page");

	$data['infoheader_holder']=$ld;
	$data['homepage_holder']=$ldh;

	$ulogged=false;
	$uname="guest";

	// check whether the user is already logged inet_ntop
	if ($this->session->userdata('signedinuser')== true)
	{
	$ulogged=true;
	$uname=$this->session->userdata('user_name');
	}
	$data['ulogset']=$ulogged;
	$data['usernamesses']=$uname;
	$this->load->model('ipad_log');
	$dump = print_r($_SERVER, true);
	$this->ipad_log->log_me($dump);

	$data['usrseslang']=$this->session->userdata('default_language');
	$this->load->helper('url');
	$this->load->view("header_aw",$data);
	$this->load->view("ipad",$data);
	$this->load->view("footer");

	}

	public function info() {
	$this->load->library('session');
	if (!isset($this->session->userdata))
	{
	$this->session->set_userdata('default_language', 'en');
	}
	
	// load the language module
	$this->load->model('ablang');
	$data = array();
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"home_page");

	$data['infoheader_holder']=$ld;
	$data['homepage_holder']=$ldh;

	$ulogged=false;
	$uname="guest";

	// check whether the user is already logged inet_ntop
	if ($this->session->userdata('signedinuser')== true)
	{
	$ulogged=true;
	$uname=$this->session->userdata('user_name');
	}
	$data['ulogset']=$ulogged;
	$data['usernamesses']=$uname;
	$this->load->model('ipad_log');
	$this->ipad_log->log_me($this->input->post("searchForm"));

	$data['usrseslang']=$this->session->userdata('default_language');
	$this->load->helper('url');
	$this->load->view("header_aw",$data);
	$this->load->view("ipad",$data);
	$this->load->view("footer");

	}

	public function my_article()
	{
	$this->load->library('session');
	if (!isset($this->session->userdata))
	{
	$this->session->set_userdata('default_language', 'en');
	}

	if ($this->session->userdata('signedinuser')== true)
	{
	}
	else
	{
	$this->load->helper('url');
	$this->load->view("redirect");
	return;
	}
	// load the language module
	$this->load->model('ablang');
	$data = array();
	$ulogged=false;
	$uname="guest";

	// check whether the user is already logged inet_ntop
	if ($this->session->userdata('signedinuser')== true)
	{
	$ulogged=true;
	$uname=$this->session->userdata('user_name');
	}
	$data['ulogset']=$ulogged;
	$data['usernamesses']=$uname;

	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");

	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"my_article");


	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;


	$this->load->helper('url');
	$this->load->view("header_aw",$data);
	$this->load->view("account/view_myarticle",$data);
	$this->load->view("footer");
	}
}