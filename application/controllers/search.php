<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class search extends CI_Controller 
{
public function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
	
	try
	
	{
	$this->load->library('session');
	}
	catch(Exception $e)
	{
	}
	
	if (!isset($this->session->userdata))
	{
	$this->session->set_userdata('default_language', 'en');
	}
	if ($this->session->userdata('signedinuser')== true)
	{
	
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
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"article_page");
	
	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;
	
	$this->load->helper('url');	
	$this->load->view("header_bs",$data);
	$this->load->view("account/search_view",$data);
	$this->load->view("footer");	
	}

}