<?php
class payment_model extends CI_Model
{

  public function insert_freemodule($uid,$module)
  {
    if ($this->isexist_freemodule($uid)==true)
    {
      $this->update_freemodule($uid,$module);
      return true;
    }

    $data = array(
     'user_id' => $uid ,
     'modules' => $module
     );
    $this->db->insert('free_modules', $data); 
  }

  public function update_freemodule($uid,$module)
  {
    try
    {
      $data = array(
       'modules' => $module
       );
      $this->db->where('user_id', $uid);
      $this->db->update('free_modules', $data);
    }
    catch(Exception $e)
    {

      $data = array(
       'modules' => $module
       );
      $this->db->where('user_id', $uid);
      $this->db->update('free_modules', $data);

    }
  }

  public function get_freemodule($uid)
  {
    $this->db->select('*');
    $this->db->where('user_id',$uid);
    $this->db->from('free_modules');
    $q = $this->db->get('');
    $row = $q->row_array(); 
    return $row;
  }
  public function isexist_freemodule($uid)
  {
    $this->db->select('*');
    $this->db->where('user_id',$uid);
    $this->db->from('free_modules');
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

  public function get_subs_options()
  {
    $this->db->select('*');
    $this->db->from('sub_information');
    $q = $this->db->get('');
    return $q->result();
  }

  public function log_paypal($info,$desc)
  {
    $data = array(
     'paypal_info' => $info ,
     'paypal_desc' => $desc 
     );

    $this->db->insert('paypal_log', $data); 

  }
  public function check_txnid($tnxid)
  {
    $this->db->select('*');
    $this->db->where('paypal_id',$tnxid);
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
  public function insert_used_coupon($cid,$user_id)
  {
    $indata = array(
     'coupon_id' => $cid,               
     'user_id' => $user_id			  
     );
    $this->db->insert('used_coupon', $indata);

  }
  public function used_coupon($cid,$user_id)
  {
    $warray = array('coupon_id' => $cid, 'user_id' => $user_id);
    $this->db->select('*');
    $this->db->where($warray);
    $this->db->from('used_coupon');
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
  public function isSalesCoupon($cid)  {
    $this->db->select('*');
    $this->db->where('coupon_id',$cid);
    $this->db->where('coupon_percentage > ',0);
    $this->db->from('coupon_data');
    $q = $this->db->get('');
    $rowcount = $q->num_rows();
    if ($rowcount >= 1) {
      return true;
    } else {
      return false;
    }
  }

  public function getCouponData($cid)  {
    $this->db->select('*');
    $this->db->where('coupon_id',$cid);
    $this->db->where('coupon_percentage > ',0);
    $this->db->from('coupon_data');
    $q = $this->db->get('');
    $rowcount = $q->num_rows();
    if ($rowcount >= 1) {
      $row = $q->row_array(); 
      return $row;
    }

  }

  public function check_cid($cid)
  {
    $this->db->select('*');
    $this->db->where('coupon_id',$cid);
    $this->db->from('coupon_data');
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
  public function coupon_details($cid)
  {
    $this->db->select('*');
    $this->db->where('coupon_id',$cid);
    $this->db->from('coupon_data');
    $q = $this->db->get('');
    return $q;
  }

  public function coupon_details_module($cid)
  {
    $this->db->select('*');
    $this->db->where('coupon_id',$cid);
    $this->db->from('coupon_data');
    $q = $this->db->get('');
    $rowcount = $q->num_rows();
    if ($rowcount >= 1)
    {
      $row = $q->row_array(); 
      return $row['coupon_type'];
    }
    else
    {
      return "";
    }
  }

  public function insert_coupon_data($cid,$module,$user_id,$payment,$subs_detail,$txn_id)
  {

    if ($this->is_subs_already($user_id)==true)
    {
     $qd=$this->get_subs_data($user_id);
     $sub=$qd['subs_module'];
     if ($sub == "")
     {
     }
     else
     {
       $module=$sub.":".$module;
     }
	// update the subs module
     $this->update_coupon_data($cid,$module,$user_id,$payment,$subs_detail,$txn_id);
     return true;
   }
   $indata = array(
     'paypal_validated' => 1,               
     'subs_module' => $module,
     'paypal_id' => $txn_id,
     'user_id' =>$user_id,
     'subs_payment' => 0,
     'subs_details' => $cid,
     'is_coupon' => 1	   
     );
   $this->db->insert('users_payment', $indata);
 }
 public function GUID()
 {
  if (function_exists('com_create_guid') === true)
  {
    return trim(com_create_guid(), '{}');
  }

  return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
public function is_subs_already($user_id)
{
  $this->db->select('*');
  $this->db->where('user_id',$user_id);
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

public function get_subs_data($user_id)
{
  $this->db->select('*');
  $this->db->where('user_id',$user_id);
  $this->db->from('users_payment');
  $q = $this->db->get('');
  $row = $q->row_array(); 
  return $row;

}

public function update_coupon_data($cid,$module,$user_id,$payment,$subs_detail,$txn_id)
{
  $updata = array(
   'paypal_validated' => 1,               
   'subs_module' => $module,
   'paypal_id' => $txn_id,
   'subs_payment' => 0,
   'subs_details' => $cid,
   'is_coupon' => 1	   
   );
  $this->db->where('user_id', $user_id);
  $this->db->update('users_payment', $updata);
}

public function update_paypal_data($tnxid,$validated)
{
  $updata = array(
   'paypal_validated' => $validated            
   );
  $this->db->where('paypal_id', $tnxid);
  $this->db->update('users_payment', $updata);

}

public function is_paid($tnxid)
{
  $this->db->select('*');
  $this->db->where('paypal_id',$tnxid);
  $this->db->where('paypal_validated',1);
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
public function update_payapl_request($user_id,$paypal_id,$paypal_validate,$user_email,$user_org,$subs_module,$subs_payment,$subs_details)
{
  $data = array(
   'user_id' => $user_id ,
   'paypal_id' => $paypal_id,
   'paypal_validated' => $paypal_validate ,
   'user_email' => $user_email ,
   'user_org' => $user_org ,
   'subs_module' => $subs_module ,
   'subs_payment' => $subs_payment ,
   'paypal_details' => $paypal_details
   );
  $this->db->where('paypal_id', $paypal_id);
  $this->db->update('users_payment', $data);
}
public function insert_paypal_request($user_id,$paypal_id,$paypal_validate,$user_email,$user_org,$subs_module,$subs_payment,$subs_details)
{
  $data = array(
   'user_id' => $user_id ,
   'paypal_id' => $paypal_id,
   'paypal_validated' => $paypal_validate ,
   'user_email' => $user_email ,
   'user_org' => $user_org ,
   'subs_module' => $subs_module ,
   'subs_payment' => $subs_payment ,
   'subs_details' => $paypal_details
   );
  $this->db->insert('users_payment', $data);
}
public function checkSalesCoupon($salesCoupon,$user_paid) {
  $this->db->select('*');
    $this->db->where('coupon_id',$salesCoupon);
    $this->db->from('coupon_data');
    $q = $this->db->get('');
    $rowcount = $q->num_rows();
    if ($rowcount >= 1) {
      $row = $q->row_array(); 
      if ( $row['coupon_percentage'] == $user_paid) {
        return true;
      } else {
        return false;
      }

    } else  {
      return false;
    }

}
public function check_price($pd,$sd,$user_paid,$salesCoupon) {

  if ($salesCoupon != "") {
    return $this->checkSalesCoupon($salesCoupon,$user_paid);
  }
  $total=0;

  foreach($pd as &$pdata)
  {

    if( $sd['sub_searchprefer'] == "yes" and $pdata->subs_type == "sub_searchprefer")
    {		
      $total = $total+$pdata->sub_payment;
    }	 

    elseif( $sd['sub_allowemails'] == "yes" and $pdata->subs_type == "sub_allowemails")
    {

      $total = $total+$pdata->sub_payment;
    }	
    elseif( $sd['sub_onceweekly'] == "yes" and $pdata->subs_type == "sub_onceweekly")
    {

      $total = $total+$pdata->sub_payment;
    }	
    elseif( $sd['sub_imageupload'] == "yes" and $pdata->subs_type == "sub_imageupload")
    {

      $total = $total+$pdata->sub_payment;
    }
    elseif( $sd['sub_videoupload'] == "yes" and $pdata->subs_type == "sub_videoupload")
    {		
     $total = $total+$pdata->sub_payment;
   }
 }
 if ($user_paid == $total)
 {
  return true; 
}
else
{
  return false;
}

}
}
?>