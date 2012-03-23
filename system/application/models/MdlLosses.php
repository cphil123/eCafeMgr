<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlLosses
 *
 * @author situs
 */
class MdlLosses extends Model {

    function MdlLosses() {
        parent::Model();
    }

    function CountAllByDate($axo_common, $startdate, $enddate) {
		$date1 = $axo_common->DatePostedToDateDb($startdate);
		$date2 = $axo_common->DatePostedToDateDb($enddate);
		$this->db->select("l.lossid");
		$this->db->where("l.date >= '$date1' AND l.date <= '$date2'");
        $query = $this->db->get('losses l');
        return $query->num_rows;
    }

    function CountAllByMonth($mon, $year) {
		$this->db->select("l.lossid");
		$this->db->where("MONTH(l.date) = $mon AND YEAR(l.date) = $year");
        $query = $this->db->get('losses l');
        return $query->num_rows;
    }

	function TotalLossesByDate($axo_common, $startdate, $enddate) {
		$date1 = $axo_common->DatePostedToDateDb($startdate);
		$date2 = $axo_common->DatePostedToDateDb($enddate);
		$this->db->select("SUM(m.price * d.qty) AS total");
		$this->db->where("l.lossid = d.lossid AND d.matid = m.matid AND l.date >= '$date1' AND l.date <= '$date2'");
        $query = $this->db->get('losses l, dtllosses d, materials m');
		$result = $query->result();
        return $result[0]->total;
	}
	
	function TotalLossesByMonth($mon, $year) {
		$this->db->select("SUM(m.price * d.qty) AS total");
		$this->db->where("l.lossid = d.lossid AND d.matid = m.matid AND MONTH(l.date) = $mon AND YEAR(l.date) = $year");
        $query = $this->db->get('losses l, dtllosses d, materials m');
		$result = $query->result();
        return $result[0]->total;
	}
	
	function Insert($data) {
		$this->db->insert('losses', $data);
	}
	
	function Update($data, $id) {
		$this->db->where("lossid = '$id'");
		$this->db->update('losses', $data);
	}
	
	function Delete($id) {
		$this->db->where("lossid = '$id'");
		$this->db->delete('losses');
	}
}

?>
