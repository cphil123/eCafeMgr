<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlPosition
 *
 * @author situs
 */
class MdlStatus extends Model {

    function MdlStatus() {
        parent::Model();
    }

    function CountAll() {
        return $this->db->count_all('status');
    }

    function Insert($data) {
        $this->db->insert('status', $data);
    }

    function Update($data, $id) {
        $this->db->where("stid = '$id'");
        $this->db->update('status', $data);
    }

    function Delete($id) {
        $this->db->where("stid = '$id'");
        $this->db->delete('status');
    }

}
?>
