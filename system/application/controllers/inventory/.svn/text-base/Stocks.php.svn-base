<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Stocks
 *
 * @author situs
 */
class Stocks extends Controller {

    function Stocks() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');

        $this->table->realm = 'inventory/Stocks';
        $this->load->model('MdlMaterials');
        $this->load->model('MdlCategories');

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Stocks');
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
            $segment[4] = 'm.name';
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
		$refer = $this->axo_common->Get("VAR_REFERENCE");
		if (is_array($refer)):
			extract($refer);
		endif;

		if ($this->input->post('catid')):
			$catid = $this->input->post('catid');
		endif;
		
		if ($this->input->post('locid')):
			$locid = $this->input->post('locid');
		endif;
		
		if ($this->input->post('search')):
			$search = $this->input->post('search');
		endif;
		
		$refer['catid'] = $catid;		
		$refer['locid'] = $locid;		
		$refer['search'] = $search;		
		$this->axo_common->Set('VAR_REFERENCE', $refer);		
		
		$where = "";
		if (!empty($catid) && $catid != -1):
			$dtl['catname'] = $this->axo_common->GetFieldValue('categories', 'name', "catid = '$catid'");
			$where .= " AND m.catid = '$catid'";
		endif;		
		
		if (!empty($locid) && $locid != -1):
			$dtl['locname'] = $this->axo_common->GetFieldValue('counter', 'name', "locid = '$locid'");
			$where .= " AND m.locid = '$locid'";
		endif;		
		
		if (!empty($search)):
			$where .= " AND m.catid LIKE '%$search%'";
		endif;		
		
