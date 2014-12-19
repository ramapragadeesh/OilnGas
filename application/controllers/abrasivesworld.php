<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class abrasivesworld extends CI_Controller {

	/**
	 * Index Page for this controller.
	**/

	public function __construct()
	{
		parent::__construct();

	}
	public function about_us()
	{
		$this->load->library('session');
		if (!isset($this->session->userdata))
		{
			$this->session->set_userdata('default_language', 'en');
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
		$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"about_us");
		$data['info_holder']=$ld;
		$data['infoheader_holder']=$ldh;
		$data['ulang']=$this->session->userdata('default_language');
		$this->load->helper('url');
		$this->load->view("header_aw",$data);
		$this->load->view("about_us/aboutus",$data);
		$this->load->view("footer");
	}

	public function members()
	{
		$this->load->library('session');
		if (!isset($this->session->userdata))
		{
			$this->session->set_userdata('default_language', 'en');
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
		$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"member");

		$data['info_holder']=$ld;
		$data['infoheader_holder']=$ldh;
		$data['ulang']=$this->session->userdata('default_language');
		$this->load->helper('url');
		$this->load->view("header_aw",$data);

		$this->load->view("member/member",$data);
		$this->load->view("footer");
	}
	public function news()
	{
		$this->load->library('session');
		if (!isset($this->session->userdata))
		{
			$this->session->set_userdata('default_language', 'en');
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
		$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"news");

		$data['info_holder']=$ld;
		$data['infoheader_holder']=$ldh;
		$data['ulang']=$this->session->userdata('default_language');
		$this->load->helper('url');
		$this->load->view("header_aw",$data);

		$this->load->view("member/news",$data);
		$this->load->view("footer");
	}
	public function member_contact() {
		   $email_config = Array(
        'mailtype'  => 'html',
        'starttls'  => true,
      	'charset' => 'UTF-8',
        'newline'   => "\r\n"
    	);

		$this->load->library('email', $email_config);
		$this->load->model('ab/ab_model');
		$this->email->from('support@abrasivesworld.com');
		$this->email->to(trim($this->input->post("receiverEmail")));
		$this->email->bcc('support@abrasivesworld.com');
		$this->email->subject("Enquiry from ".$this->input->post("senderCompany") . " using abrasivesworld.com");
		$this->email->set_mailtype("html");
		$body = "<p> <b>Name </b>:".$this->input->post("senderName")."</p>";
		$body .= "<p> <b>Email Address</b>:".trim($this->input->post("senderEmail"))."</p>";
		$body .= "<p> <b>Organazation Name</b>:".$this->input->post("senderCompany")."</p>";
		$body .= "<p> <b>Contact No </b>:".$this->input->post("senderTelephone")."</p>";
		$body .= "<p> <b>Country </b>:".$this->input->post("senderCountry")."</p>";
		$body .= "<p><b>Message</b></p><p>" .$this->input->post("senderMessage"). "</p>";
		$data['body'] = $body;
		$email = $this->load->view('template/email_member', $data, TRUE);
		$this->email->message($email);
		$this->email->send();
		$this->ab_model->save_query($this->input->post("senderName"),"",$this->input->post("senderEmail"),'Member Contact form submitted',$this->input->post("senderMessage"));

	}
		public function article_sharing() {
		   $email_config = Array(
        'mailtype'  => 'html',
        'starttls'  => true,
      	'charset' => 'UTF-8',
        'newline'   => "\r\n"
    	);

		$this->load->library('email', $email_config);
		$this->load->model('ab/ab_model');
		$this->load->model('article_model');
		$this->load->helper('url');
		$articleData  = $this->article_model->get_article_details(trim($this->input->post('articleID')));

		$this->email->from('news@abrasivesworld.com');
		$this->email->to(trim($this->input->post("senderEmail")));
		$this->email->bcc('sales@abrasivesworld.com');
		$this->email->subject($articleData[0]->article_title);
		$this->email->set_mailtype("html");
		$body = "";
		$data['senderName'] = $this->input->post("senderName");
		
		$body .= $articleData[0]->article_details;
		$data['body'] = $body;
		$data['title'] = $articleData[0]->article_title;
		$data['articleID'] = trim($this->input->post('articleID'));
		$email = $this->load->view('template/article_sharing', $data, TRUE);
		$this->email->message($email);
		$this->email->send();
		$this->ab_model->save_query($this->input->post("senderName"),"",$this->input->post("senderEmail"),'Sharing Article form submitted',"");

	}
	public function contact_us_save()
	{
		$this->load->library('session');
		if (!isset($this->session->userdata))
		{
			$this->session->set_userdata('default_language', 'en');
		}
		$this->load->helper('url');

		$fname=$this->input->post("fname");
		$lname=$this->input->post("lname");
		$email=$this->input->post("emailaddress");
		$subject=$this->input->post("subject");
		$message=$this->input->post("message");
		$gmessage="";
		$gcontent="";
		$charset = 'UTF-8';
		$length = 450;
		$ecat=0;
		if(mb_strlen($fname, $charset) > $length) {
			$fname = mb_substr($fname, 0, $length, $charset) . '...';
		}

		if(mb_strlen($lname, $charset) > $length) {
			$lname = mb_substr($lname, 0, $length, $charset) . '...';
		}

		if(mb_strlen($subject, $charset) > $length ) {
			$subject = mb_substr($subject, 0, $length, $charset) . '...';
		}

		$this->load->model('ab/ab_model');


		// send email as well

		$this->load->library('email');
		if ($subject == "misuse") {
			$this->email->from($email);
			$this->email->to('reportmisuse@abrasivesworld.com');
		} else if ($subject == "service") {
			$this->email->from($email);
			$this->email->to('enquiry@abrasivesworld.com');
		} else if ($subject == "suggestions") {
			$this->email->from($email);
			$this->email->to('enquiry@abrasivesworld.com');
		} else if ($subject == "endorser")
		{
			if ($this->session->userdata('signedinuser')== true)
			{
				$ecat=1;
				$this->email->from($email);
				$this->email->to('enquiry@abrasivesworld.com');
				$ud=$this->ab_model->company_info($this->session->userdata('usernumid'));
				$gmessage .="<p><b>Organazation Name </b> : ".$ud['user_orgname']."</p>";
				$gmessage .="<p><b>Name</b> : ".$ud['user_name']."</p>";
				$gmessage .="<p><b>Country </b> : ".$ud['user_country']."</p>";
				$gmessage .="<p><b>Contact No </b> : ".$ud['user_contactno']."</p>";
				$gmessage .="<p><b>Message from the AW user : </b>".$message."</p>";
				$message .="</br></br> By AW Admin";
			}
		} else if ($subject == "advertiser") {
			if ($this->session->userdata('signedinuser')== true) {
				$ecat=2;
				$this->email->from($email);
				$this->email->to('enquiry@abrasivesworld.com');
				$ud=$this->ab_model->company_info($this->session->userdata('usernumid'));
				$gmessage .="<p><b>Organazation Name </b> : ".$ud['user_orgname']."</p>";
				$gmessage .="<p><b>Name</b> : ".$ud['user_name']."</p>";
				$gmessage .="<p><b>Country </b> : ".$ud['user_country']."</p>";
				$gmessage .="<p><b>Contact No </b> : ".$ud['user_contactno']."</p>";
				$gmessage .="<p><b>Message from the AW user : </b>".$message."</p>";
				$message .="</br></br> By AW Admin";
			}
		} else 	{
			if ($email != "") {
			$this->email->from($email);
			$this->email->to('support@abrasivesworld.com');

			} else {

			$this->email->from( 'support@abrasivesworld.com');
			$this->email->to('support@abrasivesworld.com');

			}
		}

	if ( $ecat== 1) {
	//update_end_info
		$this->email->subject('Endorser form submitted');
		$this->email->set_mailtype("html");
		$edata="<html><body><div><p>".$gmessage."</p></div></body></html>";
		$this->email->message($edata);
		$this->ab_model->update_end_info($this->session->userdata('usernumid'));
		$this->email->send();
		$this->ab_model->save_query($fname,$lname,$email,'Endorser form submitted',$gmessage);
		echo "2";
	} else if ( $ecat== 2) {
    //update_end_info
		$this->email->subject('Advertiser form submitted');
		$this->email->set_mailtype("html");
		$edata="<html><body><div><p>".$gmessage."</p></div></body></html>";
		$this->email->message($edata);
		$this->ab_model->update_end_info($this->session->userdata('usernumid'));
		$this->email->send();
		$this->ab_model->save_query($fname,$lname,$email,'Advertiser form submitted',$gmessage);
		echo "2";
	} else {
		$this->email->subject('Contact form submitted');
		$this->email->set_mailtype("html");
		$edata="<html><body><div><p>".$message."</p></div></body></html>";
		$this->email->message($edata);
		$this->email->send();
		$this->ab_model->save_query($fname,$lname,$email,$subject,$message);
		echo "1";
	}
}
public function contact_us()
{
	$this->load->library('session');
	if (!isset($this->session->userdata))
	{
		$this->session->set_userdata('default_language', 'en');
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
	$ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"contact_us");

	$data['info_holder']=$ld;
	$data['infoheader_holder']=$ldh;
	$data['ulang']=$this->session->userdata('default_language');
	$this->load->helper('url');
	$this->load->view("header_aw",$data);

	$this->load->view("ab/contactus",$data);
	$this->load->view("footer");
}
}
?>