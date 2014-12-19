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
	$this->load->model('urldetect_model');
	$usid=$this->urldetect_model->get_uid();
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$mod="RFQ";
	
	$this->session->set_userdata('vplink', true);
	$this->session->set_userdata('vlink',$actual_link);
	$this->session->set_userdata('vpusid',$usid);
	$this->session->set_userdata('vmod',$mod);
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
	$abu=$this->ablang->get_abusers();
	$adu=$this->rfq_model->get_userarticle_group($this->session->userdata('usernumid'));
	//load RFQ main information
	$aued=$this->rfq_model->get_user_emails($uid);
	
	$data['uemaildata']=$aued;
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
	$data['usergroupinfo']=$adu;
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
	
	public function send_admin_notify($rfqemail,$rfqid,$rfqtitle,$issuedate,$closedate,$a)
	{
	if ($a == false)
	{
	return;
	}
	if ($this->session->userdata('signedinuser')== true)
	{
	$ulogged=true;
	}
	else
	{
	exit;
	}
	
	$rfqsender = $this->session->userdata('user_id');
	
	$artid="";
	$user_id="";
	$this->load->helper('url');	
	$config['protocol'] = 'sendmail';
	$config['wordwrap'] = TRUE;
	$config['validate'] = TRUE;
	$config['mailtype'] = "html";            
	$config['charset'] = "UTF-8";
	$config['mailpath'] = "/usr/sbin/sendmail -t -i";
	$config['smtp_host'] = "relay-hosting.secureserver.net";
	$config['smtp_user'] = '';
	$config['smtp_pass'] = '';
    $rfqsenderbody="";
   $data=array();
   
   $data['body']=""; 
   $data['sender']=$rfqsender;
   $data['rfq_id']=$rfqid;
   $data['rfq_title']=$rfqtitle;
   $data['rfq_idate']=$issuedate;
   $data['rfq_cdate']=$closedate;
   

   try
   {   
   $this->load->library( 'email' ,$config);   
   $this->email->from($rfqemail, 'Abrasivesworld' );
   $this->email->to("support@abrasivesworld.com");   
   $this->email->subject("Abrasivesworld Group RFQ Approval Required:".$rfqtitle);   
   $this->email->message($this->load->view('template/rfq_send_request', $data, true ));  
   $this->email->send();  
   // log the transaction
//   $this->article_model->email_sentbox($rfqid,$v,"","Abrasivesworld Bidding Information: ".$rfqtitle);
   //echo $this->email->print_debugger();
   }
   catch(Exception $err)
   {
   echo $err;
   }
   }
	public function approve_rfq()
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
	$rfqid=$this->input->get('rfqid');
	if ($rfqid=="")
	{
	exit;
	}
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
	
	//load rfq model
	$this->load->model('rfq_model');
	//load RFQ main information
	$aued=$this->rfq_model->get_user_emails($uid);
	
	$rfqm=$this->rfq_model->getrfqmain($rfqid);
	
	// load RFQ table information
	$rfqt=$this->rfq_model->getrfqtable($rfqid);
	//load RFQ docs information
	$rfqd=$this->rfq_model->getrfqdocs($rfqid);
	
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");	
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"basic_account,rfq_page");
	$adu=$this->rfq_model->get_userarticle_group($this->session->userdata('usernumid'));
	$data['usergroupinfo']=$adu;	
	$rgp=$this->rfq_model->rfq_group_list($rfqm[0]->rfq_group);
	$data['info_holder']=$ld;
	$data['rgp']=$rgp;
	$data['rfq_groupinfo']=$ld;
	$data['infoheader_holder']=$ldh;
	$data['uemaildata']=$aued;
	$data['rfqm']=$rfqm;
	$data['rfqt']=$rfqt;
	$data['rfqd']=$rfqd;
	$data['RFQGUID']=$rfqid;
	$data['user_id_info']=$this->session->userdata('usernumid');
	$data['freemodules']=$this->account_model->get_free_modules($this->session->userdata('usernumid'));
	//$data['user_udhapri']=$udhapri;
	//$data['user_udhasec']=$udhasec;
	
	$data['fs']=$fss;
	$r="";
	echo "Listed Emails:<br/><br/><br/>";
	foreach($rgp as &$v)
	{
	if ($v['user_email'] != "VICKYZH@126.com")
	{
	$r .=$v['user_email'].";";
	echo $v['user_email']."<br/>";
	}
	}
	
	$this->rfq_authemails_send($r,$rfqid,$rfqm[0]->rfq_title,$rfqm[0]->rfq_issue_date,$rfqm[0]->rfq_close_date);
	echo "<br/><br/>"."Emails have been sent";	
	}
	public function rfq_auth_groupsend()
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
	$rfqid=$this->input->get('rfqid');
	if ($rfqid=="")
	{
	exit;
	}
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
	
	//load rfq model
	$this->load->model('rfq_model');
	//load RFQ main information
	$aued=$this->rfq_model->get_user_emails($uid);
	
	$rfqm=$this->rfq_model->getrfqmain($rfqid);
	
	// load RFQ table information
	$rfqt=$this->rfq_model->getrfqtable($rfqid);
	//load RFQ docs information
	$rfqd=$this->rfq_model->getrfqdocs($rfqid);
	
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");	
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"basic_account,rfq_page");
	$adu=$this->rfq_model->get_userarticle_group($this->session->userdata('usernumid'));
	$data['usergroupinfo']=$adu;	
	$rgp=$this->rfq_model->rfq_group_list($rfqm[0]->rfq_group);
	$data['info_holder']=$ld;
	$data['rgp']=$rgp;
	$data['rfq_groupinfo']=$ld;
	$data['infoheader_holder']=$ldh;
	$data['uemaildata']=$aued;
	$data['rfqm']=$rfqm;
	$data['rfqt']=$rfqt;
	$data['rfqd']=$rfqd;
	$data['RFQGUID']=$rfqid;
	$data['user_id_info']=$this->session->userdata('usernumid');
	$data['freemodules']=$this->account_model->get_free_modules($this->session->userdata('usernumid'));
	//$data['user_udhapri']=$udhapri;
	//$data['user_udhasec']=$udhasec;
	
	$data['fs']=$fss;
	$this->load->helper('url');
	$this->load->view("header_aw",$data);
	
	$this->load->view("account/rfq_auth_send",$data);
	$this->load->view("footer");
	

	
	}
	public function remove_email_entry()
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
	exit;
	}
	$uid=$this->session->userdata('usernumid');
	$this->load->model('rfq_model');
	$this->rfq_model->remove_email_entry($uid,$this->input->post('emails'));
		
	}
	
	public function remove_rfq_entry()
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
	exit;
	}
	$uid=$this->session->userdata('usernumid');
	$this->load->model('rfq_model');
	$this->rfq_model->remove_rfq_data($uid,$this->input->post('rfqid'));
		
	}
