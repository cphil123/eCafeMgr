<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Employees
 *
 * @author situs
 */
class Employees extends Controller {

    function Employees() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'employees/Employees';
        $this->load->model('MdlEmployees');
        $this->load->model('MdlPosition');
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
            'base_url' => base_url() . 'employees/Employees/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlEmployees->CountAll(),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

        $result = $this->axo_common->Select("e.empid,e.name,p.name AS nmpos,e.bdate,e.bplace,e.addr,e.city,e.prov,e.zip,e.phone", "employee e,position p", "e.posid = p.posid", $segment, $per_page);

        if ($result):
            $head = array(
                'rownum' => '#',
                'name' => 'Full Name',
                'nmpos' => 'Position',
                'bdate' => 'Birth Date',
                'bplace' => 'Birth Place',
                'addr' => 'Address',
                'city' => 'City',
                'prov' => 'Province',
                'zip' => 'Zipcode',
                'phone' => 'Phone'
            );
            $tbl_config = array(
                'tb_width' => '160%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_LONGDATE,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NONE
                ),
                'nocheckbox' => false,
                'noaction' => false,
                'noselect' => true
            );
            $datagrid = $this->table->generate($result, 'empid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No data.</h3>';
        endif;

        $content = array(
            'datagrid' => $datagrid,
            'pagination' => $this->pagination->create_links()
        );
        $this->axo_template->deploy($content, 'employees/Employees/grid');
    }

    function add() {
        $content = array();
        $content['sel_pos'] = $this->axo_common->Options('position', 'posid', 'name');
        $this->axo_template->deploy($content, 'employees/Employees/add');
    }

    function adding() {
        $this->form_validation->set_rules('posid', 'Position', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('bdate', 'Birth date', 'required');
        $this->form_validation->set_rules('bplace', 'Birth place', 'required');
        $this->form_validation->set_rules('addr', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('prov', 'Province', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'empid' => $this->axo_common->NewID($this->MdlPosition->GetPrefixById($this->input->post('posid', true)), 'employee', 'empid', true),
                'posid' => $this->input->post('posid', true),
                'name' => $this->input->post('name', true),
                'bdate' => $this->axo_common->DatePostedToDateDb($this->input->post('bdate', true)),
                'bplace' => $this->input->post('bplace', true),
                'addr' => $this->input->post('addr', true),
                'city' => $this->input->post('city', true),
                'prov' => $this->input->post('prov', true),
                'zip' => $this->input->post('zip', true),
                'phone' => $this->input->post('phone', true)
            );
            $this->MdlEmployees->Insert($data);
            redirect('employees/Employees', 'refresh');
        else:
            $content = array();
            $content['sel_pos'] = $this->axo_common->Options('position', 'posid', 'name');
            $this->axo_template->deploy($content, 'employees/Employees/add');
        endif;
    }

    function view($id) {
        $res = $this->axo_common->FreeSelect("e.empid,e.name,p.name AS nmpos,e.bdate,e.bplace,e.addr,e.city,e.prov,e.zip,e.phone", "employee e,position p", "e.posid = p.posid AND e.empid = '$id'", true);
        $res[0]['bdate'] = $this->axo_common->DbDateToLongDateFormat($res[0]['bdate']);
        $content = $res[0];
        $this->axo_template->deploy($content, 'employees/Employees/view');
    }

    function edit($id) {
        $res = $this->axo_common->FreeSelect("e.empid,e.posid,e.name,p.name AS nmpos,e.bdate,e.bplace,e.addr,e.city,e.prov,e.zip,e.phone", "employee e,position p", "e.posid = p.posid AND e.empid = '$id'", true);
        $res[0]['bdate'] = $this->axo_common->DateDbToDatePosted($res[0]['bdate']);
        $content = $res[0];
        $content['sel_pos'] = $this->axo_common->Options('position', 'posid', 'name', $res[0]['posid']);
        $this->axo_template->deploy($content, 'employees/Employees/edit');
    }

    function editing($id) {
        $this->form_validation->set_rules('posid', 'Position', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('bdate', 'Birth date', 'required');
        $this->form_validation->set_rules('bplace', 'Birth place', 'required');
        $this->form_validation->set_rules('addr', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('prov', 'Province', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'empid' => $this->input->post('empid', true),
                'posid' => $this->input->post('posid', true),
                'name' => $this->input->post('name', true),
                'bdate' => $this->axo_common->DatePostedToDateDb($this->input->post('bdate', true)),
                'bplace' => $this->input->post('bplace', true),
                'addr' => $this->input->post('addr', true),
                'city' => $this->input->post('city', true),
                'prov' => $this->input->post('prov', true),
                'zip' => $this->input->post('zip', true),
                'phone' => $this->input->post('phone', true)
            );
            $this->MdlEmployees->update($data, $id);
            redirect('employees/Employees', 'refresh');
        else:
            $content = array();
            $res = $this->axo_common->FreeSelect("e.empid,e.posid,e.name,p.name AS nmpos,e.bdate,e.bplace,e.addr,e.city,e.prov,e.zip,e.phone", "employee e,position p", "e.posid = p.posid AND e.empid = '$id'", true);
            $res[0]['bdate'] = $this->axo_common->DateDbToDatePosted($res[0]['bdate']);
            $content = $res[0];
            $content['sel_pos'] = $this->axo_common->Options('position', 'posid', 'name', $res[0]['posid']);
            $this->axo_template->deploy($content, 'employees/employees/edit');
        endif;
    }

    function delete() {
        $res = $this->axo_common->FreeSelect('empid,name', 'employee', '', true);
        $employees = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['empid'])):
                $ada = true;
                $employees[$i]['empid'] = $data['empid'];
                $employees[$i]['name'] = $data['name'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'employees/Employees');
        else:
            $content = array(
                'employees' => $employees
            );
            $this->axo_template->deploy($content, 'employees/employees/delete');
        endif;
    }

    function deleting() {
        $res = $this->axo_common->FreeSelect('empid,name', 'employee', '', true);
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['empid'])):
                $this->MdlEmployees->Delete($data['empid']);
            endif;
        endforeach;
        redirect(base_url() . 'employees/Employees');
    }

}

?>
