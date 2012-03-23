<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Retour
 *
 * @author situs
 */
class Retour extends Controller {

    function Retour() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');

        $this->table->realm = 'inventory/Retour';
        $this->load->model('MdlSupplier');
        $this->load->model('MdlMaterials');
        $this->load->model('MdlRetour');
        $this->load->model('MdlCategories');
        $this->load->model('MdlDtlRetour');

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Retour');
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

		if ($this->input->post('catid')):
			$catid = $this->input->post('catid');
		endif;
		
		if ($this->input->post('dtrange')):
			$dtrange = $this->input->post('dtrange');
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('enddate');
			$mon = $this->input->post('mon');
			$year = $this->input->post('year');
		endif;
				
		$radio_dtrange[$dtrange] = 'checked';
		$where = "";
		switch ($dtrange):
			case 'bydate':
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$where .= " AND r.date >= '$date1' AND r.date <= '$date2'";
				break;
			case 'bymonth':
				$where .= " AND MONTH(r.date) = $mon AND YEAR(r.date) = $year";
				break;
		endswitch;

		$refer['dtrange'] = $dtrange;
		$refer['startdate'] = $startdate;
		$refer['enddate'] = $enddate;
		$refer['mon'] = $mon;
		$refer['year'] = $year;
		$refer['catid'] = $catid;
		$this->axo_common->Set('VAR_REFERENCE', $refer);

		$dtl['startdate'] = $this->axo_common->DatePostedToLongDateFormat($startdate);
		$dtl['enddate'] = $this->axo_common->DatePostedToLongDateFormat($enddate);
		$dtl['mon'] = $this->axo_common->mon_str($mon);
		$dtl['year'] = $year;

		if (!empty($catid) && $catid != -1):
			$dtl['catname'] = $this->axo_common->GetFieldValue('categories', 'name', "catid = '$catid'");
			$where .= " AND c.catid = '$catid' ";
		endif;		
		
