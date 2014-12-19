<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class setlanguage extends CI_Controller 
{
	public function index()
	{
	$this->load->library('session');
	$this->load->helper('url');	
	$this->session->set_userdata('default_language', 'en');	   
	$lan=$this->input->get('lan', TRUE);
	
	//set the session info
	switch($lan)
	{
	case "en":
	$this->session->set_userdata('default_language', 'en');
	
	break;
	case "cn":
	$this->session->set_userdata('default_language', 'zh-cn');
	break;
	
	}
	if (isset($_SERVER['HTTP_REFERER'])==true)
	{
	header('Location: '.$_SERVER['HTTP_REFERER']);
	die;
	}
	else
	{
	header('Location: '.base_url());	
	}
	}
}