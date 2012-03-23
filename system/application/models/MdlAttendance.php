<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlEmployees
 *
 * @author situs
 */
class MdlAttendance extends Model {

    function MdlAttendance() {
        parent::Model();
    }

    function CountAll() {
        return $this->db->count_all('employee');
    }

    function Insert($data) {
        $this->db->insert('employee', $data);
    }

    function Update($data, $id) {
        $this->db->where("empid = '$id'");
        $this->db->update('employee', $data);
    }

    function Delete($id) {
        $this->db->where("empid = '$id'");
        $this->db->delete('employee');
    }

}

?>
