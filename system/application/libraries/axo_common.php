<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of axo_common
 *
 * @author situs
 */
class Axo_Common {

    var $ci;

    function Axo_Common() {
        $this->ci = &get_instance();
    }

	function UnitConversion($from, $to, $num) {
		if ($from == "kg"):
			if ($to == "gr"):
				return $num * 1000;
			else:
				return $num;
			endif;
		elseif ($from == "gr"):
			if ($to == "kg"):
				return $num / 1000;
			else:
				return $num;
			endif;
		elseif ($from == "ltr"):
			if ($to == "ml"):
				return $num * 1000;
			else:
				return $num;
			endif;
		elseif ($from == "ml"):
			if ($to == "ltr"):
				return $num / 1000;
			else:
				return $num;
			endif;
		else:
			return $num;
		endif;
	}

    function ObjToArray($obj) {
        $res = array();
        for ($i = 0; $i < count($obj); $i++):
            $res[$i] = get_object_vars($obj[$i]);
        endfor;
        return $res;
    }

	function LastDay($month = '', $year = '') {
		if (empty($month)) {
			$month = date('m');
		}
		if (empty($year)) {
			$year = date('Y');
		}
		$result = strtotime("{$year}-{$month}-01");
		$result = strtotime('-1 second', strtotime('+1 month', $result));
		return date('d', $result);
	}
	
    function Set($var, $val) {
//        $uvar = $this->ci->session->userdata($var);
//        if (empty($uvar) || (!empty($uvar) && $override)):
			$this->Erase($var);
            $this->ci->session->set_userdata($var, $val);
//        endif;
    }

    function Get($var) {
        return $this->ci->session->userdata($var);
    }

    function Erase($var) {
        $this->ci->session->unset_userdata($var);
    }

    function AutoPrefix($str, $len = 3) {
        $str = strtoupper($str);
        $key = array('A', 'E', 'I', 'O', 'U');
        $finished = false;
        $i = 0;
        $res = '';
        while (!$finished):
            $tmp = substr($str, $i, 1);
            if (!in_array($tmp, $key)):
                $res .= $tmp;
            endif;
            if ((strlen($res) < $len) && ($i >= strlen($str))):
                $res .= $tmp;
                $finished = true;
            endif;
            if (strlen($res) >= $len) {
                $finished = true;
            }
            $i++;
        endwhile;
        return $res;
    }

    function Select($cols = '', $from = '', $where = '', $segment = array(), $lim = 0, $group = "") {
        if (!empty($cols)):
            $this->ci->db->select($cols);
        endif;
		
        $this->ci->db->from($from);
		
        if (!empty($segment[4])):
            $this->ci->db->order_by($segment[4], strtoupper($segment[6]));
        endif;
        
		if (!empty($where)):
            $this->ci->db->where($where);
        endif;
		
		if (!empty($group)):
			$this->ci->db->group_by($group);
		endif;
        
		if (!empty($lim) || !empty($segment[7])):
            $this->ci->db->limit($lim, $segment[7]);
        endif;		
        
		$query = $this->ci->db->get();
        $this->numRows = $query->num_rows;
        
		return $query->result();
    }

    function DateDbToLongDateFormat($dt) {
        $arr = explode("-", $dt);
        return $arr[2] . ' ' . $this->ci->axo_common->mon_str($arr[1]) . ' ' . $arr[0];
    }

    function DatePostedToLongDateFormat($dt) {
        $arr = explode("-", $dt);
        return $arr[0] . ' ' . $this->ci->axo_common->mon_str($arr[1]) . ' ' . $arr[2];
    }

    function FormatUnit($unid) {
        $this->ci->db->select('desc');
        $this->ci->db->where("unid = '$unid'");
        $query = $this->ci->db->get('unit');
        $result = $query->result();
        return $result[0]->desc;
    }

    function FormatNumber($num) {
		$num *= 1;
		$dec = explode(".", $num);
		if (count($dec) > 1):
			$nums = $dec[0]."";
		else:
			$nums = $num;
		endif;
        $num_rev = strrev($nums);
        $num_ar = chunk_split($num_rev, 3, ":");
        $cur_ar = explode(":", $num_ar);
        foreach ($cur_ar as $val) {
            $cur[] = $val;
            $cur[] = ".";
        }
        array_pop($cur);
        array_pop($cur);
        array_pop($cur);
        $curr = implode("", $cur);
        if ($curr != ""):
            $curr = strrev($curr) . '';
			if (!empty($dec[1])):
				$curr .= ",".$dec[1];
			endif;
        endif;
        return $curr;
    }

