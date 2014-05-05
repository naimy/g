<?php
class config_model extends CI_Model {

    function getTitle() {
        $query = $this->db->query ("SELECT * FROM config where id_config = 1");
        $result = $query->result ();
        return $result;
    }

    function getAdress() {
    	$query = $this->db->query ("SELECT * FROM config where id_config != 1");
    	$result = $query->result ();
    	return $result;
    }

    function modifyTitle($value) {
        $query = $this->db->query ("UPDATE config SET title = '$value' WHERE id_config = 1");
    }

}