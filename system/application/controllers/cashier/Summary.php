<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Summary
 *
 * @author situs
 */
class Summary extends Controller {

    function Summary() {
        parent::Controller();
        $this->load->helper('url');
        $this->table->realm = 'cashier/Summary';
        $this->load->database();
		$this->load->library('table');
		$this->load->helper('form');
		$this->load->model('MdlSummary');

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Summary');
        $this->view();
    }

	function view() {
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		if (is_array($refer)):
			extract($refer);		
		else:
			$startdate = $this->axo_common->today('ddmmyyyy');
		endif;

		if ($this->input->post('startdate')):
			$startdate = $this->input->post('startdate');
		endif;
				
		$dbdate = $this->axo_common->DatePostedToDateDb($startdate);

		$refer['startdate'] = $startdate;
		$this->axo_common->Set('VAR_REFERENCE', $refer);		
		$dtl['startdate'] = $this->axo_common->DatePostedToLongDateFormat($startdate);

		// today's revenue
		$ttlrevenue = $this->MdlSummary->TotalRevenueByDate($dbdate);
		
		// revenue MTD
		$ttlrevenue_mtd = $this->MdlSummary->TotalRevenueMTD($dbdate);

		// today's discount
		$ttldisc = $this->MdlSummary->TotalDiscountByDate($dbdate);

		// discount MTD
		$ttldisc_mtd = $this->MdlSummary->TotalDiscountMTD($dbdate);

		// today's taax
		$ttltax = $this->MdlSummary->TotalTaxByDate($dbdate);

		// tax MTD
		$ttltax_mtd = $this->MdlSummary->TotalTaxMTD($dbdate);

		// today's number of pax
		$ttlpax = $this->MdlSummary->TotalPaxByDate($dbdate);

		// number of pax MTD
		$ttlpax_mtd = $this->MdlSummary->TotalPaxMTD($dbdate);

		// total void
		$ttlvoid = $this->MdlSummary->TotalVoidByDate($dbdate);		
		
		// void MTD
		$ttlvoid_mtd = $this->MdlSummary->TotalVoidMTD($dbdate);

		// number of guest each group
		$result = $this->MdlSummary->ListPaxPerGroupByDate($dbdate);
		if ($result):
			$head = array(
				'rownum' => '#',
				'nmgroup' => 'Group Description',
				'ttlgroup' => 'Number of KOT',
				'ttlpax' => 'Number of Pax',
				'totalrev' => 'Total Revenue'
			);
			$tbl_config = array(
				'tb_width' => '100%',
				'col_format' => array(
					COL_FORMAT_IS_TEXT,
					COL_FORMAT_IS_TEXT_CENTER,
					COL_FORMAT_IS_TEXT_CENTER,
					COL_FORMAT_IS_CURRENCY,
					COL_FORMAT_IS_NONE
				),
				'noselect' => true,
				'noaction' => true,
				'nocheckbox' => true
			);
			$ttlpergroup = $this->table->generate($result, 'ctid', $head, $segment, $tbl_config);
		else:
			$ttlpergroup = '<h4 style="color: red;">No pax per group.</h4>';
		endif;
		$this->table->clear();
						
		// number of guest each group MTD
		$result = $this->MdlSummary->ListPaxPerGroupMTD($dbdate);
		if ($result):
			$head = array(
				'rownum' => '#',
				'nmgroup' => 'Group Description',
				'ttlgroup' => 'Number of KOT',
				'ttlpax' => 'Number of Pax',
				'totalrev' => 'Total Revenue'
			);
			$tbl_config = array(
				'tb_width' => '100%',
				'col_format' => array(
					COL_FORMAT_IS_TEXT,
					COL_FORMAT_IS_TEXT_CENTER,
					COL_FORMAT_IS_TEXT_CENTER,
					COL_FORMAT_IS_CURRENCY,
					COL_FORMAT_IS_NONE
				),
				'noselect' => true,
				'noaction' => true,
				'nocheckbox' => true
			);
			$ttlpergroup_mtd = $this->table->generate($result, 'ctid', $head, $segment, $tbl_config);
		else:
			$ttlpergroup_mtd = '<h4 style="color: red;">No pax per group.</h4>';
		endif;
		$this->table->clear();
						
		// today's guest comments
		$result = $this->MdlSummary->ListGuestCommentsByDate($dbdate);
		if ($result):
			$head = array(
				'rownum' => '#',
				'name' => 'Customer Name',
				'msg' => 'Feedback'
			);
			$tbl_config = array(
				'tb_width' => '100%',
				'col_format' => array(
					COL_FORMAT_IS_TEXT,
					COL_FORMAT_IS_TEXT
				),
				'noselect' => true,
				'noaction' => true,
				'nocheckbox' => true
			);
			$feedback = $this->table->generate($result, 'norec', $head, $segment, $tbl_config);
		else:
			$feedback = '<h4 style="color: red;">No feedback from guests.</h4>';
		endif;
		$this->table->clear();

        $content = array(
            'dtl' => $dtl,
			'sel_mon' => $this->axo_common->OptionsMonth($mon),
			'radio_dtrange' => $radio_dtrange,
            'ttlrevenue' => $this->axo_common->FormatCurrency($ttlrevenue),
            'ttldisc' => $this->axo_common->FormatCurrency($ttldisc),
            'ttltax' => $this->axo_common->FormatCurrency($ttltax),
            'ttlrevenue_mtd' => $this->axo_common->FormatCurrency($ttlrevenue_mtd),
            'ttldisc_mtd' => $this->axo_common->FormatCurrency($ttldisc_mtd),
            'ttltax_mtd' => $this->axo_common->FormatCurrency($ttltax_mtd),
            'ttlpax' => $this->axo_common->FormatNumber($ttlpax),
            'ttlpax_mtd' => $this->axo_common->FormatNumber($ttlpax_mtd),
            'ttlpergroup' => $ttlpergroup,
            'ttlpergroup_mtd' => $ttlpergroup_mtd,
            'feedback' => $feedback
        );
		$content = array_merge($content, $refer);
        $this->axo_template->deploy($content, 'cashier/summary/view');
	}

