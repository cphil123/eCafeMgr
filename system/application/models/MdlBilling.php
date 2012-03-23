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
class MdlBilling extends Model {

    var $numRows = 0;

    function MdlBilling() {
        parent::Model();
    }

    function CountAllByDate($axo_common, $startdate, $enddate, $ctid = "") {
		if (!empty($ctid)):
			$wctid = " AND k.ctid = $ctid";
		endif;
		$date1 = $axo_common->DatePostedToDateDb($startdate);
		$date2 = $axo_common->DatePostedToDateDb($enddate);
		$this->db->where("r.kotid = k.kotid AND r.date >= '$date1' AND r.date <= '$date2' $wctid");
        $query = $this->db->get('receipt r,kot k');
        return $query->num_rows;
    }

    function CountAllByMonth($mon, $year, $ctid = "") {
		if ($ctid != -1):
			$wctid = " AND k.ctid = $ctid";
		endif;
		$this->db->where("r.kotid = k.kotid AND MONTH(r.date) = $mon AND YEAR(r.date) = $year $wctid");
        $query = $this->db->get('receipt r,kot k');
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

	function Hide($id) {
		$this->db->query("UPDATE receipt SET is_hidden = 'Y' WHERE recid = '$id'");
	}
	
	function Unhide($id) {
		$this->db->query("UPDATE receipt SET is_hidden = 'N' WHERE recid = '$id'");
	}
	
}

?>
