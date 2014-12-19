<?php
class user_model extends CI_Model
{

  public function isUserWebsiteContentExist($uid) {
    $this->db->select('user_id');
    $this->db->where('user_id',$uid);
    $this->db->from('user_website_html');
    $q = $this->db->get('');
    $rowcount = $q->num_rows();
    if ($rowcount >= 1) {
      return true;
    } else {
      return false;
    }
  }

  public function updateWebsiteContent($uid,&$homeContent,&$servicesContent,&$aboutusContent,&$contactusContent) {
    $data = array(
     'home' => $homeContent,
     'services' => $servicesContent,
     'about_us' => $aboutusContent,
     'contact_us' => $contactusContent
     );      
    $this->db->where('user_id', $uid);
    $this->db->update('user_website_html', $data);    
  }

  public function insertWebsiteContent($uid,&$homeContent,&$servicesContent,&$aboutusContent,&$contactusContent) {
    $data = array(
      'user_id' => $uid,
      'home' => $homeContent,
      'services' => $servicesContent,
      'about_us' => $aboutusContent,
      'contact_us' => $contactusContent
      );
    $this->db->insert('user_website_html', $data);
    
  }

  public function insertWebsiteMenu($uid,&$labelHome,&$labelServices,&$labelAboutus,&$labelContactus) {
    $data = array(
      'user_id' => $uid,
      'home' => $labelHome,
      'services' => $labelServices,
      'about_us' => $labelAboutus,
      'contact_us' => $labelContactus
      );
    $this->db->insert('user_website_header', $data);    
  }

  public function deleteWebsiteMenu($uid) {
    $this->db->where('user_id', $uid);
    $this->db->delete('user_website_header'); 
  }

  public function getWebsiteMenu($uid) {
    $this->db->select('*');
    $this->db->from('user_website_header');
    $this->db->where('user_id',$uid);
    $q = $this->db->get('');
    return $q->result();
  }

  public function getWebsiteContent($uid) {
    $this->db->select('*');
    $this->db->from('user_website_html');
    $this->db->where('user_id',$uid);
    $q = $this->db->get('');
    return $q->result();
  }

  public function getWebsiteContentAll() {
    $this->db->select('user_id');
    $this->db->from('user_website_html');
    $q = $this->db->get('');
    return $q->result();
  }
}
?>