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
class MdlVoid extends Model {

    function MdlVoid() {
        parent::Model();
    }

    function CountAllByDate($axo_common, $startdate, $enddate) {
		$date1 = $axo_common->DatePostedToDateDb($startdate);
		$date2 = $axo_common->DatePostedToDateDb($enddate);
		$this->db->select("v.void");
		$this->db->where("v.date >= '$date1' AND v.date <= '$date2'");
        $query = $this->db->get('void v');
        return $query->num_rows;
    }

    function CountAllByMonth($mon, $year) {
		$this->db->select("v.void");
		$this->db->where("MONTH(v.date) = $mon AND YEAR(v.date) = $year");
        $query = $this->db->get('void v');
        return $query->num_rows;
    }

	function TotalVoidByDate($axo_common, $startdate, $enddate) {
		$date1 = $axo_common->DatePostedToDateDb($startdate);
		$date2 = $axo_common->DatePostedToDateDb($enddate);
		$this->db->select("SUM(m.price * d.qty) AS total");
		$this->db->where("v.void = d.void AND d.menuid = m.menuid AND v.date >= '$date1' AND v.date <= '$date2'");
        $query = $this->db->get('void v, dtlvoid d, menus m');
		$result = $query->result();
        return $result[0]->total;
	}
	
	function TotalVoidByMonth($mon, $year) {
		$this->db->select("SUM(m.price * d.qty) AS total");
		$this->db->where("v.void = d.void AND d.menuid = m.menuid AND MONTH(v.date) = $mon AND YEAR(v.date) = $year");
        $query = $this->db->get('void v, dtlvoid d, menus m');
		$result = $query->result();
        return $result[0]->total;
	}
	
	function IsKotExists($kotid) {
		$this->db->where("kotid = '$kotid'");
		$result = $this->db->get('void');
		if ($result->num_rows > 0):
			return true;
		else:
			return false;
		endif;
	}
	
	function Insert($data) {
		$this->db->insert('void', $data);
	}
	
	function Update($data, $id) {
		$this->db->where("void = '$id'");
		$this->db->update('void', $data);
	}
	
	function Delete($id) {
		$this->db->where("void = '$id'");
		$this->db->delete('void');
	}
}

?>
