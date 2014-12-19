<?php
class ab_model extends CI_Model
{

public function save_query($fname,$lname,$email,$subject,$message)
{
$data = array(
   'first_name' => $fname ,
   'last_name' => $lname ,
   'email' => $email,
   'subject' => $subject,
   'message' => $message
  
);
$this->db->insert('contact_us_query', $data); 
return $this->db->insert_id();
}
public function company_info($uid)
{
$query = $this->db->query("SELECT * FROM user_profile WHERE recordno=".$uid);
$row = $query->row_array(); 
return $row;
}

public function update_end_info($uid)
{
$data = array(
               'is_endorser' => 1
            );

$this->db->where('recordno', $uid);
$this->db->update('user_profile', $data);
}

}