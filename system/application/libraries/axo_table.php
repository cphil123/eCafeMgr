<?

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AXO_Table extends CI_Table {

    private $ci;
    public $realm;

    public function AXO_Table() {
        parent::CI_Table();
        $this->ci = &get_instance();
    }

    public function generate($tdata, $id, $heading = array(), $segment = array(), $config = array()) {
		$offset = $segment[7];
		
        // config: col_format = array(col1, col2, col3, ...), possible value = is_text, is_currency
        extract($config);

        if (empty($justview)):
            $justview = false;
        endif;
        
        if (empty($grid)):
            $grid = 'grid';
        endif;

        if (empty($view)):
            $view = 'view';
        endif;

        if (empty($edit)):
            $edit = 'edit';
        endif;

        if (empty($tb_width)):
            $tb_width = '100%';
        endif;

        $tpl = array(
            'table_open' => '<table width="' . $tb_width . '" cellpadding="2" cellspacing="1" border="0" class="tabel">',
            'heading_row_start' => '<tr class="headrow">',
            'row_start' => '<tr class="mout" onmouseover="this.className = \'mover\';" onmouseout="this.className = \'mout\';" onclick="checkThis(this);">',
            'row_alt_start' => '<tr class="mout" onmouseover="this.className = \'mover\';" onmouseout="this.className = \'mout\';" onclick="checkThis(this);">'
        );
		
		if ($noselect && $nocheckbox && $noaction):
			$tpl['row_start'] = '';
			$tpl['row_alt_start'] = '';
		endif;
		
        parent::set_template($tpl);
        $firsttime = true;
        foreach ($heading as $name => $head):
            if ($firsttime):
                $firsttime = false;
                $hdtitle[] = $head;
                continue;
            endif;

            // 9650, 9660
            if (count($segment) > 0):
                if ($name == $segment[4]):
					if ($segment[6] == 'asc'):
	                    $arrow = '&#9650;';
						$ordertype = 'desc';
					elseif ($segment[6] == 'desc'):					
	                    $arrow = '&#9660;';
						$ordertype = 'asc';
					endif;
                else:
                    $arrow = '_';
                endif;
                $hdtitle[] = '<a href="' . base_url() . $this->realm . '/' . $grid . '/' . $name . '/' . $segment[5] . '/' . $ordertype . '/' . $segment[7] . '">[' . $arrow . ']</a> ' . $head;
            else:
                $hdtitle[] = $head;
            endif;
        endforeach;

        if ((!$noaction) || (!$noselect) || !empty($customlink)):
            $hdtitle[] = 'Action';
        endif;

        if ($segment[8] == 'all'):
            $checked = ' checked';
        else:
            $selcb = '/all';
        endif;

        if (!$nocheckbox):
            $hdtitle[] = '<input type="checkbox" onclick="javascript:_goto(\'' . $this->realm . '/' . $grid . '/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/' . $segment[7] . $selcb . '\')"' . $checked . ' />';
        endif;

        parent::set_heading($hdtitle);
        $row = 1;
		// looping data per baris
        foreach ($tdata as $srow):
            $drow = array();
            $drow[] = '<div align="center">' . ($row + $offset) . '</div>';
            if (!$noaction):
                $srow->action = '<div align="center"><a href="' . base_url() . $this->realm . '/' . $view . '/' . $srow->$id . '">view</a>';
                if (!$justview):
                    $srow->action .= ' | <a href="' . base_url() . $this->realm . '/' . $edit . '/' . $srow->$id . '">edit</a>';
                endif;
            endif;
			if (!empty($customlink)):
				$srow->action = '<div align="center"><a href="' . base_url() . $customlink . '/' . $srow->$id . '">view</a>';
			endif;
            if (!$noselect):
                if (count($param) == 3):
                    $srow->action = '<div align="center"><a href="javascript:_select3(\'' . $param[1] . '\',\'' . $param[2] . '\',\'' . $param[0] . '\',\'' . $srow->$param[1] . '\',\'' . $srow->$param[2] . '\',\'' . $srow->$param[0] . '\')">select</a>';
                elseif (count($param) == 4):
                    $srow->action = '<div align="center"><a href="javascript:_select4(\'' . $param[1] . '\',\'' . $param[2] . '\',\'' . $param[3] . '\',\'' . $param[0] . '\',\'' . $srow->$param[1] . '\',\'' . $srow->$param[2] . '\',\''. $srow->$param[3] .'\',\'' . $srow->$param[0] . '\')">select</a>';
                elseif (count($param) == 5):
                    $srow->action = '<div align="center"><a href="javascript:_select5(\'' . $param[1] . '\',\'' . $param[2] . '\',\'' . $param[3] . '\',\'' . $param[4] . '\',\'' . $param[0] . '\',\'' . $srow->$param[1] . '\',\'' . $srow->$param[2] . '\',\''. $srow->$param[3] .'\',\''. $srow->$param[4] .'\',\'' . $srow->$param[0] . '\')">select</a>';
				else:
                    $srow->action = '<div align="center"><a href="javascript:_select2(\'' . $param[1] . '\',\'' . $param[0] . '\',\'' . $srow->$param[1] . '\',\'' . $srow->$param[0] . '\')">select</a>';
                endif;
            endif;
            $datarow = get_object_vars($srow);

            $firsttime = true;
            $i = 0;
			// looping data per kolom
			$colcount = count($datarow);
            foreach ($datarow as $dtr):
                if ($firsttime):
                    $firsttime = false;
                    continue;
                endif;

				if ($any_unit_conversion_exists && ($i + 1 == $colcount - 1)):
					break;
				endif;
				
                // column format
                switch ($col_format[$i]):
                    case COL_FORMAT_IS_TEXT:
                        $dtr = $dtr;
                        break;
                    case COL_FORMAT_IS_TEXT_CENTER:
                        $dtr = '<div align="center">' . $dtr . '</div>';
                        break;
                    case COL_FORMAT_IS_TEXT_RIGHT:
                        $dtr = '<div align="right">' . $dtr . '</div>';
                        break;
                    case COL_FORMAT_IS_CURRENCY:
                        $dtr = '<div align="right">' . $this->ci->axo_common->FormatCurrency($dtr) . '</div>';
                        break;
                    case COL_FORMAT_IS_LONGDATE:
                        $dtr = '<div align="center">' . $this->ci->axo_common->DateDbToLongDateFormat($dtr) . '</div>';
                        break;
                    case COL_FORMAT_IS_NUMBER:
                        $dtr = '<div align="center">' . $this->ci->axo_common->FormatNumber($dtr) . '</div>';
                        break;
                    case COL_FORMAT_IS_UNIT:
                        $dtr = '<div align="center">' . $this->ci->axo_common->FormatUnit($dtr) . '</div>';
                        break;
                    case COL_FORMAT_IS_GROUP:
                        $dtr = '<div align="left">' . $this->ci->axo_access->GroupName($dtr) . '</div>';
                        break;
                endswitch;
                $drow[] = $dtr;
                $i++;
            endforeach;
            if (!$nocheckbox):
                $drow[] = '<div align="center"><input type="checkbox" name="cb-' . $srow->$id . '" value="yes"' . $checked . ' /></div>';
            endif;
            parent::add_row($drow);
            $row++;
        endforeach;
        return parent::generate();
    }

}

?>