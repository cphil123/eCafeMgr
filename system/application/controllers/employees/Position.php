<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Position
 *
 * @author situs
 */
class Position extends Controller {

    function Position() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');

        $this->table->realm = 'employees/Position';
        $this->load->model('MdlPosition');

        $this->axo_access->must_logged();
    }

    function index() {
        $this->grid();
    }

    function grid() {
        $per_page = 100;

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
            'base_url' => base_url() . 'cashier/Position/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlPosition->CountAll(),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->axo_common->Select("
            posid,name
            ",
                        "position",
                        "", $segment,
                        $per_page
        );

        if ($result):
            $head = array(
                'rownum' => '#',
                'name' => 'Position'
            );
            $tbl_config = array(
                'tb_width' => '40%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NONE
                ),
                'nocheckbox' => false,
                'noaction' => false,
                'noselect' => true
            );
            $datagrid = $this->table->generate($result, 'posid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No data exists.</h3>';
        endif;

        $content = array(
            'datagrid' => $datagrid,
            'pagination' => $this->pagination->create_links()
        );
        $this->axo_template->deploy($content, 'employees/position/grid');
    }

    function add() {
        $content = array();
        $this->axo_template->deploy($content, 'employees/position/add');
    }

    function adding() {
        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'posid' => $this->axo_common->NewID('P', 'position', 'posid'),
                'name' => $this->input->post('name', true),
                'prefix' => $this->axo_common->AutoPrefix($this->input->post('name', true), 2)
            );
            $this->MdlPosition->Insert($data);
            redirect('employees/Position', 'refresh');
        else:
            $content = array();
            $this->axo_template->deploy($content, 'employees/position/add');
        endif;
    }

    function view($id) {
        $res = $this->axo_common->FreeSelect("posid,name", "position", "posid = '$id'", true);
        $content = $res[0];
        $this->axo_template->deploy($content, 'employees/position/view');
    }

    function edit($id) {
        $res = $this->axo_common->FreeSelect("posid,name", "position", "posid = '$id'", true);
        $content = $res[0];
		$content['posid'] = $id;
        $this->axo_template->deploy($content, 'employees/position/edit');
    }

    function editing($id) {
        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'name' => $this->input->post('name', true),
                'prefix' => $this->axo_common->AutoPrefix($this->input->post('name', true), 2)
            );
            $this->MdlPosition->Update($data, $id);
            redirect('employees/Position', 'refresh');
        else:
            $content = array(
				'posid' => $id
			);
            $this->axo_template->deploy($content, 'employees/position/edit');
        endif;
    }

    function delete() {
        $res = $this->axo_common->FreeSelect('posid,name', 'position', '', true);
        $position = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['posid'])):
                $ada = true;
                $position[$i]['posid'] = $data['posid'];
                $position[$i]['name'] = $data['name'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'employees/Position');
        else:
            $content = array(
                'position' => $position
            );
            $this->axo_template->deploy($content, 'employees/position/delete');
        endif;
    }

    function deleting() {
        $res = $this->axo_common->FreeSelect('posid', 'position', '', true);
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['posid'])):
                $this->MdlPosition->Delete($data['posid']);
            endif;
        endforeach;
        redirect(base_url() . 'employees/Position');
    }
}
?>
