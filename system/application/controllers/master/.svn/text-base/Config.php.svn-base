<?php

class Config extends Controller {

    function Config() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'master/config';
        $this->load->model('MdlConfig');
        $this->load->database();

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Config');
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
            'base_url' => base_url() . 'master/Config/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlConfig->CountAll(),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->axo_common->Select('norec,name,`value`', 'config', "", $segment, $per_page);

        if ($result):
            $head = array(
				'rownum' => '#',
				'name' => 'Name', 
				'value' => 'Value'
			);
            $tbl_config = array(
                'tb_width' => '40%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NONE
                ),
				'noaction' => false,
				'nocheckbox' => true,
				'noselect' => true
            );
            $datagrid = $this->table->generate($result, 'norec', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No config exists on database.</h3>';
        endif;

        $content = array(
            'datagrid' => $datagrid,
            'pagination' => $this->pagination->create_links()
        );
        $this->axo_template->deploy($content, 'master/config/grid');
    }

    function view($id) {
        $res = $this->axo_common->FreeSelect("*", "config", "norec = $id", true);
        $content = $res[0];
		$content['groupname'] = $this->axo_access->GroupName($res[0]['group']);
        $this->axo_template->deploy($content, 'master/config/view');
    }

    function edit($id) {
        $res = $this->axo_common->FreeSelect("norec,name,value,`type`", "config", "norec = $id", true);
        $content = $res[0];
        $this->axo_template->deploy($content, 'master/config/edit');
    }

    function editing() {
        $this->form_validation->set_rules('value', 'Config value', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'name' => $this->input->post('name', true),
                'value' => $this->input->post('value', true)
            );
            $this->MdlConfig->Update($data, $this->input->post('norec', true));
            redirect('master/Config', 'refresh');
        else:
			$content = array(
			);
            $this->axo_template->deploy($content, 'master/config/edit');
        endif;
    }

}

?>
