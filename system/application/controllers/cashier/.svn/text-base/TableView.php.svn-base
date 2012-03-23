<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TableView
 *
 * @author situs
 */
class TableView extends Controller {

    //put your code here
    function TableView() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'cashier/TableView';
        $this->load->model('MdlTableView');
        $this->load->model('MdlDtlKot');
        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('TableVoid');
        $this->grid();
    }

    function grid() {
        $per_page = 80;

        $segment[4] = $this->uri->segment(4);
        $segment[5] = $this->uri->segment(5);
        $segment[6] = $this->uri->segment(6);
        $segment[7] = $this->uri->segment(7);
        $segment[8] = $this->uri->segment(8);

        // order
        if (empty($segment[4])):
            $segment[4] = 'num';
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

        $this->pagination->initialize(array(
            'base_url' => base_url() . 'cashier/tableview/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlTableView->CountAll(),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->axo_common->Select(
			't.tabid,t.num,t.start,t.end,t.custname,e.name AS nmserver,', 
			'tableview t, employee e', 
			"t.is_occupied = 'Y' AND t.server = e.empid", 
			$segment, $per_page);

        $head = array(
            'rownum' => '#',
            'num' => 'Table',
            'start' => 'Check In',
            'end' => 'Check Out',
            'custname' => 'Customer Name',
            'nmserver' => 'Server'
        );

        $tbl_config = array(
            'tb_width' => '100%',
            'col_format' => array(
                COL_FORMAT_IS_TEXT_CENTER,
                COL_FORMAT_IS_TEXT_CENTER,
                COL_FORMAT_IS_TEXT_CENTER,
                COL_FORMAT_IS_TEXT,
                COL_FORMAT_IS_NONE
            ),
            'noaction' => false,
            'nocheckbox' => false,
            'noselect' => true,
			'justview' => true
        );

        if ($result):
            $datagrid = $this->table->generate($result, 'tabid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>All table is unoccupied.</h3>';
        endif;

        $content = array(
            'datagrid' => $datagrid,
            'pagination' => $this->pagination->create_links()
        );
        $this->axo_template->deploy($content, 'cashier/tableview/grid');
    }

    function view($id) {
        $tview = $this->axo_common->FreeSelect('t.kotid,t.num,t.start,t.end,t.custname,e.name AS nmserver', 'tableview t, employee e', "t.tabid = '$id' AND t.server = e.empid", true);
        $dkot = $this->axo_common->FreeSelect('d.norec,m.name,d.qty,m.price,(d.qty * m.price) AS total', 'menus m,dtlkot d,tableview t', "m.menuid = d.menuid AND d.kotid = t.kotid AND t.tabid = '$id'");

        for ($i = 0; $i < count($dkot); $i++):
            $totalall += $dkot[$i]->qty * $dkot[$i]->price;
        endfor;

        $head = array(
            'rownum' => '#',
            'name' => 'Menu Item',
            'qty' => 'Qty',
            'price' => 'Price',
            'total' => 'Sub Total'
        );

        $tbl_config = array(
            'tb_width' => '80%',
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
            'totalall' => $this->axo_common->FormatCurrency($totalall),
            'tabid' => $id
        );
        $this->axo_template->deploy($content, 'cashier/tableview/view');
    }

    function edit($id) {
        $res = $this->mdl_divisi->select_by_id($id);
        $content = $res[0];
        $this->axo_template->deploy($content, 'master/divisi/edit');
    }

    function editing($id) {
        $this->form_validation->set_rules('nmdiv', 'Nama divisi', 'required');

        if ($this->form_validation->run() == TRUE):
            $data = array(
                'nmdiv' => $this->input->post('nmdiv', true),
            );
            $this->mdl_divisi->update($data, $id);
            redirect('master/divisi', 'refresh');
        else:
            $content = array();
            $this->axo_template->deploy($content, 'master/divisi/edit');
        endif;
    }

    function delete() {
        $result = $this->axo_common->FreeSelect('tabid,num,custname,kotid', 'tableview', '', true);
        $table = array();
        $i = 0;
        $ada = false;
        foreach ($result as $data):
            if ($this->input->post('cb-' . $data['tabid'])):
                $ada = true;
                $table[$i]['tabid'] = $data['tabid'];
                $table[$i]['num'] = $data['num'];
                $table[$i]['custname'] = $data['custname'];
                $table[$i]['kotid'] = $data['kotid'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'cashier/TableView');
        else:
            $content = array(
                'tables' => $table
            );
            $this->axo_template->deploy($content, 'cashier/tableview/delete');
        endif;
    }

    function deleting() {
        $result = $this->axo_common->FreeSelect('tabid', 'tableview', '', true);
        $table = array();
        foreach ($result as $data):
            if ($this->input->post('cb-' . $data['tabid'])):
                $this->MdlTableView->Delete($data['tabid']);
            endif;
        endforeach;
        redirect(base_url() . 'cashier/TableView');
    }

    function printing($id = 0) {
        $this->load->library('cezpdf');
        $this->cezpdf->ezSetCmMargins(4, 3, 4, 3);
        $tbcfg = array('xPos' => 'left', 'xOrientation' => 'right', 'width' => 300, 'fontSize' => 8);
        if ($id == 0):
            $this->cezpdf->ezText('DAFTAR DIVISI', 14, array('justification' => 'left'));
            $this->cezpdf->ezText('');
            $db_data = $this->mdl_divisi->select_by("kdiv,nmdiv");
            foreach ($db_data as $data) {
                $coldata[] = array($data['kdiv'], $data['nmdiv']);
            }
            $colnames = array('Kode Divisi', 'Nama Divisi');
        else:
            $res = $this->mdl_divisi->select_by_id($id);
            $data = $res[0];
            $this->cezpdf->ezText('DATA DIVISI', 14, array('justification' => 'left'));
            $this->cezpdf->ezText('');
            $colnames = array('kdiv', 'ttk2', 'nmdiv');
            $coldata[] = array('Kode divisi', ': ', $data['kdiv']);
            $coldata[] = array('Nama divisi', ': ', $data['nmdiv']);
            $tbcfg['showHeadings'] = 0;
            $tbcfg['width'] = 200;
            $tbcfg['showLines'] = 0;
            $tbcfg['shaded'] = 0;
            $tbcfg['options'] = array(
                'kdiv' => array('justification' => 'right', 'width' => 95),
                'ttk2' => array('width' => 10),
                'nmdiv' => array('width' => 95)
            );
        endif;
        $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);
        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'PT. Mega Tirta Alami');
        $this->cezpdf->ezStream();
    }

}

?>