public function rfq_modify()
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
	$rfqid=$this->input->get('rfqid');
	if ($rfqid=="")
	{
	exit;
	}
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
	
	//load rfq model
	$this->load->model('rfq_model');
	//load RFQ main information
	$aued=$this->rfq_model->get_user_emails($uid);
	
	$rfqm=$this->rfq_model->getrfqmain($rfqid);
	
	// load RFQ table information
	$rfqt=$this->rfq_model->getrfqtable($rfqid);
	//load RFQ docs information
	$rfqd=$this->rfq_model->getrfqdocs($rfqid);
	
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");	
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"basic_account,rfq_page");
	$adu=$this->rfq_model->get_userarticle_group($this->session->userdata('usernumid'));
	$data['usergroupinfo']=$adu;	
	
	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;
	$data['uemaildata']=$aued;
	$data['rfqm']=$rfqm;
	$data['rfqt']=$rfqt;
	$data['rfqd']=$rfqd;
	$data['RFQGUID']=$rfqid;
	$data['user_id_info']=$this->session->userdata('usernumid');
	$data['freemodules']=$this->account_model->get_free_modules($this->session->userdata('usernumid'));
	//$data['user_udhapri']=$udhapri;
	//$data['user_udhasec']=$udhasec;
	
	$data['fs']=$fss;
	$this->load->helper('url');
	$this->load->view("header_aw",$data);
	
	$this->load->view("account/rfq_modify",$data);
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
//print_r($_FILES['multipartFilePath']['tmp_name']);


