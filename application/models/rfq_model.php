<?php
class rfq_model extends CI_Model
{
public function rfq_group_list($arrd)
{

if ($arrd == "" or $arrd == "0" or $arrd == ";")
{
return "";
}

$slqy="SELECT DISTINCT user_email,user_orgname FROM user_profile,`user_profile_selection_primary` WHERE recordno=user_id AND (";
$asl="";
$pieces = explode(";", $arrd);
foreach($pieces as &$value)
{
if ($value !="")
{
$asl .= "selection ='".$value."' OR ";
}
}
$asl = substr($asl,0,strlen($asl)-3);
$slqy .= $asl.")";
$q=$this->db->query($slqy);

return $q->result_array();
}
public function rfqdocs_delete($docid)
{
$this->db->where('doc_id', $docid);
$this->db->delete('rfq_documents'); 
}
public function update_rfqdocs($rfqid,$docname,$doclink)
{
$data = array(
               'rfq_mid' => $rfqid,
               'rfq_filename' => $docname,
               'rfq_linkname' => $doclink			  
				 );				 
$this->db->insert('rfq_documents',$data);

}

public function update_rfqbiddocs($rfqid,$docname,$doclink,$userid)
{
$data = array(
               'rfq_mid' => $rfqid,
               'rfq_filename' => $docname,
               'rfq_linkname' => $doclink,
			  'rfq_bid_id' => $userid			   
				 );
				 
$this->db->insert('rfq_bid_documents',$data);
}
public function sender_bid_summary($uid)
{
$sq="SELECT COUNT( rfq_id ) AS  'bid_count', rfq_id
FROM  rfq_bid_main WHERE user_send_id=".$uid." 
GROUP BY rfq_id";
return $this->db->query($sq);
}

public function sender_bid_summary_view($uid,$rid)
{
$sq="SELECT COUNT( rfq_id ) AS  'bid_count', rfq_id
FROM  rfq_bid_main WHERE user_send_id=".$uid." AND rfq_id='".$rid."' 
GROUP BY rfq_id";
return $this->db->query($sq);
}


public function remove_email_entry($uid,$emails)
{
$eemails=explode(",",$emails);
foreach($eemails as $email)
{
$this->db->where('user_email', $email);
$this->db->where('user_id', $uid);
$this->db->delete('users_article_emails'); 
}

}

public function sender_bidder_information($rid)
{
$sq="SELECT A.rfq_id,B.* FROM rfq_bid_main A ,user_profile B WHERE A.user_bid_id=B.recordno AND A.rfq_id='".$rid."'";
return $this->db->query($sq);
}
public function update_rfqtable($rfqid,$rfqtsn,$rfqtcdesc,$rfqtspec,$rfqtdi,$rfqtqu,$rfqtuom,$rfqtreqprice,$rfqtleadtime)
{
// delete the article table information

$this->db->where('rfq_mid', $rfqid);
$this->db->delete('rfq_table'); 

$stc=count($rfqtsn);
for($i=0;$i<$stc;$i++)
{
$data = array(
               'rfq_mid' => $rfqid,
               'serialno' => $rfqtsn[$i],
               'cdesc' => $rfqtcdesc[$i],
			   'spec' => $rfqtspec[$i],
               'dimension' => $rfqtdi[$i],
			   'quantity' => $rfqtqu[$i],
			   'uom' => $rfqtuom[$i],
			   'reqprice' => $rfqtreqprice[$i],
			     'reqleadtime' => $rfqtleadtime[$i]
				 );
$this->db->insert('rfq_table', $data);

}
}

public function update_rfqbidtable($rfqid,$rfqtsn,$rfqtcdesc,$rfqtspec,$rfqtdi,$rfqtqu,$rfqtuom,$rfqtreqprice,$rfqtleadtime,$isorig,$userid,$bsid)
{
// delete the article table information

$this->db->where('rfq_mid', $rfqid);
$this->db->where('user_bid_id', $userid);
$this->db->delete('rfq_bid_table'); 

$stc=count($rfqtsn);
for($i=0;$i<$stc;$i++)
{
$data = array(
               'rfq_mid' => $rfqid,
               'serialno' => $rfqtsn[$i],
			   'user_bid_id' => $userid,
			   'user_send_id' => $bsid,
               'cdesc' => $rfqtcdesc[$i],
			   'spec' => $rfqtspec[$i],
               'dimension' => $rfqtdi[$i],
			   'quantity' => $rfqtqu[$i],
			   'uom' => $rfqtuom[$i],
			   'reqprice' => $rfqtreqprice[$i],
			    'reqleadtime' => $rfqtleadtime[$i],
				 'is_orig' => $isorig[$i]
				 );
$this->db->insert('rfq_bid_table', $data);

}
}


public function rfq_exists($id)
{
$this->db->select('rfq_id');
$this->db->where('rfq_id', $id);
$this->db->from('rfq_main');
$q = $this->db->get('');
$q->result();

if ( $q->num_rows() >= 1 )
{
return true;
}
else
{
return false;
}
}

public function rfqbid_exists($id,$uid)
{
$this->db->select('rfq_id');
$this->db->where('rfq_id', $id);
$this->db->where('user_bid_id', $uid);
$this->db->from('rfq_bid_main');
$q = $this->db->get('');
$q->result();

if ( $q->num_rows() >= 1 )
{
return true;
}
else
{
return false;
}
}
public function insert_rfqmain($rfqid,$rfqno,$rfqtitle,$rfqissuedby,$rfqcname,$rfq_issuedate,$rfq_closedate,$rfqcimports,$rfqcexports, $rfqcurrency,$rfqqval,$rfqincoterm,$rfqpship,$rfqemail,$rfqgroup,$userid,$rfqactive)
{


if ( $rfqactive =="0")
{
}
else if( $rfqactive =="1" )
{
}
else
{
$rfqactive=0;

}

$rfqg="";
$stc=count($rfqgroup);
for($i=0;$i<$stc;$i++)
{
$rfqg .=$rfqgroup[$i].";";
}
$rfqgroup=$rfqg;

if ($this->rfq_exists($rfqid)==true)
{
$this->update_rfqmain($rfqid,$rfqno,$rfqtitle,$rfqissuedby,$rfqcname,$rfq_issuedate,$rfq_closedate,$rfqcimports,$rfqcexports, $rfqcurrency,$rfqqval,$rfqincoterm,$rfqpship,$rfqemail,$rfqgroup,$rfqactive);
return;
}

$data = array(
               'rfq_id' => $rfqid,
               'rfq_no' => $rfqno,
			   'user_id' => $userid,
               'rfq_title' => $rfqtitle,
			   'rfq_issueby' => $rfqissuedby,
               'rfq_company_name' => $rfqcname,
			   'rfq_issue_date' => $rfq_issuedate,
			   'rfq_close_date' => $rfq_closedate,
			   'rfq_country_imports' => $rfqcimports,
			   'rfq_pref_cn_export' => $rfqcexports,			   
			   'rfq_pref_currency' => $rfqcurrency,
               'rfq_quot_validation' => $rfqqval,
			   'rfq_incoterm' => $rfqincoterm,
               'rfq_partial' => $rfqpship,
			   'rfq_email' => $rfqemail,
			   'rfq_group' => $rfqgroup,
			   'rfq_active' => $rfqactive
			   
				 );
$this->db->insert('rfq_main', $data);
}

public function insert_rfqbidmain($rfqid,$rfqno,$rfqtitle,$rfqissuedby,$rfqcname,$rfq_issuedate,$rfq_closedate,$rfqcimports,$rfqcexports, $rfqcurrency,$rfqqval,$rfqincoterm,$rfqpship,$rfqemail,$rfqgroup,$userid,$bsid)
{
if ($this->rfqbid_exists($rfqid,$userid)==true)
{
$this->update_rfqbidmain($rfqid,$rfqno,$rfqtitle,$rfqissuedby,$rfqcname,$rfq_issuedate,$rfq_closedate,$rfqcimports,$rfqcexports, $rfqcurrency,$rfqqval,$rfqincoterm,$rfqpship,$rfqemail,$rfqgroup,$userid);
return;
}
$data = array(
               'rfq_id' => $rfqid,
               'rfq_no' => $rfqno,
			   'user_bid_id' => $userid,
			   'user_send_id' => $bsid,
               'rfq_title' => $rfqtitle,
			   'rfq_issueby' => $rfqissuedby,
               'rfq_company_name' => $rfqcname,
			   'rfq_issue_date' => $rfq_issuedate,
			   'rfq_close_date' => $rfq_closedate,
			   'rfq_country_imports' => $rfqcimports,
			   'rfq_pref_cn_export' => $rfqcexports,			   
			   'rfq_pref_currency' => $rfqcurrency,
               'rfq_quot_validation' => $rfqqval,
			   'rfq_incoterm' => $rfqincoterm,
               'rfq_partial' => $rfqpship,
			   'rfq_email' => $rfqemail,
			   'rfq_group' => $rfqgroup
			   
				 );
$this->db->insert('rfq_bid_main', $data);
}

public function get_rfq_ebsid($uid)
{

$this->db->select('user_email');
$this->db->where('recordno', $uid);
$this->db->from('user_profile');
$q = $this->db->get('');
return $q->result();

}
public function get_rfq_bsid($rfqid)
{
$this->db->select('user_id');
$this->db->where('rfq_id', $rfqid);
$this->db->from('rfq_main');
$q = $this->db->get('');
return $q->result();
}
public function update_rfqmain($rfqid,$rfqno,$rfqtitle,$rfqissuedby,$rfqcname,$rfq_issuedate,$rfq_closedate,$rfqcimports,$rfqcexports, $rfqcurrency,$rfqqval,$rfqincoterm,$rfqpship,$rfqemail,$rfqgroup,$rfqactive)
{
$data = array(
               'rfq_no' => $rfqno,
               'rfq_title' => $rfqtitle,
			   'rfq_issueby' => $rfqissuedby,
               'rfq_company_name' => $rfqcname,
			   'rfq_issue_date' => $rfq_issuedate,
			   'rfq_close_date' => $rfq_closedate,
			   'rfq_country_imports' => $rfqcimports,
			   'rfq_pref_cn_export' => $rfqcexports,			   
			   'rfq_pref_currency' => $rfqcurrency,
               'rfq_quot_validation' => $rfqqval,
			   'rfq_incoterm' => $rfqincoterm,
               'rfq_partial' => $rfqpship,
			   'rfq_email' => $rfqemail,
			   'rfq_group' => $rfqgroup,
			   'rfq_active' => $rfqactive
			   
				 );
$this->db->where('rfq_id', $rfqid);
$this->db->update('rfq_main', $data);
}

public function update_rfqbidmain($rfqid,$rfqno,$rfqtitle,$rfqissuedby,$rfqcname,$rfq_issuedate,$rfq_closedate,$rfqcimports,$rfqcexports, $rfqcurrency,$rfqqval,$rfqincoterm,$rfqpship,$rfqemail,$rfqgroup,$userid)
{
$data = array(
               'rfq_no' => $rfqno,
               'rfq_title' => $rfqtitle,
			   'rfq_issueby' => $rfqissuedby,
               'rfq_company_name' => $rfqcname,
			   'rfq_issue_date' => $rfq_issuedate,
			   'rfq_close_date' => $rfq_closedate,
			   'rfq_country_imports' => $rfqcimports,
			   'rfq_pref_cn_export' => $rfqcexports,			   
			   'rfq_pref_currency' => $rfqcurrency,
               'rfq_quot_validation' => $rfqqval,
			   'rfq_incoterm' => $rfqincoterm,
               'rfq_partial' => $rfqpship,
			   'rfq_email' => $rfqemail,
			   'rfq_group' => $rfqgroup
			   
				 );
$this->db->where('rfq_id', $rfqid);
$this->db->where('user_bid_id', $userid);
$this->db->update('rfq_bid_main', $data);
}
public function get_rfq_byuid($id)
{

$this->db->select('*');
$this->db->from('rfq_main');
$this->db->where('user_id', $id);
$q = $this->db->get('');
return $q->result();

}

public function get_rfq_bidbyuid($id)
{

$this->db->select('*');
$this->db->from('rfq_bid_main');
$this->db->where('user_bid_id', $id);
$q = $this->db->get('');
return $q->result();
}

public function get_rfq_bidbyruid($id,$rid)
{

$this->db->select('*');
$this->db->from('rfq_bid_main');
$this->db->where('user_send_id', $id);
$this->db->where('rfq_id', $rid);
$q = $this->db->get('');
return $q->result();
}

public function get_rfq_resbyuid($id)
{

$this->db->select('*');
$this->db->from('rfq_bid_main');
$this->db->where('user_send_id', $id);
$q = $this->db->get('');
return $q->result();

}

public function getrfqmain($rfqid)
{

$this->db->select('*');
$this->db->from('rfq_main');
$this->db->where('rfq_id', $rfqid);
$q = $this->db->get('');
return $q->result();
}

public function getrfqbidmain($rfqid,$bid)
{

$this->db->select('*');
$this->db->from('rfq_bid_main');
$this->db->where('rfq_id', $rfqid);
$this->db->where('user_bid_id', $bid);
$q = $this->db->get('');
return $q->result();
}

public function getrfqtable($rfqid)
{

$this->db->select('*');
$this->db->from('rfq_table');
$this->db->where('rfq_mid', $rfqid);
$this->db->order_by('serialno', 'asc');
$q = $this->db->get('');
return $q->result();
}

public function getrfqbidtableall($rfqid)
{
$this->db->select('*');
$this->db->from('rfq_bid_table');
$this->db->where('rfq_mid', $rfqid);
$this->db->where('is_orig', 1);
$this->db->order_by("serialno", "asc"); 
$q = $this->db->get('');
return $q->result();
}

public function getrfqbidtableallsub($rfqid)
{
$this->db->select('*');
$this->db->from('rfq_bid_table');
$this->db->where('rfq_mid', $rfqid);
$this->db->where('is_orig', 2);
$q = $this->db->get('');
return $q->result();
}

public function getrfqbidtable_orgcurrency($rfqid)
{
$this->db->select('*');
$this->db->from('rfq_main');
$this->db->where('rfq_id', $rfqid);
$q = $this->db->get('');
return $q->result();
}
public function getrfqbidtable_orgdetails($rid)
{
$sq="SELECT A.rfq_id,B.* FROM rfq_bid_main A ,user_profile B WHERE A.user_bid_id=B.recordno AND A.rfq_id='".$rid."'";
return $this->db->query($sq);
}

public function getrfqbidtable($rfqid,$bid)
{

$this->db->select('*');
$this->db->from('rfq_bid_table');
$this->db->where('rfq_mid', $rfqid);
$this->db->where('user_bid_id', $bid);
$this->db->order_by("serialno", "asc"); 
$this->db->order_by("is_orig", "asc"); 
$q = $this->db->get('');
return $q->result();
}

public function getrfqdocs($rfqid)
{

$this->db->select('*');
$this->db->from('rfq_documents');
$this->db->where('rfq_mid', $rfqid);
$q = $this->db->get('');
return $q->result();
}
public function getrfqbiddocs($rfqid,$bid)
{
$this->db->distinct();
$this->db->select('*');
$this->db->from('rfq_bid_documents');
$this->db->where('rfq_mid', $rfqid);
$this->db->where('rfq_bid_id', $bid);
$this->db->group_by('rfq_filename');
$q = $this->db->get('');
return $q->result();
}

public function update_user_article($uid)
{
//CURRENT_TIMESTAMP
$csql = "UPDATE user_profile SET last_article_date=NOW() WHERE recordno=".$uid."";
$q=$this->db->query($csql);
}
public function download_article_byid($id)
{
$this->db->select('*');
$this->db->from('article_information');
$this->db->where('article_id', $id);
$q = $this->db->get('');
$row = $q->row_array(); 
return $row;
}

public function get_article_byid($id)
{

$this->db->select('*');
$this->db->from('article_information');
$this->db->where('article_id', $id);
$q = $this->db->get('');
return $q->result();
}
public function get_userarticle_group($uid)
{
//$slqy="SELECT user_profile_selection_primary.selection AS 'uselection',IF (user_profile_selection_primary.selection = 'G',user_profile_selection_primary.selection_text,user_group.selection_text) AS 'uselectiontext' FROM user_profile_selection_primary ,user_group  WHERE user_profile_selection_primary.selection = user_group.selection and user_profile_selection_primary.user_id=".$uid;
$slqy="SELECT selection AS 'uselection',selection_text AS 'uselectiontext' FROM user_group  ORDER BY gid ASC";
$q=$this->db->query($slqy);
return $q->result_array();

}

public function get_article_userinfo($uid)
{
$this->db->select('*');
$this->db->from('user_profile');
$this->db->where('recordno', $uid);
$q = $this->db->get('');
return $q->result();
}

public function get_user_emails($id)
{
$this->db->select('id');
$this->db->select('user_email');
$this->db->select('user_id');
$this->db->from('users_article_emails');
$this->db->where('user_id', $id);
$q = $this->db->get('');
return $q->result();

}
public function remove_rfq_data($uid,$rid)
{
$this->db->where('rfq_id', $rid);
$this->db->where('user_id', $uid);
$this->db->delete('rfq_main');

$this->db->where('rfq_mid', $rid);
$this->db->delete('rfq_table');

}

public function get_article_details($id)
{
$this->db->select('*');
$this->db->from('article_information');
$this->db->where('article_id', $id);
$q = $this->db->get('');
return $q->result();
}
public function getall_article_details($uid)
{
$csql = "SELECT * FROM article_information WHERE user_id=".$uid." ORDER BY STR_TO_DATE(article_date,'%d/%m/%Y') DESC";

if ($uid==1)
{
$csql = "SELECT * FROM article_information ORDER BY STR_TO_DATE(article_date,'%d/%m/%Y') DESC";
}
$q=$this->db->query($csql)->result();
return $q;
}

public function update_article_status($id,$article_active=0)
{
$data = array(
              
               'article_active' => $article_active,
			   'article_ready' => 1
            );

$this->db->where('article_id', $id);
$this->db->update('article_information', $data); 
}

public function update_articles_details($id,$article_title,$article_date,$article_author,$article_details,$article_active=0,$article_lang,$article_en,$article_ch,$targetemail,$targetcat,$aha,$th_content,$hi_content,$de_content,$id_content,$en_tcontent,$cn_tcontent,$th_tcontent,$hi_tcontent,$de_tcontent,$id_tcontent)
{
$data = array(
               'article_title' => $article_title,
               'article_date' => $article_date,
               'article_author' => $article_author,
			   'article_details' => $article_details,
               'article_lang' => $article_lang,
			   'article_en' => $article_en,
			   'article_active' => $article_active,			   
			   'article_ch' => $article_ch,
			   'article_th' => $th_content,
			   'article_hi' => $hi_content,
			   'article_de' => $de_content,
			   'article_bh' => $id_content,			   
			   'arttitle_en' => $en_tcontent,
			   'arttitle_ch' => $cn_tcontent,
			   'arttitle_th' => $th_tcontent,
			   'arttitle_hi' => $hi_tcontent,
			   'arttitle_de' => $de_tcontent,
			   'arttitle_bh' => $id_tcontent,			   
			   	'article_target_email' => $targetemail,
			   'article_target_group' => $targetcat,
			   'article_ready'=>$aha			   
            );
$this->db->set('article_timestamp', 'NOW()', FALSE);
$this->db->where('article_id', $id);
$this->db->update('article_information', $data);
}

public function delete_article_details($id)
{
$this->db->where('article_id', $id);
$this->db->delete('article_information'); 
}

public function article_exists($id,$uid)
{
$this->db->select('article_id');
$this->db->where('article_id', $id);
$this->db->where('user_id', $uid);
$this->db->from('article_information');
$q = $this->db->get('');
$q->result();

if ( $q->num_rows() >= 1 )
{
return true;
}
else
{
return false;
}

}
public function save_email_list($einfo,$uid)
{
$pieces=explode(',',$einfo);
$pieces = array_unique($pieces);
$retuemail="";
foreach($pieces as &$value)
{
$warray = array('user_id' => $uid, 'user_email' => $value);
$this->db->select('user_email');
$this->db->where($warray);
$this->db->from('users_article_emails');
$q = $this->db->get('');
$q->result();
if ( $q->num_rows() >= 1 )
{
}
else
{
$sql = 'INSERT INTO users_article_emails (user_email,user_id) VALUES ('.$this->db->escape($value).','.$uid.')';
$this->db->query($sql);
}
if ($value != "")
{
$retuemail .= $value.",";
}
}
return $retuemail;
}
public function new_article_details($article_id,$article_title,$article_date,$article_author,$article_user,$article_details,$article_active,$article_lang,$uid,$userorg,$targetemail,$targetcat,$aha)
{
$lan=array("en","zh-cn","th","hi","de","id");
$arrlength=count($lan);
$n_sid="";
$n_did="";
$en_content="";
$cn_content="";
$th_content="";
$hi_content="";
$de_content="";
$id_content="";

$en_tcontent="";
$cn_tcontent="";
$th_tcontent="";
$hi_tcontent="";
$de_tcontent="";
$id_tcontent="";

for($x=0;$x<$arrlength;$x++)
{
	if ($lan[$x] == $article_lang)
	{
	
		$n_sid=$article_lang; 
		switch($article_lang)
		{
		case "en":
		$en_content=$article_details;
		$en_tcontent=$article_title;
		
		break;
		case "zh-cn":
		$cn_content=$article_details;
		$cn_tcontent=$article_title;
		break;
		case "th":
		$th_content=$article_details;
		$th_tcontent=$article_title;
		break;
		case "hi":
		$hi_content=$article_details;
		$hi_tcontent=$article_title;
		break;
		case "de":
		$de_content=$article_details;
		$de_tcontent=$article_title;
		break;
		case "id":
		$id_content=$article_details;
		$id_tcontent=$article_title;
		break;
		}
	}
	else
	{
		switch($lan[$x])
		{
		case "en":
		$en_content=$this->google_translator($article_lang,$lan[$x],$article_details);
		$en_tcontent=$this->google_translator($article_lang,$lan[$x],$article_title);
		
		break;
		case "zh-cn":
		$cn_content=$this->google_translator($article_lang,$lan[$x],$article_details);
		$cn_tcontent=$this->google_translator($article_lang,$lan[$x],$article_title);
		break;
		case "th":
		$th_content=$this->google_translator($article_lang,$lan[$x],$article_details);
		$th_tcontent=$this->google_translator($article_lang,$lan[$x],$article_title);
		break;
		case "hi":
		$hi_content=$this->google_translator($article_lang,$lan[$x],$article_details);
		$hi_tcontent=$this->google_translator($article_lang,$lan[$x],$article_title);
		break;
		case "de":
		$de_content=$this->google_translator($article_lang,$lan[$x],$article_details);
		$de_tcontent=$this->google_translator($article_lang,$lan[$x],$article_title);
		break;
		case "id":
		$id_content=$this->google_translator($article_lang,$lan[$x],$article_details);
		$id_tcontent=$this->google_translator($article_lang,$lan[$x],$article_title);
		break;
		}
	}
}
//$eng_content="";
//$ch_content="";
$sid="en";
$did="zh-cn";

if ($article_lang == "en")
{
$sid="en";
$did="zh-cn";
//$ch_content=$this->google_translator($sid,$did,$article_details);
//$eng_content=$article_details;
}
else
{
//$article_lang="zh-cn";
$sid="zh-cn";
$did="en";
//$eng_content=$this->google_translator($sid,$did,$article_details);
//$ch_content=$article_details;
}
// check if the article exists

$targetemail= $this->save_email_list($targetemail,$uid);

if ($this->article_exists($article_id,$uid) == true)
{
// update
$this->update_articles_details($article_id,$article_title,$article_date,$article_author,$article_details,$article_active,$article_lang,$en_content,$cn_content,$targetemail,$targetcat,$aha,$th_content,$hi_content,$de_content,$id_content,$en_tcontent,$cn_tcontent,$th_tcontent,$hi_tcontent,$de_tcontent,$id_tcontent);
}
else
{
$sql = "INSERT INTO article_information (article_id,article_title,article_date,article_author,article_user,article_details,article_active,article_en,article_ch,article_th,article_hi,article_de,article_bh,arttitle_en,arttitle_ch,arttitle_th,arttitle_hi,arttitle_de,arttitle_bh,user_id,article_org,article_target_email,article_target_group,article_ready) 
        VALUES (".$this->db->escape($article_id).", ".$this->db->escape($article_title).", ".$this->db->escape($article_date).",".$this->db->escape($article_author).",".$this->db->escape($article_user).",".$this->db->escape($article_details).",".$this->db->escape($article_active).",".$this->db->escape($en_content).",".$this->db->escape($cn_content).",".$this->db->escape($th_content).",".$this->db->escape($hi_content).",".$this->db->escape($de_content).",".$this->db->escape($id_content).",".$this->db->escape($en_tcontent).",".$this->db->escape($cn_tcontent).",".$this->db->escape($th_tcontent).",".$this->db->escape($hi_tcontent).",".$this->db->escape($de_tcontent).",".$this->db->escape($id_tcontent).",".$this->db->escape($uid).",".$this->db->escape($userorg).",".$this->db->escape($targetemail).",".$this->db->escape($targetcat).",".$aha.")";
$this->db->query($sql);
}
}
public function google_translator($sid,$did,$content)
{
$tt="";
//$content=$this->file_get_contents_utf8($content);
$body_array = str_split($content, 700);
foreach($body_array as &$value)
{

$postdata = http_build_query(
    array(
        'source' => $sid,
        'target' => $did,
		'q' => urlencode($value),
		'format'=>'html',
		'key'=>"AIzaSyAqEhtDrrTMdUfXLz40-_F-0gZ8B9Bgt-M"
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);
$ci = get_instance();
$ci->load->helper('t');
return t($content, $sid,$did);
$context  = stream_context_create($opts);
$value=urlencode($value);
$translate = file_get_contents("https://www.googleapis.com/language/translate/v2?key=AIzaSyAqEhtDrrTMdUfXLz40-_F-0gZ8B9Bgt-M&q=$value&source=".$sid."&target=".$did."&format=html");
//$translate = file_get_contents("https://www.googleapis.com/language/translate/v2/",false,$context);
$arr = json_decode($translate, true);
$tt .=$arr['data']['translations'][0]['translatedText'];
}
return $tt;

}
private function file_get_contents_utf8($fn)
{
$fn = mb_convert_encoding($fn, 'HTML-ENTITIES', "UTF-8");
return $fn;
}

public function article_search($articlestartdate,$articleenddate,$sarticle_language,$sartcile_title,$sarticle_regcomp,$sarticle_regcompcoun,$sartcile_content,$particle,$earticle,$sarticle_lang)
{
$csql="SELECT * FROM article_information WHERE article_active=1 and article_ready=1 ";
if ($articlestartdate != "")
{
try
{
error_reporting(0);
$myDateTime = DateTime::createFromFormat('d/m/Y', $articlestartdate);
$newDateString = $myDateTime->format('Y-m-d');
//$csql .= " AND article_timestamp >= '".$newDateString."'";
$csql .= " AND STR_TO_DATE(article_date,'%d/%m/%Y') >= STR_TO_DATE('".$articlestartdate."','%d/%m/%Y')";
}
catch (Exception $e)
{
echo "OOPS, check your input";
exit;
}
}
if ($articleenddate != "")
{
try
{
error_reporting(0);
$myDateTime = DateTime::createFromFormat('d/m/Y', $articleenddate);
$newDateString = $myDateTime->format('Y-m-d');
//$csql .= " AND article_timestamp <= '".$newDateString."'";
$csql .= " AND STR_TO_DATE(article_date,'%d/%m/%Y') <= STR_TO_DATE('".$articleenddate."','%d/%m/%Y')";
}
catch (Exception $e)
{
echo "OOPS, check your input";
exit;
}
}
error_reporting(1);
if ($sarticle_language != "")
{
$csql .= " AND article_language like ".$this->db->escape("%".$sarticle_language."%")."";
}

if ($sarticle_lang != "")
{
//$csql .= " AND article_lang like ".$this->db->escape("%".$sarticle_lang."%")."";
}
if ($sartcile_title != "")
{
$csql .= " AND article_title like ".$this->db->escape("%".$sartcile_title."%")."";
}
if ($sartcile_content != "")
{
$csql .= " AND ( article_details like ".$this->db->escape("%".$sartcile_content."%")." OR article_en like ".$this->db->escape("%".$sartcile_content."%")."  OR article_ch like ".$this->db->escape("%".$sartcile_content."%").")";
}
if ($sarticle_regcomp != "")
{
$csql .= " AND article_org like ".$this->db->escape("%".$sarticle_regcomp."%")."";
}
if ($sarticle_regcompcoun != "")
{
$csql .= " AND article_orgin_country like ".$this->db->escape("%".$sarticle_regcompcoun."%")."";
}
if ($particle == 1 and $earticle==1)
{
$csql .= " AND (article_type=1 OR article_type=0) ";
}
elseif ($particle == 1 and $earticle==0)
{
$csql .= " AND (article_type=1) ";
}
elseif ($particle == 0 and $earticle==1)
{
$csql .= " AND (article_type=0) ";
}
$csql .= " ORDER BY STR_TO_DATE(article_date,'%d/%m/%Y') DESC";
$q=$this->db->query($csql)->result();
return $q;
}
public function email_sentbox($aid,$toa,$con,$sub)
{
$data = array(
               'article_id' => $aid,
               'to_address' => $toa,
               'content' => $con,
			   'subject' => $sub
            );

$this->db->insert('email_sentbox', $data); 

}
public function google_address()
{


}

}