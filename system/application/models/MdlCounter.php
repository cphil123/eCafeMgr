<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlCounter
 *
 * @author situs
 */
class MdlCounter extends Model {

    function MdlCounter() {
        parent::Model();
    }

    function CountAll() {
        return $this->db->count_all('counter');
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

    function Insert($data) {
        $this->db->insert('counter', $data);
    }

    function Update($data, $id) {
        $this->db->where("locid = '$id'");
        $this->db->update('counter', $data);
    }

    function Delete($id) {
        $this->db->where("locid = '$id'");
        $this->db->delete('counter');
    }

}

?>
