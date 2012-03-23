<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Purchase
 *
 * @author situs
 */
class Purchase extends Controller {

    function Purchase() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');

        $this->table->realm = 'inventory/purchase';
        $this->load->model('MdlSupplier');
        $this->load->model('MdlMaterials');
        $this->load->model('MdlPurchase');
        $this->load->model('MdlCategories');
        $this->load->model('MdlDtlPurchase');

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Purchase');
        $this->grid();
    }

    function grid($journal = false) {
		$this->MdlPurchase->CleanUp();

        $per_page = 20;

        $segment[4] = $this->uri->segment(4);
        $segment[5] = $this->uri->segment(5);
        $segment[6] = $this->uri->segment(6);
        $segment[7] = $this->uri->segment(7);
        $segment[8] = $this->uri->segment(8);

        // order
        if (empty($segment[4])):
            $segment[4] = 'nmsup';
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
			$dtrange = 'bydate';
			$startdate = $this->axo_common->today('ddmmyyyy');
			$enddate = $this->axo_common->today('ddmmyyyy');
			$mon = $this->axo_common->curMonth();
			$year = $this->axo_common->curYear();
		endif;

		if ($this->input->post('catid')):
			$catid = $this->input->post('catid');
		endif;
		
		if ($this->input->post('supid')):
			$supid = $this->input->post('supid');
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
				$totalrows = $this->MdlPurchase->CountAllByDate($this->axo_common, $startdate, $enddate, $catid, $supid);
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$wdate = " AND p.orderdate >= '$date1' AND p.orderdate <= '$date2'";
				break;
			case 'bymonth':
				$totalrows = $this->MdlPurchase->CountAllByMonth($mon, $year, $catid, $supid);
				$wdate = " AND MONTH(p.orderdate) = $mon AND YEAR(p.orderdate) = $year";
				break;
		endswitch;

		$refer['dtrange'] = $dtrange;
		$refer['startdate'] = $startdate;
		$refer['enddate'] = $enddate;
		$refer['mon'] = $mon;
		$refer['year'] = $year;
		$refer['catid'] = $catid;		
		$refer['supid'] = $supid;		
		$this->axo_common->Set('VAR_REFERENCE', $refer);

		$dtl['dtrange'] =  $dtrange;
		$dtl['startdate'] = $this->axo_common->DatePostedToLongDateFormat($startdate);
		$dtl['enddate'] = $this->axo_common->DatePostedToLongDateFormat($enddate);
		$dtl['mon'] = $this->axo_common->mon_str($mon);
		$dtl['year'] = $year;

		if (!empty($catid) && $catid != -1):
			$dtl['catname'] = $this->axo_common->GetFieldValue('categories', 'name', "catid = '$catid'");
			$wcatid = " AND m.catid = '$catid'";
		endif;		
		
		if (!empty($supid) && $supid != -1):
			$dtl['supname'] = $this->axo_common->GetFieldValue('supplier', 'name', "supid = '$supid'");
			$wsupid = " AND p.supid = '$supid'";
		endif;		
		
		$vdate = 'p.`orderdate`, ';
		$col_format = array(
			COL_FORMAT_IS_LONGDATE,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_TEXT,
			COL_FORMAT_IS_CURRENCY,
			COL_FORMAT_IS_NUMBER,
			COL_FORMAT_IS_UNIT,
			COL_FORMAT_IS_CURRENCY,
			COL_FORMAT_IS_NONE
		);
		$head = array(
			'rownum' => '#',
			'orderdate' => 'Purchase Date',
			'nmsup' => 'Supplier',
			'nmmat' => 'Item Description',
			'price' => 'Price',
			'qty' => 'Qty',
			'desc' => 'Unit',
			'total' => 'Total'
		);

		$this->pagination->initialize(array(
            'base_url' => base_url() . 'inventory/Purchase/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $totalrows,
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->axo_common->Select(
			'd.norec,p.orderdate,s.name AS nmsup,m.name AS nmmat,d.price,d.qty,m.unid,d.total', 
			'purchase p,dtlpurchase d,materials m,supplier s', 
			"p.supid = s.supid AND p.ordernum = d.ordernum AND d.matid = m.matid $wdate $wcatid $wsupid", 
			$segment, $per_page);

        if ($result):
            $tbl_config = array(
                'tb_width' => '100%',
                'col_format' => $col_format,
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
			'usergroup' => $this->axo_common->Get('usergroup'),
            'datagrid' => $datagrid,
            'orderdate' => $orderdate,
			'radio_dtrange' => $radio_dtrange,
			'startdate' => $startdate,
			'enddate' => $enddate,
			'sel_mon'=> $this->axo_common->OptionsMonth($mon),
			'mon' => $mon,
			'year' => $year,
			'sel_cat' => $this->axo_common->Options("categories", "catid", "name", $catid),
			'sel_sup' => $this->axo_common->Options("supplier", "supid", "name", $supid),
			'dtrange' => $dtrange,
            'pagination' => $this->pagination->create_links(),
			'dtl' => $dtl
        );
		if ($journal):
			$this->axo_template->deploy($content, 'inventory/purchase/list');
		else:
			$this->axo_template->deploy($content, 'inventory/purchase/grid');
		endif;
    }

    function add() {
        if ($this->input->post('formtype')):
            $this->form_validation->set_rules('startdate', 'Date', 'required');
            $this->form_validation->set_rules('supid', 'Supplier name', 'required');

            if ($this->form_validation->run()):
                $ordernum = $this->axo_common->NewID('P', 'purchase', 'ordernum');
                $data = array(
                    'ordernum' => $ordernum,
                    'orderdate' => $this->axo_common->DatePostedToDateDb($this->input->post('startdate', true)),
					'numref' => $this->input->post('numref', true),
                    'supid' => $this->input->post('supid', true),
                    'userid' => $this->input->post('userid', true),
                    'tax' => 0,
                    'total' => 0
                );
                $this->MdlPurchase->Insert($data);
                redirect(base_url() . 'inventory/Purchase/dtl/' . $ordernum, 'refresh');
            endif;
        endif;

        if (!$this->input->post() || !$this->form_validation->run()):
            $result = $this->axo_common->FreeSelect('supid,name AS nmsup,addr,phone', 'supplier', '');

            $head = array(
                'rownum' => '#',
                'nmsup' => 'Supplier Name',
                'addr' => 'Address',
                'phone' => 'Phone'
            );
            $tbl_config = array(
                'tb_width' => '100%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NONE
                ),
                'nocheckbox' => true,
                'noaction' => true,
                'noselect' => false,
                'param' => array('supid', 'nmsup')
            );
            $datagrid = $this->table->generate($result, 'supid', $head, $segment, $tbl_config);
            $content = array(
                'startdate' => $this->axo_common->today('ddmmyyyy'),
                'datagrid' => $datagrid,
                'userid' => $this->session->userdata('userid'),
                'uname' => $this->session->userdata('uname')
            );
            $this->axo_template->deploy($content, 'inventory/purchase/add');
        endif;
    }

    function dtl($ordernum) {
        switch ($this->uri->segment(5)):
            case 'cat':
                $catid = $this->uri->segment(6);
                break;
        endswitch;

        switch ($this->uri->segment(7)):
            case 'mat':
                $matid = $this->uri->segment(8);
                break;
        endswitch;

        if ($this->input->post('formtype')):
            if ($this->input->post('formtype') == 'newdetail'):
                $this->form_validation->set_rules('matid', 'Item', 'required');
                $this->form_validation->set_rules('price', 'Price', 'required');
                $this->form_validation->set_rules('qty', 'Quantity', 'required');

                if ($this->form_validation->run()):
                    $matid = $this->input->post('matid', true);
                    $price = (int) $this->input->post('price', true);
                    $qty = $this->input->post('qty', true);
                    $total = $price * $qty;
					$disc = (int) $this->input->post('disc', true);
					$totaldisc = ($total * $disc) / 100;
                    $data = array(
                        'ordernum' => $ordernum,
                        'matid' => $matid,
                        'price' => $price,
                        'qty' => $qty,
                        'total' => $total,
                        'disc' => $disc,
                        'totaldisc' => $totaldisc
                    );
                    $this->MdlDtlPurchase->Insert($data);
					$this->MdlMaterials->UpdatePrice($matid, $price);
                    $this->MdlMaterials->IncStock($matid, $qty);
                    redirect(base_url() . 'inventory/Purchase/dtl/' . $ordernum, 'refresh');
                endif;
            elseif ($this->input->post('formtype') == 'newitem'):
                $this->form_validation->set_rules('name', 'Item name', 'required');
                $this->form_validation->set_rules('unid', 'Unit', 'required');
                $this->form_validation->set_rules('locid', 'Counter', 'required');

                $catid = $this->input->post('catid', true);

                if ($this->form_validation->run()):
					$locid = $this->input->post('locid', true);
					$name = $this->input->post('name', true);
                    $unid = $this->input->post('unid', true);
                    $prefix = $this->MdlCategories->GetPrefixById($catid);
                    $matid = $this->axo_common->NewID($prefix, 'materials', 'matid');
                    $data = array(
                        'matid' => $matid,
                        'catid' => $catid,
                        'locid' => $locid,
                        'name' => $name,
                        'stock' => 0,
                        'unid' => $unid
                    );
                    $this->MdlMaterials->Insert($data);
                    redirect(base_url() . 'inventory/Purchase/dtl/' . $ordernum . '/cat/' . $catid . '/mat/' . $matid, 'refresh');
                endif;
            elseif ($this->input->post('formtype') == 'newcat'):
                $this->form_validation->set_rules('cname', 'Category name', 'required');

                if ($this->form_validation->run()):
                    $name = $this->input->post('cname', true);
                    $prefix = $this->axo_common->AutoPrefix($name, 2);

                    $catid = $this->axo_common->NewID('C', 'categories', 'catid', true);
                    $data = array(
                        'catid' => $catid,
                        'name' => $name,
                        'prefix' => $prefix
                    );
                    $this->MdlCategories->Insert($data);
                    redirect(base_url() . 'inventory/Purchase/dtl/' . $ordernum, 'refresh');
                endif;
            endif;
        endif;

        if (!$this->input->post() || !$this->form_validation->run()):
			$dataref = $this->axo_common->FreeSelect("p.orderdate,s.name,p.numref", "purchase p,supplier s", "p.supid = s.supid AND p.ordernum = '$ordernum'");
            $result = $this->axo_common->Select('m.matid,m.name AS nmmat,m.stock,u.desc', 'materials m, unit u', "u.unid = m.unid AND m.catid = '$catid'");
            $head = array(
                'rownum' => '#',
                'nmmat' => 'Item Name',
                'stock' => 'Stock',
                'desc' => 'Unit'
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
                'param' => array('matid', 'nmmat', 'desc')
            );
            $datagrid = $this->table->generate($result, 'matid', $head, $segment, $tbl_config);

            $result = $this->axo_common->FreeSelect('m.name,u.desc', 'materials m, unit u', "m.matid = '$matid' AND m.unid = u.unid");

            $content = array(
				'date' => $this->axo_common->DateDbToLongDateFormat($dataref[0]->orderdate),
				'nmsup' => $dataref[0]->name,
				'numref' => $dataref[0]->numref,
                'matid' => $matid,
                'name' => $result[0]->name,
                'desc' => $result[0]->desc,
                'catid' => $catid,
                'ordernum' => $ordernum,
                'cat_options' => $this->axo_common->Options('categories', 'catid', 'name', $catid),
                'sel_unit' => $this->axo_common->Options('unit', 'unid', 'desc', $unid),
                'sel_ctr' => $this->axo_common->Options('counter', 'locid', 'name', $unid),
                'datagrid' => $datagrid
            );
            $this->axo_template->deploy($content, 'inventory/purchase/dtl');
        endif;
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
            'orderdate' => 'Purchase Date',
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

	function delete() {
        $res = $this->axo_common->FreeSelect('d.norec,s.name AS nmsup,m.name AS nmmat', 'purchase p,dtlpurchase d,materials m,supplier s', "p.ordernum = d.ordernum AND d.matid = m.matid AND p.supid = s.supid", true);
        $purchase = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['norec'])):
                $ada = true;
                $purchase[$i]['norec'] = $data['norec'];
                $purchase[$i]['nmsup'] = $data['nmsup'];
                $purchase[$i]['nmmat'] = $data['nmmat'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'inventory/Purchase');
        else:
            $content = array(
                'purchase' => $purchase
            );
            $this->axo_template->deploy($content, 'inventory/purchase/delete');
        endif;
	}
	
	function deleting() {	
        $res = $this->axo_common->FreeSelect('norec', 'dtlpurchase', '', true);
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['norec'])):
                $this->MdlDtlPurchase->Delete($data['norec']);
            endif;
        endforeach;
        redirect(base_url() . 'inventory/Purchase');
	}
	
	function journal() {
		$this->grid(true);
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
				$wdate = " p.orderdate >= '$startdate' AND p.orderdate <= '$enddate'";
				break;
			case 'bymonth':
				$str_report_range = $this->axo_common->mon_str($mon) . ' ' . $year;
				$wdate = " MONTH(p.orderdate) = $mon AND YEAR(p.orderdate) = $year";
				break;
		endswitch;

		if (!empty($catid) && $catid != -1):
			$dtl['catname'] = $this->axo_common->GetFieldValue('categories', 'name', "catid = '$catid'");
			$wcatid = " AND p.catid = '$catid'";
		endif;		
		
		if (!empty($catid) && $supid != -1):
			$dtl['supname'] = $this->axo_common->GetFieldValue('supplier', 'name', "supid = '$supid'");
			$wsupid = " AND p.supid = '$supid'";
		endif;		
		
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
        $this->cezpdf->ezText('Purchase Journal', 12, array('justification' => 'center'));
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
		
        $result = $this->axo_common->FreeSelect(
			'p.orderdate,s.name AS nmsup,m.name AS nmmat,d.price,d.qty,u.`desc` AS nmunit,d.total', 
			'purchase p,dtlpurchase d,materials m,supplier s,unit u', 
			"p.supid = s.supid AND p.ordernum = d.ordernum AND d.matid = m.matid AND $wdate $wcatid $wsupid"
		);

		$total = 0;
		$ttlqty = 0;
        for ($i = 0; $i < count($result); $i++):
			$coldata[$i]['rownum'] = $i + 1;
			$coldata[$i]['orderdate'] = $this->axo_common->DbDateToLongDateFormat($result[$i]->orderdate);
			$coldata[$i]['nmsup'] = $result[$i]->nmsup;
			$coldata[$i]['nmmat'] = $result[$i]->nmmat;
			$coldata[$i]['price'] = $this->axo_common->FormatCurrency($result[$i]->price);
			$coldata[$i]['qty'] = $this->axo_common->FormatNumber($result[$i]->qty);
			$coldata[$i]['nmunit'] = $result[$i]->nmunit;
			$coldata[$i]['total'] = $this->axo_common->FormatCurrency($result[$i]->total);
			$total += $result[$i]->total;
			$ttlqty += $result[$i]->qty;
        endfor;
		$y = $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);

		$y -= 25;
		$this->cezpdf->addText(70, $y, 8, 'Total Item');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatNumber($ttlqty));

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Total Purchase');
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
