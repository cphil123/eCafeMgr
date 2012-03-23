<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlCategories
 *
 * @author situs
 */
class MdlCategories extends Model {

    function MdlCategories() {
        parent::Model();
    }

    function CountAll() {
        return $this->db->count_all('categories');
    }

    function Insert($data) {
        $this->db->insert('categories', $data);
    }

    function Update($data, $id) {
        $this->db->where("catid = '$id'");
        $this->db->update('categories', $data);
    }

    function Delete($id) {
        $this->db->where("catid = '$id'");
        $this->db->delete('categories');
    }

    function GetPrefixById($catid) {
        $this->db->select('prefix');
        $this->db->from('categories');
        $this->db->where("catid = '$catid'");
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->prefix;
    }

}

?>
