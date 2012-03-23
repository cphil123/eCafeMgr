<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Categories
 *
 * @author situs
 */
class Categories extends Controller {

    function Categories() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');

        $this->table->realm = 'products/categories';
        $this->load->model('MdlProductCategories');

        $this->load->database();
        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Categories');
        $this->grid();
    }

    function grid() {
        $per_page = 10;

        $segment[4] = $this->uri->segment(4);
        $segment[5] = $this->uri->segment(5);
        $segment[6] = $this->uri->segment(6);
        $segment[7] = $this->uri->segment(7);
        $segment[8] = $this->uri->segment(8);

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
            'base_url' => base_url() . 'products/Categories/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/' . '/',
            'total_rows' => $this->MdlProductCategories->CountAll(),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->MdlProductCategories->Select('catid,name,prefix', 'menucats', '', $segment[4], $per_page, $segment[7]);

        if ($this->MdlProductCategories->numRows > 0):
            $head = array('rownum' => '#', 'name' => 'Description', 'prefix' => 'Prefix ID');
            $tbl_config = array(
                'tb_width' => '50%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT_CENTER,
                    COL_FORMAT_IS_NONE
                ),
                'noaction' => false,
                'nocheckbox' => false,
                'noselect' => true,
                'offset' => $segment[7]
            );
            $datagrid = $this->table->generate($result, 'catid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No data exists on database.</h3>';
        endif;

        $content = array(
            'datagrid' => $datagrid,
            'pagination' => $this->pagination->create_links()
        );
        $this->axo_template->deploy($content, 'products/categories/grid');
    }

    function add() {
        $content = array();
        $this->axo_template->deploy($content, 'products/categories/add');
    }

    function adding() {
        $this->form_validation->set_rules('name', 'Product category\'s name', 'required');

        if ($this->form_validation->run() == TRUE):
            $data = array(
				'catid' => $this->axo_common->NewID('C', 'menucats', 'catid'),				
                'name' => $this->input->post('name', true),
				'prefix' => $this->axo_common->AutoPrefix($this->input->post('name', true))
            );
            $this->MdlProductCategories->Insert($data);
            redirect('products/categories', 'refresh');
        else:
            $content = array();
            $this->axo_template->deploy($content, 'products/categories/add');
        endif;
    }

    function view($id) {
        $res = $this->axo_common->FreeSelect("catid,name,prefix", "menucats", "catid = '$id'", true);
        $content = $res[0];
        $this->axo_template->deploy($content, 'products/categories/view');
    }

    function edit($id) {
        $res = $this->axo_common->FreeSelect("catid,name,prefix", "menucats", "catid = '$id'", true);
        $content = $res[0];
        $this->axo_template->deploy($content, 'products/categories/edit');
    }

    function editing() {
        $this->form_validation->set_rules('nmdiv', 'Product category\'s name', 'required');

        if ($this->form_validation->run() == TRUE):
            $data = array(
                'nmdiv' => $this->input->post('nmdiv', true),
            );
            $this->MdlProductCategories->Update($data, $id);
            redirect('products/categories', 'refresh');
        else:
            $content = array();
            $this->axo_template->deploy($content, 'products/categories/edit');
        endif;
    }

    function delete() {
        $res = $this->axo_common->FreeSelect("catid,name", "menucats", "", true);
        $menucats = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['catid'])):
                $ada = true;
                $menucats[$i]['catid'] = $data['catid'];
                $menucats[$i]['name'] = $data['name'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'products/categories');
        else:
            $content = array(
                'menucats' => $menucats
            );
            $this->axo_template->deploy($content, 'products/categories/delete');
        endif;
    }

    function deleting() {
        $res = $this->axo_common->FreeSelect("catid,name", "menucats", "", true);
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['catid'])):
                $this->MdlProductCategories->Delete($data['catid']);
            endif;
        endforeach;
        redirect(base_url() . 'products/categories');
    }

}

?>
