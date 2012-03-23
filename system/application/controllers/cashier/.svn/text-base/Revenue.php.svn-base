<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Revenue
 *
 * @author situs
 */
class Revenue extends Controller {

    function Revenue() {
        parent::Controller();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'cashier/Revenue';
        $this->load->model('MdlRevenue');
        $this->load->database();

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Revenue');
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

		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		if ($refer):
			extract($refer);
		else:
			$dtrange = 'bydate';
			$startdate = $this->axo_common->today('ddmmyyyy');
			$enddate = $this->axo_common->today('ddmmyyyy');
			$mon = $this->axo_common->curMonth();
			$year = $this->axo_common->curYear();
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
				$totalrows = $this->MdlRevenue->CountAllByDate($this->axo_common, $startdate, $enddate);
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$wdate = "s.date >= '$date1' AND s.date <= '$date2'";
				break;
			case 'bymonth':
				$totalrows = $this->MdlRevenue->CountAllByMonth($mon, $year);
				$wdate = "MONTH(s.date) = $mon AND YEAR(s.date) = $year";
				break;
		endswitch;

		$refer['dtrange'] = $dtrange;
		$refer['startdate'] = $startdate;
		$refer['enddate'] = $enddate;
		$refer['mon'] = $mon;
		$refer['year'] = $year;
		$this->axo_common->Set('VAR_REFERENCE', $refer);

		$dtl['startdate'] = $this->axo_common->DatePostedToLongDateFormat($startdate);
		$dtl['enddate'] = $this->axo_common->DatePostedToLongDateFormat($enddate);
		$dtl['mon'] = $this->axo_common->mon_str($mon);
		$dtl['year'] = $year;

        $this->pagination->initialize(array(
            'base_url' => base_url() . 'cashier/Revenue/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/' . '/',
            'total_rows' => $totalrows,
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->MdlRevenue->Select('
            s.norec,s.date,s.cashier,s.cashstart,s.cashend,s.disc,s.tax
            ', 'salesummary s',
            "$wdate", $segment[4], $per_page, $segment[7]);
        $total = 0;
		$totaldsc = 0;
		$count = 0;
		$coldata = array();
        for ($i = 0; $i < count($result); $i++):
			$coldata[$i]->norec = $result[$i]->norec;			
			$coldata[$i]->date = $result[$i]->date;			
			$coldata[$i]->cashier = $result[$i]->cashier;			
			$count++;
			$coldata[$i]->principal = $result[$i]->cashstart;			
			$coldata[$i]->total = ($result[$i]->cashend - $result[$i]->cashstart - $result[$i]->tax + $result[$i]->disc);			
			$coldata[$i]->tax = $result[$i]->tax;			
			$coldata[$i]->disc = $result[$i]->disc;			
			$coldata[$i]->totalrev = $coldata[$i]->total - $coldata[$i]->disc + $coldata[$i]->tax;
			$total += $coldata[$i]->total;
			$totaldsc += $result[$i]->disc;
			$totaltax += $result[$i]->tax;
        endfor;
		$totalall = $total + $totaltax;
		
        if ($this->MdlRevenue->numRows > 0):
            $head = array(
                'rownum' => '#',
                'date' => 'Date',
                'cashier' => 'Cashier',
                'principal' => 'Principal',
                'total' => 'Total Sale',				
				'tax' => 'Tax',
                'disc' => 'Discount',
				'totalrev' => 'Revenue'
            );
            $tbl_config = array(
                'tb_width' => '80%',
                'col_format' => array(
                    COL_FORMAT_IS_LONGDATE,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_NONE
                ),
                'noselect' => true,
                'noaction' => true,
                'nocheckbox' => true
            );
            $datagrid = $this->table->generate($coldata, 'norec', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No data for particular date.</h3>';
        endif;

        $content = array(
            'sel_mon' => $this->axo_common->OptionsMonth($mon),
            'year' => $year,
            'date' => $this->axo_common->Get('date'),
            'radio_dtrange' => $radio_dtrange,
            'datagrid' => $datagrid,
            'total' => $this->axo_common->FormatCurrency($total),
            'totalall' => $this->axo_common->FormatCurrency($totalall),
            'ttlvoid' => $this->axo_common->FormatCurrency($ttlvoid),
            'average' => $this->axo_common->FormatCurrency($average),
            'totaldsc' => $this->axo_common->FormatCurrency($totaldsc),
            'totaltax' => $this->axo_common->FormatCurrency($totaltax),
			'showaverage' => $showaverage,
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
        $this->axo_template->deploy($content, 'cashier/revenue/grid');
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
				$wdate = " AND `date` >= '$startdate' AND `date` <= '$enddate'";
				break;
			case 'bymonth':
				$str_report_range = $this->axo_common->mon_str($mon) . ' ' . $year;
				$wdate = " AND MONTH(`date`) = $mon AND YEAR(`date`) = $year";
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
        $this->cezpdf->ezText('Revenue Journal', 12, array('justification' => 'center'));
        $this->cezpdf->ezText($str_report_range, 8, array('justification' => 'center'));
        $this->cezpdf->ezText('');

        $colnames = array(
            'rownum' => '#',
            'date' => 'Date',
            'cashier' => 'Cashier',
            'cashstart' => 'Principal',
            'stotal' => 'Total Sale',
            'stax' => 'Tax',
            'sdisc' => 'Discount',
            'srev' => 'Revenue'
        );

        $query1 = $this->db->query("
			SELECT
			`date`,cashier,cashstart,cashend,IF((cashend - cashstart) <= 0, 0, (cashend - cashstart + disc - tax)) AS stotal,IF((cashend - cashstart) <= 0, 0, (cashend - cashstart + disc)) AS sgross,disc AS sdisc,tax AS stax,(cashend - cashstart) AS srev
			FROM
			salesummary
			WHERE 1 = 1
			$wdate
		");
        $result = $query1->result();
		$total = 0;
		$ttlpax = 0;
        for ($i = 0; $i < count($result); $i++):
			$coldata[$i]['rownum'] = $i + 1;
			$coldata[$i]['date'] = $this->axo_common->DateDbToLongDateFormat($result[$i]->date);
			$coldata[$i]['cashier'] = $result[$i]->cashier;
			$coldata[$i]['cashstart'] = $this->axo_common->FormatCurrency($result[$i]->cashstart);
			$coldata[$i]['stotal'] = $this->axo_common->FormatCurrency($result[$i]->stotal);
			$coldata[$i]['sdisc'] = $this->axo_common->FormatCurrency($result[$i]->sdisc);
			$coldata[$i]['stax'] = $this->axo_common->FormatCurrency($result[$i]->stax);
			$coldata[$i]['srev'] = $this->axo_common->FormatCurrency($result[$i]->srev);
			$total += $result[$i]->sgross - $result[$i]->stax;
			$ttldisc += $result[$i]->sdisc;
			$ttltax += $result[$i]->stax;
			$totalall += $result[$i]->sgross;
        endfor;
		$y = $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);

		$y -= 25;
		$this->cezpdf->addText(70, $y, 8, 'Total');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($total));

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Total Tax');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($ttltax));

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Gross Revenue');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($totalall));

        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
    }

}

?>
