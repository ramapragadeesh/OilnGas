<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class payment extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}
	public function free_modules() {
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model("debug_log");
		if (!isset($this->session->userdata))
		{
			$this->session->set_userdata('default_language', 'en');
		}
		$data = array();
		if ($this->session->userdata('signedinuser')== true)
		{
		// load the language module

		}
		else
		{
			exit;
		}
		$sub_allowemails=$this->input->post("sub_allowemails");
		$sub_searchprefer=$this->input->post("sub_searchprefer");
		$sub_uniquelink=$this->input->post("sub_uniquelink");

		$module="";
		$i=0;
		for($i=0;$i < 3;$i++)
		{
			if ($i==0)
			{
				if ( $sub_allowemails=="yes")
				{
					$module=":sub_allowemails";
				}
			}

			if ($i==1)
			{
				if ( $sub_searchprefer=="yes")
				{
					$module .=":sub_searchprefer";
				}
			}
			if ($i==2)
			{
				if ( $sub_uniquelink=="yes")
				{
					$module .=":sub_uniquelink";
				}
			}

		}

		$this->load->model("payment_model");
		$uid=$this->session->userdata('usernumid');

		$this->payment_model->insert_freemodule($uid,$module);



	}

	public function coupon_verify()
	{

		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model("debug_log");
		if (!isset($this->session->userdata))
		{
			$this->session->set_userdata('default_language', 'en');
		}
		$data = array();
		if ($this->session->userdata('signedinuser')== true)
		{
		// load the language module

		}
		else
		{
			exit;
		}

		$cid=$_POST['coupon_id'];
		if ($cid=="")
		{
			$couponInfo = array(
				"couponError" => "Coupon ID is not set",
				"couponType" => 3,
				"couponData" => ""
				);
				echo json_encode($couponInfo); // sales coupon
				exit;
			}
			$this->load->model("payment_model");
			$user_id=$this->session->userdata('usernumid');

			if ($this->payment_model->check_cid($cid)==true) {
				// activate the subscription
				// check if the user already used the coupon
				if ($this->payment_model->isSalesCoupon($cid) == true) {
					$couponInfo = array(
						"couponError" => "Valid Sales Coupon",
						"couponType" => 110,
						"couponData" => $this->payment_model->getCouponData($cid)
						);
				echo json_encode($couponInfo); // sales coupon
				exit;
			} else if ($this->payment_model->used_coupon($cid,$user_id) == true) {
				$couponInfo = array(
					"couponError" => "Used Coupon",
					"couponType" => 100,
					"couponData" => ""
					);
				echo json_encode($couponInfo);
				exit;
			}
			$module=$this->payment_model->coupon_details_module($cid);
			$payment=0;
			$subs_detail="Coupon Activated";

			$txn_id=$this->payment_model->GUID();
			$this->payment_model->insert_coupon_data($cid,$module,$user_id,$payment,$subs_detail,$txn_id);
			$this->payment_model->insert_used_coupon($cid,$user_id);
			$this->debug_log->log_me($user_id,"Coupon service is activated");
			$couponInfo = array(
				"couponError" => "Normal coupon is activated",
				"couponType" => 1,
				"couponData" => ""
				);
			echo json_encode($couponInfo);
			exit;
		} else {
			$couponInfo = array(
				"couponError" => "Unknown error",
				"couponType" => 2,
				"couponData" => ""
				);
			echo json_encode($couponInfo);
			exit;			
		}


	}
	public function payment_verify()
	{

		$this->load->library('session');
		$this->load->helper('url');
		if (!isset($this->session->userdata))
		{
			$this->session->set_userdata('default_language', 'en');
		}
		$data = array();
		if ($this->session->userdata('signedinuser')== true) {
		// load the language module
		} else {
			exit;
		}

		$txnid=$_POST['txn_id'];
		if ($txnid=="") {
			echo 3;
			exit;
		}

		$this->load->model("payment_model");
		if ($this->payment_model->is_paid($txnid)==true) {
			echo 1;
			exit;
		} else {
			echo 2;
			exit;
		}
	}
	public function payment_auth() {

		$this->load->library('session');
		$this->load->helper('url');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$data = array();
		$ulogged = false;
		$uname   = "guest";
		// load the language module		
		$this->load->model('ablang');
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
			$uname   = $this->session->userdata('user_name');
		} else {
			exit;
		}

		$data['ulogset']      = $ulogged;
		$data['usernamesses'] = $uname;
		//header Language Model
		$ldh = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$paymentLanguage = $this->ablang->get_infoarray($this->session->userdata('default_language'), "payment");
		$data['paymentLanguage'] = $paymentLanguage;
		$data['infoheader_holder'] = $ldh;
		$data['txn_id']=$_POST['txn_id'];
		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view("account/pay_verify",$data);
		$this->load->view("footer");

	}

	public function payment_update()
	{
		$this->load->model("payment_model");
	   // Response from Paypal
    // read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
        $req .= "&$key=$value";
    }
    $verification=false;
    $this->payment_model->log_paypal("reached",$req);
    // assign posted variables to local variables
    $data['item_name']          = $_POST['item_name'];
    $data['item_number']        = $_POST['item_number'];
    $data['first_name']         = $_POST['first_name'];
    $data['org_name']        	= $_POST['address_name'];
    $data['org_address']        = $_POST['address_street'];
    $data['payment_status']     = $_POST['payment_status'];
    $data['payment_amount']     = $_POST['mc_gross'];
    $data['payment_currency']   = $_POST['mc_currency'];
    $data['txn_id']             = $_POST['txn_id'];
    $data['receiver_email']     = $_POST['receiver_email'];
    $data['payer_email']        = $_POST['payer_email'];
    $data['custom']         = $_POST['custom'];
    $data['invoice']            = $_POST['invoice'];
    $data['paypallog']          = $req;
   // get the user id
    $ex=explode("ZZ",$_POST['custom']);
    $salesCoupon = "";

    if (count($ex) >= 2)
    {
    	$data['user_id'] = $ex[1];
    	$data['subsmodule'] = $ex[0];

    	if (count($ex) >= 3) {
    		$salesCoupon = $ex[2];
    	}
    }
	// insert the paypal request if not exist
    $this->payment_model->log_paypal("reached","insert");
    if ($this->payment_model->check_txnid($data['txn_id']) == false )     {
    	$this->payment_model->log_paypal("reached","inserted".$data['user_id']);
    	$this->payment_model->insert_paypal_request($data['user_id'],$data['txn_id'],0,$data['payer_email'],$data['org_name']." - ".$data['org_address'],$data['subsmodule'],$data['payment_amount'],"Initial request");

    } else {
    	$this->payment_model->log_paypal("reached","not inserted");
    }


    // post back to PayPal system to validate
    $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
    $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
    $verification=false;
    if (!$fp) {
        // HTTP ERROR
    } else {


    	fputs ($fp, $header . $req);
    	while (!feof($fp)) {

    		$res = fgets ($fp, 1024);
    		if (true || strcmp($res, "VERIFIED") == 0)
    		{
    			$verification = true;

    		} elseif ($res=='INVALID') {



    		}
    	}
    	fclose ($fp);
    }

    if ($verification == true)
    {
    	$this->payment_model->log_paypal("reached","verified".$data['user_id']);
    	$pd=$this->payment_model->get_subs_options();
    	$sdt=explode(":",$data['subsmodule']);
    	$sd=array();
    	foreach($sdt as &$value) {
    		$sd[$value]="yes";
    		$this->payment_model->log_paypal("reached","pmodel".$data['user_id'].$sd[$value]);
    	} 

    	if ($this->payment_model->check_txnid($data['txn_id']) == true and $this->payment_model->check_price($pd,$sd,$data['payment_amount'],$salesCoupon)==true) {
    		$this->payment_model->log_paypal("reached","txn verified".$data['user_id']);
    		$this->payment_model->update_paypal_data($data['txn_id'],1);
    	} else {
    		$this->payment_model->log_paypal("reached","txn not verified".$data['user_id']);
    	}
    } else  {

    }

}

