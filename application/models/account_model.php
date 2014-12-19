<?php
class account_model extends CI_Model
{

    public function getAllUsers()
  {
    $this->db->select('user_email');
    $this->db->from('user_profile');
    $q = $this->db->get('');
    return $q->result();
  }

  public function update_prodocs($uid,$ptype,$pname,$plink)
  {
    $data = array(
      'user_id' => $uid,
      'pic_type' => $ptype,
      'pic_name' => $pname,
      'pic_url' => $plink
      );
    $this->db->insert('user_profile_pictures',$data);
  }

  public function get_prodocs($uid,$ptype)
  {
    $this->db->select('DISTINCT(pic_url)');
    $this->db->where('user_id',$uid);
    $this->db->where('pic_type',$ptype);
    $this->db->from('user_profile_pictures');
    $q = $this->db->get('');
    return $q->result();
  }
  public function delete_prodocs($uid,$pid)
  {
    $this->db->where('pic_url', $pid);
    $this->db->where('user_id', $uid);
    $this->db->delete('user_profile_pictures');
  }
  public function is_active_id($aid)
  {
    $this->db->select('*');
    $this->db->where('activation_id',$aid);
    $this->db->from('user_profile');
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

  public function set_active_email($aid)
  {
    $data = array(
     'is_email_activated' => 1
     );
    $this->db->where('activation_id', $aid);
    $this->db->update('user_profile', $data);
  }
  public function GUID()
  {
    if (function_exists('com_create_guid') === true)
    {
      return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
  }

  public function getUID($orgName) {
    $this->db->select('recordno');
    $this->db->where('user_orgname',$orgName);
    $this->db->from('user_profile');
    $query = $this->db->get('');
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        return $row->recordno;   
      }
    }
    return -1;
  }

  public function account_options($uid) {
    $this->db->select('DISTINCT(selection)');
    $this->db->select('selection_text');
    $this->db->select('id');
    $this->db->where('user_id',$uid);
    $this->db->from('user_profile_selection_primary');
    $q = $this->db->get('');
    return $q->result();
  }

  public function article_elap($uid)
  {
    $csql = "SELECT DATEDIFF(now(),last_article_date) AS 'eday' FROM user_profile WHERE recordno=".$uid;
    $q=$this->db->query($csql);
    return $q->result_array();
  }
  public function get_free_modules($uid)
  {
    $this->db->select('*');
    $this->db->where('user_id',$uid);
    $this->db->from('free_modules');
    $q = $this->db->get('');
    return $q->result();

  }
  public function subs_options($uid)
  {
    $this->db->select('*');
    $this->db->where('user_id',$uid);
    $this->db->from('users_payment');
    $this->db->order_by("payment_process_date", "desc");
    $q = $this->db->get('');

    return $q->result();
  }

  public function is_subs_options($uid)
  {
    $this->db->select('*');
    $this->db->where('user_id',$uid);
    $this->db->from('users_payment');
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

  public function get_account_password($eid)
  {
    $this->db->select('user_password');
    $this->db->where('user_email',$eid);
    $this->db->from('user_profile');
    $q = $this->db->get('');
    return $q->result();
  }
  public function get_account_details($uid)
  {
    $this->db->select('*');
    $this->db->where('recordno',$uid);
    $this->db->from('user_profile');
    $q = $this->db->get('');
    return $q->result();
  }

  public function gettypeofabrasive($op,$type,$misc_type,$is_all=false)
  {
    $this->db->select('option');
    $this->db->select('show_dropdown');
    $this->db->select('description');
    $this->db->select('type');
    $this->db->select('id_text');
    $this->db->select('recordno');
    $this->db->from('profile_information');
    $em=0;
    $where=" type='".$type."' AND type_misc='".$misc_type."'";
    if ( $is_all == false)
    {
      $where .=" AND ( ";
        foreach($op as &$value)
        {
          $where .=" `option` = '".$value."' OR ";
          $em=1;
        }
        if ($em==1)
        {
          $where =substr_replace($where ,"",-3);
          $where .= ")";
}
else
{
  $twhere =" `option`='NOTAPPLICABLE')";
$where .= $twhere;
}
}
else
{
}

$this->db->where($where,NULL, FALSE);
$this->db->order_by("option", "asc");
$q = $this->db->get('');

return $q->result();

}
}