        $this->pagination->initialize(array(
            'base_url' => base_url() . 'inventory/Retour/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlRetour->CountAll($where),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

		$query = $this->db->query("
			SELECT
				m.matid,
				d.qty,
				d.unid AS runid,
				m.price,
				m.unid AS sunid
			FROM
				retour r, dtlretour d, materials m
			LEFT JOIN categories c ON c.catid = m.catid
			WHERE
				r.retid = d.retid AND m.matid = d.matid
				$where
		");
		$rows = $query->result();
		$totalretour = 0;
		$totalitem = 0;
		foreach ($rows as $row):
			$matid = $row->matid;
			$qty = $row->qty;
			$runid = $row->runid;
			$sunid = $row->sunid;
			$price = $row->price;
			$runit = $this->axo_common->GetFieldValue("unit", "unit", "unid = '$runid'");
			$sunit = $this->axo_common->GetFieldValue("unit", "unit", "unid = '$sunid'");
			$cqty = $this->axo_common->UnitConversion($runit, $sunit, $qty);
			$totalretour += $cqty * $price;
			$totalitem++;
		endforeach;

        $query = $this->db->query("
			SELECT d.norec,r.`date`,c.name AS nmcat,m.name AS nmmat,m.price,d.qty,u.`desc` AS udesc,s.`desc` AS sdesc,d.notes
			FROM retour r, dtlretour d,unit u,status s, materials m
			LEFT JOIN categories c ON c.catid = m.catid 				
			WHERE d.matid = m.matid AND r.retid = d.retid AND d.unid = u.unid AND d.stid = s.stid $where
			ORDER BY " . $segment[4] . " ".$segment[6]."
			LIMIT " . $segment[7] . ", $per_page
		");
		$result = $query->result();
		
        if ($query->num_rows > 0):
            $head = array(
                'rownum' => '#',
                'date' => 'Retour Date',
                'nmcat' => 'Category',
                'nmmat' => 'Raw Material',
                'price' => 'Price',
                'qty' => 'Qty',
                'udesc' => 'Unit',
                'sdesc' => 'Status',
                'notes' => 'Notes'
            );
            $tbl_config = array(
                'tb_width' => '100%',
                'col_format' => array(
                    COL_FORMAT_IS_LONGDATE,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_NUMBER,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NONE
                ),
                'noaction' => true,
                'nocheckbox' => false,
                'noselect' => true,
                'offset' => $segment[7]
            );
            $datagrid = $this->table->generate($result, 'norec', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No data exists on database.</h3>';
        endif;

        $content = array(
			'totalitem' => $this->axo_common->FormatNumber($totalitem),
			'totalretour' => $this->axo_common->FormatCurrency($totalretour),
			'sel_cat' => $this->axo_common->Options('categories', 'catid', 'name', $catid),
            'sel_mon' => $this->axo_common->OptionsMonth($mon),
            'year' => $year,
            'date' => $this->axo_common->Get('date'),
            'radio_dtrange' => $radio_dtrange,
            'datagrid' => $datagrid,
			'radio_dtrange' => $radio_dtrange,
			'startdate' => $startdate,
			'enddate' => $enddate,
			'mon' => $mon,
			'year' => $year,
			'dtrange' => $dtrange,
            'pagination' => $this->pagination->create_links(),
			'dtl' => $dtl
        );
        $this->axo_template->deploy($content, 'inventory/retour/grid');
    }

    function add() {
		$this->form_validation->set_rules('startdate', 'Date', 'required');
		$this->form_validation->set_rules('uname', 'Operator', 'required');

		if ($this->form_validation->run()):
			$retid = $this->axo_common->NewID('R', 'retour', 'retid', true);
			$data = array(
				'retid' => $retid,
				'date' => $this->axo_common->DatePostedToDateDb($this->input->post('startdate', true)),
				'userid' => $this->input->post('userid', true)
			);
			$this->MdlRetour->Insert($data);
			redirect(base_url() . 'inventory/Retour/dtl/' . $retid, 'refresh');
		endif;

        if (!$this->input->post() || !$this->form_validation->run()):
            $content = array(
                'startdate' => $this->axo_common->today('ddmmyyyy'),
                'userid' => $this->session->userdata('userid'),
                'uname' => $this->session->userdata('uname')
            );
            $this->axo_template->deploy($content, 'inventory/retour/add');
        endif;
    }

    function dtl($retid) {
        switch ($this->uri->segment(5)):
            case 'cat':
                $catid = $this->uri->segment(6);
                break;
        endswitch;

		$this->form_validation->set_rules('matid', 'Item', 'required');
		$this->form_validation->set_rules('qty', 'Quantity', 'required');
		$this->form_validation->set_rules('stid', 'Status', 'required');
		$this->form_validation->set_rules('unid', 'Unit', 'required');

		if ($this->form_validation->run()):
			$matid = $this->input->post('matid', true);
			$qty = $this->input->post('qty', true);
			$notes = $this->input->post('notes', true);
			$stid = $this->input->post('stid', true);
			$unid = $this->input->post('unid', true);
			$query = $this->db->query("SELECT u.unit FROM materials m,unit u WHERE m.unid = u.unid AND m.matid = '$matid'");
			$result = $query->result();
			$unitname = $result[0]->unit;
			$unitretour = $this->axo_common->GetFieldValue("unit", "unit", "unid = '$unid'");
			$cqty = $this->axo_common->UnitConversion($unitretour, $unitname, $qty);
			$data = array(			
				'norec' => 'LAST_INSERT_ID()',
				'retid' => $retid,
				'stid' => $stid,
				'matid' => $matid,
				'qty' => $qty,
				'unid' => $unid,
				'notes' => $notes
			);
			$this->MdlDtlRetour->Insert($data);
			$this->MdlMaterials->DecStock($matid, $cqty);
			redirect(base_url() . 'inventory/Retour/dtl/' . $retid, 'refresh');
		endif;

        if (!$this->input->post() || !$this->form_validation->run()):
            $result = $this->axo_common->Select('m.matid,m.name AS nmmat,m.price,m.stock,u.desc AS unitname', 'materials m, unit u', "u.unid = m.unid AND m.catid = '$catid'");
            $head = array(
                'rownum' => '#',
                'nmmat' => 'Item Name',
				'price' => 'Price',
                'stock' => 'Stock',
                'unitname' => 'Unit'
            );
            $tbl_config = array(
                'tb_width' => '100%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_NUMBER,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NONE
                ),
                'nocheckbox' => true,
                'noaction' => true,
                'noselect' => false,
                'param' => array('matid', 'nmmat', 'price', 'stock', 'unitname')
            );
            $datagrid = $this->table->generate($result, 'matid', $head, $segment, $tbl_config);

            $result = $this->axo_common->FreeSelect('m.name AS nmmat,u.desc AS unitname', 'materials m, unit u', "m.matid = '$matid' AND m.unid = u.unid");

            $content = array(
				'date' => $this->axo_common->DateDbToLongDateFormat($dataref[0]->date),
                'matid' => $matid,
                'nmmat' => $result[0]->nmmat,
                'unitname' => $result[0]->unitname,
                'catid' => $catid,
                'cat_options' => $this->axo_common->Options('categories', 'catid', 'name', $catid),
                'sel_unit' => $this->axo_common->Options('unit', 'unid', 'desc', $unid),
                'sel_status' => $this->axo_common->Options('status', 'stid', 'desc', $stid),
                'datagrid' => $datagrid,
				'retid' => $retid
            );
            $this->axo_template->deploy($content, 'inventory/retour/dtl');
        endif;
    }

    function delete() {
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		extract($refer);

		$where = "";
		switch ($dtrange):
			case 'bydate':
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$where .= " AND r.date >= '$date1' AND r.date <= '$date2'";
				break;
			case 'bymonth':
				$where .= " AND MONTH(r.date) = $mon AND YEAR(r.date) = $year";
				break;
		endswitch;

		if (!empty($catid) && $catid != -1):
			$dtl['catname'] = $this->axo_common->GetFieldValue('categories', 'name', "catid = '$catid'");
			$where .= " AND c.catid = '$catid' ";
		endif;		
		
        $query = $this->db->query("
			SELECT d.norec,r.`date`,m.name AS nmmat
			FROM retour r, dtlretour d,materials m
			LEFT JOIN categories c ON c.catid = m.catid 				
			WHERE d.matid = m.matid AND r.retid = d.retid $where
			ORDER BY r.`date`
		");
		$result = $query->result_array();
        $retour = array();
        $i = 0;
        $ada = false;
        foreach ($result as $data):
            if ($this->input->post('cb-' . $data['norec'])):
                $ada = true;
                $retour[$i]['norec'] = $data['norec'];
                $retour[$i]['date'] = $data['date'];
                $retour[$i]['nmmat'] = $data['nmmat'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'inventory/Retour');
        else:
            $content = array(
				'retour' => $retour
            );
            $this->axo_template->deploy($content, 'inventory/retour/delete');
        endif;
    }

	function deleting() {		
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		extract($refer);

		$where = "";
		switch ($dtrange):
			case 'bydate':
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$where .= " AND r.date >= '$date1' AND r.date <= '$date2'";
				break;
			case 'bymonth':
				$where .= " AND MONTH(r.date) = $mon AND YEAR(r.date) = $year";
				break;
		endswitch;

		if (!empty($catid) && $catid != -1):
			$dtl['catname'] = $this->axo_common->GetFieldValue('categories', 'name', "catid = '$catid'");
			$where .= " AND c.catid = '$catid' ";
		endif;		
		
        $query = $this->db->query("
			SELECT d.norec,m.matid,u.unit,d.qty
			FROM retour r, dtlretour d, unit u, materials m
			LEFT JOIN categories c ON c.catid = m.catid 				
			WHERE d.matid = m.matid AND r.retid = d.retid AND d.unid = u.unid $where
			ORDER BY r.`date`
		");
		$result = $query->result_array();
        $retour = array();
        foreach ($result as $data):
            if ($this->input->post('cb-' . $data['norec'])):				
				$this->MdlDtlRetour->Delete($data['norec']);
				$matid = $data['matid'];
				$qty = $data['qty'];
				$unitretour = $data['unit'];				
				$query = $this->db->query("SELECT u.unit FROM materials m,unit u WHERE m.unid = u.unid AND m.matid = '$matid'");
				$result = $query->result();
				$unitname = $result[0]->unit;
				$cqty = $this->axo_common->UnitConversion($unitretour, $unitname, $qty);
				$this->MdlMaterials->IncStock($data['matid'], $cqty);
            endif;
        endforeach;
		redirect(base_url() . 'inventory/Retour');
	}
	
    function summary($ordernum) {
        $this->load->library('cezpdf');
        $this->cezpdf->ezSetCmMargins(4, 3, 4, 3);
        $tbcfg = array('xPos' => 'left', 'xOrientation' => 'right', 'width' => 800, 'fontSize' => 8);
        $data = $this->axo_common->FreeSelect('d.norec,p.orderdate,s.name AS nmsup,m.name AS nmmat,d.price,d.qty,u.desc,d.total', 'purchase p,dtlpurchase d,materials m,supplier s,unit u', "m.unid = u.unid AND p.supid = s.supid AND p.ordernum = d.ordernum AND d.matid = m.matid AND p.orderdate = '$dbdate'", true);
        $this->cezpdf->ezText('PURCHASING SUMMARY REPORT', 14, array('justification' => 'center'));
        $this->cezpdf->ezText('');
        $colnames = array(
            'norec' => '#',
            'orderdate' => 'Retour Date',
            'nmsup' => 'Supplier',
            'nmmat' => 'Item Description',
            'price' => 'Price',
            'qty' => 'Qty',
            'desc' => 'Unit',
            'total' => 'Total'
        );
        $tbcfg['showHeadings'] = 1;
        $tbcfg['width'] = 200;
        $tbcfg['showLines'] = 0;
        $tbcfg['shaded'] = 0;
        $this->cezpdf->ezTable($data, $colnames);
        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
    }

	function journal() {
        $per_page = 20;

        $segment[4] = $this->uri->segment(4);
        $segment[5] = $this->uri->segment(5);
        $segment[6] = $this->uri->segment(6);
        $segment[7] = $this->uri->segment(7);
        $segment[8] = $this->uri->segment(8);

        // order
        if (empty($segment[4])):
            $segment[4] = 'norec';
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

        $orderdate = $this->input->post('startdate1');
        if (!$orderdate):
            $orderdate = $this->axo_common->today('ddmmyyyy');
        endif;
        $dbdate = $this->axo_common->DatePostedToDateDb($orderdate);

        $this->pagination->initialize(array(
            'base_url' => base_url() . 'inventory/Retour/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlRetour->CountAll(),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->axo_common->Select(
			'd.norec,p.orderdate,s.name AS nmsup,m.name AS nmmat,d.price,d.qty,m.unid,d.total', 
			'purchase p,dtlpurchase d,materials m,supplier s', 
			"p.supid = s.supid AND p.ordernum = d.ordernum AND d.matid = m.matid AND p.orderdate = '$dbdate'", 
			$segment, $per_page);

        if ($result):
            $head = array(
                'rownum' => '#',
                'orderdate' => 'Retour Date',
                'nmsup' => 'Supplier',
                'nmmat' => 'Item Description',
                'price' => 'Price',
                'qty' => 'Qty',
                'desc' => 'Unit',
                'total' => 'Total'
            );
            $tbl_config = array(
                'tb_width' => '80%',
                'col_format' => array(
                    COL_FORMAT_IS_LONGDATE,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_NUMBER,
                    COL_FORMAT_IS_UNIT,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_NONE
                ),
                'noaction' => true,
                'nocheckbox' => false,
                'noselect' => true,
                'offset' => $segment[7]
            );
            $datagrid = $this->table->generate($result, 'name', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No data exists on database.</h3>';
        endif;

        $content = array(
            'datagrid' => $datagrid,
            'orderdate' => $orderdate,
            'pagination' => $this->pagination->create_links()
        );
        $this->axo_template->deploy($content, 'inventory/purchase/list');
	}

    function report() {
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		extract($refer);

		if ($this->input->post('catid')):
			$catid = $this->input->post('catid');
		endif;
		
		$where = "";
		switch ($dtrange):
			case 'bydate':
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$str_report_range = 'From ' . $this->axo_common->DateDbToLongDateFormat($startdate) . ' To ' . $this->axo_common->DateDbToLongDateFormat($enddate);
				$where .= " AND r.date >= '$date1' AND r.date <= '$date2'";
				break;
			case 'bymonth':
				$str_report_range = $this->axo_common->mon_str($mon) . ' ' . $year;
				$where .= " AND MONTH(r.date) = $mon AND YEAR(r.date) = $year";
				break;
		endswitch;

		if (!empty($catid) && $catid != -1):
			$where .= " AND c.catid = '$catid' ";
		endif;		
		
		$query = $this->db->query("
			SELECT
				m.matid,
				d.qty,
				d.unid AS runid,
				m.price,
				m.unid AS sunid
			FROM
				retour r, dtlretour d, materials m
			LEFT JOIN categories c ON c.catid = m.catid
			WHERE
				r.retid = d.retid AND m.matid = d.matid
				$where
		");
		$rows = $query->result();
		$totalretour = 0;
		$totalitem = 0;
		foreach ($rows as $row):
			$matid = $row->matid;
			$qty = $row->qty;
			$runid = $row->runid;
			$sunid = $row->sunid;
			$price = $row->price;
			$runit = $this->axo_common->GetFieldValue("unit", "unit", "unid = '$runid'");
			$sunit = $this->axo_common->GetFieldValue("unit", "unit", "unid = '$sunid'");
			$cqty = $this->axo_common->UnitConversion($runit, $sunit, $qty);
			$totalretour += $cqty * $price;
			$totalitem++;
		endforeach;

        $query = $this->db->query("
			SELECT d.norec,r.`date`,c.name AS nmcat,m.name AS nmmat,m.price,d.qty,u.`desc` AS udesc,s.`desc` AS sdesc,d.notes
			FROM retour r, dtlretour d,unit u,status s, materials m
			LEFT JOIN categories c ON c.catid = m.catid 				
			WHERE d.matid = m.matid AND r.retid = d.retid AND d.unid = u.unid AND d.stid = s.stid $where
			ORDER BY r.`date`
		");
		$result = $query->result();

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
        $this->cezpdf->ezText('Retour Journal', 12, array('justification' => 'center'));
        $this->cezpdf->ezText($str_report_range, 8, array('justification' => 'center'));
        $this->cezpdf->ezText('');

        $colnames = array(
            'rownum' => '#',
            'date' => 'Date',
            'nmcat' => 'Category',
            'nmmat' => 'Raw Material',
            'price' => 'Price',
			'qty' => 'Qty',
            'udesc' => 'Unit',
            'sdesc' => 'Status',
            'notes' => 'Notes'
        );

		$total = 0;
		$ttlpax = 0;
        for ($i = 0; $i < count($result); $i++):
			$coldata[$i]['rownum'] = $i + 1;
			$coldata[$i]['date'] = $this->axo_common->DateDbToLongDateFormat($result[$i]->date);
			$coldata[$i]['nmcat'] = $result[$i]->nmcat;
			$coldata[$i]['nmmat'] = $result[$i]->nmmat;
			$coldata[$i]['price'] = $this->axo_common->FormatCurrency($result[$i]->price);
			$coldata[$i]['qty'] = $this->axo_common->FormatNumber($result[$i]->qty);
			$coldata[$i]['udesc'] = $result[$i]->udesc;
			$coldata[$i]['sdesc'] = $result[$i]->sdesc;
			$coldata[$i]['notes'] = $result[$i]->notes;
        endfor;
		$y = $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);

		$y -= 25;
		$this->cezpdf->addText(70, $y, 8, 'Total Item');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatNumber($totalitem));

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Total Retour');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($totalretour));

        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
    }

}

?>
