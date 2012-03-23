<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlKot
 *
 * @author situs
 */
class MdlKot extends Model {

    var $numRows = 0;

    function MdlKot() {
        parent::Model();
    }

	function IsKotExists($kotid) {
		$this->db->where("kotid = '$kotid'");
		$result = $this->db->get('kot');
		if ($result->num_rows > 0):
			return true;
		else:
			return false;
		endif;
	}
	
    function CountAllByDate($axo_common, $startdate, $enddate, $ctid = "") {
		if (!empty($ctid)):
			$wctid = " AND ctid = $ctid";
		endif;
		$date1 = $axo_common->DatePostedToDateDb($startdate);
		$date2 = $axo_common->DatePostedToDateDb($enddate);
		$this->db->where("date >= '$date1' AND date <= '$date2' $wctid");
        $query = $this->db->get('kot');
        return $query->num_rows;
    }

    function CountAllByMonth($mon, $year, $ctid = "") {
		if (!empty($ctid)):
			$wctid = " AND ctid = $ctid";
		endif;
		$this->db->where("MONTH(date) = $mon AND YEAR(date) = $year $wctid");
        $query = $this->db->get('kot');
        return $query->num_rows;
    }

    function Select($cols = '', $where = '', $order = '', $lim = 0, $off = 0) {
        if (!empty($cols)):
            $this->db->select($cols);
        endif;
        if (!empty($order)):
            $this->db->order_by($order, 'ASC');
        endif;
        if (!empty($where)):
            $this->db->where($where);
        endif;
        $this->db->limit($lim, $off);
        $query = $this->db->get('tableview');
        $this->numRows = $query->num_rows;
        return $query->result();
    }

}

?>
