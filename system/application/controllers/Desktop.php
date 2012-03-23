<?php
class Desktop extends Controller {

    function Desktop() {
        parent::Controller();
        $this->load->database();

        $this->axo_access->must_logged();
    }
	
	function index() {
		$content = array(
		);
        $this->axo_template->deploy($content, 'desktop');
	}
}
?>