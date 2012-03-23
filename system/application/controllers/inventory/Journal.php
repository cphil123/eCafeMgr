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
class Journal extends Controller {

    function Journal() {
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
            $segment[6] = 'all';
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
            'base_url' => base_url() . 'inventory/Purchase/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlPurchase->CountAll(),
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
                'orderdate' => 'Purchase Date',
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
        $this->axo_template->deploy($content, 'inventory/purchase/grid');
    }

    function add() {
        if ($this->input->post('formtype')):
            $this->form_validation->set_rules('startdate1', 'Date', 'required');
            $this->form_validation->set_rules('supid', 'Supplier name', 'required');

            if ($this->form_validation->run()):
                $ordernum = $this->axo_common->NewID('P', 'purchase', 'ordernum');
                $data = array(
                    'ordernum' => $ordernum,
                    'orderdate' => $this->axo_common->DatePostedToDateDb($this->input->post('startdate1', true)),
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
            $result = $this->MdlSupplier->Select('supid,name AS nmsup,addr,phone', 'supplier');

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
                'orderdate' => $this->axo_common->today('ddmmyyyy'),
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
                    $qty = (int) $this->input->post('qty', true);
                    $total = $price * $qty;
                    $data = array(
                        'ordernum' => $ordernum,
                        'matid' => $matid,
                        'price' => $price,
                        'qty' => $qty,
                        'total' => $total,
                        'disc' => 0,
                        'totaldisc' => 0
                    );
                    $this->MdlDtlPurchase->Insert($data);
                    $this->MdlMaterials->IncStock($matid, $qty);
                    redirect(base_url() . 'inventory/Purchase/dtl/' . $ordernum, 'refresh');
                endif;
            elseif ($this->input->post('formtype') == 'newitem'):
                $this->form_validation->set_rules('name', 'Item name', 'required');
                $this->form_validation->set_rules('unid', 'Unit', 'required');

                $catid = $this->input->post('catid', true);

                if ($this->form_validation->run()):
                    $unid = $this->input->post('unid', true);
                    $prefix = $this->MdlCategories->GetPrefixById($catid);
                    $matid = $this->axo_common->NewID($prefix, 'materials', 'matid');
                    $data = array(
                        'matid' => $matid,
                        'catid' => $catid,
                        'name' => $this->input->post('name', true),
                        'stock' => 0,
                        'unid' => $this->input->post('unid', true)
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
            $result = $this->MdlMaterials->Select('m.matid,m.name AS nmmat,m.stock,u.desc', 'materials m, unit u', "u.unid = m.unid AND m.catid = '$catid'");
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
                'matid' => $matid,
                'name' => $result[0]->name,
                'desc' => $result[0]->desc,
                'catid' => $catid,
                'ordernum' => $ordernum,
                'cat_options' => $this->axo_common->Options('categories', 'catid', 'name', $catid),
                'sel_unit' => $this->axo_common->Options('unit', 'unid', 'desc', $unid),
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

	function journal() {
	}

    function report($orderdate) {
        $dbdate = $this->axo_common->DatePostedToDateDb($orderdate);
        $this->load->library('cezpdf');
        $this->cezpdf->ezSetCmMargins(4, 3, 4, 3);
        $tbcfg = array('xPos' => 'left', 'xOrientation' => 'right', 'width' => 800, 'fontSize' => 8);
        $data = $this->axo_common->FreeSelect('d.norec,p.orderdate,s.name AS nmsup,m.name AS nmmat,d.price,d.qty,u.desc,d.total', 'purchase p,dtlpurchase d,materials m,supplier s,unit u', "m.unid = u.unid AND p.supid = s.supid AND p.ordernum = d.ordernum AND d.matid = m.matid AND p.orderdate = '$dbdate'", true);
        $this->cezpdf->ezText('PURCHASING JOURNAL', 14, array('justification' => 'center'));
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

}

?>
