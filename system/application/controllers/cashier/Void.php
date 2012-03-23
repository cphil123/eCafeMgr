<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Void
 *
 * @author situs
 */
class Void extends Controller {

    function Void() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'cashier/Void';
		
        $this->load->model('MdlKot');
        $this->load->model('MdlVoid');
        $this->load->model('MdlDtlVoid');

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Void');
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
				$totalrows = $this->MdlVoid->CountAllByDate($this->axo_common, $startdate, $enddate);
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$total = $this->MdlVoid->TotalVoidByDate($this->axo_common, $startdate, $enddate);
				$wdate = " v.date >= '$date1' AND v.date <= '$date2'";
				break;
			case 'bymonth':
				$totalrows = $this->MdlVoid->CountAllByMonth($mon, $year);
				$total = $this->MdlVoid->TotalVoidByMonth($mon, $year);
				$wdate = " MONTH(v.date) = $mon AND YEAR(v.date) = $year";
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

		$vdate = 'v.`date`, ';
		$col_format = array(
			COL_FORMAT_IS_TEXT_CENTER,
			COL_FORMAT_IS_LONGDATE,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_CURRENCY,
			COL_FORMAT_IS_NUMBER,
			COL_FORMAT_IS_CURRENCY,
			COL_FORMAT_IS_NONE
		);
		$head = array(
			'rownum' => '#',
			'kotid' => 'Order Ref.',
			'date' => 'Date',
			'nmmenu' => 'Product Name',
			'price' => 'Price',
			'qty' => 'Qty',
			'ttl' => 'Total'
		);

