<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sales
 *
 * @author situs
 */
class Sales extends Controller {

    function Sales() {
        parent::Controller();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');
        $this->table->realm = 'products/Sales';
        $this->load->model('MdlSales');
        $this->load->database();

        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Sales');
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
            $segment[4] = 'catname';
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

		if ($this->input->post('catid')):
			$catid = $this->input->post('catid');
		endif;
		
		if ($this->input->post('tagid')):
			$tagid = $this->input->post('tagid');
		endif;
		
		if ($this->input->post('dtrange')):
			$dtrange = $this->input->post('dtrange');
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('enddate');
			$mon = $this->input->post('mon');
			$year = $this->input->post('year');
		endif;
				
		$radio_dtrange[$dtrange] = 'checked';
		$where = "";
		switch ($dtrange):
			case 'bydate':
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);
				$where .= " AND r.date >= '$date1' AND r.date <= '$date2' ";
				break;
			case 'bymonth':
				$where .= " AND MONTH(r.date) = $mon AND YEAR(r.date) = $year ";
				break;
		endswitch;

		$refer['dtrange'] = $dtrange;
		$refer['startdate'] = $startdate;
		$refer['enddate'] = $enddate;
		$refer['mon'] = $mon;
		$refer['year'] = $year;
		$refer['catid'] = $catid;
		$refer['tagid'] = $tagid;
		$this->axo_common->Set('VAR_REFERENCE', $refer);
		
		$dtl['startdate'] = $this->axo_common->DatePostedToLongDateFormat($startdate);
		$dtl['enddate'] = $this->axo_common->DatePostedToLongDateFormat($enddate);
		$dtl['mon'] = $this->axo_common->mon_str($mon);
		$dtl['year'] = $year;

		if (!empty($catid) && $catid != -1):
			$dtl['catname'] = $this->axo_common->GetFieldValue('menucats', 'name', "catid = '$catid'");
			$where .= " AND c.catid = '$catid' ";
		endif;		
		
		if (!empty($tagid) && $tagid != -1):
			$dtl['tagname'] = $this->axo_common->GetFieldValue('tags', 'desc', "tagid = '$tagid'");
			$where .= " AND t.tagid = '$tagid' ";
		endif;		

		$totalall = $this->MdlSales->TotalAll($where);
		$totalrows = $this->MdlSales->CountAll($where);

