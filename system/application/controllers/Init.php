<?php
class Init extends Controller {

    function Init() {
        parent::Controller();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('axo_template', $this);
        $this->load->model('MdlConfig');
    }

    function index() {
		$this->MdlConfig->SetConfig();
		$this->axo_access->CheckReference('Init');
		redirect(base_url() . 'cashier/Summary', 'refresh');
    }
}
?>