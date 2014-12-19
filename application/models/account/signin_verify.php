<?php
class signin_verify extends CI_Model
{
public function siginin_check($email,$userpass)
{
$this->db->select('user_email');
$this->db->select('user_language');
$this->db->select('user_name');
$this->db->select('user_orgname');
$this->db->select('recordno');
$this->db->from('user_profile');
$this->db->where('user_email',$email);
$this->db->where('user_password',$userpass);
$q = $this->db->get('');
return $q->result();
}
public function siginin_check_activation($aid)
{
$this->db->select('user_email');
$this->db->select('user_language');
$this->db->select('user_name');
$this->db->select('user_orgname');
$this->db->select('recordno');
$this->db->from('user_profile');
$this->db->where('activation_id',$aid);
$q = $this->db->get('');
return $q->result();

}

}