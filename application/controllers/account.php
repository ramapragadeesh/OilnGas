<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class account extends CI_Controller {

	public function fix() {
		$this->load->model('account_model');
		$q = $this->account_model->getAllUsers();

		foreach ($q as $value) {
			if (file_exists("/home/content/64/11453264/html/tinymce/plugins/moxiemanager/data/files/".trim($value->user_email)) == false) {
				echo $value->user_email."\n";
				mkdir("/home/content/64/11453264/html/tinymce/plugins/moxiemanager/data/files/".trim($value->user_email));
				echo "/home/content/64/11453264/html/tinymce/plugins/moxiemanager/data/files/".trim($value->user_email);
			}

		}

	}

	public function deleteDir($dir) {
		if (substr($dir, strlen($dir)-1, 1) != '/') {
			$dir .= '/';
		}

		echo $dir;

		if ($handle = opendir($dir)) {
			while ($obj = readdir($handle)) {
				if ($obj != '.' && $obj != '..') {
					if (is_dir($dir.$obj)) {
						if (!deleteDir($dir.$obj)) {
							return false;
						}
					} elseif (is_file($dir.$obj)) {
						if (!unlink($dir.$obj)) {
							return false;
						}
					}
				}
			}

			closedir($handle);

			if (!@rmdir($dir)) {
				return false;
			}

			return true;
		}
		return false;
	}

	public function recover_password() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$data = array();

		$email      = $this->input->post('remailid');
		$data['ed'] = $email;
		$this->load->model('ablang');
		$ld                 = $this->ablang->get_infoarray($this->session->userdata('default_language'), "error");
		$data['infoholder'] = $ld;

		if ($email != "") {
			$this->load->model('account_model');
			$q = $this->account_model->get_account_password($email);

			if (isset($q[0]->user_password) == true and $q[0]->user_password != "") {
				$this->load->helper('url');
				$this->load->library('email');
				$this->email->from('support@abrasivesworld.com');
				$this->email->to($email);
				$this->email->subject('AbrasivesWorld Password Recovery');
				$data['pwdr'] = $q[0]->user_password;
				$this->email->set_mailtype("html");
				$this->email->message($this->load->view('account/password_rec', $data, true));
				$this->email->send();
				$data['info'] = 'We have sent your password to your email address';
				$this->load->view('account/error_successful', $data);
			} else {
				$data['info'] = 'Invalid Email';
				$this->load->view('account/error_successful', $data);

			}
		} else {
			$data['info'] = 'Invalid Email';
			$this->load->view('account/error_successful', $data);

		}
	}

	public function confirm_change_password() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		$oldpass        = $this->input->post('oldpass');
		$newpass        = $this->input->post('newpass');
		$newpassconfirm = $this->input->post('newpassconfirm');
		$dv             = true;
		$error          = array();
		$data           = array();
		if ($this->session->userdata('signedinuser') == true) {
			// load the language module
			$this->load->model('ablang');
			$uid = $this->session->userdata('usernumid');
			// load the language module
			$this->load->model('account/newaccountcreation');
			if ($this->newaccountcreation->old_password_correct($oldpass, $uid) == false) {
				$error[] = "Old password is incorrect";

				$dv = false;
			}
			if ($newpassconfirm != $newpass) {
				$error[] = "new password and confirm new password did not match.";
				$dv      = false;
			}
			if (strlen($newpass) <= 4) {
				$error[] = "Password length has to be atleast 5 chracters or letters.";
				$dv      = false;
			}
			$data['isvalid']   = $dv;
			$data['errordata'] = $error;
			$ld                = $this->ablang->get_infoarray($this->session->userdata('default_language'), "change_password");
			$data['ldata']     = $ld;
			$this->load->view("account/confirm_change_password", $data);

		} else {
			exit;
		}

	}
	public function save_picture() {
		$this->load->helper(array('form', 'url'));
		$config['upload_path']   = $this->session->userdata('user_rootfolder')."/";
		$config['allowed_types'] = 'gif|jpg|png|PNG|JPEG|GIF|JPG|';
		$config['max_size']      = '5000';
		$config['max_width']     = '2000';
		$config['max_height']    = '2000';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload("usercompanypic")) {
			$error = array('error' => $this->upload->display_errors());

			return $error;
		} else {
			$success = $this->upload->data();
			return $success;

		}

	}

	public function save_pictures_cbond() {
		$this->load->helper(array('form', 'url'));
		$config['upload_path']   = $this->session->userdata('user_rootfolder')."/";
		$config['allowed_types'] = 'gif|jpg|png|svg|jpeg|GIF|JPG|PNG|SVG|JPEG';
		$config['max_size']      = '5000';
		$config['max_width']     = '2000';
		$config['max_height']    = '2000';

		if ($_FILES['bondedspic']) {
			$this->load->model('account_model');
			// normalise the array
			$file_post  = $_FILES['bondedspic'];
			$file_ary   = array();
			$file_count = count($file_post['name']);
			$file_keys  = array_keys($file_post);

			for ($i = 0; $i < $file_count; $i++) {
				foreach ($file_keys as $key) {
					$file_ary[$i][$key] = $file_post[$key][$i];
				}
			}

			$profilefolder = $this->session->userdata('user_rootfolder')."/";

			$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.PNG', '.GIF', '.JPG', '.JPEG');
			foreach ($file_ary as $file) {
				$extension = strrchr($file['name'], '.');
				if (in_array($extension, $extensions)) {
//		print 'File Name: ' . $file['tmp_name'];
					//        print 'File Type: ' . $file['type'];
					//        print 'File Size: ' . $file['size'];
					$docurl = $this->config->base_url()."/tinymce/plugins/moxiemanager/data/files/".$this->session->userdata('user_id')."/";

					move_uploaded_file($file['tmp_name'], $profilefolder."/".str_replace("\\'", "", $file['name']));
					$docurl .= str_replace("\\'", "", $file['name']);
					$this->account_model->update_prodocs($this->session->userdata('usernumid'), "bond", str_replace("\\'", "", $file['name']), $docurl);

				}
			}
		}

		if ($_FILES['coatedspic']) {
			$this->load->model('account_model');
			// normalise the array
			$file_post  = $_FILES['coatedspic'];
			$file_ary   = array();
			$file_count = count($file_post['name']);
			$file_keys  = array_keys($file_post);

			for ($i = 0; $i < $file_count; $i++) {
				foreach ($file_keys as $key) {
					$file_ary[$i][$key] = $file_post[$key][$i];
				}
			}

			$profilefolder = $this->session->userdata('user_rootfolder')."/";

			$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.PNG', '.GIF', '.JPG', '.JPEG');
			foreach ($file_ary as $file) {
				$extension = strrchr($file['name'], '.');
				if (in_array($extension, $extensions)) {
					$docurl = $this->config->base_url()."/tinymce/plugins/moxiemanager/data/files/".$this->session->userdata('user_id')."/";
					move_uploaded_file($file['tmp_name'], $profilefolder."/".str_replace("\\'", "", $file['name']));
					$docurl .= str_replace("\\'", "", $file['name']);
					$this->account_model->update_prodocs($this->session->userdata('usernumid'), "coat", str_replace("\\'", "", $file['name']), $docurl);
				}
			}
		}
	}

	public function generate_qrcode() {
		$uid = 1;
		$this->load->helper('url');
		$this->load->library('Barcode');
		$bc = new Barcode();
		$f  = $this->session->userdata('user_rootfolder');
// set the barcode content and type
		$barcodeobj = new TCPDF2DBarcode($this->config->base_url()."account/public_profile/?uid="+$uid, 'QRCODE,H');
// output the barcode as PNG image
		$data = $barcodeobj->getBarcodePNGSave(6, 6, array(0, 0, 0));
//$data = base64_decode($data);
		$success = file_put_contents($f."/profile.png", $data);

	}
	public function save_edited_profile() {$this->load->library('session');
		$this->load->helper('url');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		if ($this->session->userdata('signedinuser') == true) {

		} else {
			exit;
		}
		// load the language module
		$this->load->model('ablang');
		$data = array();
		$ld   = $this->ablang->get_infoarray($this->session->userdata('default_language'), "basic_account");

		$data['info_holder'] = $ld;

		$data['ulang']        = $this->session->userdata('default_language');
		$data['ulogset']      = true;
		$data['usernamesses'] = $this->session->userdata('user_name');

		$pui = $this->save_picture();

		$this->save_pictures_cbond();
		$upic = "";
		if (is_array($pui) && isset($pui['file_name'])) {
			$upic = $this->config->base_url()."tinymce/plugins/moxiemanager/data/files/".$this->session->userdata('user_id')."/".$pui['file_name'];
		}
		
		// check user seleted atleast one selection
		$dataerror = array();

		$addressofreg = "";
		$country      = "";
		$name         = "";
		$jobtitle     = "";

		$telarea       = "";
		$telcountry    = "";
		$contactnumber = "";

		$notificationemail = "";
		$compweb           = "";
		$ulang             = "en";
		$datavalidate      = true;

		if (is_array($this->input->post('AU')) != 1) {
			$dataerror[]  = "select at least one option under 'Are You a'";
			//$datavalidate = false;
		}

		if ($this->input->post('scw_orgaddress') == "" or strlen($this->input->post('scw_orgaddress')) <= 5 or strlen($this->input->post('scw_orgaddress')) >= 500) {
			$dataerror[]  = "check the organization address , it should not be empty, minimum allowed characters are 5 and maximum allowed chracters are 400";
			//$datavalidate = false;
		}

		if ($this->input->post('scw_orgcountry') == "" or strlen($this->input->post('scw_orgcountry')) >= 500) {
			$dataerror[]  = "check the country data , it should not be empty and maximum allowed characters are 400";
			//$datavalidate = false;
		}
		if ($this->input->post('scw_orgepname') == "" or strlen($this->input->post('scw_orgcountry')) >= 500) {
			$dataerror[]  = "check the name, it should not be empty and maximum allowed characters are 400";
			//$datavalidate = false;
		}

		if ($this->input->post('scw_orgcontact') == "" or strlen($this->input->post('scw_orgcontact')) < 5) {
			$dataerror[]  = "check the contact number, it should not be empty and should be at least 5 characters";
			//$datavalidate = false;
		}

		$gmapaddress = $this->input->post('targetsearch');
		//$orgname=$this->input->post('scw_orgname');
		$addressofreg = $this->input->post('scw_orgaddress');
		$country      = $this->input->post('scw_orgcountry');
		$name         = $this->input->post('scw_orgepname');
		$jobtitle     = $this->input->post('scw_orgempposition');
		//$email=$this->input->post('scw_orgemail');
		$contactnumber = $this->input->post('scw_telconcode')."-".$this->input->post('scw_telareacode')."-".$this->input->post('scw_orgcontact');
		//$password=$this->input->post('scw_orgpass');
		$notificationemail = $this->input->post('scw_orgnotemail');
		$compweb           = $this->input->post('scw_orgweb');
		$ulang             = $this->input->post('scwlanguage');
		$uloc              = $this->input->post('glocation');
		$uid               = $this->session->userdata('usernumid');
		$this->load->model('account/newaccountcreation');

		$data['dv']      = $datavalidate;
		$data['pudata']  = $pui;
		$data['dataert'] = $dataerror;
		$bst             = $this->input->post('BUDT1').";".$this->input->post('BUDT2').";".$this->input->post('BUDT3').";".$this->input->post('BUDT4');
		$bss             = $this->input->post('BUDS1').";".$this->input->post('BUDS2').";".$this->input->post('BUDS3').";".$this->input->post('BUDS4');

		$cst = $this->input->post('CUDT1').";".$this->input->post('CUDT2').";".$this->input->post('CUDT3').";".$this->input->post('CUDT4');
		$css = $this->input->post('CUDS1').";".$this->input->post('CUDS2').";".$this->input->post('CUDS3').";".$this->input->post('CUDS4');

		if ($datavalidate == true) {
			$this->newaccountcreation->update_user_data($addressofreg, $country, $name, $jobtitle, $contactnumber, $notificationemail, $compweb, $ulang, $upic, $uloc, $uid, $gmapaddress, $this->input->post('bondeddesc'), $this->input->post('coateddesc'));
			$this->newaccountcreation->insert_user_choice($this->input->post('AU'), $this->input->post('OVV'), $this->input->post('ABL'), $uid);
			$this->newaccountcreation->update_nuser_choice($uid, $this->input->post('BMMSF'), $this->input->post('CMMSF'), $this->input->post('BMMSS'), $this->input->post('CMMSS'), $bst, $bss, $cst, $css, $this->input->post('BUIND'), $this->input->post('CUIND'), $this->input->post('bonded_cprod'), $this->input->post('bbrprod'), $this->input->post('bonded_cpwish'), $this->input->post('bond_prod_country'), $this->input->post('cbrprod'), $this->input->post('coated_cpwish'), $this->input->post('CPLA'), $this->input->post('CSLA'), $this->input->post('BMMSFO'), $this->input->post('BMMSSO'), $this->input->post('CMMSFO'), $this->input->post('CMMSSO'), $this->input->post('CPLAO'), $this->input->post('CSLAO'), $this->input->post('BSELI'), $this->input->post('CSELI'), $this->input->post('ABL'), $this->input->post('ABSMO'));
			$this->load->view('account/edit_profile_info', $data);
		} else {
			$this->load->view('account/edit_profile_info', $data);
		}
		if ($this->input->post("urltrackid") != "") {
//header( 'Location: http://www.yoursite.com/new_page.html' ) ;
			header("Location:".$this->input->post("urltrackid"));
		} else {
//header($this->input->post("urltrackid"));

		}

	}
	public function change_password() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		if ($this->session->userdata('signedinuser') == true) {
			// load the language module
			$this->load->model('ablang');
			$data = array();
			$ldh  = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
			$ld   = $this->ablang->get_infoarray($this->session->userdata('default_language'), "change_password");

			$data['info_holder']       = $ld;
			$data['infoheader_holder'] = $ldh;
			$data['ulang']             = $this->session->userdata('default_language');
			$this->load->helper('url');
			$data['ulogset']      = true;
			$data['usernamesses'] = $this->session->userdata('user_name');
			$this->load->view("header_aw", $data);
			$this->load->view("account/change_password", $data);
			$this->load->view("footer");

		} else {
			echo "You are not logged in";
		}

	}
	public function create_account() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		// check user seleted atleast one selection
		$dataerror         = array();
		$orgname           = "";
		$addressofreg      = "";
		$country           = "";
		$name              = "";
		$jobtitle          = "";
		$email             = "";
		$telarea           = "";
		$telcountry        = "";
		$contactnumber     = "";
		$password          = "";
		$notificationemail = "";
		$compweb           = "";
		$ulang             = "en";
		$datavalidate      = true;

		if (is_array($this->input->post('AU')) != 1) {
			$dataerror[]  = "select at least one option under 'Are You a'";
			$datavalidate = false;
		}
		if ($this->input->post('scw_orgname') == "" or strlen($this->input->post('scw_orgname')) <= 5 or strlen($this->input->post('scw_orgname')) >= 500) {
			$dataerror[]  = "check the organizational name data , it should not be empty, minimum allowed characters are 5 and maximum allowed characters are 400";
			$datavalidate = false;
		}
		if ($this->input->post('scw_orgaddress') == "" or strlen($this->input->post('scw_orgaddress')) <= 5 or strlen($this->input->post('scw_orgaddress')) >= 500) {
			$dataerror[]  = "check the organization address , it should not be empty, minimum allowed characters are 5 and maximum allowed characters are 400";
			$datavalidate = false;
		}

		if ($this->input->post('scw_orgcountry') == "" or strlen($this->input->post('scw_orgcountry')) >= 500) {
			$dataerror[]  = "check the country data , it should not be empty and maximum allowed characters are 400";
			$datavalidate = false;
		}
		if ($this->input->post('scw_orgepname') == "" or strlen($this->input->post('scw_orgcountry')) >= 500) {
			$dataerror[]  = "check the name, it should not be empty and maximum allowed characters are 400";
			$datavalidate = false;
		}
		if ($this->input->post('scw_orgemail') == "" or filter_var($this->input->post('scw_orgemail'), FILTER_VALIDATE_EMAIL) == false) {
			$dataerror[]  = "check the email address, it should not be empty and should be valid email address";
			$datavalidate = false;
		}
		if ($this->input->post('scw_orgcontact') == "" or strlen($this->input->post('scw_orgcontact')) < 5) {
			$dataerror[]  = "check the contact number, it should not be empty and should be at-least 5 characters";
			$datavalidate = false;
		}

		if ($this->input->post('scw_orgpass') == "" or $this->input->post('scw_orgpass') != $this->input->post('scw_orgconfpass') or strlen($this->input->post('scw_orgpass')) < 5) {
			$dataerror[]  = "check the password, it should not be empty, should be at-least 5 characters and password and confirmation password shoud match";
			$datavalidate = false;
		}
		if ($this->input->post('agreetermsandcond') == "" or strlen($this->input->post('agreetermsandcond')) < 2) {
			$dataerror[]  = "Please agree to terms and conditions.";
			$datavalidate = false;
		}
		$data['autoUser'] = false;
		$orgname           = $this->input->post('scw_orgname');
		$addressofreg      = $this->input->post('scw_orgaddress');
		$country           = $this->input->post('scw_orgcountry');
		$name              = $this->input->post('scw_orgepname');
		$jobtitle          = $this->input->post('scw_orgempposition');
		$email             = $this->input->post('scw_orgemail');
		$contactnumber     = $this->input->post('scw_telconcode')."-".$this->input->post('scw_telareacode')."-".$this->input->post('scw_orgcontact');
		$password          = $this->input->post('scw_orgpass');
		$notificationemail = $this->input->post('scw_orgnotemail');
		$compweb           = $this->input->post('scw_orgweb');
		$ulang             = $this->input->post('scwlanguage');
		$uex               = false;

		if ($datavalidate == true) {

			// save the information
			//$orgname,$addressofreg,$country,$name,$jobtitle,$email,$contactnumber,$password,$notificationemail
			$this->load->model('account/newaccountcreation');
			$uex = $this->newaccountcreation->is_user_exists($email);
			if ($uex == false) {
				$aid = $this->newaccountcreation->GUID();
				$uid = $this->newaccountcreation->insert_user_data($orgname, $addressofreg, $country, $name, $jobtitle, $email, $contactnumber, $password, $notificationemail, $compweb, $ulang, $aid);
				$this->newaccountcreation->insert_user_choice($this->input->post('AU'), $this->input->post('OVV'), $this->input->post('ABL'), $uid);
				// send activation email
				$this->activation_email($email, $aid);

				$md = getcwd()."/tinymce/plugins/moxiemanager/data/files/".$email;
				try
				{
					if (file_exists($md) == true) {
						//$this->deleteDir($md);
						//rmdir($md);
						//mkdir($md);
					} else {
						mkdir($md);
					}
				}
				 catch (Exception $err) {
				}

			} else if ($this->newaccountcreation->is_user_auto($email) == true )  {
				$aid = $this->newaccountcreation->GUID();
				$uidObject = $this->newaccountcreation->insert_user_data($orgname, $addressofreg, $country, $name, $jobtitle, $email, $contactnumber, $password, $notificationemail, $compweb, $ulang, $aid);
				$uid = $uidObject[0]->recordno;
				$this->newaccountcreation->insert_user_choice($this->input->post('AU'), $this->input->post('OVV'), $this->input->post('ABL'), $uid);
				// send activation email
				$this->activation_email($email, $aid);
				
				$md = getcwd()."/tinymce/plugins/moxiemanager/data/files/".$email;
				$data['autoUser'] = true;
				try
				{
					if (file_exists($md) == true) {
						//$this->deleteDir($md);
						//rmdir($md);
						//mkdir($md);
					} else {
						mkdir($md);
					}
				}
				 catch (Exception $err) {
				}

			}

		}

		// load the language module
		$this->load->model('ablang');
		$ld                   = $this->ablang->get_infoarray($this->session->userdata('default_language'), "basic_account");
		$data['vdata']        = $dataerror;
		$data['validatedata'] = $datavalidate;
		$data['uexd']         = $uex;
		$data['lf']           = $ld;
		$data['toa']          = $email;
		$this->load->view("account/account_verify", $data);

	}

	public function activate_account() {

		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		// check login
		$aid = "";
		if (isset($_GET['activation_id']) == true) {
			$aid = $_GET['activation_id'];
		}
		$this->load->model('account/signin_verify');
		$ldh = $this->signin_verify->siginin_check_activation($aid);
		$isv = 0;
		if (is_array($ldh) == true and count($ldh) == 1) {
			$isv = 1;
			$this->session->set_userdata('default_language', $ldh[0]->user_language);
			$this->session->set_userdata('user_id', $ldh[0]->user_email);
			$this->session->set_userdata('signedinuser', true);
			$this->session->set_userdata('usernumid', $ldh[0]->recordno);
			$this->session->set_userdata('user_name', $ldh[0]->user_name);
			$this->session->set_userdata('user_orgname', $ldh[0]->user_orgname);
			$this->session->set_userdata('user_rootfolder', getcwd()."/tinymce/plugins/moxiemanager/data/files/".$this->session->userdata('user_id'));
			session_start();
			$_SESSION["isLoggedIn"]                       = true;
			$_SESSION["user"]                             = $this->session->userdata('user_id');
			$_SESSION["user_mname"]                       = $this->session->userdata('user_name');
			$_SESSION["user_morgname"]                    = $this->session->userdata('user_orgname');
			$_SESSION['moxiemanager.filesystem.rootpath'] = getcwd()."/tinymce/plugins/moxiemanager/data/files/".$this->session->userdata('user_id');// Set a root path for this use
		}

		$data = array();
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged              = true;
			$uname                = $this->session->userdata('user_name');
			$data['ulogset']      = $ulogged;
			$data['usernamesses'] = $uname;

		}
		$data['isval'] = $isv;
		$this->load->model('ablang');
		$ldh                       = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$ld                        = $this->ablang->get_infoarray($this->session->userdata('default_language'), "email_activation");
		$data['info_holder']       = $ld;
		$data['infoheader_holder'] = $ldh;
		$data['aid']               = $aid;
		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view('account/activation_id');
		$this->load->view("footer");

	}
	public function activation_email($email, $aid) {
		$config['protocol']  = 'sendmail';
		$config['wordwrap']  = TRUE;
		$config['validate']  = TRUE;
		$config['mailtype']  = "html";
		$config['charset']   = "UTF-8";
		$config['mailpath']  = "/usr/sbin/sendmail -t -i";
		$config['smtp_host'] = "relay-hosting.secureserver.net";
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$data                = array();
		$data['cemail']      = $email;
		$data['aid']         = $aid;
		$this->load->library('email', $config);
		$this->load->library('session');
		$this->load->helper('url');
		$this->email->from('support@abrasivesworld.com', 'Abrasivesworld');
		$this->email->to($email);
		$this->email->cc("support@abrasivesworld.com");
		$this->email->subject("Abrasivesworld Account Activation");
		$this->email->message($this->load->view('template/account_activation', $data, true));
		if ($this->email->send()) {
		} else {
		}
	}
	public function download_factsheet() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');

		}
		// load the language module
		$this->load->model('ablang');
		$data = array();
		echo "Under construction";

	}
	public function edit_profile() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');

		}
		// load the language module
		$this->load->model('ablang');
		$data = array();

		$ulogged = false;
		// check whether the user is already logged inet_ntop
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged              = true;
			$uname                = $this->session->userdata('user_name');
			$data['ulogset']      = $ulogged;
			$data['usernamesses'] = $uname;

		} else {
			$this->load->helper('url');
			$this->load->view("redirect", $data);
			return;
		}

		$this->load->model('account_model');
		$uid = $this->session->userdata('usernumid');
		$uod = $this->account_model->account_options($uid);
		$add = $this->account_model->get_account_details($uid);

		$ldh = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");

		$ld = $this->ablang->get_infoarray($this->session->userdata('default_language'), "basic_account");

		$abu = $this->ablang->get_abusers();

		$data['info_holder']       = $ld;
		$data['infoheader_holder'] = $ldh;
		$data['abuser']            = $abu;
		$data['uodd']              = $uod;
		$data['adu']               = $add;
		$cssarray                  = array();
		$cssarray[]                = "http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqEhtDrrTMdUfXLz40-_F-0gZ8B9Bgt-M&sensor=false";
		$data['css']               = $cssarray;
		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view("account/editprofile", $data);
		$this->load->view("footer");

	}
	public function upic_delete() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}

		if ($this->session->userdata('signedinuser') == true) {

		} else {
			$this->load->helper('url');
			$this->load->view("redirect");
			return;
		}
		$this->load->model('account_model');
		$this->account_model->delete_prodocs($this->session->userdata('usernumid'), $this->input->post('dtu'));

	}
	public function newaccount() {

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

		$ldh = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");

		$ld = $this->ablang->get_infoarray($this->session->userdata('default_language'), "basic_account,profile_page");

		$abu = $this->ablang->get_abusers();

		$data['info_holder']       = $ld;
		$data['infoheader_holder'] = $ldh;
		$data['abuser']            = $abu;

		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view("account/newaccount", $data);
		$this->load->view("footer");
	}

	public function my_article() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}

		if ($this->session->userdata('signedinuser') == true) {

		} else {
			$this->load->helper('url');
			$this->load->view("redirect");
			return;
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

		$ldh = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");

		$ld = $this->ablang->get_infoarray($this->session->userdata('default_language'), "my_article");

		$data['info_holder']       = $ld;
		$data['infoheader_holder'] = $ldh;

		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view("account/view_myarticle", $data);
		$this->load->view("footer");
	}
	public function download_profile() {
		$data = array();
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}

		// load the language module
		$this->load->model('account_model');
		// load the language module
		$this->load->model('ablang');

		$uid = $this->input->get('uid');

		$uod  = $this->account_model->account_options($uid);
		$subs = $this->account_model->subs_options($uid);

		$issub = $this->account_model->is_subs_options($uid);
		$add   = $this->account_model->get_account_details($uid);
		$abu   = $this->ablang->get_abusers();

		$data['abuser'] = $abu;
		$data['uodd']   = $uod;
		$data['adu']    = $add;
		$data['subsd']  = $subs;
		$data['issubs'] = $issub;
		$cssarray       = array();
		$cssarray[]     = "http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqEhtDrrTMdUfXLz40-_F-0gZ8B9Bgt-M&sensor=false";
		$data['css']    = $cssarray;
		$ulogged        = false;
		$uname          = "guest";
		// check whether the user is already logged inet_ntop
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
			$uname   = $this->session->userdata('user_name');
		}
		$data['ulogset']      = $ulogged;
		$data['usernamesses'] = $uname;
		$uop                  = array();
		$fss                  = "";

		foreach ($uod as &$value) {
			if ($value->selection == 'F') {
				$fss = "F";
			} else {
				$uop[] = $value->selection;
			}
		}

		$udh    = $this->account_model->gettypeofabrasive($uop, 'Bonded', 'Your Product', false);
		$udhc   = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Your Product', false);
		$upbond = $this->account_model->get_prodocs($uid, "bond");
		$upcoat = $this->account_model->get_prodocs($uid, "coat");

		$udhaf  = $this->account_model->gettypeofabrasive($uop, 'Bonded', 'Abrasive Focus', true);
		$udhafc = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Abrasive Focus', true);

		$udhapri = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Primary', true);
		$udhasec = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Secondary', true);

		$ldh = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$ld  = $this->ablang->get_infoarray($this->session->userdata('default_language'), "basic_account,profile_page");

		$data['upbond'] = $upbond;
		$data['upcoat'] = $upcoat;

		$data['fs'] = $fss;

		$data['info_holder']       = $ld;
		$data['infoheader_holder'] = $ldh;
		$data['user_selection']    = $udh;
		$data['user_selectionc']   = $udhc;
		$data['user_abfb']         = $udhaf;
		$data['user_abfc']         = $udhafc;
		$data['user_id_info']      = $uid;
		$data['freemodules']       = $this->account_model->get_free_modules($uid);
		$data['user_udhapri']      = $udhapri;
		$data['user_udhasec']      = $udhasec;

		$this->load->helper('url');
		//$this->load->view("header_aw",$data);

		//$this->load->view("account/public_profile",$data);
		//$this->load->view("footer");

		// page info here, db calls, etc.
		$this->load->library('Barcode');
		$bc         = new Barcode();
		$bchtml     = $bc->GetHTML($this->config->base_url().$_SERVER['REQUEST_URI']);
		$data['QR'] = $bchtml;

		$html = $this->load->view('account/public_profile', $data, true);
		$this->load->library('Pdf');

		$orgname = $add[0]->user_orgname;
		if (session_id() == '') {
			session_start();
			$_SESSION['PDFH_ORG']    = $orgname;
			$_SESSION['PDFH_ORGURL'] = "http://www.abrasivesworld.com/account/download_profile/?uid=".$add[0]->recordno;
		}
