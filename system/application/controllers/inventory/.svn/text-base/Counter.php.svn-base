<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Counter
 *
 * @author situs
 */
class Counter extends Controller {

    function Counter() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');

        $this->table->realm = 'inventory/Counter';
        $this->load->model('MdlCounter');

        $this->load->database();
        $this->axo_access->must_logged();
    }

    function index() {
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
            'base_url' => base_url() . 'inventory/Counter/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/' . '/',
            'total_rows' => $this->MdlCounter->CountAll(),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->MdlCounter->Select('locid,name', 'counter', "", $segment[4], $per_page, $segment[7]);

        if ($this->MdlCounter->numRows > 0):
            $head = array(
                'rownum' => '#',
                'name' => 'Name'
            );
            $tbl_config = array(
                'tb_width' => '40%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NONE
                ),
                'noaction' => false,
                'nocheckbox' => false,
                'noselect' => true,
                'offset' => $segment[7]
            );
            $datagrid = $this->table->generate($result, 'locid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No data exists on database.</h3>';
        endif;

        $content = array(
            'datagrid' => $datagrid,
            'pagination' => $this->pagination->create_links()
        );
        $this->axo_template->deploy($content, 'inventory/Counter/grid');
    }

    function add() {
        $content = array();
        $this->axo_template->deploy($content, 'inventory/counter/add');
    }

    function adding() {
        $this->form_validation->set_rules('name', 'Product name', 'required');

        if ($this->form_validation->run() == TRUE):
            $data = array(
                'locid' => $this->axo_common->NewID("L", 'counter', 'locid', true),
                'name' => $this->input->post('name', true)
            );
            $this->MdlCounter->Insert($data);
            redirect('inventory/Counter', 'refresh');
        else:
            $content = array();
            $this->axo_template->deploy($content, 'inventory/counter/add');
        endif;
    }

    function view($id) {
        $res = $this->axo_common->FreeSelect('locid,name', 'counter', "locid = '$id'", true);
        $content = $res[0];
        $this->axo_template->deploy($content, 'inventory/counter/view');
    }

    function edit($id) {
        $res = $this->axo_common->FreeSelect('locid,name', 'counter', "locid = '$id'", true);
        $content = $res[0];
        $this->axo_template->deploy($content, 'inventory/counter/edit');
    }

    function editing($id) {
        $this->form_validation->set_rules('name', 'Product name', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'name' => $this->input->post('name', true)
            );
            $this->MdlCounter->Update($data, $id);
            redirect('inventory/counter', 'refresh');
        else:
            $res = $this->axo_common->FreeSelect('locid,name', 'counter', "locid = '$id'", true);
            $content = array();
            $content = $res[0];
            $this->axo_template->deploy($content, 'inventory/counter/edit');
        endif;
    }

    function delete() {
        $res = $this->axo_common->FreeSelect('locid,name', 'counter', '', true);
        $counter = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['locid'])):
                $ada = true;
                $counter[$i]['locid'] = $data['locid'];
                $counter[$i]['name'] = $data['name'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'inventory/Counter');
        else:
            $content = array(
                'counter' => $counter
            );
            $this->axo_template->deploy($content, 'inventory/counter/delete');
        endif;
    }

    function deleting() {
        $res = $this->axo_common->FreeSelect('locid', 'counter', '', true);
        $counter = array();
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['locid'])):
                $this->MdlCounter->delete($data['locid']);
            endif;
        endforeach;
        redirect(base_url() . 'inventory/Counter');
    }

}

?>
