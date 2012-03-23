<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlComposition
 *
 * @author situs
 */
class MdlComposition extends Model {

    function MdlComposition() {
        parent::Model();
    }

    function CountAll($id) {
        $this->db->select('comid');
        $this->db->where("comid = '$comid'");
        $query = $this->db->get('composition');
        return $query->num_rows();
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

    function SelectById($id) {
        $this->db->select('m.menuid,m.catid,m.tagid,m.name,m.price,c.name AS catname,t.desc AS tagname');
        $this->db->from('menus m');
        $this->db->join('menucats c', 'm.catid = c.catid', 'left');
        $this->db->join('tags t', 'm.tagid = t.tagid', 'left');
        $this->db->where("menuid = '$id'");
        $query = $this->db->get();
        return $query->result();
    }

	function GetHPP($menuid) {
		$query = $this->db->query("SELECT SUM(price) AS hpp FROM composition WHERE menuid = '$menuid'");
		$result = $query->result();
		return $result[0]->hpp;
	}

    function Insert($data) {
        $this->db->insert('composition', $data);
    }

    function Delete($id) {
        $this->db->where("comid = '$id'");
        $this->db->delete('composition');
    }

}

?>
