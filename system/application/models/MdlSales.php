<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlSales
 *
 * @author situs
 */
class MdlSales extends Model {

    function MdlSales() {
        parent::Model();
    }

    function CountAll($where) {
        $query = $this->db->query("
            SELECT
                m.menuid
            FROM
                receipt r,menus m,dtlkot d,menucats c,tags t
			WHERE
				r.kotid = d.kotid AND d.menuid = m.menuid AND m.catid = c.catid AND m.tagid = t.tagid $where GROUP BY m.menuid
        ");
        return $query->num_rows;
    }

	function TotalAll($where) {
        $query = $this->db->query("
            SELECT
                SUM(m.price * d.qty) AS totalall
            FROM
                receipt r,menus m,dtlkot d,menucats c,tags t
			WHERE
				r.kotid = d.kotid AND d.menuid = m.menuid AND m.catid = c.catid AND m.tagid = t.tagid $where
        ");
		$total = $query->result();
        return $total[0]->totalall;
	}
}

?>
