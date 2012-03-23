<?
	session_start();
	error_reporting(E_ERROR);
	
	function _now($str = 'str') {
		$d = getdate();
		//$d['hours'] += 7;
		if ($d['hours'] >= 24) {
			$d['hours'] -= 24;
		}
		if ($d['hours'] < 10) {
			$d['hours'] = '0'.$d['hours'];
		}
		if ($d['minutes'] < 10) {
			$d['minutes'] = '0'.$d['minutes'];
		}
		switch($str) {
			case 'str':
				$dt = $d['hours'].':'.$d['minutes'].':'.$d['seconds'];
				break;
			case 'db':
				$dt = $d['hours'].':'.$d['minutes'].':'.$d['seconds'];
				break;
			case 'array':
				$dt['jam'] = $d['hours'];
				$dt['mnt'] = $d['minutes'];
				$dt['dtk'] = $d['seconds'];
				break;
		}
		return $dt;
	}

	function mon_str($m) {
		switch ($m) {
			case '1':
				$mstr = 'January';
				break;
			case '2':
				$mstr = 'February';
				break;
			case '3':
				$mstr = 'March';
				break;
			case '4':
				$mstr = 'April';
				break;
			case '5':
				$mstr = 'May';
				break;
			case '6':
				$mstr = 'June';
				break;
			case '7':
				$mstr = 'July';
				break;
			case '8':
				$mstr = 'August';
				break;
			case '9':
				$mstr = 'September';
				break;
			case '10':
				$mstr = 'October';
				break;
			case '11':
				$mstr = 'November';
				break;
			case '12':
				$mstr = 'December';
				break;
		}
		return $mstr;
	}

	function unit2str($un) {
		switch ($un) {
			case "kg":
            	$name = "Kgram";
                break;
			case "gr":
            	$name = "Gram";
                break;
			case "lt":
            	$name = "Liter";
                break;
			case "oz":
            	$name = "Ounce";
                break;
			case "un":
            	$name = "Unit";
                break;
			case "pcs":
            	$name = "Pieces";
                break;
		}		
		return $name;
	}
	
	function lastday($month = '', $year = '') {
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
	
	function _tgl_to_str($tgl) {
		$ex_tgl = explode("-", $tgl);
		return $ex_tgl[2].'/'.$ex_tgl[1].'/'.$ex_tgl[0];
	}

	function _str_to_tgl($str) {
		$ex_tgl = explode("/", $str);
		return $ex_tgl[2].'-'.$ex_tgl[1].'-'.$ex_tgl[0];
	}
	
	function _tgl_skrg_str() {
		$d = getdate();
		if ($d['mon'] < 10) {
			$d['mon'] = '0'.$d['mon'];
		}
		if ($d['mday'] < 10) {
			$d['mday'] = '0'.$d['mday'];
		}
		return $d['mday'].'/'.$d['mon'].'/'.$d['year'];
	}
	
 	function _format_uang($num) {
		// misal: num = 810000
		$num *= 1;
   		$num_rev = strrev($num);	// num_rev = 000018
		$num_ar = chunk_split($num_rev, 3, ":");	// num_ar = 000:018:
		$cur_ar = explode(":", $num_ar);	// cur_ar[0] = 000, cur_ar[1] = 018
		foreach($cur_ar as $val) {
			$cur[] = $val;
			$cur[] = ".";
		}
		/*
			cur[0] = 000
			cur[1] = . 
			cur[2] = 018
			cur[3] = .
		*/
		array_pop($cur);
		array_pop($cur);
		array_pop($cur);
		$curr = implode("", $cur);	// curr = 000.018
		if (empty($curr) || ($curr == 0)) {
			$curr = '0';
		} else {
			$curr = strrev($curr); // curr = Rp. 810.000,-
		}
		return $curr;
	}	
?>