<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class abprofile extends CI_Controller 
{
public function vprofile()
{

	$data = array();	
	$this->load->library('session');
	if (!isset($this->session->userdata))
	{
	$this->session->set_userdata('default_language', 'en');
	}
	$uid=0;
	if(isset($_GET['profile_id'])==true and is_numeric($_GET['profile_id'])==true)
	{	
	$uid=$_GET['profile_id'];
	}
	else
	{
	echo "No profile is found.";
	exit;
	}
	// load the language module
	$this->load->model('ablang');
	$this->load->model('account_model');	
	$uod=$this->account_model->account_options($uid);	
	$add=$this->account_model->get_account_details($uid);
	$abu=$this->ablang->get_abusers();
	
	$data['abuser']=$abu;	
	$data['uodd']=$uod;
	$data['adu']=$add;
	$cssarray=array();
	$cssarray[]="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqEhtDrrTMdUfXLz40-_F-0gZ8B9Bgt-M&sensor=false";
	$data['css']=$cssarray;	
	$ulogged=false;
	$uname="guest";	
	$data['ulogset']=$ulogged;
	$data['usernamesses']=$uname;	
	$uop=array();
	$fss="";
	foreach($uod as &$value)
	{
	if ($value->selection == 'F')
	{
	$fss="F";
	}
	else
	{
	$uop[]=$value->selection;
	}
	}
	
	
	// check whether the user is already logged inet_ntop
	if ($this->session->userdata('signedinuser')== true)
	{
	$ulogged=true;
	$uname=$this->session->userdata('user_name');
	}
	$data['ulogset']=$ulogged;
	$data['usernamesses']=$uname;	
	$uop=array();
	$fss="";
	
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");	
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"basic_account,profile_page");
	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;	
	$this->load->helper('url');
	$output="";
	$output  = $this->load->view("header_aw",$data,true);	
    $output .= $this->load->view("ab/public_model",$data,true);
	$output .=$this->load->view("footer",$data,true);
	//$this->load->helper(array('dompdf', 'file'));
	// page info here, db calls, etc. 
    
     //pdf_create($output, 'Myprofile',true);    
	 
	$this->output->set_output($output);
}

public function vprofile_download()
{

	$data = array();	
	$this->load->library('session');
	if (!isset($this->session->userdata))
	{
	$this->session->set_userdata('default_language', 'en');
	}
	$uid=0;
	if(isset($_GET['profile_id'])==true and is_numeric($_GET['profile_id'])==true)
	{	
	$uid=$_GET['profile_id'];
	}
	else
	{
	echo "No profile is found.";
	exit;
	}
	// load the language module
	$this->load->model('ablang');
	$this->load->model('account_model');	
	$uod=$this->account_model->account_options($uid);	
	$add=$this->account_model->get_account_details($uid);
	$abu=$this->ablang->get_abusers();
	
	$data['abuser']=$abu;	
	$data['uodd']=$uod;
	$data['adu']=$add;
	$cssarray=array();
	$cssarray[]="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqEhtDrrTMdUfXLz40-_F-0gZ8B9Bgt-M&sensor=false";
	$data['css']=$cssarray;	
	$ulogged=false;
	$uname="guest";	
	$data['ulogset']=$ulogged;
	$data['usernamesses']=$uname;	
	$uop=array();
	$fss="";
	foreach($uod as &$value)
	{
	if ($value->selection == 'F')
	{
	$fss="F";
	}
	else
	{
	$uop[]=$value->selection;
	}
	}
	
	
	// check whether the user is already logged inet_ntop
	if ($this->session->userdata('signedinuser')== true)
	{
	$ulogged=true;
	$uname=$this->session->userdata('user_name');
	}
	$data['ulogset']=$ulogged;
	$data['usernamesses']=$uname;	
	$uop=array();
	$fss="";
	
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");	
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"basic_account,profile_page");
	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;	
	$this->load->helper('url');
	$output="";
	$output .= $this->load->view("ab/download_profile",$data,true);	
	$this->load->helper('docx_helper'); 
	docx_create($output,"My_Profile");    
 
	

}
}
?>