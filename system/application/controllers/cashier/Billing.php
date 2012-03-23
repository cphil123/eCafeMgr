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
class Billing extends Controller {

    function Billing() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'cashier/Billing';
        $this->load->model('MdlBilling');
        $this->load->model('MdlSummary');
        $this->load->database();

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Billing');
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
            $segment[4] = 'r.date';
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

		if ($this->input->post('ctid')):
			$ctid = $this->input->post('ctid');
		endif;
		
		if ($this->input->post('ptid')):
			$ptid = $this->input->post('ptid');
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
				$totalrows = $this->MdlBilling->CountAllByDate($this->axo_common, $startdate, $enddate, $ctid);
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$wdate = " r.date >= '$date1' AND r.date <= '$date2'";
				break;
			case 'bymonth':
				$totalrows = $this->MdlBilling->CountAllByMonth($mon, $year, $ctid);
				$wdate = " MONTH(r.date) = $mon AND YEAR(r.date) = $year";
				break;
		endswitch;

		$refer['dtrange'] = $dtrange;
		$refer['startdate'] = $startdate;
		$refer['enddate'] = $enddate;
		$refer['mon'] = $mon;
		$refer['year'] = $year;
		$refer['ctid'] = $ctid;		
		$refer['ptid'] = $ptid;		
		$this->axo_common->Set('VAR_REFERENCE', $refer);

		$dtl['startdate'] = $this->axo_common->DatePostedToLongDateFormat($startdate);
		$dtl['enddate'] = $this->axo_common->DatePostedToLongDateFormat($enddate);
		$dtl['mon'] = $this->axo_common->mon_str($mon);
		$dtl['year'] = $year;

		if (!empty($ptid) && $ptid != -1):
			$dtl['ptype'] = $this->axo_common->GetFieldValue('paytype', 'desc', "ptid = '$ptid'");
			$wctid = " AND r.ptid = '$ptid'";
		endif;		
		
		if (!empty($ctid) && $ctid != -1):
			$dtl['ctype'] = $this->axo_common->GetFieldValue('custype', 'desc', "ctid = '$ctid'");
			$wctid .= " AND k.ctid = '$ctid'";
		endif;		
		
		$vdate = 'r.`date`, ';
		$col_format = array(
			COL_FORMAT_IS_LONGDATE,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_CURRENCY,
			COL_FORMAT_IS_CURRENCY,
			COL_FORMAT_IS_CURRENCY,
			COL_FORMAT_IS_CURRENCY,
			COL_FORMAT_IS_TEXT_CENTER,
			COL_FORMAT_IS_NONE
		);
		$head = array(
			'rownum' => '#',
			'r.date' => 'Date',
			'r.time' => 'Time',
			'custname' => 'Customer',
			'cdesc' => 'Group',
			'pdesc' => 'Payment Type',
			'total' => 'Total',
			'ptax' => 'Tax',
			'dsc' => 'Discount',
			'totalall' => 'Total Amount'
		);

