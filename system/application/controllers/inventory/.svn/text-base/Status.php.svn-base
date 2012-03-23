<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Status
 *
 * @author situs
 */
class Status extends Controller {

    function Status() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'inventory/status';
        $this->load->model('MdlStatus');
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
            $segment[4] = 'stid';
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
            'base_url' => base_url() . 'inventory/Status/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlStatus->CountAll(),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->axo_common->Select('stid,title', 'status', "", $segment, $per_page);

        if ($result):
            $head = array(
				'rownum' => '#',
				'title' => 'Status Title'
			);
            $tbl_config = array(
                'tb_width' => '40%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NONE
                ),
				'noaction' => false,
				'nocheckbox' => false,
				'noselect' => true
            );
            $datagrid = $this->table->generate($result, 'stid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No status exists on database.</h3>';
        endif;

        $content = array(
            'datagrid' => $datagrid,
            'pagination' => $this->pagination->create_links()
        );
        $this->axo_template->deploy($content, 'inventory/status/grid');
    }

    function add() {
        $content = array();
        $this->axo_template->deploy($content, 'inventory/status/add');
    }

    function adding() {
        $this->form_validation->set_rules('title', 'Status title', 'required');

        if ($this->form_validation->run() == TRUE):
            $data = array(
				'stid' => $this->axo_common->NewID('T', 'status', 'stid', true),
                'title' => $this->input->post('title', true),
            );
            $this->MdlStatus->Insert($data);
            redirect('inventory/Status', 'refresh');
        else:
            $content = array();
            $this->axo_template->deploy($content, 'inventory/status/add');
        endif;
    }

    function view($id) {
        $res = $this->axo_common->FreeSelect("stid,title", "status", "stid = '$stid'", true);
        $content = $res[0];
        $this->axo_template->deploy($content, 'inventory/status/view');
    }

    function edit($id) {
        $res = $this->axo_common->FreeSelect("stid,title", "status", "stid = '$stid'", true);
        $content = $res[0];
        $this->axo_template->deploy($content, 'inventory/status/edit');
    }

    function editing($id) {
        $this->form_validation->set_rules('title', 'Status title', 'required');

        if ($this->form_validation->run() == TRUE):
			$stid = $this->input->post('stid');
            $data = array(
                'title' => $this->input->post('title', true),
            );
            $this->MdlStatus->Update($data, $stid);
            redirect('inventory/Status', 'refresh');
        else:
            $content = array();
            $this->axo_template->deploy($content, 'inventory/status/edit');
        endif;
    }

    function delete() {
        $res = $this->axo_common->FreeSelect("stid,title", "status", "", true);
        $status = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['stid'])):
                $ada = true;
                $status[$i]['stid'] = $data['stid'];
                $status[$i]['title'] = $data['title'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'inventory/Status');
        else:
            $content = array(
                'status' => $status
            );
            $this->axo_template->deploy($content, 'inventory/status/delete');
        endif;
    }

    function deleting() {
        $res = $this->axo_common->FreeSelect("stid", "status", "", true);
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['stid'])):
                $this->MdlStatus->Delete($data['stid']);
            endif;
        endforeach;
        redirect(base_url() . 'inventory/Status');
    }

}

?>