        $this->pagination->initialize(array(
            'base_url' => base_url() . 'cashier/Void/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $totalrows,
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

		$result = $this->axo_common->FreeSelect("d.norec,v.kotid,v.date,m.name AS nmmenu,m.price,d.qty,(m.price * d.qty) AS ttl", "void v, dtlvoid d,menus m", "v.void = d.void AND d.menuid = m.menuid AND $wdate");

        $tbl_config = array(
            'tb_width' => '100%',
            'col_format' => $col_format,
            'noaction' => true,
            'nocheckbox' => false,
            'noselect' => true
        );

        if ($result):
            $datagrid = $this->table->generate($result, 'norec', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No voids are available.</h3>';
        endif;

        $content = array(
            'date' => $this->axo_common->Get('date'),
            'datagrid' => $datagrid,
			'total' => $this->axo_common->FormatCurrency($total),
			'radio_dtrange' => $radio_dtrange,
			'startdate' => $startdate,
			'enddate' => $enddate,
			'sel_mon'=> $this->axo_common->OptionsMonth($mon),
			'mon' => $mon,
			'year' => $year,
			'dtrange' => $dtrange,
            'pagination' => $this->pagination->create_links(),
			'dtl' => $dtl
        );
        $this->axo_template->deploy($content, 'cashier/void/grid');
	}

	function kot_check($kotid) {
		if (empty($kotid)):
			$this->form_validation->set_message('kot_check', 'KOT reference cannot be empty.');
			return false;
		else:
			if ($this->MdlVoid->IsKotExists($kotid)):
				$this->form_validation->set_message('kot_check', 'Void for particular KOT reference already exists.');
				return false;
			else:
				if ($this->MdlKot->IsKotExists($kotid)):
					return true;
				else:
					$this->form_validation->set_message('kot_check', 'There\'s no such KOT reference exists.');
					return false;
				endif;
			endif;
		endif;
	}

	function add() {	
		if (!$this->input->post('date')):
			$date = $this->axo_common->today('ddmmyyyy');	
		else:
			$date = $this->input->post('date');	
		endif;

        if ($this->input->post('userid')):
            $this->form_validation->set_rules('kotid', 'KOT reference', 'callback_kot_check');

            if ($this->form_validation->run()):
		        $dbdate = $this->axo_common->DatePostedToDateDb($date);
				$kotid = $this->input->post('kotid');
				$userid = $this->input->post('userid');
                $void = 'V' . substr($kotid, 1);
                $data = array(
                    'void' => $void,
                    'kotid' => $kotid,
                    'date' => $dbdate,
                    'void_by' => $userid
                );
                $this->MdlVoid->Insert($data);
                redirect(base_url() . 'cashier/Void/dtl/' . $void, 'refresh');
            endif;
        endif;

        if (!$this->input->post() || !$this->form_validation->run()):
            $content = array(
                'date' => $date,
                'datagrid' => $datagrid,
                'userid' => $this->axo_common->Get('userid'),
                'uname' => $this->axo_common->Get('uname')
            );
            $this->axo_template->deploy($content, 'cashier/void/add');
        endif;
	}
	
	function dtl($void) {
		$kotid = 'K' . substr($void, 1);
		$this->form_validation->set_rules('menuid', 'Product', 'required');
		$this->form_validation->set_rules('qty', 'Quantity', 'required');

		if ($this->form_validation->run()):
			$menuid = $this->input->post('menuid', true);
			$qty = (int) $this->input->post('qty', true);
			$notes = (int) $this->input->post('notes', true);
			$data = array(
				'void' => $void,
				'menuid' => $menuid,
				'qty' => $qty,
				'notes' => $notes
			);
			$this->MdlDtlVoid->Insert($data);
			redirect(base_url() . 'cashier/Void/dtl/' . $void, 'refresh');
		endif;

        if (!$this->input->post() || !$this->form_validation->run()):			
            $result = $this->axo_common->FreeSelect("d.menuid,m.name,m.price,d.qty", "dtlkot d,menus m", "d.menuid = m.menuid AND d.kotid = '$kotid'");
            $head = array(
                'rownum' => '#',
                'name' => 'Product Name',
                'price' => 'Price',
                'qty' => 'Qty'
            );
            $tbl_config = array(
                'tb_width' => '100%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NUMBER,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NONE
                ),
                'nocheckbox' => true,
                'noaction' => true,
                'noselect' => false,
                'param' => array('menuid', 'name', 'price')
            );
            $datagrid = $this->table->generate($result, 'menuid', $head, $segment, $tbl_config);
			$result = $this->axo_common->FreeSelect("custname", "kot", "kotid = '$kotid'");
            $content = array(
                'void' => $void,
				'kotid' => $kotid,
				'custname' => $result[0]->custname,
                'datagrid' => $datagrid
            );
            $this->axo_template->deploy($content, 'cashier/void/dtl');
        endif;
	}	

	function cancel() {
		$query = $this->db->query("SELECT void FROM void");
		$result = $query->result();
		foreach ($result as $row):
			$void = $row->void;
			$query = $this->db->query("SELECT norec FROM dtlvoid WHERE void = '$void'");
			if ($query->num_rows > 0):
			else:
				$query = $this->db->query("DELETE FROM void WHERE void = '$void'");
			endif;
		endforeach;
		redirect(base_url() . 'cashier/Void');
	}
	
	function finish() {
		$this->cancel();
	}
	
    function delete() {
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		extract($refer);

		switch ($dtrange):
			case 'bydate':
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$wdate = " v.date >= '$date1' AND v.date <= '$date2'";
				break;
			case 'bymonth':
				$wdate = " MONTH(v.date) = $mon AND YEAR(v.date) = $year";
				break;
		endswitch;

		$date = $this->input->post('startdate1');
		$dbdate = $this->axo_common->DatePostedToDateDb($date);
        $res = $this->axo_common->FreeSelect('d.norec,m.name', 'void v, dtlvoid d,menus m', "v.void = d.void AND m.menuid = d.menuid AND $wdate", true);
        $void = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['norec'])):
                $ada = true;
                $void[$i]['norec'] = $data['norec'];
                $void[$i]['name'] = $data['name'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'cashier/Void');
        else:
            $content = array(
				'void' => $void
            );
            $this->axo_template->deploy($content, 'cashier/Void/delete');
        endif;
    }

    function deleting() {
        $res = $this->axo_common->FreeSelect('norec', 'dtlvoid', '', true);
        $divisi = array();
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['norec'])):
                $this->MdlDtlVoid->Delete($data['norec']);
            endif;
        endforeach;
        redirect(base_url() . 'cashier/Void');
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
				$wdate = " v.date >= '$startdate' AND v.date <= '$enddate'";
				break;
			case 'bymonth':
				$str_report_range = $this->axo_common->mon_str($mon) . ' ' . $year;
				$wdate = " MONTH(v.date) = $mon AND YEAR(v.date) = $year";
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
			'showLines' => 1
		);
		$this->cezpdf->addJpegFromFile('images/logo-kecil.jpg', 10, 770, 80);
        $this->cezpdf->ezText('Void', 12, array('justification' => 'center'));
        $this->cezpdf->ezText($str_report_range, 8, array('justification' => 'center'));
        $this->cezpdf->ezText('');

        $colnames = array(
            'rownum' => '#',
            'kotid' => 'Ref',
            'date' => 'Date',
            'nmmenu' => 'Product',
            'price' => 'Price',
            'qty' => 'Qty',
			'ttl' => 'Total'
        );

		if (!empty($ctid) && $ctid != -1):
			$wctid = " AND k.ctid = $ctid";
		endif;
		
		$result = $this->axo_common->FreeSelect("d.norec,v.kotid,v.date,m.name AS nmmenu,m.price,d.qty,(m.price * d.qty) AS ttl", "void v, dtlvoid d,menus m", "v.void = d.void AND d.menuid = m.menuid AND $wdate");
		$total = 0;
        for ($i = 0; $i < count($result); $i++):
			$coldata[$i]['rownum'] = $i + 1;
			$coldata[$i]['kotid'] = $result[$i]->kotid;
			$coldata[$i]['date'] = $this->axo_common->DateDbToLongDateFormat($result[$i]->date);
			$coldata[$i]['nmmenu'] = $result[$i]->nmmenu;
			$coldata[$i]['price'] = $this->axo_common->FormatCurrency($result[$i]->price);
			$coldata[$i]['qty'] = $this->axo_common->FormatNumber($result[$i]->qty);
			$coldata[$i]['ttl'] = $this->axo_common->FormatCurrency($result[$i]->ttl);
			$total += $result[$i]->ttl;
        endfor;
		$this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);
        $this->cezpdf->ezText('');
        $this->cezpdf->ezText("Total Void\t\t\t: " . $this->axo_common->FormatCurrency($total), 8, array('justification' => 'left'));

        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
    }

}

?>
