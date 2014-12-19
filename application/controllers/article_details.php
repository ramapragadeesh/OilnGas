<?php
class article_details extends CI_Controller
{
public function __construct()
	{
		parent::__construct();

	}

	public function article_headings()
	{
	$this->load->library('session');
	if (!isset($this->session->userdata))
	{
	$this->session->set_userdata('default_language', 'en');
	}
	
	// load the language module
	$this->load->model('ablang');
	$data = array();
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");
	$data['infoheader_holder']=$ld;
	$this->load->helper('url');
	
	}

}