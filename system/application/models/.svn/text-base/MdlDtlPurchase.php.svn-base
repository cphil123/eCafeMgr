<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlDtlPurchase
 *
 * @author situs
 */
class MdlDtlPurchase extends Model {

    function MdlDtlPurchase() {
        parent::Model();
    }

    function Insert($data) {
        $this->db->insert('dtlpurchase', $data);
    }
	
	function Delete($id) {
		$query = $this->db->query("SELECT matid,qty FROM dtlpurchase WHERE norec = $id");
		$result = $query->result();
		$matid = $result[0]->matid;
		$qty = $result[0]->qty;
		
		$query = $this->db->query("UPDATE materials SET stock = stock - $qty WHERE matid = '$matid'");
		
		$this->db->where("norec = $id");
		$this->db->delete('dtlpurchase');
	}
	
}

?>
