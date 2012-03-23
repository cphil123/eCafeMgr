<?php
class Login extends Controller {

    function Login() {
        parent::Controller();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('axo_template', $this);
    }

    function index() {
        $this->axo_template->deploy($data, 'login');
    }
}
?>