        $this->pagination->initialize(array(
            'base_url' => base_url() . 'cashier/billing/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $totalrows,
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

		if ($this->session->userdata("tax_audit") == 'Y'):
			$tax_audit = ',r.is_hidden';
			$count_sql = " AND r.is_hidden = 'N'";
			array_pop($col_format);
			$col_format[count($col_format)] = COL_FORMAT_IS_TEXT_CENTER;
			$col_format[count($col_format) + 1] = COL_FORMAT_IS_NONE;
			$head['is_hidden'] = 'Hidden';
		else:
			$tax_audit = '';
		endif;

		// hitung total
        $result = $this->axo_common->FreeSelect(
			'SUM(r.`total`) AS ttl, SUM((r.`tax` * r.`total`) / 100) AS ttltax, SUM((r.`disc` * r.`total`) / 100) AS ttldisc, SUM(r.`totalall`) AS ttlall', 
			'receipt r, kot k', 
			"r.is_paid = 'Y' AND r.kotid = k.kotid $count_sql AND $wdate $wctid");
		$total = $result[0]->ttl;
		$totaldisc = $result[0]->ttldisc;
		$totaltax = $result[0]->ttltax;
		$totalall = $result[0]->ttlall;
		
        $result = $this->axo_common->Select(
			'r.`recid`, '.$vdate.'r.time,r.`custname`, ct.desc AS cdesc, pt.desc AS pdesc, r.`total`, ((r.`tax` * r.`total`) / 100) AS ptax, ((r.`disc` * r.`total`) / 100) AS dsc, r.`totalall`'.$tax_audit, 
			'receipt r, kot k, paytype pt,custype ct', "k.kotid = r.kotid AND k.ctid = ct.ctid AND r.ptid = pt.ptid AND r.is_paid = 'Y' AND $wdate $wctid", 
			$segment, $per_page);

        $tbl_config = array(
            'tb_width' => '100%',
            'col_format' => $col_format,
            'noaction' => true,
            'nocheckbox' => true,
            'noselect' => true,
			'customlink' => 'cashier/Billing/view'
        );
		
		if ($this->session->userdata("tax_audit") == 'Y'):
			$tbl_config['nocheckbox'] = false;
		endif;

        if ($result):
            $datagrid = $this->table->generate($result, 'recid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No billing statements are available.</h3>';
        endif;

        $content = array(
            'date' => $this->axo_common->Get('date'),
            'datagrid' => $datagrid,
			'total' => $this->axo_common->FormatCurrency($total),
			'totaldisc' => $this->axo_common->FormatCurrency($totaldisc),
			'totaltax' => $this->axo_common->FormatCurrency($totaltax),
			'totalall' => $this->axo_common->FormatCurrency($totalall),
			'radio_dtrange' => $radio_dtrange,
			'startdate' => $startdate,
			'enddate' => $enddate,
			'sel_mon'=> $this->axo_common->OptionsMonth($mon),
			'mon' => $mon,
			'year' => $year,
			'sel_payment' => $this->axo_common->Options("paytype", "ptid", "desc", $ptid),
			'sel_group' => $this->axo_common->Options("custype", "ctid", "desc", $ctid),
			'dtrange' => $dtrange,
            'pagination' => $this->pagination->create_links(),
			'dtl' => $dtl,
			'tax_audit' => $this->session->userdata('tax_audit')
        );
        $this->axo_template->deploy($content, 'cashier/billing/grid');
    }

    function view($id) {		
        $tview = $this->axo_common->FreeSelect('k.kotid,t.num,k.time,k.custname,e.name AS nmserver', 'receipt r,kot k, tableview t, employee e', "r.kotid = k.kotid AND t.tabid = k.tabid AND r.recid = '$id' AND k.server = e.empid", true);
        $dkot = $this->axo_common->FreeSelect('d.norec,m.name,d.qty,m.price,(d.qty * m.price) AS total,d.is_void,d.void_by', 'receipt r,menus m,dtlkot d,kot k', "k.kotid = r.kotid AND m.menuid = d.menuid AND d.kotid = k.kotid AND r.recid = '$id'");

        for ($i = 0; $i < count($dkot); $i++):
            $total += $dkot[$i]->qty * $dkot[$i]->price;
        endfor;
		
        $head = array(
            'rownum' => '#',
            'name' => 'Menu Item',
            'qty' => 'Qty',
            'price' => 'Price',
            'total' => 'Sub Total',
            'is_void' => 'Voided',
            'void_by' => 'Cashier'
        );

        $tbl_config = array(
            'tb_width' => '80%',
            'col_format' => array(
                COL_FORMAT_IS_TEXT,
                COL_FORMAT_IS_TEXT_CENTER,
                COL_FORMAT_IS_CURRENCY,
                COL_FORMAT_IS_CURRENCY,
                COL_FORMAT_IS_TEXT_CENTER,
                COL_FORMAT_IS_TEXT,
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

        $this->axo_template->deploy($content, 'cashier/billing/view');
    }

	function hide() {
        $res = $this->axo_common->FreeSelect('recid,custname,kotid', 'receipt', "", true);
        $receipt = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['recid'])):
                $ada = true;
                $receipt[$i]['recid'] = $data['recid'];
                $receipt[$i]['custname'] = $data['custname'];
                $receipt[$i]['kotid'] = $data['kotid'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'cashier/Billing');
        else:
            $content = array(
                'receipt' => $receipt
            );
            $this->axo_template->deploy($content, 'cashier/Billing/hide');
        endif;
	}

	function hiding() {
        $res = $this->axo_common->FreeSelect('recid', 'receipt', "", true);
        $i = 0;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['recid'])):
				$this->MdlBilling->Hide($data['recid']);
			endif;
        endforeach;
        redirect('cashier/Billing', 'refresh');
	}
	
