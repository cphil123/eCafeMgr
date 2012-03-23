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

        $this->table->realm = 'inventory/Categories';
        $this->load->model('MdlCategories');

        $this->load->database();
        $this->axo_access->must_logged();
    }

    function index() {
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
            'base_url' => base_url() . 'inventory/Categories/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/' . '/',
            'total_rows' => $this->MdlCategories->CountAll(),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->axo_common->Select('catid,name,prefix', 'categories', '', $segment, $per_page);

        if ($result):
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
        $this->axo_template->deploy($content, 'inventory/categories/grid');
    }

    function add() {
        $content = array();
        $this->axo_template->deploy($content, 'inventory/categories/add');
    }

    function adding() {
        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'catid' => $this->axo_common->NewID('C', 'categories', 'catid', true),
                'name' => $this->input->post('name', true),
                'prefix' => $this->axo_common->AutoPrefix($this->input->post('name', true)),
            );
            $this->MdlCategories->Insert($data);
            redirect('inventory/Categories', 'refresh');
        else:
            $content = array();
            $this->axo_template->deploy($content, 'inventory/categories/add');
        endif;
    }

    function view($id) {
        $res = $this->axo_common->FreeSelect('catid,name,prefix', 'categories', "catid = '$id'", true);
        $content = $res[0];
        $this->axo_template->deploy($content, 'inventory/categories/view');
    }

    function edit($id) {
        $res = $this->axo_common->FreeSelect('catid,name,prefix', 'categories', "catid = '$id'", true);
        $content = $res[0];
        $this->axo_template->deploy($content, 'inventory/categories/edit');
    }

    function editing($id) {
        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'name' => $this->input->post('name', true),
                'prefix' => $this->input->post('prefix', true)
            );
            $this->MdlCategories->Update($data, $id);
            redirect('inventory/Categories', 'refresh');
        else:
            $content = array();
            $this->axo_template->deploy($content, 'inventory/categories/edit');
        endif;
    }

    function delete() {
        $res = $this->axo_common->FreeSelect('catid,name', 'categories', "", true);
        $categories = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['catid'])):
                $ada = true;
                $categories[$i]['catid'] = $data['catid'];
                $categories[$i]['name'] = $data['name'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'inventory/Categories');
        else:
            $content = array(
                'categories' => $categories
            );
            $this->axo_template->deploy($content, 'inventory/categories/delete');
        endif;
    }

    function deleting() {
        $res = $this->axo_common->FreeSelect('catid', 'categories', "", true);
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['catid'])):
                $this->MdlCategories->Delete($data['catid']);
            endif;
        endforeach;
        redirect(base_url() . 'inventory/Categories');
    }

}

?>
