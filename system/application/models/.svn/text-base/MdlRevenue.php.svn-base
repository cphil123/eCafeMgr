<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlRevenue
 *
 * @author situs
 */
class MdlRevenue extends Model {

    var $numRows = 0;

    function MdlRevenue() {
        parent::Model();
    }

    function CountAllByDate($axo_common, $startdate, $enddate) {
		$date1 = $axo_common->DatePostedToDateDb($startdate);
		$date2 = $axo_common->DatePostedToDateDb($enddate);
        $query = $this->db->query("
            SELECT
				norec
            FROM
                salesummary
            WHERE
				`date` >= '$date1' AND `date` <= '$date2'
        ");
        return $query->num_rows;
    }

    function CountAllByMonth($mon, $year) {
        $query = $this->db->query("
            SELECT
				norec
            FROM
                salesummary
            WHERE
				MONTH(`date`) = $mon AND YEAR(`date`) = $year
        ");
        return $query->num_rows;
    }

    function Select($cols = '', $from = '', $where = '', $order = '', $lim = 0, $off = 0) {
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
        $query = $this->db->get($from);
        $this->numRows = $query->num_rows;
        return $query->result();
    }

}

?>