	function unhide() {
        $res = $this->axo_common->FreeSelect('recid,custname,kotid', 'receipt', "", true);
        $receipt = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['recid'])):
                $ada = true;
                $receipt[$i]['recid'] = $data['recid'];
                $receipt[$i]['custname'] = $data['custname'];
                $receipt[$i]['kotid'] = $data['kotid'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'cashier/Billing');
        else:
            $content = array(
                'receipt' => $receipt
            );
            $this->axo_template->deploy($content, 'cashier/Billing/unhide');
        endif;
	}

	function unhiding() {
        $res = $this->axo_common->FreeSelect('recid', 'receipt', "", true);
        $i = 0;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['recid'])):
				$this->MdlBilling->Unhide($data['recid']);
			endif;
        endforeach;
        redirect('cashier/Billing', 'refresh');
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
				$wdate = " AND r.date >= '$startdate' AND r.date <= '$enddate'";
				break;
			case 'bymonth':
				$str_report_range = $this->axo_common->mon_str($mon) . ' ' . $year;
				$wdate = " AND MONTH(r.date) = $mon AND YEAR(r.date) = $year";
				break;
		endswitch;

		if (!empty($ptid) && $ptid != -1):
			$wctid = " AND r.ptid = $ptid";
		endif;
		
		if (!empty($ctid) && $ctid != -1):
			$wctid .= " AND k.ctid = $ctid";
		endif;
		
        $this->load->library('cezpdf');
        $this->cezpdf->ezSetCmMargins(3, 2, 2.5, 2);
		$vdate = 'r.date,';
		$colnames = array(
			'rownum' => '#',
			'date' => 'Date',
			'custname' => 'Customer',
			'cdesc' => 'Group',
			'pdesc' => 'Payment',
			'total' => 'Total',
			'ptax' => 'Tax',
			'dsc' => 'Discount',
			'totalall' => 'Total Payment'
		);
        $tbcfg = array(
			'xPos' => 'left', 
			'xOrientation' => 'right', 
			'width' => 480, 
			'fontSize' => 8, 
			'shaded' => 0, 
			'showLines' => 2
		);
		$this->cezpdf->addJpegFromFile('images/logo-kecil.jpg', 10, 770, 80);
        $this->cezpdf->ezText('Billing Statement', 12, array('justification' => 'center'));
        $this->cezpdf->ezText($str_report_range, 8, array('justification' => 'center'));
        $this->cezpdf->ezText('');
		
		if (!empty($ptype)):
			$this->cezpdf->ezText("Customer: " . $ptype, 8, array('justification' => 'left'));
		endif;
		
		if (!empty($ctype)):
			$this->cezpdf->ezText("Payment: " . $ctype, 8, array('justification' => 'left'));
		endif;
		
		if ($this->session->userdata("tax_audit") == 'Y'):
			$count_sql = " AND r.is_hidden = 'N'";
		endif;
		
		$segment = $this->axo_common->Get('segment');
		
		$query1 = $this->db->query("
			SELECT
			$vdate r.`custname`, ct.`desc` AS cdesc, pt.`desc` AS pdesc,r.`total`, ((r.`tax` * r.`total`) / 100) AS ptax, ((r.`disc` * r.`total`) / 100) AS dsc, r.`totalall`
			FROM
			receipt r, kot k,paytype pt,custype ct
			WHERE
			k.kotid = r.kotid AND k.ctid = ct.ctid AND r.ptid = pt.ptid $count_sql AND r.is_paid = 'Y' $wdate $wctid
			ORDER BY ".$segment[4]." ".strtoupper($segment[6])."
		");
        $result = $query1->result();
		$ttl = 0;
		$ttldisc = 0;
		$ttltax = 0;
		$total = 0;
        for ($i = 0; $i < count($result); $i++):
			$coldata[$i]['rownum'] = $i + 1;
			$coldata[$i]['date'] = $this->axo_common->DateDbToLongDateFormat($result[$i]->date);
			$coldata[$i]['custname'] = $result[$i]->custname;
			$coldata[$i]['cdesc'] = $result[$i]->cdesc;
			$coldata[$i]['pdesc'] = $result[$i]->pdesc;
			$coldata[$i]['total'] = $this->axo_common->FormatCurrency($result[$i]->total);
			$coldata[$i]['ptax'] = $this->axo_common->FormatCurrency($result[$i]->ptax);
			$coldata[$i]['dsc'] = $this->axo_common->FormatCurrency($result[$i]->dsc);
			$coldata[$i]['totalall'] = $this->axo_common->FormatCurrency($result[$i]->totalall);
			$ttl += $result[$i]->total;
			$ttldisc += $result[$i]->dsc;
			$ttltax += $result[$i]->ptax;
			$total += $result[$i]->totalall;
        endfor;
		$y = $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);
		
		$y -= 25;
		$this->cezpdf->addText(70, $y, 8, 'Total');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($ttl));

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Total Tax');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($ttltax));

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Total Discount');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($ttldisc));

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Total Gross Revenue');
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
