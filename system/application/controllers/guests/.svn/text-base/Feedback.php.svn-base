<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Feedback
 *
 * @author situs
 */
class Feedback extends Controller {

    function Feedback() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'guests/Feedback';
        $this->load->model('MdlFeedback');
        $this->load->database();

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Feedback');
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
            $segment[4] = 'date';
        endif;

        // selected filter
        if (empty($segment[5])):
            $segment[5] = 'none';
        endif;

        // order type
        if (empty($segment[6])):
            $segment[6] = 'asc';
        endif;

        // offset paging
        if (empty($segment[7])):
            $segment[7] = '0';
        endif;
		
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		if (is_array($refer)):
			extract($refer);
		else:
			$dtrange = 'bydate';
			$startdate = $this->axo_common->today('ddmmyyyy');
			$enddate = $this->axo_common->today('ddmmyyyy');
			$mon = $this->axo_common->curMonth();
			$year = $this->axo_common->curYear();
		endif;

		if ($this->input->post('dtrange')):
			$dtrange = $this->input->post('dtrange');
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('enddate');
			$mon = $this->input->post('mon');
			$year = $this->input->post('year');
		endif;
				
		$radio_dtrange[$dtrange] = 'checked';
		switch ($dtrange):
			case 'bydate':
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$where = " AND date >= '$date1' AND date <= '$date2'";
				break;
			case 'bymonth':
				$where = " AND MONTH(date) = $mon AND YEAR(date) = $year";
				break;
		endswitch;

		$refer['dtrange'] = $dtrange;
		$refer['startdate'] = $startdate;
		$refer['enddate'] = $enddate;
		$refer['mon'] = $mon;
		$refer['year'] = $year;
		$this->axo_common->Set('VAR_REFERENCE', $refer);

		$dtl['startdate'] = $this->axo_common->DatePostedToLongDateFormat($startdate);
		$dtl['enddate'] = $this->axo_common->DatePostedToLongDateFormat($enddate);
		$dtl['mon'] = $this->axo_common->mon_str($mon);
		$dtl['year'] = $year;
		
        $this->pagination->initialize(array(
            'base_url' => base_url() . 'guests/Feedback/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6],
            'total_rows' => $this->MdlFeedback->CountAll($where),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

		$query = $this->db->query("
			SELECT norec,date,name,msg
			FROM feedback
			WHERE 1 = 1 $where
			ORDER BY ".$segment[4]." ".$segment[6]."
			LIMIT ".$segment[7].", $per_page
		");
		$result = $query->result();

        if ($query->num_rows > 0):
            $head = array(
				'rownum' => '#',
				'date' => 'Date', 
				'name' => 'Customer Name', 
				'msg' => 'Feedback'
			);
            $tbl_config = array(
                'tb_width' => '100%',
				'offset' => $segment[7],
                'col_format' => array(
                    COL_FORMAT_IS_LONGDATE,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_NONE
                ),
				'noaction' => true,
				'nocheckbox' => true,
				'noselect' => true
            );
            $datagrid = $this->table->generate($result, 'norec', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No feedback exists on database.</h3>';
        endif;

        $content = array(
            'date' => $this->axo_common->Get('date'),
            'datagrid' => $datagrid,
			'radio_dtrange' => $radio_dtrange,
			'startdate' => $startdate,
			'enddate' => $enddate,
			'sel_mon'=> $this->axo_common->OptionsMonth($mon),
			'mon' => $mon,
			'year' => $year,
			'dtrange' => $dtrange,
            'pagination' => $this->pagination->create_links(),
			'segment' => $segment,
			'dtl' => $dtl
        );
        $this->axo_template->deploy($content, 'guests/feedback/grid');
    }

	function report() {
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		extract($refer);

		switch ($dtrange):
			case 'bydate':
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$where = " AND date >= '$date1' AND date <= '$date2'";
				$str_report_range = 'From ' . $this->axo_common->DateDbToLongDateFormat($startdate) . ' To ' . $this->axo_common->DateDbToLongDateFormat($enddate);
				break;
			case 'bymonth':
				$where = " AND MONTH(date) = $mon AND YEAR(date) = $year";
				$str_report_range = $this->axo_common->mon_str($mon) . ' ' . $year;
				break;
		endswitch;

        $this->load->library('cezpdf');
        $this->cezpdf->ezSetCmMargins(3, 2, 2.5, 2);
		$colnames = array(
			'rownum' => '#',
			'date' => 'Date', 
			'name' => 'Customer Name', 
			'msg' => 'Feedback'
		);
        $tbcfg = array(
			'xPos' => 'left', 
			'xOrientation' => 'right', 
			'width' => 480, 
			'fontSize' => 8, 
			'shaded' => 0, 
			'showLines' => 2
		);
		$this->cezpdf->addJpegFromFile('images/logo-kecil.jpg', 10, 770, 80);
        $this->cezpdf->ezText('Guest Comments', 12, array('justification' => 'center'));
        $this->cezpdf->ezText($str_report_range, 8, array('justification' => 'center'));
        $this->cezpdf->ezText('');
		
		$query1 = $this->db->query("
			SELECT norec,date,name,msg
			FROM feedback
			WHERE 1 = 1 $where
		");
        $result = $query1->result();
		$ttl = 0;
		$ttldisc = 0;
		$ttltax = 0;
		$total = 0;
        for ($i = 0; $i < count($result); $i++):
			$coldata[$i]['rownum'] = $i + 1;
			$coldata[$i]['date'] = $this->axo_common->DateDbToLongDateFormat($result[$i]->date);
			$coldata[$i]['name'] = $result[$i]->name;
			$coldata[$i]['msg'] = $result[$i]->msg;
        endfor;
		$y = $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);
		
        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
	}

}

?>
