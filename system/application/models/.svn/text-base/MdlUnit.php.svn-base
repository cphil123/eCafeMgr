<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlPosition
 *
 * @author situs
 */
class MdlUnit extends Model {

    function MdlUnit() {
        parent::Model();
    }

	function GetUnitFromId($unid) {
		$query = $this->db->query("SELECT unit FROM unit WHERE unid = '$unid'");
		$result = $query->result();
		return $result[0]->unit;
	}

}
?>
