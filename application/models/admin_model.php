<?php
class admin_model extends CI_Model
{
public function create_banner($bannerData)
{
$this->db->insert('banner_data', $bannerData);
}
public function is_banner_exists($bannerTitle)
{

$this->db->select('*');
$this->db->from('banner_data');
$this->db->where('title', $bannerTitle);
$this->db->order_by("order", "asc");
$q = $this->db->get('');
return $q->num_rows();

}
}
?>