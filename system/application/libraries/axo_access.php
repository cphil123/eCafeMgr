<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class AXO_Access {
	var $ci;
	
	function AXO_Access() {
		$this->ci = &get_instance();
	}	
	
	function is_logged() {
		if ($this->ci->session->userdata('is_logged')):
			return true;
		else:
			return false;
		endif;
	}
	
	function must_logged() {
		if (!$this->is_logged()):
			redirect(base_url().'Login');
		endif;
	}
	
	function CheckReference($curr_con) {
		$prev_con = $this->ci->axo_common->Get('CONTROLLER');
		if ($curr_con != $prev_con):
			$this->ci->axo_common->Erase('CONTROLLER');			
			$this->ci->axo_common->Set('CONTROLLER', $curr_con);
			$this->ci->axo_common->Erase('VAR_REFERENCE');
		endif;
		$prev_con = $this->ci->axo_common->Get('CONTROLLER');
	}
	
	function GroupName($str) {
		switch ($str) {
			case 'SYS':
				$groupname = 'Technical Support Officer';
				break;
			case 'CSR':
				$groupname = 'Cashier';
				break;
			case 'SPV':
				$groupname = 'Supervisor';
				break;
			case 'ADM':
				$groupname = 'Office Administration';
				break;
			case 'ACC':
				$groupname = 'Accounting &amp; Finance';
				break;
			case 'OMG':
				$groupname = 'Operational Manager';
				break;
			case 'GMG':
				$groupname = 'General Manager';
				break;
			case 'OWN':
				$groupname = 'Business Owner';
				break;
			case 'PUR':
				$groupname = 'Purchasing';
				break;
		}
		return $groupname;
	}
}
?>