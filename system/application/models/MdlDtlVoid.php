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
class MdlDtlVoid extends Model {

    function MdlDtlVoid() {
        parent::Model();
    }

	function Insert($data) {
		$this->db->insert('dtlvoid', $data);
		$menuid = $data['menuid'];
		$qty = $data['qty'];
		
		$this->db->select("c.matid,c.qty,u.unit");
		$this->db->where("c.unid = u.unid AND c.menuid = '$menuid'");
		$query = $this->db->get("composition c,unit u");
		$result = $query->result();
		for ($i = 0; $i < count($result); $i++):
			$matid = $result[$i]->matid;
			$mqty = $result[$i]->qty;
			$munid = $result[$i]->unit;

			$this->db->select("u.unit");
			$this->db->where("m.unid = u.unid AND m.matid = '$matid'");
			$qunit = $this->db->get("materials m,unit u");
			$runit = $qunit->result();
			$mqty = $this->axo_common->UnitConversion($munid, $runit[0]->unit, $mqty);			
			$sqty = $mqty * $qty;
			$this->db->query("UPDATE materials SET stock = stock + $sqty WHERE matid = '$matid'");
		endfor;
	}
	
	function Delete($id) {
		$query = $this->db->query("SELECT void,menuid,qty FROM dtlvoid WHERE norec = $id");
		$result = $query->result();
		$void = $result[0]->void;
		$menuid = $result[0]->menuid;
		$qty = $result[0]->qty;
		
		$this->db->select("c.matid,c.qty,u.unit");
		$this->db->where("c.unid = u.unid AND c.menuid = '$menuid'");
		$query = $this->db->get("composition c,unit u");
		$result = $query->result();
		for ($i = 0; $i < count($result); $i++):
			$matid = $result[$i]->matid;
			$mqty = $result[$i]->qty;
			$munid = $result[$i]->unit;
			
			$this->db->select("u.unit");
			$this->db->where("m.unid = u.unid AND m.matid = '$matid'");
			$qunit = $this->db->get("materials m,unit u");
			$runit = $qunit->result();
			$mqty = $this->axo_common->UnitConversion($munid, $runit[0]->unit, $mqty);			
			$sqty = $mqty * $qty;
			$this->db->query("UPDATE materials SET stock = stock - $sqty WHERE matid = '$matid'");
			
		endfor;		

		$query = $this->db->query("SELECT norec FROM dtlvoid WHERE void = '$void'");			
		if (!($query->num_rows() > 0)):				
			$this->db->query("DELETE FROM void WHERE void = '$void'");
		endif;

		$this->db->where("norec = $id");
		$this->db->delete('dtlvoid');
	}
}
?>