        $this->pagination->initialize(array(
            'base_url' => base_url() . 'products/Sales/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $totalrows,
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

		$query = $this->db->query("
			SELECT m.menuid,c.name AS catname,t.`desc` AS tagname,m.name,SUM(p.price) AS hpp,m.price,SUM(d.qty) AS sqty,(m.price * SUM(d.qty)) AS ttl
			FROM receipt r,dtlkot d,menucats c,tags t,menus m
			LEFT JOIN composition p ON p.menuid = m.menuid
			WHERE r.kotid = d.kotid AND d.menuid = m.menuid AND m.catid = c.catid AND m.tagid = t.tagid $where 
			GROUP BY m.menuid
			ORDER BY ".$segment[4]." ".$segment[6]."
			LIMIT ".$segment[7].", $per_page
		");
		$result = $query->result();
		
        if ($result):
            $head = array(
                'rownum' => '#',
                'catname' => 'Category',
                'tagname' => 'Label',
                'name' => 'Product Name',
				'hpp' => 'CoP',
                'price' => 'Price',
                'sqty' => 'Qty',
                'ttl' => 'Sub Total'
            );
            $tbl_config = array(
                'tb_width' => '100%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_NUMBER,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_NONE
                ),
				'offset' =>$segment[7],
                'noselect' => true,
                'noaction' => true,
                'nocheckbox' => true
            );
            $datagrid = $this->table->generate($result, 'menuid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No data for particular date.</h3>';
        endif;

        $content = array(
			'date' => $date,
            'year' => $year,
            'radio_dtrange' => $radio_dtrange,
			'sel_cat' => $this->axo_common->Options("menucats", "catid", "name", $catid),
			'sel_tag' => $this->axo_common->Options("tags", "tagid", "desc", $tagid),
            'datagrid' => $datagrid,			
            'totalall' => $this->axo_common->FormatCurrency($totalall),
			'radio_dtrange' => $radio_dtrange,
			'startdate' => $startdate,
			'enddate' => $enddate,
			'sel_mon'=> $this->axo_common->OptionsMonth($mon),
			'mon' => $mon,
			'year' => $year,
			'dtrange' => $dtrange,
            'pagination' => $this->pagination->create_links(),
			'dtl' => $dtl
        );
        $this->axo_template->deploy($content, 'products/sales/grid');
    }

    function report() {
		$refer = array();
		$refer = $this->axo_common->Get('VAR_REFERENCE');
		extract($refer);

		$where = "";
		switch ($dtrange):
			case 'bydate':
				$date1 = $this->axo_common->DatePostedToDateDb($startdate);
				$date2 = $this->axo_common->DatePostedToDateDb($enddate);				
				$str_report_range = 'From ' . $this->axo_common->DateDbToLongDateFormat($date1) . ' To ' . $this->axo_common->DateDbToLongDateFormat($date2);
				$where .= " AND r.date >= '$date1' AND r.date <= '$date2' ";
				break;
			case 'bymonth':
				$str_report_range = $this->axo_common->mon_str($mon) . ' ' . $year;
				$where .= " AND MONTH(r.date) = $mon AND YEAR(r.date) = $year ";
				break;
		endswitch;

		if (!empty($catid) && $catid != -1):
			$dtl['catname'] = $this->axo_common->GetFieldValue('menucats', 'name', "catid = '$catid'");
			$where .= " AND c.catid = '$catid' ";
		endif;		
		
		if (!empty($tagid) && $tagid != -1):
			$dtl['tagname'] = $this->axo_common->GetFieldValue('tags', 'desc', "tagid = '$tagid'");
			$where .= " AND t.tagid = '$tagid' ";
		endif;		
		
        $this->load->library('cezpdf');
        $this->cezpdf->ezSetCmMargins(3, 2, 2.5, 2);
        $tbcfg = array(
			'xPos' => 'left', 
			'xOrientation' => 'right', 
			'width' => 480, 
			'fontSize' => 8, 
			'shaded' => 0, 
			'showLines' => 2
		);
		$this->cezpdf->addJpegFromFile('images/logo-kecil.jpg', 10, 770, 80);
        $this->cezpdf->ezText('Sales Journal', 12, array('justification' => 'center'));
        $this->cezpdf->ezText($str_report_range, 8, array('justification' => 'center'));
        $this->cezpdf->ezText('');

        $colnames = array(
            'rownum' => '#',
            'catname' => 'Category',
            'tagname' => 'Label',
            'name' => 'Product Name',
			'hpp' => 'CoP',
            'price' => 'Price',
            'ttlqty' => 'Qty',
            'ttl' => 'Sub Total'
        );

		if (!empty($ctid) && $ctid != -1):
			$wctid = " AND k.ctid = $ctid";
		endif;
		
		$query = $this->db->query("
			SELECT c.name AS catname,t.`desc` AS tagname,m.name,SUM(p.price) AS hpp,m.price,SUM(d.qty) AS ttlqty,(m.price * SUM(d.qty)) AS ttl
			FROM receipt r,dtlkot d,menucats c,tags t,menus m
			LEFT JOIN composition p ON p.menuid = m.menuid
			WHERE r.kotid = d.kotid AND d.menuid = m.menuid AND m.catid = c.catid AND m.tagid = t.tagid $where 
			GROUP BY m.menuid
		");
		$result = $query->result();
		
		$total = 0;
		$ttlqty = 0;
        for ($i = 0; $i < count($result); $i++):
			$coldata[$i]['rownum'] = $i + 1;
			$coldata[$i]['catname'] = $result[$i]->catname;
			$coldata[$i]['tagname'] = $result[$i]->tagname;
			$coldata[$i]['name'] = $result[$i]->name;
			$coldata[$i]['hpp'] = $this->axo_common->FormatCurrency($result[$i]->hpp);
			$coldata[$i]['price'] = $this->axo_common->FormatCurrency($result[$i]->price);
			$coldata[$i]['ttlqty'] = $this->axo_common->FormatNumber($result[$i]->ttlqty);
			$coldata[$i]['ttl'] = $this->axo_common->FormatCurrency($result[$i]->ttl);
			$total += $result[$i]->ttl;
			$ttlqty += $result[$i]->ttlqty;
        endfor;
		$y = $this->cezpdf->ezTable($coldata, $colnames, '', $tbcfg);

		$y -= 25;
		$this->cezpdf->addText(70, $y, 8, 'Total Product');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatNumber($ttlqty));

		$y -= 15;
		$this->cezpdf->addText(70, $y, 8, 'Total Sales');
		$this->cezpdf->addText(180, $y, 8, ':');
		$this->cezpdf->addText(190, $y, 8, $this->axo_common->FormatCurrency($total));

        $this->cezpdf->ezStartPageNumbers(750, 28, 8, '', '{PAGENUM}', 1);
        $this->cezpdf->line(20, 40, 800, 40);
        $this->cezpdf->addText(50, 32, 8, 'Printed on ' . date('m/d/Y h:i:s a'));
        $this->cezpdf->addText(50, 22, 8, 'Lemah Ledok Garden Resto');
        $this->cezpdf->ezStream();
    }

}

?>
