<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Composition
 *
 * @author situs
 */
class Composition extends Controller {

    function Composition() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');

        $this->table->realm = 'products/composition';
        $this->load->model('MdlComposition');
        $this->load->model('MdlMaterials');
		$this->load->model('MdlUnit');

        $this->load->database();
        $this->axo_access->must_logged();
    }

    function index() {
        $this->grid();
    }

    function grid($id) {
        $per_page = 20;

        $segment[4] = $this->uri->segment(5);
        $segment[5] = $this->uri->segment(6);
        $segment[6] = $this->uri->segment(7);
        $segment[7] = $this->uri->segment(8);
        $segment[8] = $this->uri->segment(9);

        // order
        if (empty($segment[4])):
            $segment[4] = 'name';
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
            'base_url' => base_url() . 'products/Composition/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/' . '/',
            'total_rows' => $this->MdlComposition->CountAll($id),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->MdlComposition->Select('c.comid,t.name,c.qty,c.unid,c.price', 'composition c,materials t', "c.menuid = '$id' AND t.matid = c.matid", $segment[4], $per_page, $segment[7]);

        if ($this->MdlComposition->numRows > 0):
            $head = array(
                'rownum' => '#',
                'name' => 'Description',
                'qty' => 'Qty',
                'unid' => 'Unit',
				'price' => 'Price'
            );
            $tbl_config = array(
                'grid' => 'grid/' . $id,
                'view' => 'view/' . $id,
                'edit' => 'edit/' . $id,
                'tb_width' => '60%',
				'menuid' => $id,
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
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
            $datagrid = $this->table->generate($result, 'comid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No data exists on database.</h3>';
        endif;

        $rdata = $this->axo_common->FreeSelect('name,price', 'menus', "menuid = '$id'");

        $content = array(
            'datagrid' => $datagrid,
            'menuid' => $id,
            'name' => $rdata[0]->name,
            'price' => $this->axo_common->FormatCurrency($rdata[0]->price),
			'hpp' => $this->axo_common->FormatCurrency($this->MdlComposition->GetHPP($id)),
            'pagination' => $this->pagination->create_links()
        );
        $this->axo_template->deploy($content, 'products/Composition/grid');
    }

    function add($menuid) {
        switch ($this->uri->segment(5)):
            case 'cat':
                $catid = $this->uri->segment(6);
                break;
        endswitch;

        $result = $this->MdlMaterials->Select('matid,name AS nmmat,stock,u.desc', 'materials m,unit u', "u.unid = m.unid AND catid = '$catid'");
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
            'param' => array('matid', 'nmmat')
        );
        $datagrid = $this->table->generate($result, 'matid', $head, $segment, $tbl_config);

        $rdata = $this->axo_common->FreeSelect('name,price', 'menus', "menuid = '$menuid'");

        $content = array(
            'name' => $name,
            'name' => $rdata[0]->name,
            'price' => $this->axo_common->FormatCurrency($rdata[0]->price),
            'catid' => $catid,
            'menuid' => $menuid,
            'cat_options' => $this->axo_common->Options('categories', 'catid', 'name', $catid),
            'sel_unit' => $this->axo_common->Options('unit', 'unid', 'desc', $unid),
            'datagrid' => $datagrid
        );
        $this->axo_template->deploy($content, 'products/composition/add');
    }

    function adding($menuid) {
        $this->form_validation->set_rules('matid', 'Raw item', 'required');
        $this->form_validation->set_rules('qty', 'Quantity', 'required');
        $this->form_validation->set_rules('unid', 'Unit', 'required');

        if ($this->form_validation->run()):
			$matid = $this->input->post('matid', true);
			$unid = $this->input->post('unid', true);
			$to = $this->MdlMaterials->GetUnitFromStock($matid);
			$from = $this->MdlUnit->GetUnitFromId($unid);
			$prod = $this->axo_common->UnitConversion($from, $to, $this->input->post('qty', true));
			$matprice = $this->MdlMaterials->GetPricePerUnit($matid);
			$price = $prod * $matprice;
            $data = array(
                'comid' => $this->axo_common->NewID('C', 'composition', 'comid'),
                'menuid' => $menuid,
                'matid' => $matid,
                'qty' => $this->input->post('qty', true),
                'unid' => $unid,
				'price' => $price
            );
            $this->MdlComposition->Insert($data);
            redirect('products/Composition/add/' . $menuid, 'refresh');
        else:
            switch ($this->uri->segment(5)):
                case 'cat':
                    $catid = $this->uri->segment(6);
                    break;
            endswitch;

            $result = $this->MdlMaterials->Select('matid,name AS nmmat,stock,unit', 'materials', "catid = '$catid'");
            $head = array(
                'rownum' => '#',
                'nmmat' => 'Item Name',
                'stock' => 'Stock',
                'unit' => 'Unit'
            );
            $tbl_config = array(
                'tb_width' => '100%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NUMBER,
                    COL_FORMAT_IS_UNIT,
                    COL_FORMAT_IS_NONE
                ),
                'nocheckbox' => true,
                'noaction' => true,
                'noselect' => false,
                'param' => array('matid', 'nmmat')
            );
            $datagrid = $this->table->generate($result, 'matid', $head, $segment, $tbl_config);

            $rdata = $this->axo_common->FreeSelect('name,unit', 'materials', "matid = '$matid'");

            $content = array(
                'matid' => $matid,
                'name' => $rdata->name,
                'catid' => $catid,
                'unit' => $rdata->unit,
                'menuid' => $menuid,
                'cat_options' => $this->axo_common->Options('categories', 'catid', 'name', $catid),
                'datagrid' => $datagrid
            );
            $this->axo_template->deploy($content, 'products/composition/add');
        endif;
    }

    function delete($menuid) {
        $res = $this->axo_common->FreeSelect('c.comid,m.name', 'composition c,materials m', "c.matid = m.matid AND c.menuid = '$menuid'", true);
        $compositions = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['comid'])):
                $ada = true;
                $compositions[$i]['comid'] = $data['comid'];
                $compositions[$i]['name'] = $data['name'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'products/Composition/grid/'.$menuid);
        else:
            $content = array(
				'menuid' => $menuid,
				'compositions' => $compositions
            );
            $this->axo_template->deploy($content, 'products/composition/delete');
        endif;
    }

    function deleting($menuid) {
        $res = $this->axo_common->FreeSelect('c.comid,m.name', 'composition c,materials m', "c.matid = m.matid AND c.menuid = '$menuid'", true);
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['comid'])):
                $this->MdlComposition->Delete($data['comid']);
            endif;
        endforeach;
        redirect(base_url() . 'products/composition/grid/'.$menuid);
    }


    function printing($menuid) {
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
        $this->cezpdf->ezText('PRODUCT COMPOSITION', 12, array('justification' => 'center'));
        $y = $this->cezpdf->ezText('');
		
		$query = $this->db->query("SELECT name,price FROM menus WHERE menuid = '$menuid'");
		$result = $query->result();

		$y -= 25;
		$this->cezpdf->addText(70, $y, 8, 'ID');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $menuid);

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Product Name');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $result[0]->name);

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Price');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($result[0]->price));

        $colnames = array(
			'rownum' => '#',
			'name' => 'Description',
			'qty' => 'Qty',
			'desc' => 'Unit',
			'price' => 'Price'
        );

		$this->cezpdf->ezSetY($y - 15);
		$query = $this->db->query("SELECT m.name,c.qty,u.desc,c.price FROM composition c, materials m, unit u WHERE m.matid = c.matid AND c.unid = u.unid AND c.menuid = '$menuid'");
		$dbdata = $query->result_array();
		if ($dbdata):
			$cop = 0;
			$coldata = $dbdata;
			for ($i = 0; $i < count($dbdata); $i++):
				$coldata[$i]['rownum'] = $i + 1;
				$coldata[$i]['qty'] = $this->axo_common->FormatNumber($dbdata[$i]['qty']);
				$coldata[$i]['price'] = $this->axo_common->FormatCurrency($dbdata[$i]['price']);
				$cop += $dbdata[$i]['price'];
			endfor;
			$this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);
			$y = $this->cezpdf->ezText("");
		endif;

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Cost of Product');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($cop));

		$this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
    }
	
}

?>
