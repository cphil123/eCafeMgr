<?php
class Notifikasi extends Controller {

    function Notifikasi() {
        parent::Controller();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('axo_template', $this);
    }

    function index() {
    }
	
	function must_logged() {
		$data = array(
			'title'		=> 'Notifikasi',
			'content'	=> 'Maaf, Anda harus login terlebih dulu.'
		);
        $this->axo_template->deploy($data, 'notifikasi');
	}
}
?>