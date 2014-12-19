<?php
class banner_model extends CI_Model
{
public function list_banner($position)
{
$this->db->select('*');
$this->db->from('banner_data');
$this->db->where('position', $position);
$q = $this->db->get('');
return $q->result();
}
}
?>