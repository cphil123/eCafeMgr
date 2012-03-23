<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlUsers
 *
 * @author situs
 */
class MdlFeedback extends Model {

    function MdlFeedback() {
        parent::Model();
    }

    function CountAll($where) {
		$query = $this->db->query("
			SELECT norec
			FROM feedback
			WHERE 1 = 1 $where
		");
        return $query->num_rows;
    }

	function Hide($id) {
		$this->db->where("norec = $id");
		$this->db->update('feedback', array('is_hide' => 'Y'));
	}
	
	function Unhide($id) {
		$this->db->where("norec = $id");
		$this->db->update('feedback', array('is_hide' => 'N'));
	}
}

?>