$this->rfq_model->insert_rfqmain($this->input->post('rfqid'),$this->input->post('rfqno'),$this->input->post('rfqtitle'),$this->input->post('rfqissuedby'),$this->input->post('rfqcname'),$this->input->post('rfq_issuedate'),$this->input->post('rfq_closedate'),$this->input->post('rfqcimports'),$this->input->post('rfqcexports'), $this->input->post('rfqcurrency'),$this->input->post('rfqqval'),$this->input->post('rfqincoterm'),$this->input->post('rfqpship'),$this->input->post('rfqemail'),$this->input->post('artgroup'),$uid,$this->input->post('rfqactiveme'));
$this->rfq_model->update_rfqtable($this->input->post('rfqid'),$this->input->post('rfqtsn'),$this->input->post('rfqtcdesc'),$this->input->post('rfqtspec'),$this->input->post('rfqtdi'),$this->input->post('rfqtqu'),$this->input->post('rfqtuom'),$this->input->post('rfqtreqprice'),$this->input->post('rfqtleadtime'));
if ($this->input->post('rfqactiveme')== "1")
{
$this->rfq_emails_send($this->input->post('rfqemail'),$this->input->post('rfqid'),$this->input->post('rfqtitle'),$this->input->post('rfq_issuedate'),$this->input->post('rfq_closedate'));
$this->send_admin_notify($this->session->userdata('user_id'),$this->input->post('rfqid'),$this->input->post('rfqtitle'),$this->input->post('rfq_issuedate'),$this->input->post('rfq_closedate'),$this->input->post('artgroup'));

}
$this->save_docs($this->input->post('rfqid'));
$targetemail= $this->rfq_model->save_email_list($this->input->post('rfqemail'),$uid);
$u="Location: ".$this->config->base_url()."rfq/rfq_manage";
header($u);

}


public function rfq_bid_submit()
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

//load rfq model
$this->load->model('rfq_model');
// get rfq sender idate
$bsidt=$this->rfq_model->get_rfq_bsid($this->input->post('rfqid'));
$bsid=$bsidt[0]->user_id;
$ebsidt=$this->rfq_model->get_rfq_ebsid($bsidt[0]->user_id);
$ebsid=$ebsidt[0]->user_email;

//insert rfq main
//print_r($_FILES['multipartFilePath']['tmp_name']);

$this->rfq_model->insert_rfqbidmain($this->input->post('rfqid'),$this->input->post('rfqno'),$this->input->post('rfqtitle'),$this->input->post('rfqissuedby'),$this->input->post('rfqcname'),$this->input->post('rfq_issuedate'),$this->input->post('rfq_closedate'),$this->input->post('rfqcimports'),$this->input->post('rfqcexports'), $this->input->post('rfqcurrency'),$this->input->post('rfqqval'),$this->input->post('rfqincoterm'),$this->input->post('rfqpship'),$this->input->post('rfqemail'),$this->input->post('rfqgroup'),$uid,$bsid);
$this->rfq_model->update_rfqbidtable($this->input->post('rfqid'),$this->input->post('rfqtsn'),$this->input->post('rfqtcdesc'),$this->input->post('rfqtspec'),$this->input->post('rfqtdi'),$this->input->post('rfqtqu'),$this->input->post('rfqtuom'),$this->input->post('rfqtreqprice'),$this->input->post('rfqtleadtime'),$this->input->post('isorig'),$uid,$bsid);
$this->save_biddocs($this->input->post('rfqid'),$this->session->userdata("user_id"));
// send email

