<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlBilling
 *
 * @author situs
 */
class MdlSummary extends Model {

    var $numRows = 0;

    function MdlSummary() {
        parent::Model();
    }

	function TotalRevenueByDate($dbdate) {
		$query = $this->db->query("SELECT SUM(total) AS ttlrevenue FROM receipt WHERE `date` = '$dbdate'");
		$result = $query->result();
		return $result[0]->ttlrevenue;
	}
	
	function TotalRevenueMTD($dbdate) {
		$query = $this->db->query("SELECT SUM(total) AS ttlrevenue FROM receipt WHERE MONTH(date) = MONTH('$dbdate') AND YEAR(date) = YEAR('$dbdate') AND date <= '$dbdate'");
		$result = $query->result();
		return $result[0]->ttlrevenue;		
	}
	
	function TotalDiscountByDate($dbdate) {
		$query = $this->db->query("SELECT SUM((total * disc) / 100) AS ttldisc FROM receipt WHERE date = '$dbdate'");
		$result = $query->result();
		return $result[0]->ttldisc;
	}
	
	function TotalDiscountMTD($dbdate) {
		$query = $this->db->query("SELECT SUM((total * disc) / 100) AS ttldisc FROM receipt WHERE MONTH(date) = MONTH('$dbdate') AND YEAR(date) = YEAR('$dbdate') AND date <= '$dbdate'");
		$result = $query->result();
		return $result[0]->ttldisc;
	}
	
	function TotalTaxByDate($dbdate) {
		$query = $this->db->query("SELECT SUM((total * tax) / 100) AS ttltax FROM receipt WHERE date = '$dbdate'");
		$result = $query->result();
		return $result[0]->ttltax;
	}
	
	function TotalTaxMTD($dbdate) {
		$query = $this->db->query("SELECT SUM((total * tax) / 100) AS ttltax FROM receipt WHERE MONTH(date) = MONTH('$dbdate') AND YEAR(date) = YEAR('$dbdate') AND date <= '$dbdate'");
		$result = $query->result();
		return $result[0]->ttltax;
	}
	
	function TotalPaxByDate($dbdate) {
		$query = $this->db->query("SELECT SUM(pax) AS ttlpax FROM kot k WHERE k.date = '$dbdate'");
		$result = $query->result();
		return $result[0]->ttlpax;
	}
	
	function TotalPaxMTD($dbdate) {
		$query = $this->db->query("SELECT SUM(pax) AS ttlpax FROM kot k WHERE MONTH(k.date) = MONTH('$dbdate') AND YEAR(k.date) = YEAR('$dbdate') AND k.date <= '$dbdate'");
		$result = $query->result();
		return $result[0]->ttlpax;
	}
	
	function ListPaxPerGroupByDate($dbdate) {
		$query = $this->db->query("SELECT ct.ctid,ct.`desc` AS nmgroup,COUNT(k.kotid) AS ttlgroup,SUM(k.pax) AS ttlpax,SUM(r.total) AS totalrev FROM custype ct,kot k, receipt r WHERE r.kotid = k.kotid AND k.ctid = ct.ctid AND k.`date` = '$dbdate' GROUP BY k.ctid");
		return $query->result();
	}
	
	function ListPaxPerGroupMTD($dbdate) {
		$query = $this->db->query("SELECT ct.ctid,ct.`desc` AS nmgroup,COUNT(k.kotid) AS ttlgroup,SUM(pax) AS ttlpax,SUM(r.total) AS totalrev FROM custype ct,kot k, receipt r WHERE r.kotid = k.kotid AND k.ctid = ct.ctid AND MONTH(k.date) = MONTH('$dbdate') AND YEAR(k.date) = YEAR('$dbdate') AND k.date <= '$dbdate' GROUP BY k.ctid");
		return $query->result();
	}
	
	function TotalVoidByDate($dbdate) {
		$query = $this->db->query("SELECT SUM(d.qty * m.price) AS ttlvoid FROM void v,dtlvoid d,menus m WHERE v.void = d.void AND d.menuid = m.menuid AND v.`date` = '$dbdate'");
		$result = $query->result();
		return $result[0]->ttlvoid;
	}
	
	function TotalVoidMTD($dbdate) {
		$query = $this->db->query("SELECT SUM(d.qty * m.price) AS ttlvoid FROM void v,dtlvoid d,menus m WHERE v.void = d.void AND d.menuid = m.menuid AND MONTH(v.date) = MONTH('$dbdate') AND YEAR(v.date) = YEAR('$dbdate') AND v.date <= '$dbdate'");
		$result = $query->result();
		return $result[0]->ttlvoid;
	}
	
	function ListGuestCommentsByDate($dbdate) {
		$query = $this->db->query("SELECT norec,name,msg FROM feedback WHERE date = '$dbdate'");
		return $query->result();
	}
}

?>
