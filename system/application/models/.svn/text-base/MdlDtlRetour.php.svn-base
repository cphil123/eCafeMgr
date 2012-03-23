<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlDtlRetour
 *
 * @author situs
 */
class MdlDtlRetour extends Model {

    function MdlDtlRetour() {
        parent::Model();
    }

    function Insert($data) {
        $this->db->insert('dtlretour', $data);
    }
	
	function Delete($id) {
		$this->db->where("norec = $id");
		$this->db->delete('dtlretour');
	}
}

?>