public function summary_show() {
	$this->load->library('session');
	$this->load->helper('url');
	if (!isset($this->session->userdata))
	{
		$this->session->set_userdata('default_language', 'en');
	}
	$data = array();
	if ($this->session->userdata('signedinuser')== true)
	{
		// load the language module

	}
	else
	{
		exit;
	}
	$uid=$this->session->userdata('usernumid');
	$sub_searchprefer="no";
	$sub_allowemails="no";
	$sub_onceweekly="no";
	$sub_imageupload="no";
	$sub_videoupload="no";
	$sub_uniquelink="no";
	$salesCoupon = "no";

	$sub_searchprefer=$this->input->post("sub_searchprefer");

	$sub_allowemails=$this->input->post("sub_allowemails");
	$sub_onceweekly=$this->input->post("sub_onceweekly");
	$sub_imageupload=$this->input->post("sub_imageupload");
	$sub_videoupload=$this->input->post("sub_videoupload");
	$sub_uniquelink=$this->input->post("sub_uniquelink");

	$subsdata=array();

	$subsdata['sub_searchprefer']=$sub_searchprefer;
	$subsdata['sub_allowemails']=$sub_allowemails;
	$subsdata['sub_onceweekly']=$sub_onceweekly;
	$subsdata['sub_imageupload']=$sub_imageupload;
	$subsdata['sub_videoupload']=$sub_videoupload;

	$subsdata['sub_uniquelink']=$sub_uniquelink;

	$this->load->model('ablang');
	$this->load->model('payment_model');
	$this->load->model('account_model');
	$data['udata']=$this->account_model->get_account_details($uid);
	$data['pdata']=$this->payment_model->get_subs_options();
	$data['sdata']=$subsdata;
	$uid=$this->session->userdata('usernumid');

	$submd=$this->get_subs_module($data['sdata']);
	$data['subm']=$submd;
	$this->session->set_userdata('subm',$submd);
	//$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"profile");
	$data['info_holder']=$ld;
	$data['salesCoupon'] = $salesCoupon;
	//$data['infoheader_holder']=$ldh;
	$this->load->view("account/subs_sum",$data);
}


