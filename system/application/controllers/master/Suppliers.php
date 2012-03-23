<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author situs
 */
class Suppliers extends Controller {

    function Suppliers() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'master/Suppliers';
        $this->load->model('MdlSupplier');

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
            $segment[4] = 'supid';
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
            'base_url' => base_url() . 'master/Suppliers/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlSupplier->CountAll(),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->axo_common->Select('supid,name,addr,city,prov,zip,phone', 'supplier', "", $segment, $per_page);

        if ($result):
            $head = array(
				'rownum' => '#',
				'name' => 'Name', 
				'addr' => 'Address', 
				'city' => 'City', 
				'prov' => 'Province', 
				'zip' => 'Zip Cod', 
				'phone' => 'Phone'
			);
            $tbl_config = array(
                'tb_width' => '100%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NONE
                ),
				'noaction' => false,
				'nocheckbox' => false,
				'noselect' => true
            );
            $datagrid = $this->table->generate($result, 'supid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No suppliers exists on database.</h3>';
        endif;

        $content = array(
            'datagrid' => $datagrid,
            'pagination' => $this->pagination->create_links()
        );
        $this->axo_template->deploy($content, 'master/suppliers/grid');
    }

    function add() {
        $content = array();
        $this->axo_template->deploy($content, 'master/suppliers/add');
    }

    function adding() {
        $this->form_validation->set_rules('name', 'Supplier\'s name', 'required');
        $this->form_validation->set_rules('phone', 'Phone number', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'supid' => $this->axo_common->NewID('S', 'supplier', 'supid', true),
                'name' => $this->input->post('name', true),
                'addr' => $this->input->post('addr', true),
                'city' => $this->input->post('city', true),
                'prov' => $this->input->post('prov', true),
                'zip' => $this->input->post('zip', true),
                'phone' => $this->input->post('phone', true)
            );
            $this->MdlSupplier->Insert($data);
            redirect('master/Suppliers', 'refresh');
        else:
            $content = array();
            $this->axo_template->deploy($content, 'master/Suppliers/add');
        endif;
    }

    function view($id) {
        $res = $this->axo_common->FreeSelect("supid,name,addr,city,prov,zip,phone", "supplier", "supid = '$id'");
        $content = $res[0];
        $this->axo_template->deploy($content, 'master/suppliers/view');
    }

    function edit($id) {
        $res = $this->axo_common->FreeSelect("supid,name,addr,city,prov,zip,phone", "supplier", "supid = '$id'", true);
        $content = $res[0];
        $this->axo_template->deploy($content, 'master/suppliers/edit');
    }

    function editing() {
        $this->form_validation->set_rules('name', 'Supplier\'s name', 'required');
        $this->form_validation->set_rules('phone', 'Phone number', 'required');

        if ($this->form_validation->run()):
			$supid = $this->input->post('supid', true);
            $data = array(
                'name' => $this->input->post('name', true),
                'addr' => $this->input->post('addr', true),
                'city' => $this->input->post('city', true),
                'prov' => $this->input->post('prov', true),
                'zip' => $this->input->post('zip', true),
                'phone' => $this->input->post('phone', true)
            );
            $this->MdlSupplier->Update($data, $supid);
            redirect('master/Suppliers', 'refresh');
        else:
            $content = array(
				'supid' => $supid
			);
            $this->axo_template->deploy($content, 'master/Suppliers/edit');
        endif;
    }

    function delete() {
        $res = $this->axo_common->FreeSelect("supid,name", "supplier", "", true);
        $supplier = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['supid'])):
                $ada = true;
                $supplier[$i]['supid'] = $data['supid'];
                $supplier[$i]['name'] = $data['name'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'master/Suppliers');
        else:
            $content = array(
                'supplier' => $supplier
            );
            $this->axo_template->deploy($content, 'master/suppliers/delete');
        endif;
    }

    function deleting() {
        $res = $this->axo_common->FreeSelect("supid,name", "supplier", "", true);
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['supid'])):
                $this->MdlSupplier->Delete($data['supid']);
            endif;
        endforeach;
        redirect(base_url() . 'master/Suppliers');
    }

}

?>