$this->rfq_bid_emails_send($ebsid,$this->input->post('rfqid'),$this->input->post('rfqtitle'),$this->input->post('rfq_issuedate'),$this->input->post('rfq_closedate'));
$u="Location: ".$this->config->base_url()."rfq/rfq_manage/?view=bidder";
header($u);

}
public function rfq_modify_save()
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
//print_r($_FILES['multipartFilePath']['tmp_name']);
//var_dump($this->input->post('rfqtcdesc'));
//exit;
$this->rfq_model->insert_rfqmain($this->input->post('rfqid'),$this->input->post('rfqno'),$this->input->post('rfqtitle'),$this->input->post('rfqissuedby'),$this->input->post('rfqcname'),$this->input->post('rfq_issuedate'),$this->input->post('rfq_closedate'),$this->input->post('rfqcimports'),$this->input->post('rfqcexports'), $this->input->post('rfqcurrency'),$this->input->post('rfqqval'),$this->input->post('rfqincoterm'),$this->input->post('rfqpship'),$this->input->post('rfqemail'),$this->input->post('artgroup'),$uid,$this->input->post('rfqactiveme'));
$this->rfq_model->update_rfqtable($this->input->post('rfqid'),$this->input->post('rfqtsn'),$this->input->post('rfqtcdesc'),$this->input->post('rfqtspec'),$this->input->post('rfqtdi'),$this->input->post('rfqtqu'),$this->input->post('rfqtuom'),$this->input->post('rfqtreqprice'),$this->input->post('rfqtleadtime'));
$this->save_docs($this->input->post('rfqid'));
if ($this->input->post('rfqactiveme')== "1")
{
$this->rfq_emails_send($this->input->post('rfqemail'),$this->input->post('rfqid'),$this->input->post('rfqtitle'),$this->input->post('rfq_issuedate'),$this->input->post('rfq_closedate'));
$this->send_admin_notify($this->session->userdata('user_id'),$this->input->post('rfqid'),$this->input->post('rfqtitle'),$this->input->post('rfq_issuedate'),$this->input->post('rfq_closedate'),$this->input->post('artgroup'));

}
$u="Location: ".$this->config->base_url()."rfq/rfq_manage";
header($u);
}
public function docs_delete()
{

//load rfq model
$this->load->model('rfq_model');
$this->rfq_model->rfqdocs_delete($this->input->post('docid'));

}
public function save_docs($rfqid="RFQID")
{

if ( !isset($_FILES['multipartFilePath'])) {
	return;
}

if ($_FILES['multipartFilePath'])
 {
 $this->load->model('rfq_model');
 // normalise the array
 $file_post=$_FILES['multipartFilePath'];
  $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
	
$rfqfolder=$this->session->userdata('user_rootfolder')."/RFQ";
$rfqidfolder=$this->session->userdata('user_rootfolder')."/RFQ/".$rfqid;

if (!is_dir($rfqfolder))
{
mkdir($rfqfolder);
}

if (!is_dir($rfqidfolder))
{
mkdir($rfqidfolder);
}


$extensions = array('.png', '.gif', '.jpg', '.jpeg','.PNG', '.GIF', '.JPG', '.JPEG','.DOCX', '.docx','.XLS', '.xls','.XLSX', '.xlsx','.DOCX', '.doc','.PDF', '.pdf','.PPT', '.ppt','.PPTX', '.pptx','.TXT', '.txt');
foreach ($file_ary as $file)
{
$docurl=$this->config->base_url()."tinymce/plugins/moxiemanager/data/files/".$this->session->userdata('user_id')."/"."RFQ/".$rfqid."/";

$extension = strrchr($file['name'], '.');
if (in_array($extension, $extensions))
{
//		print 'File Name: ' . $file['tmp_name'];
//        print 'File Type: ' . $file['type'];
//        print 'File Size: ' . $file['size'];		
move_uploaded_file($file['tmp_name'],$rfqidfolder."/".$file['name']);

$vdocsurl = $docurl .$file['name'];
$this->rfq_model->update_rfqdocs($rfqid,$file['name'],$vdocsurl);		
}
}
}	
}

