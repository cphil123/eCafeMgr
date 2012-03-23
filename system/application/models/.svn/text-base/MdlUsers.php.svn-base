<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlUsers
 *
 * @author situs
 */
class MdlUsers extends Model {

    function MdlUsers() {
        parent::Model();
    }

    function CountAll($date = "", $cashier = "") {
        $where = "";
        if (!empty($date)):
            $where += "`date` = '$date'";
        endif;
        if (empty($cashier)):
            $group_by = "cashier";
        else:
            if (!empty($where)):
                $where += " AND ";
            endif;
            $where += "cashier = '$cashier'";
        endif;
        $query = $this->db->query("
            SELECT
                *,
                IF(cashend > 0,SUM(cashend - cashstart), 0) AS revenue,
                SUM(disc) AS discount
            FROM
                salesummary
            $where
            $group_by
        ");
        return $query->num_rows;
    }

	function Insert($data) {
		$this->db->insert("users", $data);
	}
	
	function Update($data, $id) {
		$this->db->where("userid = $id");
		$this->db->update("users", $data);
	}
	
	function Delete($id) {
		$this->db->where("userid = $id");
		$this->db->delete("users");
	}
	
}

?>
