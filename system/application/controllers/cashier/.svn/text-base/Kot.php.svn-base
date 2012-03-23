<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kot
 *
 * @author situs
 */
class Kot extends Controller {

    function Kot() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'cashier/Kot';
        $this->load->model('MdlKot');
        $this->load->database();

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Kot');
        $this->grid();
    }

    function grid() {
        $per_page = 20;

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

		$this->axo_common->Set('segment', $segment);

		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		if (is_array($refer)):
			extract($refer);		
		else:
			$dtrange = 'bydate';
			$startdate = $this->axo_common->today('ddmmyyyy');
			$enddate = $this->axo_common->today('ddmmyyyy');
			$mon = $this->axo_common->curMonth();
			$year = $this->axo_common->curYear();
		endif;

		if ($this->input->post('ctid') && $this->input->post('ctid') != -1):
			$ctid = $this->input->post('ctid');
		endif;
		
		if ($this->input->post('dtrange')):
			$dtrange = $this->input->post('dtrange');
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('enddate');
			$mon = $this->input->post('mon');
			$year = $this->input->post('year');
		endif;
				
		$radio_dtrange[$dtrange] = 'checked';
		switch ($dtrange):
			case 'bydate':
				$totalrows = $this->MdlKot->CountAllByDate($this->axo_common, $startdate, $enddate, $ctid);
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$wdate = " k.date >= '$date1' AND k.date <= '$date2'";
				break;
			case 'bymonth':
				$totalrows = $this->MdlKot->CountAllByMonth($mon, $year, $ctid);
				$wdate = " MONTH(k.date) = $mon AND YEAR(k.date) = $year";
				break;
		endswitch;

		$refer['dtrange'] = $dtrange;
		$refer['startdate'] = $startdate;
		$refer['enddate'] = $enddate;
		$refer['mon'] = $mon;
		$refer['year'] = $year;
		$refer['ctid'] = $ctid;		
		$this->axo_common->Set('VAR_REFERENCE', $refer);
		
		$dtl['startdate'] = $this->axo_common->DatePostedToLongDateFormat($startdate);
		$dtl['enddate'] = $this->axo_common->DatePostedToLongDateFormat($enddate);
		$dtl['mon'] = $this->axo_common->mon_str($mon);
		$dtl['year'] = $year;

		if (!empty($ctid) && $ctid != -1):
			$dtl['ctype'] = $this->axo_common->GetFieldValue('custype', 'desc', "ctid = $ctid");
			$wctid = " AND k.ctid = '$ctid'";
		endif;		
		
		$result = $this->axo_common->FreeSelect("SUM(d.qty * m.price) AS total", "kot k,menus m,dtlkot d", "k.kotid = d.kotid AND d.menuid = m.menuid AND $wdate $wctid");
		$total = $result[0]->total;
		$result = $this->axo_common->FreeSelect("SUM(pax) AS ttlpax", "kot k", "$wdate $wctid");
		$ttlpax = $result[0]->ttlpax;

		$vdate = 'k.`date`, ';

		$col_format = array(
			COL_FORMAT_IS_LONGDATE,
			COL_FORMAT_IS_TEXT_CENTER,
			COL_FORMAT_IS_TEXT_CENTER,
			COL_FORMAT_IS_TEXT_CENTER,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_NUMBER,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_CURRENCY,
			COL_FORMAT_IS_NONE
		);
		$head = array(
			'rownum' => '#',
			'date' => 'Date',
			'orderref' => 'Ref',
			'time' => 'Time',
			'num' => 'Table',
			'custname' => 'Customer',
			'pax' => 'Pax',
			'desc' => 'Group',
			'total' => 'Total'
		);

        $this->pagination->initialize(array(
            'base_url' => base_url() . 'cashier/kot/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/' . '/',
            'total_rows' => $totalrows,
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));
	
        $result = $this->axo_common->Select(
			'k.`kotid`, '.$vdate.'k.`kotid` AS orderref, k.`time`, tv.num, k.`custname`, k.`pax`, ct.desc, SUM(m.price * d.qty) AS total', 
			'kot k,tableview tv,custype ct,dtlkot d, menus m', 
			"ct.ctid = k.ctid AND k.kotid = d.kotid AND d.menuid = m.menuid AND k.tabid = tv.tabid AND $wdate $wctid", 
			$segment, $per_page, 'k.kotid');
		
        $tbl_config = array(
            'tb_width' => '100%',
            'col_format' => $col_format,
            'noaction' => false,
            'nocheckbox' => true,
            'noselect' => true,
            'justview' => true
        );
		
        if ($result):
            $datagrid = $this->table->generate($result, 'kotid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3 class="nodata">No KOTs are available.</h3>';
        endif;

        $content = array(
            'date' => $this->axo_common->Get('date'),
            'datagrid' => $datagrid,
			'total' => $this->axo_common->FormatCurrency($total),
			'ttlpax' => $this->axo_common->FormatNumber($ttlpax),
			'radio_dtrange' => $radio_dtrange,
			'startdate' => $startdate,
			'enddate' => $enddate,
			'sel_mon'=> $this->axo_common->OptionsMonth($mon),
			'mon' => $mon,
			'year' => $year,
			'sel_group' => $this->axo_common->Options("custype", "ctid", "desc", $ctid),
			'dtrange' => $dtrange,
            'pagination' => $this->pagination->create_links(),
			'dtl' => $dtl
        );
        $this->axo_template->deploy($content, 'cashier/kot/grid');
    }

    function view($id) {		
        $tview = $this->axo_common->FreeSelect('k.kotid,t.num,k.time,k.custname,e.name AS nmserver', 'kot k, tableview t, employee e', "t.tabid = k.tabid AND k.kotid = '$id' AND k.server = e.empid", true);
        $dkot = $this->axo_common->FreeSelect('d.norec,m.name,d.qty,m.price,(d.qty * m.price) AS total', 'menus m,dtlkot d,kot k', "m.menuid = d.menuid AND d.kotid = k.kotid AND k.kotid = '$id'");

        for ($i = 0; $i < count($dkot); $i++):
            $total += $dkot[$i]->qty * $dkot[$i]->price;
        endfor;
		
        $head = array(
            'rownum' => '#',
            'name' => 'Menu Item',
            'qty' => 'Qty',
            'price' => 'Price',
            'total' => 'Sub Total'
        );

        $tbl_config = array(
            'tb_width' => '60%',
            'col_format' => array(
                COL_FORMAT_IS_TEXT,
                COL_FORMAT_IS_TEXT_CENTER,
                COL_FORMAT_IS_CURRENCY,
                COL_FORMAT_IS_CURRENCY,
                COL_FORMAT_IS_NONE
            ),
            'noaction' => true,
            'nocheckbox' => true,
            'noselect' => true
        );

        $datagrid = $this->table->generate($dkot, 'norec', $head, $segment, $tbl_config);

        $content = array(
            'datagrid' => $datagrid,
            'tview' => $tview[0],
            'total' => $this->axo_common->FormatCurrency($total),
            'tabid' => $id
        );
		$content = array_merge($content, $this->axo_common->Get('VAR_REFERENCE'));

        $this->axo_template->deploy($content, 'cashier/kot/view');
    }

    function report() {
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		extract($refer);

		switch ($dtrange):
			case 'bydate':
				$startdate = $this->axo_common->DatePostedToDateDb($startdate);
				$enddate = $this->axo_common->DatePostedToDateDb($enddate);
				
				$str_report_range = 'From ' . $this->axo_common->DateDbToLongDateFormat($startdate) . ' To ' . $this->axo_common->DateDbToLongDateFormat($enddate);
				$wdate = " AND k.date >= '$startdate' AND k.date <= '$enddate'";
				break;
			case 'bymonth':
				$str_report_range = $this->axo_common->mon_str($mon) . ' ' . $year;
				$wdate = " AND MONTH(k.date) = $mon AND YEAR(k.date) = $year";
				break;
		endswitch;

        $this->load->library('cezpdf');
        $this->cezpdf->ezSetCmMargins(3, 2, 2.5, 2);
        $tbcfg = array(
			'xPos' => 'left', 
			'xOrientation' => 'right', 
			'width' => 480, 
			'fontSize' => 8, 
			'shaded' => 0, 
			'showLines' => 2
		);
		$this->cezpdf->addJpegFromFile('images/logo-kecil.jpg', 10, 770, 80);
        $this->cezpdf->ezText('Kitchen Order Ticket', 12, array('justification' => 'center'));
        $this->cezpdf->ezText($str_report_range, 8, array('justification' => 'center'));
        $this->cezpdf->ezText('');

        $colnames = array(
            'rownum' => '#',
            'date' => 'Date',
            'orderref' => 'Ref',
            'time' => 'Time',
            'num' => 'Table',
            'custname' => 'Customer',
            'pax' => 'Pax',
            'desc' => 'Group',
			'total' => 'Total'
        );

		if (!empty($ctid) && $ctid != -1):
			$wctid = " AND k.ctid = $ctid";
		endif;
		
		$segment = $this->axo_common->Get('segment');
		
        $query1 = $this->db->query("SELECT
			k.`kotid` AS orderref, k.date, k.time,tv.num, k.`custname`, k.`pax`, e.name AS nmserver, ct.desc, SUM(m.price * d.qty) AS total
			FROM kot k,tableview tv,employee e,custype ct,dtlkot d, menus m
			WHERE ct.ctid = k.ctid AND e.empid = k.server AND k.kotid = d.kotid AND d.menuid = m.menuid AND k.tabid = tv.tabid $wdate $wctid GROUP BY k.kotid 
			ORDER BY ".$segment[4]." ".strtoupper($segment[6]));
        $result = $query1->result();
		$total = 0;
		$ttlpax = 0;
        for ($i = 0; $i < count($result); $i++):
			$coldata[$i]['rownum'] = $i + 1;
			$coldata[$i]['orderref'] = $result[$i]->orderref;
			$coldata[$i]['date'] = $this->axo_common->DateDbToLongDateFormat($result[$i]->date);
			$coldata[$i]['time'] = $result[$i]->time;
			$coldata[$i]['num'] = $result[$i]->num;
			$coldata[$i]['custname'] = $result[$i]->custname;
			$coldata[$i]['pax'] = $this->axo_common->FormatNumber($result[$i]->pax);
			$coldata[$i]['desc'] = $result[$i]->desc;
			$coldata[$i]['total'] = $this->axo_common->FormatCurrency($result[$i]->total);
			$total += $result[$i]->total;
			$ttlpax += $result[$i]->pax;
        endfor;
		$y = $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);

		$y -= 25;
		$this->cezpdf->addText(70, $y, 8, 'Total Pax');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatNumber($ttlpax));

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Total Order');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($total));

        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
    }

}

?>
