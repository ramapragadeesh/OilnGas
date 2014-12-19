<?php
class admin extends CI_Controller
{
public function __construct()
  {
    parent::__construct();

  }

  public function index()
  {

  try

  {
  $this->load->library('session');
  }
  catch(Exception $e)
  {
  }

  if (!isset($this->session->userdata))
  {
  $this->session->set_userdata('default_language', 'en');
  }

  // check whether the user is already logged inet_ntop
  if ($this->session->userdata('signedinuser')== true)
  {
  }
  else
  {
  $this->load->helper('url');
  $this->load->view("redirect");
  return;
  }
// load the language module
  $this->load->model('ablang');
  $data = array();

  $ulogged=false;
  $uname="guest";

  // check whether the user is already logged inet_ntop
  if ($this->session->userdata('signedinuser')== true)
  {
  $ulogged=true;
  $uname=$this->session->userdata('user_name');
  }
  $data['ulogset']=$ulogged;
  $data['usernamesses']=$uname;
  $ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");
//  $ld=$this->ablang->get_infoarray($this->session->userdata('default_language'),"article_page");

//  $data['info_holder']=$ld;
  $data['infoheader_holder']=$ldh;

  $data['ussersessionlang']=$this->session->userdata('default_language');
  $data['user_id_info']=$this->session->userdata('usernumid');;

  $this->load->helper('url');

  $this->load->view("header_aw",$data);
  $this->load->view("admin/banner",$data);
  $this->load->view("footer");


  }
  public function save_banner()
  {

  try

  {
  $this->load->library('session');
  }
  catch(Exception $e)
  {
  }

  if (!isset($this->session->userdata))
  {
  $this->session->set_userdata('default_language', 'en');
  }

  // check whether the user is already logged inet_ntop
  if ($this->session->userdata('signedinuser')== true)
  {
  }
  else
  {
  $this->load->helper('url');
  $this->load->view("redirect");
  return;
  }
// load the language module
  $this->load->model('ablang');
  $this->load->model('admin_model');
  $data = array();

  // check whether the user is already logged inet_ntop
  $ulogged=true;
  $uname=$this->session->userdata('user_name');
  $data['ulogset']=$ulogged;
  $data['usernamesses']=$uname;
  $ldh=$this->ablang->get_infoarray($this->session->userdata('default_language'),"header_info");
  $data['infoheader_holder']=$ldh;
  $data['ussersessionlang']=$this->session->userdata('default_language');
  $data['user_id_info']=$this->session->userdata('usernumid');
  $this->load->helper('url');
  $adImageDirectory = getcwd()."/ad_images/";
  $bannerTitle=$this->input->post("bannerTitle");
  $bannerDesc=$this->input->post("bannerDesc");
  $bannerPosition=$this->input->post("bannerPosition");
  $bannerPictureLink1=$this->input->post("bannerPictureLink1");
  $bannerPictureLink2=$this->input->post("bannerPictureLink2");
  $bannerPictureLink3=$this->input->post("bannerPictureLink3");
  $activeBanner=$this->input->post("activeBanner");
  $config['upload_path'] = $adImageDirectory;
  $config['allowed_types'] = 'gif|jpg|png';
  $config['max_size'] = '2000';
  $config['max_width'] = '2024';
  $config['max_height'] = '2024';
  $config['encrypt_name'] = TRUE;
  $this->load->library('upload', $config);
  /*
  if ($this->admin_model->is_banner_exists($bannerTitle) != 0)
  {
    $error = array('error' => '<p style="color:red;font-weight:bold">'."Banner Title is alredy in the system".'</p>');
    $this->load->view("header_aw",$data);
    $this->load->view('admin/banner',$error);
    $this->load->view("footer");
    return;
  }
  */
  $link_image1="";//$this->config->base_url()."ad_images/"."";
  $link_image1_url="";
  $link_image2="";
  $link_image2_url="";
  $link_image3="";
  $link_image3_url="";

  if ($this->upload->do_upload('bannerPicture1'))
  {
      $imageDetails = $this->upload->data();
      $link_image1=$this->config->base_url()."ad_images/".$imageDetails["file_name"];
      $link_image1_url=$bannerPictureLink1;

  }
  if ($this->upload->do_upload('bannerPicture2'))
  {
      $imageDetails = $this->upload->data();
      $link_image2=$this->config->base_url()."ad_images/".$imageDetails["file_name"];
      $link_image2_url=$bannerPictureLink2;
  }
  if ($this->upload->do_upload('bannerPicture3'))
  {
    $imageDetails = $this->upload->data();
    $link_image3=$this->config->base_url()."ad_images/".$imageDetails["file_name"];
    $link_image3_url=$bannerPictureLink3;

  }

  $bannerData = array(
  'title' => $bannerTitle,
  'description' => $bannerDesc,
  'position' => $bannerPosition,
  'link_image' => $link_image1,
  'link_image_url' => $link_image1_url,
  'link_image2' => $link_image2,
  'link_image2_url' => $link_image2_url,
  'link_image3' => $link_image3,
  'link_image3_url' => $link_image3_url,
  'active' => $activeBanner

  );
  $this->admin_model->create_banner($bannerData);
  $this->load->view("header_aw",$data);
  $this->load->view('admin/banner',$data);
  $this->load->view("footer");
  }
}