<?php
class ablang extends CI_Model
{
public function get_infoarray($lang_id,$group_id)
{
$lang="english_text";
switch ($lang_id) {
    case "en":
    $lang="english_text";
    break;
	
    case "zh-cn":
    $lang="chinese_text";
    break;
   
}
$gin=explode(",",$group_id);
$wherec="(";
foreach($gin as &$value)
{
$wherec .="groupid='".$value."' OR ";
}

$wherec .="groupid='".$group_id."')";

if (strpos($group_id,",") == false) {
$wherec="(groupid='".$group_id."')";
}


 $this->db->select($lang." as 'dp',default_text");

$this->db->from('lang_repo');
$this->db->where($wherec);
$q = $this->db->get('');
return $q->result();
 
}

public function get_abusers()
{

 $this->db->select("au_id");
$this->db->select("au_category");
 $this->db->from('abrasive_users');
 $q = $this->db->get('');
 return $q->result();
 
}
}
