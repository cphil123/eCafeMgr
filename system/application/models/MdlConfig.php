<?php

class MdlConfig extends Model {

    function MdlConfig() {
        parent::Model();
    }

    function CountAll() {
        $query = $this->db->query("
			SELECT * FROM config
        ");
        return $query->num_rows;
    }

	function Update($data, $id) {
		$this->db->where("norec = $id");
		$this->db->update("config", $data);
		$this->session->set_userdata($data['name'], $data['value']);
	}
		
	function SetConfig() {
		$query = $this->db->query("SELECT * FROM config");
		$result = $query->result();
		for ($i = 0; $i < count($result); $i++):
			$this->session->set_userdata($result[$i]->name, $result[$i]->value);
		endfor;
	}
}

?>
