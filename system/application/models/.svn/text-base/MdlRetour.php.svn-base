<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlVoid
 *
 * @author situs
 */
 
class MdlRetour extends Model {

    function MdlRetour() {
        parent::Model();
    }

    function CountAll($where) {
        $query = $this->db->query("
			SELECT d.norec 
			FROM retour r,dtlretour d,materials m,categories c 
			WHERE r.retid = d.retid AND d.matid = m.matid AND m.catid = c.catid $where");
        return $query->num_rows;
    }
	
	function Insert($data) {
		$this->db->insert('retour', $data);
	}
	
	function Update($data, $id) {
		$this->db->where("retid = '$id'");
		$this->db->update('retour', $data);
	}
	
	function Delete($id) {
		$this->db->where("retid = '$id'");
		$this->db->delete('retour');
	}
}

?>
