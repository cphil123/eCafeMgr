<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlProductCategories
 *
 * @author situs
 */
class MdlProductCategories extends Model {

    function MdlProductCategories() {
        parent::Model();
    }

    function GetPrefixById($catid) {
        $this->db->select('prefix');
        $this->db->from('menucats');
        $this->db->where("catid = '$catid'");
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->prefix;
    }

    function CountAll() {
        return $this->db->count_all('menucats');
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
        if (!empty($lim) || !empty($off)):
            $this->db->limit($lim, $off);
        endif;
        $query = $this->db->get();
        $this->numRows = $query->num_rows;
        return $query->result();
    }
	
	function Insert($data) {
		$this->db->insert('menucats', $data);
	}
	
	function Update($data, $id) {
		$this->db->where("catid = '$id'");
		$this->db->update('menucats', $data);
	}
	
	function Delete($id) {
		$this->db->where("catid = '$id'");
		$this->db->delete('menucats');
	}

}

?>
