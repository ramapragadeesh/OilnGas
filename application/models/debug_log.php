<?php
class debug_log extends CI_Model
{
public function log_me($uid,$ld)
{
$data = array(
   'user_id' => $uid,
   'log_details' => $ld 
);
$this->db->insert('debug_log', $data); 
}
}
?>