//'http://www.tcpdf.org'
		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
		$pdf->SetCreator("Abrasivesworld");
		$pdf->SetAuthor('Abrasivesworld');
		$pdf->SetTitle('Abrasivesworld');
		$pdf->SetSubject('Abrasivesworld');
		$pdf->SetKeywords('Abrasivesworld');

// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
		$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set default font subsetting mode
		$pdf->setFontSubsetting(true);

// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('dejavusans', '', 14, '', true);
		$pdf->SetFont('helvetica', '', 20);
// set font
		$pdf->SetFont('cid0jp', '', 12);
// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();

// set text shadow effect
		$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
		$html1 = '
	<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;
<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;
</a>!</h1>
	<i>This is the first example of TCPDF library.</i>
	<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
	<p>Please check the source code documentation and other examples for further information.</p>
	<p style="color:#CC0000;"> (汉语TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
		';

// Print text using writeHTMLCell()
		//$pdf->write2DBarcode('www.tcpdf.org', 'QRCODE,H', 20, 210, 50, 50, $style, 'N');
		//$pdf->Text(20, 205, 'QRCODE H');
		//echo $html;
		//exit;
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// QRCODE,H : QR-CODE Best error correction
		// ---------------------------------------------------------

// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output('My Abrasivesworld Profile.pdf', 'I');

//============================================================+
		// END OF FILE
		//============================================================+

	}

	public function curPageURL() {

		$pageURL = 'http';

		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	public function public_profile() {

		$data = array();
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}

		// load the language module
		$this->load->model('account_model');
		// load the language module
		$this->load->model('ablang');

		$uid = $this->input->get('uid');

		$uod  = $this->account_model->account_options($uid);
		$subs = $this->account_model->subs_options($uid);

		$issub = $this->account_model->is_subs_options($uid);
		$add   = $this->account_model->get_account_details($uid);
		$abu   = $this->ablang->get_abusers();

		$data['abuser'] = $abu;
		$data['uodd']   = $uod;
		$data['adu']    = $add;
		$data['subsd']  = $subs;
		$data['issubs'] = $issub;
		$cssarray       = array();
		$cssarray[]     = "http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqEhtDrrTMdUfXLz40-_F-0gZ8B9Bgt-M&sensor=false";
		$data['css']    = $cssarray;
		$ulogged        = false;
		$uname          = "guest";

		// check whether the user is already logged inet_ntop
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
			$uname   = $this->session->userdata('user_name');
		}
		$data['ulogset']      = $ulogged;
		$data['usernamesses'] = $uname;
		$uop                  = array();
		$fss                  = "";

		foreach ($uod as &$value) {
			if ($value->selection == 'F') {
				$fss = "F";
			} else {
				$uop[] = $value->selection;
			}
		}

		$udh    = $this->account_model->gettypeofabrasive($uop, 'Bonded', 'Your Product', false);
		$udhc   = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Your Product', false);
		$upbond = $this->account_model->get_prodocs($uid, "bond");
		$upcoat = $this->account_model->get_prodocs($uid, "coat");

		$udhaf  = $this->account_model->gettypeofabrasive($uop, 'Bonded', 'Abrasive Focus', true);
		$udhafc = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Abrasive Focus', true);

		$udhapri = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Primary', true);
		$udhasec = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Secondary', true);

		$ldh = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$ld  = $this->ablang->get_infoarray($this->session->userdata('default_language'), "basic_account,profile_page");

		$data['upbond'] = $upbond;
		$data['upcoat'] = $upcoat;

		$data['fs'] = $fss;
		//$adu[0]->user_orgaddress
		if (file_exists("/home/content/64/11453264/html/tinymce/plugins/moxiemanager/data/files/".$add[0]->user_email."/QR.PNG") == false) {
			$this->load->library('ciqrcode');
			$params['data']     = $this->config->base_url().$_SERVER['REQUEST_URI'];
			$params['level']    = 'H';
			$params['size']     = 4;
			$params['savename'] = $this->session->userdata('user_rootfolder')."/"."QR.PNG";
			$this->ciqrcode->generate($params);
		}

		$data['info_holder']       = $ld;
		$data['ishtml']            = true;
		$data['infoheader_holder'] = $ldh;
		$data['user_selection']    = $udh;
		$data['user_selectionc']   = $udhc;
		$data['user_abfb']         = $udhaf;
		$data['user_abfc']         = $udhafc;
		$data['user_id_info']      = $uid;
		$data['freemodules']       = $this->account_model->get_free_modules($uid);
		$data['user_udhapri']      = $udhapri;
		$data['user_udhasec']      = $udhasec;
		$data['user_qrc']          = "http://abrasivesworld.com//tinymce/plugins/moxiemanager/data/files/".$this->session->userdata('user_id')."/QR.PNG";

		$this->load->helper('url');
		$this->load->library('Barcode');
		$bc         = new Barcode();
		$bchtml     = $bc->GetHTML($this->config->base_url().$_SERVER['REQUEST_URI']);
		$data['QR'] = $bchtml;
		$this->load->view("header_aw", $data);

		$this->load->view("account/public_profile", $data);
		$this->load->view("footer");

	}

	public function my_profile() {
		$data = array();
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');
		}
		if ($this->session->userdata('signedinuser') == true) {

		} else {
			$this->load->helper('url');
			$this->load->view("redirect");
			return;
		}
		// load the language module
		$this->load->model('ablang');
		$this->load->model('account_model');
		$uid  = $this->session->userdata('usernumid');
		$uod  = $this->account_model->account_options($uid);
		$subs = $this->account_model->subs_options($uid);

		$issub = $this->account_model->is_subs_options($uid);
		$add   = $this->account_model->get_account_details($uid);
		$abu   = $this->ablang->get_abusers();

		$data['abuser'] = $abu;
		$data['uodd']   = $uod;
		$data['adu']    = $add;
		$data['subsd']  = $subs;
		$data['issubs'] = $issub;
		$cssarray       = array();
		$cssarray[]     = "http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqEhtDrrTMdUfXLz40-_F-0gZ8B9Bgt-M&sensor=false";
		$data['css']    = $cssarray;
		$ulogged        = false;
		$uname          = "guest";

		// check whether the user is already logged inet_ntop
		if ($this->session->userdata('signedinuser') == true) {
			$ulogged = true;
			$uname   = $this->session->userdata('user_name');
		}
		$data['ulogset']      = $ulogged;
		$data['usernamesses'] = $uname;
		$uop                  = array();
		$fss                  = "";
		foreach ($uod as &$value) {
			if ($value->selection == 'F') {
				$fss = "F";
			} else {
				$uop[] = $value->selection;
			}
		}

		$udh    = $this->account_model->gettypeofabrasive($uop, 'Bonded', 'Your Product', false);
		$udhc   = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Your Product', false);
		$upbond = $this->account_model->get_prodocs($uid, "bond");
		$upcoat = $this->account_model->get_prodocs($uid, "coat");

		$udhaf  = $this->account_model->gettypeofabrasive($uop, 'Bonded', 'Abrasive Focus', true);
		$udhafc = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Abrasive Focus', true);

		$udhapri = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Primary', true);
		$udhasec = $this->account_model->gettypeofabrasive($uop, 'Coated', 'Secondary', true);

		$ldh = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$ld  = $this->ablang->get_infoarray($this->session->userdata('default_language'), "basic_account,profile_page");

		$data['upbond'] = $upbond;
		$data['upcoat'] = $upcoat;

		$data['info_holder']       = $ld;
		$data['infoheader_holder'] = $ldh;
		$data['user_selection']    = $udh;
		$data['user_selectionc']   = $udhc;
		$data['user_abfb']         = $udhaf;
		$data['user_abfc']         = $udhafc;
		$data['user_id_info']      = $this->session->userdata('usernumid');
		$data['freemodules']       = $this->account_model->get_free_modules($this->session->userdata('usernumid'));
		$data['user_udhapri']      = $udhapri;
		$data['user_udhasec']      = $udhasec;

		$data['fs'] = $fss;
		$this->load->helper('url');
		$this->load->view("header_aw", $data);

		$this->load->view("account/profile", $data);
		$this->load->view("footer");

	}

	public function signin() {
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

		$ldh = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");
		$ld  = $this->ablang->get_infoarray($this->session->userdata('default_language'), "login_page");

		$data['info_holder']       = $ld;
		$data['infoheader_holder'] = $ldh;

		$data['vplink'] = $this->session->userdata('vplink');
		$data['vlink']  = $this->session->userdata('vlink');
		$data['vpusid'] = $this->session->userdata('vpusid');
		$data['vmod']   = $this->session->userdata('vmod');

		//$this->session->userdata('signedinuser')

		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view("account/login", $data);
		$this->load->view("footer");

	}

	public function termsandconditions() {
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

		$ldh = $this->ablang->get_infoarray($this->session->userdata('default_language'), "header_info");

		$ld = $this->ablang->get_infoarray($this->session->userdata('default_language'), "termscond_page");

		$data['info_holder']       = $ld;
		$data['infoheader_holder'] = $ldh;
		$data['userlanguage']      = $this->session->userdata('default_language');

		$this->load->helper('url');
		$this->load->view("header_aw", $data);
		$this->load->view("termscond", $data);
		$this->load->view("footer");

	}
	public function signin_check() {
		$this->load->library('session');
		if (!isset($this->session->userdata)) {
			$this->session->set_userdata('default_language', 'en');

		}

		// check login
		$userid   = $this->input->post('scw_orgemail');
		$userpass = $this->input->post('scw_orgpass');

		$this->load->model('account/signin_verify');

		$ldh = $this->signin_verify->siginin_check($userid, $userpass);
		if (is_array($ldh) == true and count($ldh) == 1) {

			$this->session->set_userdata('default_language', $ldh[0]->user_language);
			$this->session->set_userdata('user_id', $ldh[0]->user_email);
			$this->session->set_userdata('signedinuser', true);
			$this->session->set_userdata('usernumid', $ldh[0]->recordno);
			$this->session->set_userdata('user_name', $ldh[0]->user_name);
			$this->session->set_userdata('user_orgname', $ldh[0]->user_orgname);

			$this->session->set_userdata('user_rootfolder', getcwd()."/tinymce/plugins/moxiemanager/data/files/".$this->session->userdata('user_id'));
			session_cache_expire(720000);
			$_SESSION['start'] = time();
			$_SESSION['expire'] = $_SESSION['start'] + (300 * 60);
			session_start();
			/*
			$this->session->set_userdata('isLoggedIn', "true");
			$this->session->set_userdata('user', $this->session->userdata('user_id'));
			$this->session->set_userdata('user_mname', $this->session->userdata('user_name'));
			$this->session->set_userdata('user_morgname', $this->session->userdata('user_orgname'));
			$this->session->set_userdata('moxiemanager.filesystem.rootpath',  getcwd()."/tinymce/plugins/moxiemanager/data/files/".$this->session->userdata('user_id'));
			 */
			$_SESSION["isLoggedIn"]    = true;
			$_SESSION["user"]          = $this->session->userdata('user_id');
			$_SESSION["user_mname"]    = $this->session->userdata('user_name');
			$_SESSION["user_morgname"] = $this->session->userdata('user_orgname');

			$this->session->set_userdata('vplink', false);

			$_SESSION['moxiemanager.filesystem.rootpath'] = getcwd()."/tinymce/plugins/moxiemanager/data/files/".$this->session->userdata('user_id');// Set a root path for this use

			echo 1;

		}

	}

	public function test_google() {
		$this->load->helper('t');
		$text   = 'Translate this text.';
		$toLang = '';//or any other language - http://code.google.com/apis/language/translate/v2/using_rest.html#language-params
		echo t($text, $toLang);
	}
	public function logout() {
		session_start();
		$this->session->sess_destroy();
		$this->session->set_userdata('default_language', "en");
		$_SESSION["isLoggedIn"]                       = false;
		$_SESSION["user"]                             = 'guest';
		$_SESSION["user_mname"]                       = 'guest';
		$_SESSION["user_morgname"]                    = 'guest';
		$_SESSION['moxiemanager.filesystem.rootpath'] = '';
		session_destroy();
		$this->load->helper('url');
		$this->load->view("logout");

	}

}