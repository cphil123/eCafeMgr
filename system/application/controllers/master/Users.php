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
class Users extends Controller {

    function Users() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'master/users';
        $this->load->model('MdlUsers');
        $this->load->database();

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Users');
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
            $segment[4] = 'userid';
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
            'base_url' => base_url() . 'master/users/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlUsers->CountAll(),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->axo_common->Select('userid,uname,group', 'users', "", $segment, $per_page);

        if ($result):
            $head = array(
				'rownum' => '#',
				'uname' => 'Username', 
				'group' => 'Group'
			);
            $tbl_config = array(
                'tb_width' => '40%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_GROUP,
                    COL_FORMAT_IS_NONE
                ),
				'noaction' => false,
				'nocheckbox' => false,
				'noselect' => true
            );
            $datagrid = $this->table->generate($result, 'userid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No users exists on database.</h3>';
        endif;

        $content = array(
            'datagrid' => $datagrid,
            'pagination' => $this->pagination->create_links()
        );
        $this->axo_template->deploy($content, 'master/users/grid');
    }

    function add() {
        $content = array(
			'sel_group' => $this->axo_common->OptionGroups('')
		);
        $this->axo_template->deploy($content, 'master/users/add');
    }

    function adding() {
        $this->form_validation->set_rules('uname', 'Username', 'required');
        $this->form_validation->set_rules('paswd', 'Password', 'required');
        $this->form_validation->set_rules('group', 'Usergroup', 'required');

        if ($this->form_validation->run() == TRUE):
            $data = array(
                'userid' => 'LAST_INSERT_ID()',
                'uname' => $this->input->post('uname', true),
                'paswd' => $this->input->post('paswd', true),
                'group' => $this->input->post('group', true),
            );
            $this->MdlUsers->Insert($data);
            redirect('master/Users', 'refresh');
        else:
			$content = array(
				'sel_group' => $this->axo_common->OptionGroups('')
			);
            $this->axo_template->deploy($content, 'master/users/add');
        endif;
    }

    function view($id) {
        $res = $this->axo_common->FreeSelect("*", "users", "userid = '$id'", true);
        $content = $res[0];
		$content['groupname'] = $this->axo_access->GroupName($res[0]['group']);
        $this->axo_template->deploy($content, 'master/users/view');
    }

    function edit($id) {
        $res = $this->axo_common->FreeSelect("userid,uname,paswd,`group`", "users", "userid = '$id'", true);
        $content = $res[0];
		$content['sel_group'] = $this->axo_common->GroupOptions($res[0]['group']);
        $this->axo_template->deploy($content, 'master/users/edit');
    }

    function editing() {
        $this->form_validation->set_rules('uname', 'Username', 'required');
        $this->form_validation->set_rules('paswd', 'Password', 'required');
        $this->form_validation->set_rules('group', 'Usergroup', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'uname' => $this->input->post('uname', true),
                'paswd' => $this->input->post('paswd', true),
                'group' => $this->input->post('group', true)
            );
            $this->MdlUsers->Update($data, $this->input->post('userid', true));
            redirect('master/Users', 'refresh');
        else:
			$content = array(
				'sel_group' => $this->axo_common->OptionGroups('')
			);
            $this->axo_template->deploy($content, 'master/users/edit');
        endif;
    }

    function delete() {
        $res = $this->axo_common->FreeSelect('userid,uname', "users", "", true);
        $divisi = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['userid'])):
                $ada = true;
                $divisi[$i]['userid'] = $data['userid'];
                $divisi[$i]['uname'] = $data['uname'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'master/Users');
        else:
            $content = array(
                'divisi' => $divisi
            );
            $this->axo_template->deploy($content, 'master/users/delete');
        endif;
    }

    function deleting() {
        $res = $this->axo_common->FreeSelect("userid,uname", "users", "", true);
        $divisi = array();
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['userid'])):
                $this->MdlUsers->Delete($data['userid']);
            endif;
        endforeach;
        redirect(base_url() . 'master/users');
    }

}

?>
