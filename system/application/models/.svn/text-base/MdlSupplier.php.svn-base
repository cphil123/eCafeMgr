<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlSupplier
 *
 * @author situs
 */
class MdlSupplier extends Model {

    function MdlSupplier() {
        parent::Model();
    }

    function CountAll() {
        $query = $this->db->query("
			SELECT supid FROM supplier
        ");
        return $query->num_rows;
    }

    function Insert($data) {
        $this->db->insert('supplier', $data);
    }

    function Update($data, $id) {
        $this->db->where("supid = '$id'");
        $this->db->update('supplier', $data);
    }

    function Delete($id) {
        $this->db->where("supid = '$id'");
        $this->db->delete('supplier');
    }


}

?>