    function FormatCurrency($num) {
		$num *= 1;
		$dec = explode(".", $num);
		if (count($dec) > 1):
			$num = floor($num);
			$dec = explode(".", $num);
			$nums = $dec[0]."";
		else:
			$nums = $num;
		endif;
        $num_rev = strrev($nums);
        $num_ar = chunk_split($num_rev, 3, ":");
        $cur_ar = explode(":", $num_ar);
        foreach ($cur_ar as $val) {
            $cur[] = $val;
            $cur[] = ".";
        }
        array_pop($cur);
        array_pop($cur);
        array_pop($cur);
        $curr = implode("", $cur);
        if ($curr != "") {
            $curr = strrev($curr) . '';
			if (!empty($dec[1])):
				$curr .= ",".$dec[1];
			endif;
        }
        return $this->ci->config->item("currency") . $curr;
    }

    function FreeSelect($select, $from, $where = "", $as_array = false, $groupby = "") {
		$qry = "SELECT $select FROM $from";
        
		if (!empty($where)):
            $qry .= " WHERE $where";
        endif;
		
		if (!empty($groupby)):
			$qry .= " GROUP BY $groupby";
		endif;
		
        $query = $this->ci->db->query($qry);
        if ($as_array):
            return $query->result_array();
        else:
            return $query->result();
        endif;
    }
	
	function GetFieldValue($table, $field, $where) {
		$result = $this->FreeSelect("`$field`", $table, $where);
		return $result[0]->$field;
	}

    function OptionsMonth($selected = "") {
        if (!empty($selected)):
            $sel_value[$selected] = ' selected';
        endif;
        $opt = '<option value="">-- Choose --</option>';
        $opt .= "\n";
        for ($i = 1; $i < 13; $i++):
            $opt .= '<option value="' . $i . '"' . $sel_value[$i] . '>' . $this->mon_str($i) . '</option>';
            $opt .= "\n";
        endfor;
        return $opt;
    }

    function OptionGroups($selected = "") {
        if (!empty($selected)):
            $sel_value[$selected] = ' selected';
        endif;
        $opt = '<option value="">-- Choose --</option>'."\n";
		$opt .= '<option value="CSR"' . $sel_value['CSR'] . '>Cashier</option>'."\n";
		$opt .= '<option value="PUR"' . $sel_value['PUR'] . '>Purchasing</option>'."\n";
		$opt .= '<option value="ADM"' . $sel_value['ADM'] . '>Office Administration</option>'."\n";
		$opt .= '<option value="ACC"' . $sel_value['ACC'] . '>Accounting / Finance</option>'."\n";
		$opt .= '<option value="OWN"' . $sel_value['OWN'] . '>Business Owner</option>'."\n";
		$opt .= '<option value="SPV"' . $sel_value['SPV'] . '>Supervisor</option>'."\n";
		$opt .= '<option value="GMG"' . $sel_value['GMG'] . '>General Manager</option>'."\n";
		$opt .= '<option value="OMG"' . $sel_value['OMG'] . '>Operational Manager</option>'."\n";
		$opt .= '<option value="SYS"' . $sel_value['SYS'] . '>Technical Support Officer</option>'."\n";
        return $opt;
    }
	
    function Options($table, $value, $display, $selected = "") {
        if (!empty($selected)):
            $sel_value[$selected] = ' selected';
        endif;
        $query = $this->ci->db->query("SELECT `$value`,`$display` FROM `$table` ORDER BY `$display`");
        $result = $query->result();
        $opt = '<option value="-1">-- Choose --</option>';
        $opt .= "\n";
        for ($i = 0; $i < $query->num_rows; $i++):
            $opt .= '<option value="' . $result[$i]->$value . '"' . $sel_value[$result[$i]->$value] . '>' . $result[$i]->$display . '</option>';
            $opt .= "\n";
        endfor;
        return $opt;
    }

    function GroupOptions($selected = "") {
        if (!empty($selected)):
            $sel_value[$selected] = ' selected';
        endif;
        $opt = '<option value="-1">-- Choose --</option>' . "\n";
		$opt .= '<option value="SYS"' . $sel_value['SYS'] . '>Technical Support Officer</option>' . "\n";
		$opt .= '<option value="CSR"' . $sel_value['CSR'] . '>Cashier</option>' . "\n";
		$opt .= '<option value="SPV"' . $sel_value['SPV'] . '>Supervisor</option>' . "\n";
		$opt .= '<option value="ADM"' . $sel_value['ADM'] . '>Office Administration</option>' . "\n";
		$opt .= '<option value="ACC"' . $sel_value['ACC'] . '>Accounting &amp; Finance</option>' . "\n";
		$opt .= '<option value="OMG"' . $sel_value['OMG'] . '>Operational Manager</option>' . "\n";
		$opt .= '<option value="GMG"' . $sel_value['GMG'] . '>General Manager</option>' . "\n";
		$opt .= '<option value="OWN"' . $sel_value['OWN'] . '>Business Owner</option>' . "\n";
		$opt .= '<option value="PUR"' . $sel_value['PUR'] . '>Purchasing</option>' . "\n";
        return $opt;
    }

