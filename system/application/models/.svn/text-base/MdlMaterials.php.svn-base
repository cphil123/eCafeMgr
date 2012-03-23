<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdlMaterials
 *
 * @author situs
 */
class MdlMaterials extends Model {

    function MdlMaterials() {
        parent::Model();
    }

    function CountAll($where) {
		$query = $this->db->query("
			SELECT m.matid,c.name AS ctrname,m.name,m.price,m.stock,m.unid,(m.price * m.stock) AS stockval
			FROM unit u, materials m
			LEFT JOIN counter c ON m.locid = c.locid
			WHERE m.unid = u.unid $where
		");
		return $query->num_rows;
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
        if (!empty($lim) && !empty($off)):
            $this->db->limit($lim, $off);
        endif;
        $query = $this->db->get();
        $this->numRows = $query->num_rows;
        return $query->result();
    }

    function SelectById($matid) {
        $this->db->select('m.matid,m.name,p.orderdate,m.price,m.stock,m.catid,m.locid,c.name AS catname,m.unid,u.desc AS udesc');
        $this->db->from('materials m');
        $this->db->join('categories c', 'c.catid = m.catid', 'left');
        $this->db->join('counter t', 't.locid = m.locid', 'left');
        $this->db->join('unit u', 'u.unid = m.unid', 'left');
        $this->db->join('dtlpurchase d', 'd.matid = m.matid', 'left');
        $this->db->join('purchase p', 'p.ordernum = d.ordernum', 'left');
        $this->db->where("m.matid = '$matid'");
        $query = $this->db->get();
        return $query->result();
    }

    function GetNameById($matid) {
        $this->db->select('name');
        $this->db->from('materials');
        $this->db->where("matid = '$matid'");
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->name;
    }
	
	function GetPricePerUnit($matid) {
        $this->db->select('price');
        $this->db->from('materials');
        $this->db->where("matid = '$matid'");
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->price;
	}
	
	function GetUnitFromStock($matid) {
        $this->db->select('u.unit');
        $this->db->from('materials m, unit u');
        $this->db->where("m.unid = u.unid AND m.matid = '$matid'");
        $query = $this->db->get();
        $result = $query->result();
        return $result[0]->unit;
	}	

    function Insert($data) {
        $this->db->insert('materials', $data);
    }

    function Update($data, $id) {
        $this->db->where("matid = '$id'");
        $this->db->update('materials', $data);
    }

    function Delete($id) {
		$this->db->query("UPDATE materials SET active = 'N' WHERE matid = '$id'");
    }

    function Reset($id) {
		$this->db->query("UPDATE materials SET stock = 0 WHERE matid = '$id'");
    }

	function UpdatePrice($id, $price) {
        $query = $this->db->query("UPDATE materials SET price = $price WHERE matid = '$id'");
	}

    function IncStock($id, $qty) {
        $query = $this->db->query("UPDATE materials SET stock = stock + $qty WHERE matid = '$id'");
    }

    function DecStock($id, $qty) {
        $query = $this->db->query("UPDATE materials SET stock = stock - $qty WHERE matid = '$id'");
    }

}

?>
