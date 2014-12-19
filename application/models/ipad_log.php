<?php
class ipad_log extends CI_Model
{
public function log_me($info)
{
$data = array(
   'log_details' => $info
);
$this->db->insert('ipad_log', $data); 
}
}
?>