public function sales_coupon_show() {
	$this->load->library('session');
	$this->load->helper('url');
	if (!isset($this->session->userdata)) {
		$this->session->set_userdata('default_language', 'en');
	}
	$data = array();
	if ($this->session->userdata('signedinuser')== true) {
		// load the language module
	} else {
		exit;
	}

	$uid=$this->session->userdata('usernumid');
	$sub_searchprefer="no";
	$sub_allowemails="no";
	$sub_onceweekly="no";
	$sub_imageupload="no";
	$sub_videoupload="no";
	$sub_uniquelink="no";
	$modules = explode(":",$this->input->post("coupon_type"));
	foreach ($modules as $key => $value) {
		if ($value == "sub_onceweekly"){
			$sub_onceweekly = "yes";
		} else if ($value == "sub_imageupload") {
			$sub_imageupload = "yes";

		} else if ($value == "sub_videoupload") {
			$sub_videoupload = "yes";

		}
	}


	$subsdata=array();

	$subsdata['sub_searchprefer']=$sub_searchprefer;
	$subsdata['sub_allowemails']=$sub_allowemails;
	$subsdata['sub_onceweekly']=$sub_onceweekly;
	$subsdata['sub_imageupload']=$sub_imageupload;
	$subsdata['sub_videoupload']=$sub_videoupload;

	$subsdata['sub_uniquelink']=$sub_uniquelink;

	$this->load->model('ablang');
	$this->load->model('payment_model');
	$this->load->model('account_model');
	$data['udata']=$this->account_model->get_account_details($uid);
	$data['pdata']=$this->payment_model->get_subs_options();
	$data['sdata']=$subsdata;
	$uid=$this->session->userdata('usernumid');

	$submd=$this->get_subs_module($data['sdata']);
	$data['subm']=$submd;
	$this->session->set_userdata('subm',$submd);
	//$ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"profile");
	$data['info_holder']=$ld;
	$data['salesCoupon'] = "yes";
	$data['salesPrice'] = $this->input->post("coupon_percentage");
	$data['couponCode'] = $this->input->post("coupon_id");
	//$data['infoheader_holder']=$ldh;
	$this->load->view("account/sales_offer",$data);
}

public function get_subs_module($sd)
{
	$subm="";
	if( $sd['sub_searchprefer'] == "yes")
	{
		$subm .="sub_searchprefer:";
	}
	if( $sd['sub_allowemails'] == "yes")
	{
		$subm .="sub_allowemails:";
	}
	if($sd['sub_onceweekly'] == "yes")
	{
		$subm .="sub_onceweekly:";
	}

	if($sd['sub_imageupload'] == "yes")
	{
		$subm .="sub_imageupload:";
	}

	if($sd['sub_videoupload'] == "yes")
	{
		$subm .="sub_videoupload";
	}
	return $subm;
}

}
?>