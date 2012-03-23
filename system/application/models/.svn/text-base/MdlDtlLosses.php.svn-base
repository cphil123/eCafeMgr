<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlDtlKot
 *
 * @author situs
 */
class MdlDtlLosses extends Model {

    function MdlDtlLosses() {
        parent::Model();
    }

	function Insert($data) {
		$this->db->insert('dtllosses', $data);
		$matid = $data['matid'];
		$mqty = $data['qty'];
		
		$this->db->query("UPDATE materials SET stock = stock - $mqty WHERE matid = '$matid'");
	}
	
	function Delete($id) {
		$query = $this->db->query("SELECT matid,qty FROM dtllosses WHERE norec = $id");
		$result = $query->result();
		$matid = $result[0]->matid;
		$mqty = $result[0]->qty;
		
		$this->db->select("matid,qty");
		$this->db->where("matid = '$matid'");
		$query = $this->db->get("composition");
		$result = $query->result();
		for ($i = 0; $i < count($result); $i++):
			$matid = $result[$i]->matid;
			$sqty = $result[$i]->qty;
			$ttl = $sqty * $mqty;
			$this->db->query("UPDATE materials SET stock = stock - $ttl WHERE matid = '$matid'");
		endfor;		

		$this->db->where("norec = $id");
		$this->db->delete('dtllosses');
	}
}
?>
