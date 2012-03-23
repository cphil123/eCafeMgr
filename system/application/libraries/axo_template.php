<?

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AXO_Template {

    var $ci;

    function AXO_Template() {
        $this->ci = &get_instance();
    }

    function header() {
        $header = array(
            'is_logged' => $this->ci->session->userdata('is_logged'),
            'web_title' => $this->ci->config->item('web_title'),
			'uname' => $this->ci->session->userdata('uname'),
			'usergroup' => $this->ci->session->userdata('usergroup'),
            'groupname' => $this->ci->session->userdata('groupname')
        );
        $this->ci->load->view('layout/header', $header);
    }

    function content($data, $view) {
        $this->ci->load->view($view, $data);
    }

    function footer() {
        $footer = array(
            'web_copy' => $this->ci->config->item('web_copy')
        );
        $this->ci->load->view('layout/footer', $footer);
    }

    function deploy($data = array(), $view = 'layout/content') {
        $this->header();
        $this->content($data, $view);
        $this->footer();
    }

}

?>