    function report() {
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		if (is_array($refer)):
			extract($refer);		
		else:
			$startdate = $this->axo_common->today('ddmmyyyy');
		endif;

		if ($this->input->post('startdate')):
			$startdate = $this->input->post('startdate');
		endif;
				
		$dbdate = $this->axo_common->DatePostedToDateDb($startdate);
		
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
        $this->cezpdf->ezText('SALES SUMMARY', 12, array('justification' => 'center'));
        $this->cezpdf->ezText('Date: '.$this->axo_common->DatePostedToLongDateFormat($startdate), 8, array('justification' => 'center'));
        $y = $this->cezpdf->ezText('');

        $colnames = array(
            'rownum' => '#',
            'nmgroup' => 'Group',
            'ttlgroup' => 'Number of KOT',
            'ttlpax' => 'Number of Pax',
            'totalrev' => 'Total Revenue'
        );

		// number of guest each group
		$dbdata = $this->MdlSummary->ListPaxPerGroupByDate($dbdate);
		if ($dbdata):
			$this->cezpdf->addText(70, $y, 8, '<b>Total Pax per Group for Current Date</b>');
			$this->cezpdf->ezSetY($y - 5);
			for ($i = 0; $i < count($dbdata); $i++):
				$coldata[$i] = get_object_vars($dbdata[$i]);			
				$coldata[$i]['rownum'] = $i + 1;
				$coldata[$i]['totalrev'] = $this->axo_common->FormatCurrency($dbdata[$i]->totalrev);
			endfor;
			$y = $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);
			$this->cezpdf->ezText("");

			$y -= 25;
			$ttldisc = $this->MdlSummary->TotalDiscountByDate($dbdate);
			$this->cezpdf->addText(70, $y, 8, 'Total Discount');
			$this->cezpdf->addText(180, $y, 8, ':');
			$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($ttldisc));

			$y -= 15;
			$ttltax = $this->MdlSummary->TotalTaxByDate($dbdate);
			$this->cezpdf->addText(70, $y, 8, 'Total Tax');
			$this->cezpdf->addText(180, $y, 8, ':');
			$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($ttltax));

			$y -= 15;
			$ttlrevenue = $this->MdlSummary->TotalRevenueByDate($dbdate);
			$this->cezpdf->addText(70, $y, 8, 'Total Revenue');
			$this->cezpdf->addText(180, $y, 8, ':');
			$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($ttlrevenue));

			$y -= 15;
			$ttlpax = $this->MdlSummary->TotalPaxByDate($dbdate);
			$this->cezpdf->addText(70, $y, 8, 'Total Pax');
			$this->cezpdf->addText(180, $y, 8, ':');
			$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatNumber($ttlpax));
		endif;
		
		// number of guest each group MTD
		$dbdata = $this->MdlSummary->ListPaxPerGroupMTD($dbdate);
		if ($dbdata):
			$this->cezpdf->addText(70, $y - 25, 8, '<b>Total Pax per Group for Month to Date</b>');
			$this->cezpdf->ezSetY($y - 30);
			for ($i = 0; $i < count($dbdata); $i++):
				$coldata[$i] = get_object_vars($dbdata[$i]);			
				$coldata[$i]['rownum'] = $i + 1;
				$coldata[$i]['totalrev'] = $this->axo_common->FormatCurrency($dbdata[$i]->totalrev);
			endfor;
			$y = $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);
			$this->cezpdf->ezText("");
			
			$y -= 25;
			$ttldisc_mtd = $this->MdlSummary->TotalDiscountMTD($dbdate);
			$this->cezpdf->addText(70, $y, 8, 'Total Discount');
			$this->cezpdf->addText(180, $y, 8, ':');
			$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($ttldisc_mtd));

			$y -= 15;
			$ttltax_mtd = $this->MdlSummary->TotalTaxMTD($dbdate);
			$this->cezpdf->addText(70, $y, 8, 'Total Tax');
			$this->cezpdf->addText(180, $y, 8, ':');
			$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($ttltax_mtd));

			$y -= 15;
			$ttlrevenue_mtd = $this->MdlSummary->TotalRevenueMTD($dbdate);
			$this->cezpdf->addText(70, $y, 8, 'Total Revenue');
			$this->cezpdf->addText(180, $y, 8, ':');
			$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($ttlrevenue_mtd));

			$y -= 15;
			$ttlpax_mtd = $this->MdlSummary->TotalPaxMTD($dbdate);
			$this->cezpdf->addText(70, $y, 8, 'Total Pax');
			$this->cezpdf->addText(180, $y, 8, ':');
			$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatNumber($ttlpax_mtd));
		endif;

        $colnames = array(
            'rownum' => '#',
            'name' => 'Name',
            'msg' => 'Comments'
        );

		// today's guest comments
		$dbdata = $this->MdlSummary->ListGuestCommentsByDate($dbdate);
		if ($dbdata):
			$this->cezpdf->addText(70, $y - 25, 8, '<b>Guest Comments for Current Date</b>');
			$this->cezpdf->ezSetY($y - 30);
			for ($i = 0; $i < count($dbdata); $i++):
				$coldata[$i] = get_object_vars($dbdata[$i]);			
				$coldata[$i]['rownum'] = $i + 1;
			endfor;
			$this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);
		endif;

        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
    }

}

?>
