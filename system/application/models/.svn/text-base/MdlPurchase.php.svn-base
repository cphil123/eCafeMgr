<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlPurchase
 *
 * @author situs
 */
class MdlPurchase extends Model {

    function MdlPurchase() {
        parent::Model();
    }

    function CountAllByDate($axo_common, $startorderdate, $endorderdate, $catid = "", $supid = "") {
		if (!empty($catid)):
			$wcatid = " AND m.catid = '$catid'";
		endif;
		if (!empty($supid)):
			$wsupid = " AND p.supid = '$supid'";
		endif;
		$orderdate1 = $axo_common->DatePostedToDateDb($startorderdate);
		$orderdate2 = $axo_common->DatePostedToDateDb($endorderdate);
		$this->db->where("p.ordernum = d.ordernum AND d.matid = m.matid AND p.orderdate >= '$orderdate1' AND p.orderdate <= '$orderdate2' $wcatid $wsupid");
        $query = $this->db->get('purchase p,dtlpurchase d,materials m');
        return $query->num_rows;
    }

    function CountAllByMonth($mon, $year, $catid = "", $supid = "") {
		if (!empty($catid)):
			$wcatid = " AND m.catid = '$catid'";
		endif;
		if (!empty($supid)):
			$wsupid = " AND p.supid = '$supid'";
		endif;
		$this->db->where("p.ordernum = d.ordernum AND d.matid = m.matid AND MONTH(p.orderdate) = $mon AND YEAR(p.orderdate) = $year $wcatid $wsupid");
        $query = $this->db->get('purchase p,dtlpurchase d,materials m');
        return $query->num_rows;
    }

    function Select($cols = '', $from = '', $where = '', $order = '', $lim = 0, $off = 0) {
        if (!empty($cols)):
            $this->db->select($cols);
        endif;
        $this->db->from($from);
        if (!empty($order)):
            $this->db->order_by($order, 'ASC');
        endif;
        if (!empty($where)):
            $this->db->where($where);
        endif;
        $this->db->limit($lim, $off);
        $query = $this->db->get();
        $this->numRows = $query->num_rows;
        return $query->result();
    }

    function Insert($data) {
        $this->db->insert('purchase', $data);
    }
	
	function CleanUp() {
		$query = $this->db->query("SELECT ordernum FROM purchase");
		$result1 = $query->result();
		foreach ($result1 as $row):
			$ordernum = $row->ordernum;
			$query = $this->db->query("SELECT norec FROM dtlpurchase WHERE ordernum = '$ordernum'");
			$numrows = $query->num_rows();
			if (!($numrows > 0)):
				$query = $this->db->query("DELETE FROM purchase WHERE ordernum = '$ordernum'");
			endif;
		endforeach;
	}

}

?>
