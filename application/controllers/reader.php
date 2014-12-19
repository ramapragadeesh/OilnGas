<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class reader extends CI_Controller 
{

public function test() {

	$maxlifetime = ini_get("session.gc_maxlifetime");
	echo $maxlifetime;
}

public function read()
{
$this->load->library('csvreader');
$filePath = '/home/content/64/11453264/html/all_data.xml';
$xml=simplexml_load_file($filePath);



foreach($xml->children() as $child)
{
$em=explode(",",$child->Email);
$e1="";
$e2="";

if ( count($em) < 2)
{
$e1=$em[0];
$e2="";
}
if (count($em) >= 2)
{
$e1=$em[0];
$e2=$em[1];
}

$str=$child[0]->Company;
$strc=$child[0]->Country;
$stra=$child[0]->Address;
$strn=$child[0]->Person;
$strnb=$child[0]->NBusiness;
$strhp=$child[0]->HPage;
if ( $strnb == "Abrasive producer (Bonded)") {
$this->create_user($str,$stra,$strc,$strn,$child[0]->NBusiness,str_replace(",","",$child[0]->HPage),$e1,"en",$e2);
}
}
}

public function create_user($orgname,$addressofreg,$country,$name,$us,$compweb,$email,$ulang,$nemail)
{
$this->load->model('account/newaccountcreation');
$uex=$this->newaccountcreation->is_user_exists($email);
if ($uex == false)
{
$aid=$this->newaccountcreation->GUID();
$uid=$this->newaccountcreation->insert_user_data_mass($orgname,$addressofreg,$country,$name,"",$email,"","abc123",$nemail,$compweb,$ulang,$aid);
//$this->newaccountcreation->insert_user_choice($this->user_selection($us),$uid);
$md=getcwd()."/tinymce/plugins/moxiemanager/data/files/".$email;
echo $md;
try
{
if ( file_exists($md)== true)
{
}
else
{
mkdir($md);
}
}
catch(Exception $err)
{
}
}
else
{
$r=$this->newaccountcreation->get_user_id($email);
$ud=$r[0]->recordno;
$this->newaccountcreation->insert_user_choice_mass($this->user_selection($us),$ud);

}


}
public function user_selection($e)
{
$e=strtolower($e);
if ($e == "machine manufacturers or supplier" )
{
return "A";
}
else if ($e == "raw material supplier" )
{
return "B";
}
else if ($e == "bonded abrasive producer" )
{
return "C";
}
else if ($e == "abrasive producer (bonded)") {
return "C";
}
else if ($e == "coated abrasive producer" )
{
return "Z";
}
else if ($e == "abrasive producer (coated)" )
{
return "Z";
}
else if ($e == "coated abrasives converter" )
{
return "D";
}

else if ($e == "dealers (bonded or coated abrasives etc)" )
{
return "E";
}

else if ($e == "dealers" )
{
return "E";
}
else if ($e == "abrasive users" )
{
return "F";
}
else if ($e == "others, please specify" )
{
return "G";
}
else if ($e == "others" )
{
return "G";
}

}


}