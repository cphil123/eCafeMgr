<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlTableView
 *
 * @author situs
 */
class MdlTableView extends Model {

    var $numRows = 0;

    function MdlTableView() {
        parent::Model();
    }

    function CountAll() {
        $query = $this->db->get('tableview');
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

    function SelectById($id) {
        $this->db->select("tv.kotid,tv.tabid,tv.num,tv.custname,e.name");
        $this->db->from("tableview tv,employee e");
        $this->db->where("tv.server = e.empid");
        $this->db->where("tabid", $id);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	function Delete($id) {
		$query = $this->db->query("UPDATE tableview SET start = '00:00:00', end = '00:00:00', is_occupied = 'N', custname = '', server = '', kotid = '' WHERE tabid = '$id'");
	}
}

?>