    function RandomID($prefix, $short) {
        if ($short):
            $ran = rand(1, 9999);
        else:
            $ran = rand(1, 99999999);
        endif;

        if ($short):
            if (($ran < 10000) && ($ran > 1000)) {
                $kode = $prefix . "" . $ran;
            } else
            if (($ran < 1000) && ($ran > 100)) {
                $kode = $prefix . "0" . $ran;
            } else
            if (($ran < 100) && ($ran > 10)) {
                $kode = $prefix . "00" . $ran;
            } else
            if ($ran < 10) {
                $kode = $prefix . "000" . $ran;
            } else {
                $kode = $prefix . $ran;
            }
        else:
            if (($ran < 100000000) && ($ran > 10000000)) {
                $kode = $prefix . "0" . $ran;
            } else
            if (($ran < 10000000) && ($ran > 1000000)) {
                $kode = $prefix . "00" . $ran;
            } else
            if (($ran < 1000000) && ($ran > 100000)) {
                $kode = $prefix . "000" . $ran;
            } else
            if (($ran < 100000) && ($ran > 10000)) {
                $kode = $prefix . "0000" . $ran;
            } else
            if (($ran < 10000) && ($ran > 1000)) {
                $kode = $prefix . "00000" . $ran;
            } else
            if (($ran < 1000) && ($ran > 100)) {
                $kode = $prefix . "000000" . $ran;
            } else
            if (($ran < 100) && ($ran > 10)) {
                $kode = $prefix . "0000000" . $ran;
            } else
            if ($ran < 10) {
                $kode = $prefix . "00000000" . $ran;
            } else {
                $kode = $prefix . $ran;
            }
        endif;
        return $kode;
    }

    function NewID($prefix, $table, $key, $short = false) {
        $valid = false;
        $ran = 0;
        while (!$valid):
            $ran = $this->RandomID($prefix, $short);
            $this->ci->db->select($key);
            $this->ci->db->from($table);
            $this->ci->db->where($key, $ran);
            $query = $this->ci->db->get();
            if ($query->num_rows > 0):
                continue;
            else:
                $valid = true;
            endif;
        endwhile;
        return $ran;
    }

    function mon_str($m) {
        switch ($m) {
            case '1':
                $mstr = 'Jan';
                break;
            case '2':
                $mstr = 'Feb';
                break;
            case '3':
                $mstr = 'Mar';
                break;
            case '4':
                $mstr = 'Apr';
                break;
            case '5':
                $mstr = 'May';
                break;
            case '6':
                $mstr = 'Jun';
                break;
            case '7':
                $mstr = 'Jul';
                break;
            case '8':
                $mstr = 'Agt';
                break;
            case '9':
                $mstr = 'Sep';
                break;
            case '10':
                $mstr = 'Oct';
                break;
            case '11':
                $mstr = 'Nov';
                break;
            case '12':
                $mstr = 'Dec';
                break;
        }
        return $mstr;
    }

    function DatePostedToDateDb($dt) {
        $arr = explode("-", $dt);
        return $arr[2] . '-' . $arr[1] . '-' . $arr[0];
    }

    function DateDbToDatePosted($dt) {
        $arr = explode("-", $dt);
        return $arr[0] . '-' . $arr[1] . '-' . $arr[2];
    }

    function today($type = 'str') {
        $d = getdate();
        switch ($type) {
            case 'array':
                $dt['thn'] = $d['year'];
                $dt['bln'] = $d['mon'];
                $dt['tgl'] = $d['mday'];
                break;
            case 'db':
                $dt = $d['year'] . '-' . $d['mon'] . '-' . $d['mday'];
                break;
            case 'str':
                $mstr = $this->mon_str($d['mon']);
                $dt = $d['mday'] . ' ' . $mstr . ' ' . $d['year'];
                break;
            case 'ddmmyyyy':				
				if (($d['mday'] * 1) < 10):
					$d['mday'] = '0'.$d['mday'];
				endif;
				if (($d['mon'] * 1) < 10):
					$d['mon'] = '0'.$d['mon'];
				endif;
                $dt = $d['mday'] . '-' . $d['mon'] . '-' . $d['year'];
                break;
        }
        return $dt;
    }

	function curMonth() {
		$dt = $this->today('array');
		return $dt['bln'];
	}
	
	function curYear() {
		$dt = $this->today('array');
		return $dt['thn'];
	}
	
	function dumpResult($result) {
		error_reporting(E_NONE);
		foreach ($result as $data):
			var_dump($data);
			echo "<br>";
		endforeach;
	}
}

?>
