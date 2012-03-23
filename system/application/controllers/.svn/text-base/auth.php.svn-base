<?php

class Auth extends Controller {

    function Auth() {
        parent::Controller();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('axo_template', $this);
    }

    function index() {

    }

    function login() {
        $this->form_validation->set_rules('uname', 'Username', 'required');
        $this->form_validation->set_rules('paswd', 'Password', 'required');

        if ($this->form_validation->run() == false):
            $this->axo_template->deploy();
        else:
            $uname = $this->input->post('uname');
            $paswd = $this->input->post('paswd');

            $query = $this->db->query("SELECT userid,paswd,`group` FROM `users` WHERE uname = '$uname'");
            $rows = $query->result();
            if ($query->num_rows() > 0):
                $paswd_ = $rows[0]->paswd;
                if ($paswd == $paswd_):
                    $this->session->set_userdata('is_logged', true);
                    $this->session->set_userdata('uname', $uname);
                    $this->session->set_userdata('userid', $rows[0]->userid);
                    $this->session->set_userdata('usergroup', $rows[0]->group);
                    $this->session->set_userdata('groupname', $this->axo_access->GroupName($rows[0]->group));
                    redirect('');
                else:
                    $this->axo_template->deploy();
                endif;
            else:
                $this->axo_template->deploy();
            endif;
        endif;
    }

    function logout() {
        $data = array(
            'is_logged' => ''
        );
        $this->session->unset_userdata($data);
        redirect('');
    }

}

?>