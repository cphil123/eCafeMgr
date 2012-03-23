<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Attendance
 *
 * @author situs
 */
class Attendance extends Controller {

    function Attendance() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'employees/Employees';
        $this->load->model('MdlAttendance');
        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Attendance');
        $this->grid();
    }

    function grid() {
        $per_page = 40;

        $segment[4] = $this->uri->segment(4);
        $segment[5] = $this->uri->segment(5);
        $segment[6] = $this->uri->segment(6);
        $segment[7] = $this->uri->segment(7);
        $segment[8] = $this->uri->segment(8);

        // order
        if (empty($segment[4])):
            $segment[4] = 'date';
        endif;

        // selected filter
        if (empty($segment[5])):
            $segment[5] = 'none';
        endif;

        // selected checkbox
        if (empty($segment[6])):
            $segment[6] = 'asc';
        endif;

        // offset paging
        if (empty($segment[7])):
            $segment[7] = '0';
        endif;

		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		if (is_array($refer)):
			extract($refer);
		else:
			$mon = $this->axo_common->curMonth();
			$year = $this->axo_common->curYear();
		endif;

		if ($this->input->post('empid')):
			$empid = $this->input->post('empid');
		endif;
		
		if ($this->input->post('mon') && $this->input->post('year')):
			$mon = $this->input->post('mon');
			$year = $this->input->post('year');
		endif;

		if (!empty($mon) && !empty($year)):
			$where .= " AND MONTH(date) = $mon AND YEAR(date) = $year";
		endif;

		$refer['mon'] = $mon;
		$refer['year'] = $year;
		$refer['empid'] = $empid;		
		$this->axo_common->Set('VAR_REFERENCE', $refer);
		
		$dtl['mon'] = $this->axo_common->mon_str($mon);
		$dtl['year'] = $year;

		if (!empty($empid) && $empid != -1):
			$dtl['empname'] = $this->axo_common->GetFieldValue('employee', 'name', "empid = '$empid'");
		endif;		
		
		$col_format = array(
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_NONE
		);
		$head = array(
			'rownum' => '#',
			'date' => 'Date',
			'checkin' => 'Check In',
			'checkout' => 'Check Out',
			'diff' => 'Total Hours'
		);

		if (!empty($empid)):
			$days = $this->axo_common->LastDay($mon, $year);
			for ($j = 0; $j < $days; $j++):			
				$date = $year.'-'.$mon.'-'.($j + 1);
    	        $query2 = $this->db->query("SELECT date,checkout,checkin,(checkout - checkin) AS `check`,TIMEDIFF(checkout,checkin) AS diff FROM attendance WHERE date = '$date' AND empid = '$empid' $where");
	            $dbdata = $query2->result();
				$max = count($dbdata);
				$max--;
				$coldata[$j]->rownum = $j;
				$coldata[$j]->date = $this->axo_common->DateDbToLongDateFormat($date);
				if ($dbdata):
					$coldata[$j]->checkout = $dbdata[$max]->checkout;
					$coldata[$j]->checkin = $dbdata[$max]->checkin;
					if ($dbdata[0]->check < 0):
						$coldata[$j]->diff = '-';
					else:
						$coldata[$j]->diff = $dbdata[$max]->diff;
					endif;
				else:
					$coldata[$j]->checkout = '-';
					$coldata[$j]->checkin = '-';
					$coldata[$j]->diff = '-';
				endif;
			endfor;
		endif;
		
        $this->pagination->initialize(array(
            'base_url' => base_url() . 'employees/Attendance/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/' . '/',
            'total_rows' => 31,
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        if (!empty($empid) && $empid != -1):
            $tbl_config = array(
                'tb_width' => '50%',
                'col_format' => $col_format,
                'nocheckbox' => true,
                'noaction' => true,
                'noselect' => true
            );
            $datagrid = $this->table->generate($coldata, 'rownum', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>Please, select employee first.</h3>';
        endif;

        $content = array(
            'sel_mon' => $this->axo_common->OptionsMonth($mon),
            'year' => $year,
            'datagrid' => $datagrid,
			'mon' => $mon,
			'year' => $year,
			'sel_emp' => $this->axo_common->Options("employee", "empid", "name", $empid),
			'dtrange' => $dtrange,
            'pagination' => $this->pagination->create_links(),
			'dtl' => $dtl
        );
        $this->axo_template->deploy($content, 'employees/attendance/grid');
    }

    function report() {
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		if (is_array($refer)):
			extract($refer);
		endif;
		
        $this->load->library('cezpdf');
        $this->cezpdf->ezSetCmMargins(3, 2, 3, 2);
        $tbcfg = array(
			'xPos' => 'left', 
			'xOrientation' => 'right', 
			'width' => 400, 
			'fontSize' => 8, 
			'shaded' => 0, 
			'showLines' => 2
		);
        $coldata = array();
        $ttlall = 0;
        for ($i = 0; $i < count($dbdata); $i++):
            $coldata[$i] = get_object_vars($dbdata[$i]);
            $coldata[$i]['date'] = $this->axo_common->DateDbToLongDateFormat($coldata[$i]['date']);
            $ttl = $coldata[$i]['cashend'] - $coldata[$i]['cashstart'] + $coldata[$i]['disc'];
            $coldata[$i]['cashstart'] = $this->axo_common->FormatCurrency($coldata[$i]['cashstart']);
            $coldata[$i]['cashend'] = $this->axo_common->FormatCurrency($coldata[$i]['cashend']);
            $coldata[$i]['disc'] = $this->axo_common->FormatCurrency($coldata[$i]['disc']);
            if ($ttl > 0):
                $ttlall += $ttl;
            endif;
        endfor;

        $colnames = array(
            'date' => 'Date',
            'checkin' => 'Check In',
            'checkout' => 'Check Out',
            'diff' => 'Duration'
        );

        $query1 = $this->db->query("SELECT e.empid,e.name,p.name AS nmpos FROM employee e,position p WHERE p.posid = e.posid AND e.empid = '$empid'");
        $result = $query1->result();
        for ($i = 0; $i < count($result); $i++):
            $this->cezpdf->ezText('ATTENDANCE REPORT', 12, array('justification' => 'left'));
            $this->cezpdf->ezText('Period: ' . $this->axo_common->mon_str($mon) .' '. $year, 10, array('justification' => 'left'));
			$this->cezpdf->ezText('');
            $this->cezpdf->ezText('Nama     		: ' . $result[$i]->name, 8, array('justification' => 'left'));
            $this->cezpdf->ezText('Jabatan  		: ' . $result[$i]->nmpos, 8, array('justification' => 'left'));
            $this->cezpdf->ezText('');
            $empid = $result[$i]->empid;
			$days = $this->axo_common->LastDay($mon, $year);
			for ($j = 0; $j < $days; $j++):			
				$date = $year.'-'.$mon.'-'.($j + 1);
    	        $query2 = $this->db->query("SELECT date,checkout,checkin,(checkout - checkin) AS `check`,TIMEDIFF(checkout,checkin) AS diff FROM attendance WHERE `date` = '$date' AND empid = '$empid'");
	            $dbdata = $query2->result();
				$coldata[$j]['date'] = $this->axo_common->DateDbToLongDateFormat($date);
				if ($dbdata):
					$coldata[$j]['checkout'] = $dbdata[0]->checkout;
					$coldata[$j]['checkin'] = $dbdata[0]->checkin;
					if ($dbdata[0]->check < 0):
						$coldata[$j]['diff'] = '-';
					else:
						$coldata[$j]['diff'] = $dbdata[0]->diff;
					endif;
				else:
					$coldata[$j]['checkout'] = '-';
					$coldata[$j]['checkin'] = '-';
					$coldata[$j]['diff'] = '-';
				endif;
			endfor;
            $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);
			$this->cezpdf->ezNewPage();
        endfor;

        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
    }

    function reportall() {
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		if (is_array($refer)):
			extract($refer);
		endif;
		
        $this->load->library('cezpdf');
        $this->cezpdf->ezSetCmMargins(3, 2, 3, 2);
        $tbcfg = array(
			'xPos' => 'left', 
			'xOrientation' => 'right', 
			'width' => 400, 
			'fontSize' => 8, 
			'shaded' => 0, 
			'showLines' => 2
		);
        $coldata = array();
        $ttlall = 0;
        for ($i = 0; $i < count($dbdata); $i++):
            $coldata[$i] = get_object_vars($dbdata[$i]);
            $coldata[$i]['date'] = $this->axo_common->DateDbToLongDateFormat($coldata[$i]['date']);
            $ttl = $coldata[$i]['cashend'] - $coldata[$i]['cashstart'] + $coldata[$i]['disc'];
            $coldata[$i]['cashstart'] = $this->axo_common->FormatCurrency($coldata[$i]['cashstart']);
            $coldata[$i]['cashend'] = $this->axo_common->FormatCurrency($coldata[$i]['cashend']);
            $coldata[$i]['disc'] = $this->axo_common->FormatCurrency($coldata[$i]['disc']);
            if ($ttl > 0):
                $ttlall += $ttl;
            endif;
        endfor;

        $colnames = array(
            'date' => 'Date',
            'checkin' => 'Check In',
            'checkout' => 'Check Out',
            'diff' => 'Duration'
        );

        $query1 = $this->db->query("SELECT e.empid,e.name,p.name AS nmpos FROM employee e,position p WHERE p.posid = e.posid");
        $result = $query1->result();
        for ($i = 0; $i < count($result); $i++):
            $this->cezpdf->ezText('ATTENDANCE REPORT', 12, array('justification' => 'left'));
            $this->cezpdf->ezText('Period: ' . $this->axo_common->mon_str($mon) .' '. $year, 10, array('justification' => 'left'));
			$this->cezpdf->ezText('');
            $this->cezpdf->ezText('Nama     		: ' . $result[$i]->name, 8, array('justification' => 'left'));
            $this->cezpdf->ezText('Jabatan  		: ' . $result[$i]->nmpos, 8, array('justification' => 'left'));
            $this->cezpdf->ezText('');
            $empid = $result[$i]->empid;
			$days = $this->axo_common->LastDay($mon, $year);
			for ($j = 0; $j < $days; $j++):			
				$date = $year.'-'.$mon.'-'.($j + 1);
    	        $query2 = $this->db->query("SELECT date,checkout,checkin,(checkout - checkin) AS `check`,TIMEDIFF(checkout,checkin) AS diff FROM attendance WHERE `date` = '$date' AND empid = '$empid'");
	            $dbdata = $query2->result();
				$coldata[$j]['date'] = $this->axo_common->DateDbToLongDateFormat($date);
				if ($dbdata):
					$coldata[$j]['checkout'] = $dbdata[0]->checkout;
					$coldata[$j]['checkin'] = $dbdata[0]->checkin;
					if ($dbdata[0]->check < 0):
						$coldata[$j]['diff'] = '-';
					else:
						$coldata[$j]['diff'] = $dbdata[0]->diff;
					endif;
				else:
					$coldata[$j]['checkout'] = '-';
					$coldata[$j]['checkin'] = '-';
					$coldata[$j]['diff'] = '-';
				endif;
			endfor;
            $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);
			$this->cezpdf->ezNewPage();
        endfor;

        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
    }
}

?>
