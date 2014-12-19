<?php
class newaccountcreation extends CI_Model
{

public function user_password_change($newpass,$uid)
{
$updata = array(
               'user_password' => $newpass             
            );
$this->db->where('recordno', $uid);
$this->db->update('user_profile', $updata); 
}
public function old_password_correct($oldpass,$uid)
{
$uarray = array('user_password' => $oldpass,'recordno' => $uid);
$this->db->select('user_email');
$this->db->from('user_profile');
$this->db->where($uarray);
$q = $this->db->get('');
$rowcount = $q->num_rows();
if ($rowcount >= 1)
{
return true;
}
else
{
return false;
}
}

public function is_user_exists($email) {
$this->db->select('user_email');
$this->db->from('user_profile');
$this->db->where('user_email',$email);
$q = $this->db->get('');
$rowcount = $q->num_rows();
if ($rowcount >= 1)
{
return true;
}
else
{
return false;
}
}

public function is_user_auto($email) {
$this->db->select('user_email');
$this->db->from('user_profile');
$this->db->where('user_email',$email);
$this->db->where('user_password',"abc123");
$q = $this->db->get('');
$rowcount = $q->num_rows();
if ($rowcount >= 1)
{
return true;
}
else
{
return false;
}
}

public function get_user_id($email)
{
$this->db->select('*');
$this->db->from('user_profile');
$this->db->where('user_email',$email);
$q = $this->db->get('');
return $q->result();
}
public function update_nuser_choice($uid,$bmms,$cmms,$brms,$crms,$bst,$bss,$cst,$css,$bmi,$cmi,$bcp,$bbp,$bmc,$ccp,$cbp,$cmc,$pla,$sla,$bmmso,$brmso,$cmmso,$crmso,$plat,$slat,$bseli,$cseli,$absm,$absmo)
{
$bmmsc="";
$cmmsc="";
$brmsc="";
$crmsc="";

$bafc="";
$cafc="";

$bmic="";
$cmic="";

$plac="";
$slac="";
$absmc="";

//bmms
for($i=0;$i< count($bmms); $i++)
{
$bmmsc .= $bmms[$i].";";
}
//cmms
for($i=0;$i< count($cmms); $i++)
{
$cmmsc .= $cmms[$i].";";
}

//bmms
for($i=0;$i< count($brms); $i++)
{
$brmsc .= $brms[$i].";";
}
//cmms
for($i=0;$i< count($crms); $i++)
{
$crmsc .= $crms[$i].";";
}

//bmi
for($i=0;$i< count($bmi); $i++)
{
$bmic .= $bmi[$i].";";
}

//cmi
for($i=0;$i< count($cmi); $i++)
{
$cmic .= $cmi[$i].";";
}

//pla
for($i=0;$i< count($pla); $i++)
{
$plac .= $pla[$i].";";
}

//sla
for($i=0;$i< count($sla); $i++)
{
$slac .= $sla[$i].";";
}

//absm
for($i=0;$i< count($absm); $i++)
{
$absmc .= $absm[$i].";";
}


$bafce=explode(";",$bst);
$bafse=explode(";",$bss);

$cafce=explode(";",$cst);
$cafse=explode(";",$css);

//bst
$bafc=$bafce[0]."`".$bafse[0].";".$bafce[1]."`".$bafse[1].";".$bafce[2]."`".$bafse[2].";".$bafce[3]."`".$bafse[3].";";
//bss
$cafc=$cafce[0]."`".$cafse[0].";".$cafce[1]."`".$cafse[1].";".$cafce[2]."`".$cafse[2].";".$cafce[3]."`".$cafse[3].";";

$data = array(
   'bmms' => $bmmsc,
   'cmms' => $cmmsc,
   'brms' => $brmsc,
   'crms' => $crmsc,
   'baf' => $bafc,
   'caf' => $cafc,   
   'bmi' => $bmic,
   'cmi' => $cmic,
	
	   'bcp' => $bcp,
   'bbp' => $bbp,
   'bmc' => $bmc,

   'ccp' => $ccp,
   'cbp' => $cbp,
   'cmc' => $cmc,
   
   'pla' => $plac,
   'sla' => $slac,
   
   'bmmso' => $bmmso,
   'brmso' => $brmso,
   
   'cmmso' => $cmmso,
   'crmso' => $crmso,
   
   'plat' => $plat,
   'slat' => $slat,
   
   'bseli' => $bseli,
   'cseli' => $cseli,
   'absm' => $absmc,
   'absmo' => $absmo


);


$this->db->where('recordno', $uid);
$this->db->update('user_profile', $data); 
}
public function insert_user_choice($ud,$ovv,$abl,$uid) {

$this->db->delete('user_profile_selection_primary', array('user_id' => $uid)); 
$data =array();
for($i=0; $i < count($ud); $i++)
{
if ($ud[$i] == "G")
{
$data[$i] = array(
           'selection' => $ud[$i],
		   'selection_text' =>$ovv,
		   'user_id' => $uid
           );
}
else
{
$data[$i] = array(
           'selection' => $ud[$i],
		   'selection_text' =>'',
		   'user_id' => $uid
           );
}		   
}


$this->db->insert_batch('user_profile_selection_primary',$data);

$data =array();
for($i=0; $i < count($abl); $i++)
{
$data[$i] = array(
           'selection' => $abl[$i],		   
		   'user_id' => $uid
           );
}
if (is_array($abl) and count($abl) >= 1)
{

$this->db->insert_batch('user_profile_selection',$data);

}

}
public function insert_user_choice_mass($ud,$uid)
{
$this->db->delete('user_profile_selection_primary', array('user_id' => $uid)); 

$data = array(
   'user_id' => $uid ,
   'selection' => $ud ,
   'selection_text' => ' '
);
$this->db->insert('user_profile_selection_primary',$data);

}

public function update_user_data($addressofreg,$country,$name,$jobtitle,$contactnumber,$notificationemail,$compweb,$ulang,$upic,$uloc,$uid,$gmapaddress,$bdesc,$cdesc)
{
$data=array();
if (strlen($upic) <= 5 ) {
$data = array(
   'user_orgaddress' => $addressofreg ,
   'user_country' => $country,
   'bonded_desc' => $bdesc ,
   'coated_desc' => $cdesc,   
   'user_name' => $name,
   'user_position' => $jobtitle,
   'user_contactno' => $contactnumber,
   'user_notemail' => $notificationemail,
   'user_webaddress' => $compweb,
   'user_language' => $ulang,
		'user_location_gmap'=>$gmapaddress,
   'user_location' => $uloc
); 
} else {
$data = array(
   'user_orgaddress' => $addressofreg ,
   'user_country' => $country,
   'user_name' => $name,
   'bonded_desc' => $bdesc ,
   'coated_desc' => $cdesc,
   
   'user_position' => $jobtitle,
   'user_contactno' => $contactnumber,
   'user_notemail' => $notificationemail,
   'user_webaddress' => $compweb,
   'user_language' => $ulang,
   'user_comppic' => $upic,
   'user_location_gmap'=>$gmapaddress,
   'user_location' => $uloc
);
}
$this->db->where('recordno', $uid);
$this->db->update('user_profile', $data); 

}

public function insert_user_data($orgname="",$addressofreg="",$country="",$name="",$jobtitle="",$email="",$contactnumber="",$password="",$notificationemail="",$compweb="",$ulang="",$aid)
{
if ($this->is_user_exists($email) == false) {
$data = array(
   'user_orgname' => $orgname,
   'user_orgaddress' => $addressofreg ,
   'user_country' => $country,
   'user_name' => $name,
   'user_position' => $jobtitle,
   'user_email' => $email,
   'user_contactno' => $contactnumber,
    'user_password' => $password,
   'user_notemail' => $notificationemail,
   'user_webaddress' => $compweb,
   'user_language' => $ulang,   
   'baf'=>'`m2;`m2;`m2;`m2;',
   'caf'=>'`m2;`m2;`m2;`m2;',   
   'activation_id' => $aid
);
$this->db->insert('user_profile', $data); 
return $this->db->insert_id();
} else {
$data = array(
   'user_orgname' => $orgname,
   'user_orgaddress' => $addressofreg ,
   'user_country' => $country,
   'user_name' => $name,
   'user_position' => $jobtitle,
   'user_email' => $email,
   'user_contactno' => $contactnumber,
    'user_password' => $password,
   'user_notemail' => $notificationemail,
   'user_webaddress' => $compweb,
   'user_language' => $ulang,   
   'baf'=>'`m2;`m2;`m2;`m2;',
   'caf'=>'`m2;`m2;`m2;`m2;',
   'activation_id' => $aid
);
$this->db->where('user_email', $email);
$this->db->update('user_profile', $data);
$uid = $this->get_user_id($email);
return $uid;

}

}

public function insert_user_data_mass($orgname="",$addressofreg="",$country="",$name="",$jobtitle="",$email="",$contactnumber="",$password="",$notificationemail="",$compweb="",$ulang="",$aid)
{
if ($this->is_user_exists($email) == false)
{
$data = array(
   'user_orgname' => $orgname,
   'user_orgaddress' => $addressofreg ,
   'user_country' => $country,
   'user_name' => $name,
   'user_position' => $jobtitle,
   'user_email' => $email,
   'user_contactno' => $contactnumber,
    'user_password' => $password,
   'user_notemail' => $notificationemail,
   'user_webaddress' => $compweb,
   'user_language' => $ulang,   
   'baf'=>'`m2;`m2;`m2;`m2;',
   'caf'=>'`m2;`m2;`m2;`m2;',   
   'activation_id' => $aid
);
$iqy="INSERT INTO `user_profile` (`user_orgname`, `user_orgaddress`, `user_country`, `user_name`, `user_position`, `user_email`, `user_contactno`, `user_password`, `user_notemail`, `user_webaddress`, `user_language`, `baf`, `caf`, `activation_id`) VALUES ";
$iqy .="('$orgname','$addressofreg','$country','$name','','$email','---','$password','$notificationemail','$compweb'
,'$ulang','`m2;`m2;`m2;`m2;','`m2;`m2;`m2;`m2;','$aid')";
//$this->db->insert('user_profile', $data); 
$this->db->query($iqy);
return "";
}
}

public function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
}