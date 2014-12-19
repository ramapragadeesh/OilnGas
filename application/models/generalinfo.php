<?php

class generalinfo extends CI_Model
{


public function country_list()
{
 $sql = 'SELECT * FROM countries';
 $query = $this->db->query($sql);
    // Fetch the result array from the result object and return it
 $data["posts"] = json_encode($query->result());
 echo $data['posts'];
}
}
?>
