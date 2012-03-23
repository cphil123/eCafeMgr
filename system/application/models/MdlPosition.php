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
class MdlPosition extends Model {

    function MdlPosition() {
        parent::Model();
    }

    function CountAll() {
        return $this->db->count_all('position');
    }

    function Insert($data) {
        $this->db->insert('position', $data);
    }

    function Update($data, $id) {
        $this->db->where("posid = '$id'");
        $this->db->update('position', $data);
    }

    function Delete($id) {
        $this->db->where("posid = '$id'");
        $this->db->delete('position');
    }

    function GetPrefixById($posid) {
        $this->db->select('prefix');
        $this->db->from('position');
        $this->db->where("posid = '$posid'");
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->prefix;
    }

}
?>
