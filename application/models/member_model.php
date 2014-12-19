<?php
class member_model extends CI_Model
{
	public function member_search_advanced($memberTypes,$abusertypes,$orgName,$countryName,&$start,&$end,$itemsPerPage,&$searchResultEmpty)
	{
		$csql = "SELECT *,(SELECT COUNT(user_id) FROM user_website_html WHERE user_id = recordno) AS 'hasWebsite' FROM user_profile WHERE recordno <> '' ";
		$memberTypesSQLInit = " SELECT COUNT(user_id) FROM user_profile_selection_primary WHERE user_id=recordno AND ";
		$memberTypesSQL = "";

		if ($orgName != "") {
			$csql .= " AND ( user_orgname like ".$this->db->escape("%".$orgName."%")." )";
		}
		if ($countryName != "") {
			$csql .= " AND ( user_country like ".$this->db->escape("%".$countryName."%")." )";
		}
		foreach ($memberTypes as &$value) {
			if ($value == "ALL") {
				break;
			} else {
				$memberTypesSQL .= " selection = ".$this->db->escape($value)." OR ";
			}
		}
		if ($memberTypesSQL != "") {
			$memberTypesSQL = substr($memberTypesSQL, 0, -3);
			$csql .= " AND 0 <> ( ".$memberTypesSQLInit." ( ".$memberTypesSQL.") )";
		}

		$totalRow=0;
		$csql .= " ORDER BY hasWebsite DESC,last_updated DESC";
		$qRow = $this->db->query($csql);
		$totalRow=$qRow->num_rows();
		if ($totalRow > 0) {
			$searchResultEmpty = false;
		}
		$lastPage = ceil($totalRow / $itemsPerPage);

		if ($start < 1 ) {
			$start = 1;
		} else if ($start > $lastPage) 	{
			$start = $lastPage;
		}
		$end = $lastPage;
		$limit = ' LIMIT ' .($start - 1) * $itemsPerPage .',' .$itemsPerPage;
		$csql .= $limit;
		$q=$this->db->query($csql)->result();
		return $q;

	}

	public function getWebsiteContentAll() {
    $this->db->select('user_id');
    $this->db->from('user_website_html');
    $q = $this->db->get('');
    return $q->result();
  }

}