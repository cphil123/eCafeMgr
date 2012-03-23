<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlDtlKot
 *
 * @author situs
 */
class MdlDtlKot extends Model {

    function MdlDtlKot() {
        parent::Model();
    }

    function SelectByKotId($kotid) {
        $query = $this->db->query("SELECT d.norec,@i:=@i+1 AS rownum,m.name,d.qty,m.price FROM (SELECT @i := 0) r,dtlkot d,menus m WHERE d.menuid = m.menuid AND d.kotid = '$kotid' AND d.is_void = 'N'");
        return $query->result();
    }
}
?>
