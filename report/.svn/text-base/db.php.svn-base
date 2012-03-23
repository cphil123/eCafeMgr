<?php
	class Database {
		var $cid;
		var $rid;
		var $sql;
		
		function Database() {
			$this->cid = mysql_connect('localhost', 'root', '', true);
			//$this->cid = mysql_connect('172.18.100.15', 'root', '', true);
			mysql_select_db('restomanager', $this->cid);
		}
		
		function Query($str) {
			$this->sql = $str;
			$this->rid = mysql_query($str, $this->cid);
		}
		
		function Slashed($str) {
    		if (function_exists('mysql_real_escape_string')) {
				return mysql_real_escape_string($str, $this->cid);
    		} elseif (function_exists('mysql_escape_string')) {
      			return mysql_escape_string($str);
    		}
    		return addslashes($str);
		}
		
		function Row() {
			return mysql_fetch_row($this->rid);
		}
		
		function Assoc() {
			return mysql_fetch_assoc($this->rid);
		}
		
		function Object() {
			return mysql_fetch_object($this->rid);
		}
		
		function NRow() {
			$num = mysql_num_rows($this->rid);
			if ($num > 0) {
				return $num;
			} else {
				return 0;
			}
		}
		
		function Close() {
			mysql_close($this->cid);
		}
	}
?>