public function save_biddocs($rfqid="RFQID",$uemail) {

if ($_FILES['multipartFilePath']) {
 $this->load->model('rfq_model');
 // normalise the array
 $file_post=$_FILES['multipartFilePath'];

  $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
	
$rfqfolder=getcwd()."/tinymce/plugins/moxiemanager/data/files/".$uemail."/RFQ";
$rfqidfolder=getcwd()."/tinymce/plugins/moxiemanager/data/files/".$uemail."/RFQ/".$rfqid;
$rfqbidfolder=getcwd()."/tinymce/plugins/moxiemanager/data/files/".$uemail."/RFQ/".$rfqid."/".$this->session->userdata('usernumid');

if (!is_dir($rfqfolder))
{
mkdir($rfqfolder);
}

if (!is_dir($rfqidfolder))
{
mkdir($rfqidfolder);
}

if (!is_dir($rfqbidfolder))
{
mkdir($rfqbidfolder);
}


$extensions = array('.png', '.gif', '.jpg', '.jpeg','.PNG', '.GIF', '.JPG', '.JPEG','.DOCX', '.docx','.XLS', '.xls','.XLSX', '.xlsx','.DOCX', '.doc','.PDF', '.pdf','.PPT', '.ppt','.PPTX', '.pptx','.TXT', '.txt');
foreach ($file_ary as $file)
{
$docurl=$this->config->base_url()."/tinymce/plugins/moxiemanager/data/files/".$uemail."/RFQ/".$rfqid."/".$this->session->userdata('usernumid')."/";

$extension = strrchr($file['name'], '.');
if (in_array($extension, $extensions))
{
//		print 'File Name: ' . $file['tmp_name'];
//        print 'File Type: ' . $file['type'];
//        print 'File Size: ' . $file['size'];		
move_uploaded_file($file['tmp_name'],$rfqbidfolder."/".$file['name']);
$docurl .= $file['name'];
$this->rfq_model->update_rfqbiddocs($rfqid,$file['name'],$docurl,$this->session->userdata('usernumid'));		
}
}
}
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
	$lrfqb=$this->rfq_model->get_rfq_bidbyuid($uid);
	
	$rfqbidsummary=$this->rfq_model->sender_bid_summary($uid);
	
	$lrfqbr=$this->rfq_model->get_rfq_resbyuid($uid);
	
	$abu=$this->ablang->get_abusers();
	$cssarray=array();
	$cssarray[]="http://anthonyterrien.com/js/jquery.knob.js";
	$data['css']=$cssarray;
	
	$data['lrfqb']=$lrfqb;
	$data['lrfqbr']=$lrfqbr;
	
	$data['abuser']=$abu;	
	$data['uodd']=$uod;
	$data['rfqbidsummary']=$rfqbidsummary;
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
	$data['aview']=$this->input->get('view');
	$data['fs']=$fss;
	$this->load->helper('url');
	$this->load->view("header_aw",$data);
	
	$this->load->view("account/rfq_manage",$data);
	$this->load->view("footer");
	
	
	}
	
	
	public function rfq_summary_view()
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
	if ($this->input->get('rfq_id') == "")
	{
	exit;
	}
	
	$rid=$this->input->get('rfq_id');
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
	$lrfqb=$this->rfq_model->get_rfq_bidbyruid($uid,$rid);
	
	//$rfqbidsummary=$this->rfq_model->sender_bid_summary($uid);
	$bidderinfo=$this->rfq_model->sender_bidder_information($rid);
	
	$rfqbidusersummary=$this->rfq_model->sender_bid_summary_view($uid,$rid);
	
	// load RFQ table information
	$rfqt=$this->rfq_model->getrfqbidtableall($rid);
	$rfqtsub=$this->rfq_model->getrfqbidtableallsub($rid);	
    $rfqbd=$this->rfq_model->getrfqbidtable_orgdetails($rid);
	$rfqoc=$this->rfq_model->getrfqbidtable_orgcurrency($rid);
		
	$lrfqbr=$this->rfq_model->get_rfq_bidbyruid($uid,$rid);
	
	$abu=$this->ablang->get_abusers();
	
	$data['lrfqb']=$lrfqb;
	$data['lrfqbr']=$lrfqbr;
	$data['bidderinfo']=$bidderinfo;
	$data['rfqbd']=$rfqbd;
	$data['abuser']=$abu;
	$data['rfqoc']=$rfqoc;
	$data['uodd']=$uod;
	$data['rfqt']=$rfqt;
	$data['rfqtsub']=$rfqtsub;
	$data['rfqbidsummary']=$rfqbidusersummary;
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
	
	$this->load->view("account/rfq_summary_details",$data);
	$this->load->view("footer");
	
	
	}
	public function rfq_bid_details()
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
	$rfqid=$this->input->get('rfqid');
	$bid=$this->session->userdata('usernumid');
	if ($rfqid=="" or $bid=="")
	{
	exit;
	}
	$this->load->model('ablang');
	$this->load->model('account_model');
	$uid=$this->session->userdata('usernumid');
	$uod=$this->account_model->account_options($uid);	
	$subs=$this->account_model->subs_options($uid);
     	
	$issub=$this->account_model->is_subs_options($uid);	
	$add=$this->account_model->get_account_details($uid);
	
	$biduser=$this->account_model->get_account_details($bid);
	
	$abu=$this->ablang->get_abusers();
	$data['abuser']=$abu;	
	$data['biduser']=$biduser;	
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
	
	//load rfq model
	$this->load->model('rfq_model');
	//load RFQ main information
	$aued=$this->rfq_model->get_user_emails($uid);
	
	$rfqm=$this->rfq_model->getrfqbidmain($rfqid,$bid);
	
	// load RFQ table information
	$rfqt=$this->rfq_model->getrfqbidtable($rfqid,$bid);
	//load RFQ docs information
	$rfqd=$this->rfq_model->getrfqbiddocs($rfqid,$bid);
	
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");	
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"basic_account,rfq_page");
	
	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;
	$data['uemaildata']=$aued;
	$data['rfqm']=$rfqm;
	$data['rfqt']=$rfqt;
	$data['rfqd']=$rfqd;
	$data['RFQGUID']=$rfqid;
	$data['user_id_info']=$this->session->userdata('usernumid');
	$data['freemodules']=$this->account_model->get_free_modules($this->session->userdata('usernumid'));
	//$data['user_udhapri']=$udhapri;
	//$data['user_udhasec']=$udhasec;
	
	$data['fs']=$fss;
	$this->load->helper('url');
	$this->load->view("header_aw",$data);	
	$this->load->view("account/rfq_bid_details",$data);
	$this->load->view("footer");
	
	}
	public function rfq_bid_info()
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
	$this->load->model('urldetect_model');
	$usid=$this->urldetect_model->get_uid();
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$mod="RFQ";
	
	$this->session->set_userdata('vplink', true);
	$this->session->set_userdata('vlink',$actual_link);
	$this->session->set_userdata('vpusid',$usid);
	$this->session->set_userdata('vmod',$mod);
	$this->load->helper('url');
	$this->load->view("redirect");	
	return;
	}
	// load the language module
	$rfqid=$this->input->get('rfqid');
	$bid=$this->input->get('user_bid_id');
	if ($rfqid=="" or $bid=="")
	{
	exit;
	}
	$this->load->model('ablang');
	$this->load->model('account_model');
	$uid=$this->session->userdata('usernumid');
	$uod=$this->account_model->account_options($uid);	
	$subs=$this->account_model->subs_options($uid);
     	
	$issub=$this->account_model->is_subs_options($uid);	
	$add=$this->account_model->get_account_details($uid);
	
	$biduser=$this->account_model->get_account_details($bid);
	
	$abu=$this->ablang->get_abusers();
	$data['abuser']=$abu;	
	$data['biduser']=$biduser;	
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
	
	//load rfq model
	$this->load->model('rfq_model');
	//load RFQ main information
	$aued=$this->rfq_model->get_user_emails($uid);
	
	$rfqm=$this->rfq_model->getrfqbidmain($rfqid,$bid);
	
	// load RFQ table information
	$rfqt=$this->rfq_model->getrfqbidtable($rfqid,$bid);
	//load RFQ docs information
	$rfqd=$this->rfq_model->getrfqbiddocs($rfqid,$bid);
	
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");	
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"basic_account,rfq_page");
	
	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;
	$data['uemaildata']=$aued;
	$data['rfqm']=$rfqm;
	$data['rfqt']=$rfqt;
	$data['rfqd']=$rfqd;
	$data['RFQGUID']=$rfqid;
	$data['user_id_info']=$this->session->userdata('usernumid');
	$data['freemodules']=$this->account_model->get_free_modules($this->session->userdata('usernumid'));
	//$data['user_udhapri']=$udhapri;
	//$data['user_udhasec']=$udhasec;
	
	$data['fs']=$fss;
	$this->load->helper('url');
	$this->load->view("header_aw",$data);	
	$this->load->view("account/rfq_bid_info",$data);
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
	$this->load->model('urldetect_model');
	$usid=$this->urldetect_model->get_uid();
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$mod="RFQ";
	
	$this->session->set_userdata('vplink', true);
	$this->session->set_userdata('vlink',$actual_link);
	$this->session->set_userdata('vpusid',$usid);
	$this->session->set_userdata('vmod',$mod);	
	$this->load->helper('url');
	$this->load->view("redirect");	
	return;
	}
	// load the language module
	$rfqid=$this->input->get('rfqid');
	if ($rfqid=="")
	{
	exit;
	}
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
	
	//load rfq model
	$this->load->model('rfq_model');
	//load RFQ main information
	$aued=$this->rfq_model->get_user_emails($uid);
	
	$rfqm=$this->rfq_model->getrfqmain($rfqid);
	if ( count($rfqm) < 1 )
	{
	echo "This RFQ ID does not exist in our system, Sorry.";
	exit;
	}
	
	// load RFQ table information
	$rfqt=$this->rfq_model->getrfqtable($rfqid);
	//load RFQ docs information
	$rfqd=$this->rfq_model->getrfqdocs($rfqid);
	
	$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");	
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"basic_account,rfq_page");
	
	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;
	$data['uemaildata']=$aued;
	$data['rfqm']=$rfqm;
	$data['rfqt']=$rfqt;
	$data['rfqd']=$rfqd;
	$data['RFQGUID']=$rfqid;
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
	
	public function rfq_authemails_send($articleto_email="",$rfqid,$rfqtitle,$issuedate="",$closedate="")
	{
	if ($articleto_email =="")
	{
	return;
	}
	$rfqsender = $this->session->userdata('user_id');
	
	if ($this->session->userdata('signedinuser')== true)
	{
	$ulogged=true;
	}
	else
	{
	}
	$artid="";
	$user_id="";
	$this->load->helper('url');	
	$articleto_email=str_replace(" ","",$articleto_email);
	if (strlen($articleto_email) > 5)
	{
	$artdata=explode(";",trim($articleto_email));
	}
	$config['protocol'] = 'sendmail';
	$config['wordwrap'] = TRUE;
	$config['validate'] = TRUE;
	$config['mailtype'] = "html";            
	$config['charset'] = "UTF-8";
	$config['mailpath'] = "/usr/sbin/sendmail -t -i";
	$config['smtp_host'] = "relay-hosting.secureserver.net";
	$config['smtp_user'] = '';
	$config['smtp_pass'] = '';
    $fedata=array();
   foreach($artdata as &$value)
   {
   if (filter_var($value, FILTER_VALIDATE_EMAIL)) 
   {
	$feddata[]=$value;
   }
   }
   if (count($feddata)> 0)
   {}
   else
   {
   //echo "No valid emails";
   //exit;
   }
   
   $rfqsenderbody="";
   $data=array();
   $footer='';
   $data['body']=""; 
   $data['sender']=$rfqsender;
   $data['rfq_id']=$rfqid;
   $data['rfq_title']=$rfqtitle;
   $data['rfq_idate']=$issuedate;
   $data['rfq_cdate']=$closedate;
   
   foreach($feddata as &$v)
   {
   try
   {
   $this->load->library( 'email' ,$config);   
   $this->email->from( 'news@abrasivesworld.com', 'Abrasivesworld' );
   $this->email->to($v);
   $this->email->cc($rfqsender);
   $this->email->subject("Abrasivesworld Bidding Information: ".$rfqtitle);   
   $this->email->message($this->load->view('template/rfq_send', $data, true ));  
   $this->email->send();   
   // log the transaction
   //$this->article_model->email_sentbox($rfqid,$v,"","Abrasivesworld Bidding Information: ".$rfqtitle);
   //echo $this->email->print_debugger();
   }
   catch(Exception $err)
   {
   
   }
   }
	
	
	}

	public function rfq_emails_send($articleto_email="",$rfqid,$rfqtitle,$issuedate="",$closedate="")
	{
	if ($articleto_email =="")
	{
	return;
	}
	$rfqsender = $this->session->userdata('user_id');
	
	if ($this->session->userdata('signedinuser')== true)
	{
	$ulogged=true;
	}
	else
	{
	}
	$artid="";
	$user_id="";
	$this->load->helper('url');	
	$articleto_email=str_replace(" ","",$articleto_email);
	if (strlen($articleto_email) > 5)
	{
	$artdata=explode(",",trim($articleto_email));
	}
	$config['protocol'] = 'sendmail';
	$config['wordwrap'] = TRUE;
	$config['validate'] = TRUE;
	$config['mailtype'] = "html";            
	$config['charset'] = "UTF-8";
	$config['mailpath'] = "/usr/sbin/sendmail -t -i";
	$config['smtp_host'] = "relay-hosting.secureserver.net";
	$config['smtp_user'] = '';
	$config['smtp_pass'] = '';
    $fedata=array();
   foreach($artdata as &$value)
   {
   if (filter_var($value, FILTER_VALIDATE_EMAIL)) 
   {
	$feddata[]=$value;
   }
   }
   if (count($feddata)> 0)
   {}
   else
   {
   //echo "No valid emails";
   //exit;
   }
   
   $rfqsenderbody="";
   $data=array();
   $footer='';
   $data['body']=""; 
   $data['sender']=$rfqsender;
   $data['rfq_id']=$rfqid;
   $data['rfq_title']=$rfqtitle;
   $data['rfq_idate']=$issuedate;
   $data['rfq_cdate']=$closedate;
   
   foreach($feddata as &$v)
   {
   try
   {
   $this->load->library( 'email' ,$config);   
   $this->email->from( 'news@abrasivesworld.com', 'Abrasivesworld' );
   $this->email->to($v);
   $this->email->cc($rfqsender);
   $this->email->subject("Abrasivesworld Bidding Information: ".$rfqtitle);   
   $this->email->message($this->load->view('template/rfq_send', $data, true ));  
   $this->email->send();   
   // log the transaction
   //$this->article_model->email_sentbox($rfqid,$v,"","Abrasivesworld Bidding Information: ".$rfqtitle);
   //echo $this->email->print_debugger();
   }
   catch(Exception $err)
   {
   
   }
   }
	
	
	}

	
	public function rfq_bid_emails_send($articleto_email="",$rfqid,$rfqtitle,$issuedate="",$closedate="")
	{
	
	$rfqsender = $this->session->userdata('user_id');
	$rfqsenderid = $this->session->userdata('usernumid');
	if ($this->session->userdata('signedinuser')== true)
	{
	$ulogged=true;
	}
	else
	{
	return;
	}
	$artid="";
	$user_id="";
	$this->load->helper('url');	
	
	$config['protocol'] = 'sendmail';
	$config['wordwrap'] = TRUE;
	$config['validate'] = TRUE;
	$config['mailtype'] = "html";            
	$config['charset'] = "UTF-8";
	$config['mailpath'] = "/usr/sbin/sendmail -t -i";
	$config['smtp_host'] = "relay-hosting.secureserver.net";
	$config['smtp_user'] = '';
	$config['smtp_pass'] = '';
   
   $rfqsenderbody="";
   $data=array();
   $footer='';
   $data['body']=""; 
   $data['sender']=$articleto_email;
   $data['rfq_id']=$rfqid;
   $data['rfq_bid_id']=$rfqsenderid;
   $data['rfq_title']=$rfqtitle;
   $data['rfq_idate']=$issuedate;
   $data['rfq_cdate']=$closedate;
   
   
   try
   {
   $this->load->library( 'email' ,$config);   
   $this->email->from( 'news@abrasivesworld.com', 'Abrasivesworld' );
   $this->email->to($articleto_email);
  // $this->email->cc($rfqsender);
   $this->email->subject("Abrasivesworld Bidding Information: ".$rfqtitle);   
   $this->email->message($this->load->view('template/rfq_bid_response', $data, true ));  
   $this->email->send();   
   // log the transaction
   //$this->article_model->email_sentbox($rfqid,$v,"","Abrasivesworld Bidding Information: ".$rfqtitle);
   //echo $this->email->print_debugger();
   }
   catch(Exception $err)
   {   
   }
   
	
	
	}
}