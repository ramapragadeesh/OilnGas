<?php
class urldetect_model extends CI_Model
{

public function insert_action($uid,$linkurl,$linkmodule)
{
$data = array(
               'user_id' => $uid,
               'action_url' => $linkurl,
               'link_module' => $linkmodule			  
				 );
				 
$this->db->insert('user_actions',$data);
}
public function delete_action($uid,$linkmodule)
{
$this->db->where('user_id', $uid);
$this->db->where('link_module', $link_module);
$this->db->delete('user_actions'); 
}
public function select_action($uid,$linkurl,$linkmodule)
{
$this->db->select('*');
$this->db->where('user_id', $uid);
$this->db->where('link_module', $linkmodule);
$this->db->from('user_actions');
$q = $this->db->get('');
return $q->result();
}

public function get_uid()
{
return md5(uniqid(rand(), true));
}
}