        $this->pagination->initialize(array(
            'base_url' => base_url() . 'inventory/Stocks/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlMaterials->CountAll($where),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

		$query = $this->db->query("
			SELECT m.matid,t.name AS catname,c.name AS ctrname,m.name,p.orderdate,m.price,m.stock,m.unid,(m.price * m.stock) AS stockval
			FROM unit u, materials m
			LEFT JOIN counter c ON m.locid = c.locid
			LEFT JOIN categories t ON m.catid = t.catid
			LEFT JOIN dtlpurchase d ON m.matid = d.matid
			LEFT JOIN purchase p ON d.ordernum = p.ordernum
			WHERE m.unid = u.unid AND m.active = 'Y' $where
			ORDER BY ".$segment[4]." ".$segment[6]."
			LIMIT ".$segment[7].", $per_page
		");
		$result = $query->result();

        if ($query->num_rows > 0):
            $head = array(
                'rownum' => '#',
				'catname' => 'Category',
                'ctrname' => 'Counter',
                'name' => 'Item Name',
				'orderdate' => 'Order Date',
                'price' => 'Price',				
                'stock' => 'Qty',
                'unid' => 'Unit',
				'stockval' => 'Value Stock'
            );
            $tbl_config = array(
                'tb_width' => '100%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
					COL_FORMAT_IS_LONGDATE,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_NUMBER,
                    COL_FORMAT_IS_UNIT,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_NONE
                ),
                'nocheckbox' => false,
                'noaction' => false,
                'noselect' => true
            );
            $datagrid = $this->table->generate($result, 'matid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No data for particular filter.</h3>';
        endif;
		
		$query = $this->db->query("
			SELECT SUM(m.price * m.stock) AS stockval
			FROM unit u, materials m
			LEFT JOIN counter c ON m.locid = c.locid
			LEFT JOIN categories t ON m.catid = t.catid
			WHERE m.unid = u.unid $where
		");
		$result = $query->result();
		$stockval = $result[0]->stockval;

        $content = array(
            'datagrid' => $datagrid,
            'sel_cat' => $this->axo_common->Options('categories', 'catid', 'name', $catid),
            'sel_cnt' => $this->axo_common->Options('counter', 'locid', 'name', $locid),
			'search' => $search,
			'stockval' => $stockval,
            'pagination' => $this->pagination->create_links(),
			'dtl' => $dtl
        );
        $this->axo_template->deploy($content, 'inventory/stocks/grid');
    }

    function add() {
        $content = array();
        $content['sel_cat'] = $this->axo_common->Options('categories', 'catid', 'name');
        $content['sel_cnt'] = $this->axo_common->Options('counter', 'locid', 'name');
        $content['sel_unit'] = $this->axo_common->Options('unit', 'unid', 'desc');
        $this->axo_template->deploy($content, 'inventory/stocks/add');
    }

    function adding() {
        $this->form_validation->set_rules('catid', 'Category', 'required');
        $this->form_validation->set_rules('locid', 'Counter', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('unid', 'Unit', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'matid' => $this->axo_common->NewID($this->MdlCategories->GetPrefixById($this->input->post('catid', true)), 'materials', 'matid'),
                'catid' => $this->input->post('catid', true),
                'locid' => $this->input->post('locid', true),
                'name' => $this->input->post('name', true),
                'unid' => $this->input->post('unid', true),
            );
            $this->MdlMaterials->Insert($data);
            redirect('inventory/Stocks', 'refresh');
        else:
            $content = array();
            $content['sel_cat'] = $this->axo_common->Options('categories', 'catid', 'name', $this->input->post('catid', true));
            $content['sel_unit'] = $this->axo_common->Options('unit', 'unid', 'desc', $this->input->post('unid', true));
            $this->axo_template->deploy($content, 'inventory/stocks/add');
        endif;
    }

    function view($id) {
        $res = $this->MdlMaterials->SelectById($id);
        $content = $res[0];
		$content->orderdate = $this->axo_common->DateDbToLongDateFormat($content->orderdate);
        $this->axo_template->deploy($content, 'inventory/stocks/view');
    }

    function edit($id) {
        $res = $this->MdlMaterials->SelectById($id);
        $content = $res[0];
        $content->sel_cat = $this->axo_common->Options('categories', 'catid', 'name', $res[0]->catid);
        $content->sel_loc = $this->axo_common->Options('counter', 'locid', 'name', $res[0]->locid);
        $content->sel_unit = $this->axo_common->Options('unit', 'unid', 'desc', $res[0]->unid);
		$content->orderdate = $this->axo_common->DateDbToLongDateFormat($content->orderdate);
        $this->axo_template->deploy($content, 'inventory/stocks/edit');
    }

    function editing($id) {
        $this->form_validation->set_rules('catid', 'Category', 'required');
        $this->form_validation->set_rules('locid', 'Counter', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('unid', 'Unit', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'catid' => $this->input->post('catid', true),
                'locid' => $this->input->post('locid', true),
                'name' => $this->input->post('name', true),
                'unid' => $this->input->post('unid', true),
            );
            $this->MdlMaterials->update($data, $id);
            redirect('inventory/Stocks', 'refresh');
        else:
            $content = array();
            $content->sel_cat = $this->axo_common->Options('categories', 'catid', 'name', $res[0]->catid);
			$content->sel_loc = $this->axo_common->Options('counter', 'locid', 'name', $res[0]->locid);
            $content->sel_unit = $this->axo_common->Options('unit', 'unid', 'desc', $res[0]->unid);
            $this->axo_template->deploy($content, 'inventory/stocks/edit');
        endif;
    }

    function delete() {
        $res = $this->axo_common->FreeSelect('matid,name', 'materials', '', true);
        $materials = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['matid'])):
                $ada = true;
                $materials[$i]['matid'] = $data['matid'];
                $materials[$i]['name'] = $data['name'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'inventory/Stocks');
        else:
            $content = array(
                'materials' => $materials
            );
            $this->axo_template->deploy($content, 'inventory/stocks/delete');
        endif;
    }

    function deleting() {
        $res = $this->axo_common->FreeSelect('matid,name', 'materials', '', true);
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['matid'])):
                $this->MdlMaterials->Delete($data['matid']);
            endif;
        endforeach;
        redirect(base_url() . 'inventory/Stocks');
    }

	function reset() {
        $res = $this->axo_common->FreeSelect('matid,name', 'materials', '', true);
        $materials = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['matid'])):
                $ada = true;
                $materials[$i]['matid'] = $data['matid'];
                $materials[$i]['name'] = $data['name'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'inventory/Stocks');
        else:
            $content = array(
                'materials' => $materials
            );
            $this->axo_template->deploy($content, 'inventory/stocks/reset');
        endif;
}

	function reseting() {
        $res = $this->axo_common->FreeSelect('matid,name', 'materials', '', true);
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['matid'])):
                $this->MdlMaterials->Reset($data['matid']);
            endif;
        endforeach;
        redirect(base_url() . 'inventory/Stocks');
	}
	
    function report() {
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		extract($refer);

		if (!empty($catid) && $catid != -1):
			$where .= " AND m.catid = '$catid'";
			$catname = $this->axo_common->GetFieldValue('categories', 'name', "catid = '$catid'");
		endif;		
		
		if (!empty($locid) && $locid != -1):
			$where .= " AND m.locid = '$locid'";
			$locname = $this->axo_common->GetFieldValue('counter', 'name', "locid = '$locid'");
		endif;		
		
		if (!empty($search)):
			$where .= " AND m.name LIKE '%$supid%'";
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
        $this->cezpdf->ezText('Master Stock Report', 12, array('justification' => 'center'));
        $this->cezpdf->ezText($str_report_range, 8, array('justification' => 'center'));
        $y = $this->cezpdf->ezText('');

        $colnames = array(
            'rownum' => '#',
			'catname' => 'Category',
            'ctrname' => 'Counter',
            'name' => 'Item Name',
            'price' => 'Price (@ unit)',
            'stock' => 'Stock',
            'desc' => 'Unit',
			'stockval' => 'Value'
        );

        $query = $this->db->query("
			SELECT t.name AS catname,c.name AS ctrname,m.name,p.orderdate,m.price,m.stock,u.`desc`,(m.price * m.stock) AS stockval
			FROM unit u, materials m
			LEFT JOIN counter c ON m.locid = c.locid
			LEFT JOIN categories t ON m.catid = t.catid
			LEFT JOIN dtlpurchase d ON m.matid = d.matid
			LEFT JOIN purchase p ON d.ordernum = p.ordernum
			WHERE m.unid = u.unid $where
		");
		$result = $query->result();

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Inventory Check');
		$this->cezpdf->addText(150, $y, 8, ':');
		$this->cezpdf->addText(160, $y, 8, $this->axo_common->today('str'));

		if (!empty($catname)):
			$y -= 15;
			$this->cezpdf->addText(70, $y, 8, 'Category');
			$this->cezpdf->addText(150, $y, 8, ':');
			$this->cezpdf->addText(160, $y, 8, $catname);
		endif;
		
		if (!empty($locname)):
			$y -= 15;
			$this->cezpdf->addText(70, $y, 8, 'Counter');
			$this->cezpdf->addText(150, $y, 8, ':');
			$this->cezpdf->addText(160, $y, 8, $locname);
		endif;
		
		if (!empty($search)):
			$y -= 15;
			$this->cezpdf->addText(70, $y, 8, 'Keywords');
			$this->cezpdf->addText(150, $y, 8, ':');
			$this->cezpdf->addText(160, $y, 8, $search);
		endif;
		
		$this->cezpdf->ezSetY($y - 10);
		$total = 0;
        for ($i = 0; $i < count($result); $i++):
			$coldata[$i]['rownum'] = $i + 1;
			$coldata[$i]['catname'] = $result[$i]->catname;
			$coldata[$i]['ctrname'] = $result[$i]->ctrname;
			$coldata[$i]['name'] = $result[$i]->name;
			$coldata[$i]['orderdate'] = $this->axo_common->DateDbToLongDateFormat($result[$i]->orderdate);
			$coldata[$i]['price'] = $this->axo_common->FormatCurrency($result[$i]->price);
			$coldata[$i]['stock'] = $this->axo_common->FormatNumber($result[$i]->stock);
			$coldata[$i]['desc'] = $result[$i]->desc;
			$coldata[$i]['stockval'] = $this->axo_common->FormatCurrency($result[$i]->stockval);
			$total += $result[$i]->stockval;
        endfor;
		$y = $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);

		$y -= 25;
		$this->cezpdf->addText(70, $y, 8, 'Total Value');
		$this->cezpdf->addText(120, $y, 8, ':');
		$this->cezpdf->addText(130, $y, 8, $this->axo_common->FormatCurrency($total));

        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
    }

}

?>
