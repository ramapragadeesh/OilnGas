<?php

class InitModel extends CI_Model
{


public function getPageTitle($pageindex)
{

switch ($pageindex)
	{	
		case "Home":
		return $this->getPageTitle_Data("Home");
		break;

	}

}

public function getPageTitle_Data($pageindex)
{
$pageTitle="";
 $this->db->select('');
 $this->db->from('ss_pagetitle');
 $this->db->where('ssp_PageId',$pageindex);
 $q = $this->db->get('');

  if($q->num_rows() > 0) 
        {
            foreach($q->result() as $row) 
            {
                $pageTitle=$row->ssp_homepageTitle;
            }
            return $pageTitle;
        }
}


}

?>