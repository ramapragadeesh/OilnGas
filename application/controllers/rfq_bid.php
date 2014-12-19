<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class rfq extends CI_Controller 
{
	public function index()
	{
	$data = array();	
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
	$this->load->model('account_model');
	$uid=$this->session->userdata('usernumid');
	$uod=$this->account_model->account_options($uid);	
	$subs=$this->account_model->subs_options($uid);
     	
	$issub=$this->account_model->is_subs_options($uid);	
	$add=$this->account_model->get_account_details($uid);
	$abu=$this->ablang->get_abusers();
	
	$data['abuser']=$abu;	
	$data['uodd']=$uod;
	$data['adu']=$add;
	$data['subsd']=$subs;
	$data['issubs']=$issub;	
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
	$uop=array();
	$fss="";
	
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");	
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"basic_account,rfq_page");
	
	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;

	$data['user_id_info']=$this->session->userdata('usernumid');
	$data['freemodules']=$this->account_model->get_free_modules($this->session->userdata('usernumid'));
	//$data['user_udhapri']=$udhapri;
	//$data['user_udhasec']=$udhasec;
	
	$data['fs']=$fss;
	$this->load->helper('url');
	$this->load->view("header_aw",$data);
	
	$this->load->view("account/rfq_create",$data);
	$this->load->view("footer");
	
	
	}
public function rfq_save()
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
$uid=$this->session->userdata('usernumid');
	
	
$data = array();
//var_dump($_POST);

//load rfq model
$this->load->model('rfq_model');


//insert rfq main
 
$this->rfq_model->insert_rfqmain($this->input->post('rfqid'),$this->input->post('rfqno'),$this->input->post('rfqtitle'),$this->input->post('rfqissuedby'),$this->input->post('rfqcname'),$this->input->post('rfq_issuedate'),$this->input->post('rfq_closedate'),$this->input->post('rfqcimports'),$this->input->post('rfqcexports'), $this->input->post('rfqcurrency'),$this->input->post('rfqqval'),$this->input->post('rfqincoterm'),$this->input->post('rfqpship'),$this->input->post('rfqemail'),$this->input->post('rfqgroup'),$uid);
$this->rfq_model->update_rfqtable('rfqid',$this->input->post('rfqtsn'),$this->input->post('rfqtcdesc'),$this->input->post('rfqtspec'),$this->input->post('rfqtdi'),$this->input->post('rfqtqu'),$this->input->post('rfqtuom'),$this->input->post('rfqtreqprice'),$this->input->post('rfqtleadtime'));
$u="Location: ".$this->config->base_url()."rfq/rfq_manage";
header($u);

}

public function redirectnonlog()
{
	$data = array();	
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
	exit;
}

public function rfq_manage()
	{
	$data = array();	
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
	$this->load->model('account_model');
	$this->load->model('rfq_model');
	$uid=$this->session->userdata('usernumid');
	$uod=$this->account_model->account_options($uid);	
	$subs=$this->account_model->subs_options($uid);
     	
	$issub=$this->account_model->is_subs_options($uid);	
	$add=$this->account_model->get_account_details($uid);
	$lrfq=$this->rfq_model->get_rfq_byuid($uid);
	
	$abu=$this->ablang->get_abusers();
	
	$data['abuser']=$abu;	
	$data['uodd']=$uod;
	$data['adu']=$add;
	$data['subsd']=$subs;
	$data['issubs']=$issub;	
	$data['lrfq']=$lrfq;	
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
	$uop=array();
	$fss="";
	
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");	
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"basic_account,rfq_page");
	
	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;

	$data['user_id_info']=$this->session->userdata('usernumid');
	$data['freemodules']=$this->account_model->get_free_modules($this->session->userdata('usernumid'));
	//$data['user_udhapri']=$udhapri;
	//$data['user_udhasec']=$udhasec;
	
	$data['fs']=$fss;
	$this->load->helper('url');
	$this->load->view("header_aw",$data);
	
	$this->load->view("account/rfq_manage",$data);
	$this->load->view("footer");
	
	
	}
	
	public function rfq_bid()
	{
	$data = array();	
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
	$this->load->model('account_model');
	$this->load->model('rfq_model');
	$uid=$this->session->userdata('usernumid');
	$uod=$this->account_model->account_options($uid);	
	$subs=$this->account_model->subs_options($uid);
     	
	$issub=$this->account_model->is_subs_options($uid);	
	$add=$this->account_model->get_account_details($uid);
	$lrfq=$this->rfq_model->get_rfq_byuid($uid);
	
	$abu=$this->ablang->get_abusers();
	
	$data['abuser']=$abu;	
	$data['uodd']=$uod;
	$data['adu']=$add;
	$data['subsd']=$subs;
	$data['issubs']=$issub;	
	$data['lrfq']=$lrfq;	
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
	$uop=array();
	$fss="";
	
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");	
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"basic_account,rfq_page");
	
	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;

	$data['user_id_info']=$this->session->userdata('usernumid');
	$data['freemodules']=$this->account_model->get_free_modules($this->session->userdata('usernumid'));
	//$data['user_udhapri']=$udhapri;
	//$data['user_udhasec']=$udhasec;
	
	$data['fs']=$fss;
	$this->load->helper('url');
	$this->load->view("header_aw",$data);
	
	$this->load->view("account/rfq_bid",$data);
	$this->load->view("footer");
	
	
	}

}