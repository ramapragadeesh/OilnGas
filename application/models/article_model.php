<?php
class article_model extends CI_Model
{
	public function art_group_list($arrd)
	{
		if ($arrd == "" or $arrd == "0" or $arrd == ";")
		{
			return "";
		}

		$slqy="SELECT DISTINCT user_email,user_orgname FROM user_profile,`user_profile_selection_primary` WHERE recordno=user_id AND (";
			$asl="";
			$pieces = explode(",", $arrd);
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

public function get_article_head($start,$end)
{
	$csql = "SELECT * FROM article_information WHERE article_active=1 AND article_ready=1 ORDER BY STR_TO_DATE(article_date,'%d/%m/%Y') DESC";
	$q=$this->db->query($csql)->result();
	return $q;

}

public function article_elap($uid)
{
	$csql = "SELECT DATEDIFF(now(),last_article_date) AS 'eday' FROM user_profile WHERE recordno=".$uid;
	$q=$this->db->query($csql);
	return $q->result_array();
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
	$slqy="SELECT selection AS 'uselection',selection_text AS 'uselectiontext' FROM user_group ORDER BY gid ASC";
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

public function article_search_advanced($articleLanguage,$searchTextTitle,$searchTextContent,$paidArticle,$eArticle,&$start,&$end,$itemsPerPage,$postStartDate,$postEndDate,$articleId,&$searchResultEmpty)
{
	$csql="SELECT * FROM article_information WHERE article_active=1 and article_ready=1 ";
	$csqlForArticleID="SELECT * FROM article_information WHERE article_active=1 and article_ready=1 ";

	if ($postStartDate != "")
	{
		try
		{
			error_reporting(0);
			$myDateTime = DateTime::createFromFormat('d/m/Y', $postStartDate);
			$newDateString = $myDateTime->format('Y-m-d');
//$csql .= " AND article_timestamp >= '".$newDateString."'";
			$csql .= " AND STR_TO_DATE(article_date,'%d/%m/%Y') >= STR_TO_DATE('".$postStartDate."','%d/%m/%Y')";
		}
		catch (Exception $e)
		{
			echo "OOPS, check your input";
			exit;
		}
	}
	if ($postEndDate != "")
	{
		try
		{
			error_reporting(0);
			$myDateTime = DateTime::createFromFormat('d/m/Y', $postEndDate);
			$newDateString = $myDateTime->format('Y-m-d');
//$csql .= " AND article_timestamp <= '".$newDateString."'";
			$csql .= " AND STR_TO_DATE(article_date,'%d/%m/%Y') <= STR_TO_DATE('".$postEndDate."','%d/%m/%Y')";
		}
		catch (Exception $e)
		{
			echo "OOPS, check your input";
			exit;
		}
	}

	error_reporting(1);

	if ($searchTextTitle != "")
	{
		$csql .= " AND ( article_title like ".$this->db->escape("%".$searchTextTitle."%")." OR article_details like ".$this->db->escape("%".$searchTextTitle."%")." OR article_en like ".$this->db->escape("%".$searchTextTitle."%")."  OR article_ch like ".$this->db->escape("%".$searchTextTitle."%").")";
	}

	if ($searchTextContent != "")
	{
		$csql .= " AND ( article_details like ".$this->db->escape("%".$searchTextContent."%")." OR article_en like ".$this->db->escape("%".$searchTextContent."%")."  OR article_ch like ".$this->db->escape("%".$searchTextContent."%").")";
	}

	if ($paidArticle == 1 and $eArticle==1)
	{
		$csql .= " AND (article_type=1 OR article_type=0) ";
	}
	elseif ($paidArticle == 1 and $eArticle==0)
	{
		$csql .= " AND (article_type=1) ";
	}
	elseif ($paidArticle == 0 and $eArticle==1)
	{
		$csql .= " AND (article_type=0) ";
	}

	$csql .= " ORDER BY STR_TO_DATE(article_date,'%d/%m/%Y') DESC";
	
	$totalRow=0;

	if ($articleId != "")
	{
	$csqlForArticleID .= " AND article_id=".$this->db->escape($articleId)."";
	$qRow = $this->db->query($csqlForArticleID);
	$totalRow=$qRow->num_rows();
	}
	else
	{
	$qRow = $this->db->query($csql);
	$totalRow=$qRow->num_rows();
	}
	if ($totalRow > 0)
	{
		$searchResultEmpty = false;
	}
	$lastPage = ceil($totalRow / $itemsPerPage);

	if ($start < 1 )
	{
		$start = 1;
	}
	else if ($start > $lastPage)
	{
		$start = $lastPage;
	}
	
	$end = $lastPage;
	$limit = ' LIMIT ' .($start - 1) * $itemsPerPage .',' .$itemsPerPage; 
	$csql .= $limit;
	if ($articleId != "")
	{
		$csql = $csqlForArticleID;
	}
	$q=$this->db->query($csql)->result();
	return $q;
}

public function article_search_new($articleLanguage,$searchText,$paidArticle,$eArticle,&$start,&$end,$itemsPerPage,&$searchResultEmpty)
{
	$csql="SELECT * FROM article_information WHERE article_active=1 and article_ready=1 ";

	if ($searchText != "")
	{
		$csql .= " AND ( article_title like ".$this->db->escape("%".$searchText."%")." OR article_details like ".$this->db->escape("%".$searchText."%")." OR article_en like ".$this->db->escape("%".$searchText."%")."  OR article_ch like ".$this->db->escape("%".$searchText."%").")";
	}

	if ($paidArticle == 1 and $eArticle==1)
	{
		$csql .= " AND (article_type=1 OR article_type=0) ";
	}
	elseif ($paidArticle == 1 and $eArticle==0)
	{
		$csql .= " AND (article_type=1) ";
	}
	elseif ($paidArticle == 0 and $eArticle==1)
	{
		$csql .= " AND (article_type=0) ";
	}

	$csql .= " ORDER BY STR_TO_DATE(article_date,'%d/%m/%Y') DESC";

	$qRow = $this->db->query($csql);
	$totalRow=$qRow->num_rows();
	$lastPage = ceil($totalRow / $itemsPerPage);

	if ($start < 1 )
	{
		$start = 1;
	}
	else if ($start > $lastPage)
	{
		$start = $lastPage;
	}
	if ($totalRow > 0)
	{
		$searchResultEmpty = false;
	}
	$end = $lastPage; 
	$limit = ' LIMIT ' .($start - 1) * $itemsPerPage .',' .$itemsPerPage; 
	$csql .= $limit;
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