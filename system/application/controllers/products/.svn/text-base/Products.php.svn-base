<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Products
 *
 * @author situs
 */
class Products extends Controller {

    function Products() {
        parent::Controller();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('table');

        $this->table->realm = 'products/products';
        $this->load->model('MdlProducts');
        $this->load->model('MdlProductCategories');

        $this->load->database();
        $this->axo_access->must_logged();
    }

    function index() {
		$this->axo_access->CheckReference('Products');
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
            $segment[4] = 'name';
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
		endif;

		if ($this->input->post('catid')):
			$catid = $this->input->post('catid');
		endif;
		
		if ($this->input->post('tagid')):
			$tagid = $this->input->post('tagid');
		endif;
		
		if ($this->input->post('search') != ""):
			$search = $this->input->post('search');
		endif;
		
		$refer['catid'] = $catid;		
		$refer['tagid'] = $tagid;		
		$refer['search'] = $search;		
		$this->axo_common->Set('VAR_REFERENCE', $refer);
		
		$dtl['catid'] = $catid;
		$dtl['tagid'] = $tagid;
		$dtl['search'] = $search;

		$where = "";
		if (!empty($catid) && $catid != -1):
			$dtl['catname'] = $this->axo_common->GetFieldValue('menucats', 'name', "catid = '$catid'");
			$where .= " AND m.catid = '$catid'";
		endif;		
		
		if (!empty($tagid) && $tagid != -1):
			$dtl['tagname'] = $this->axo_common->GetFieldValue('tags', 'desc', "tagid = '$tagid'");
			$where .= " AND m.tagid = '$tagid'";
		endif;		
		
		if (!empty($search)):
			$where .= " AND m.name LIKE '%$search%'";
		endif;		
		
        $this->pagination->initialize(array(
            'base_url' => base_url() . 'products/Products/grid/' . $segment[4] . '/' . $segment[5] . '/' . $segment[6] . '/',
            'total_rows' => $this->MdlProducts->CountAll($where),
            'per_page' => $per_page,
            'uri_segment' => 7,
            'first_link' => 'Awal',
            'last_link' => 'Akhir'
        ));

		$query = $this->db->query("
			SELECT m.menuid,m.name,SUM(c.price) AS hpp,m.price
			FROM menus m			
			LEFT JOIN composition c ON m.menuid = c.menuid			
			WHERE 1 = 1 $where
			GROUP BY m.menuid
			ORDER BY ".$segment[4]." ".$segment[6]."
			LIMIT ".$segment[7].", $per_page
		");
		$result = $query->result();
		
        if ($query->num_rows > 0):
            $head = array(
				'rownum' => '#', 
				'name' => 'Description', 
				'hpp' => 'CoP',
				'price' => 'Price'
			);
            $tbl_config = array(
                'tb_width' => '100%',
                'col_format' => array(
                    COL_FORMAT_IS_TEXT,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_CURRENCY,
                    COL_FORMAT_IS_NONE
                ),
                'noaction' => false,
                'nocheckbox' => false,
                'noselect' => true,
                'offset' => $segment[7]
            );
            $datagrid = $this->table->generate($result, 'menuid', $head, $segment, $tbl_config);
        else:
            $datagrid = '<h3>No data exists on database.</h3>';
        endif;

        $content = array(
            'datagrid' => $datagrid,
            'sel_cat' => $this->axo_common->Options('menucats', 'catid', 'name', $catid),
            'sel_tag' => $this->axo_common->Options('tags', 'tagid', 'desc', $tagid),
            'search' => $search,
            'pagination' => $this->pagination->create_links(),
			'dtl' => $dtl
        );
        $this->axo_template->deploy($content, 'products/products/grid');
    }

    function add() {
        $content = array();
        $content['sel_prdcats'] = $this->axo_common->Options('menucats', 'catid', 'name');
        $content['sel_tags'] = $this->axo_common->Options('tags', 'tagid', 'desc');
        $this->axo_template->deploy($content, 'products/products/add');
    }

    function adding() {
        $this->form_validation->set_rules('catid', 'Category', 'required');
        $this->form_validation->set_rules('tagid', 'Tag', 'required');
        $this->form_validation->set_rules('name', 'Product name', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');

        if ($this->form_validation->run() == TRUE):
            $data = array(
                'menuid' => $this->axo_common->NewID($this->MdlProductCategories->GetPrefixById($this->input->post('catid', true)), 'menus', 'menuid', true),
                'catid' => $this->input->post('catid', true),
                'tagid' => $this->input->post('tagid', true),
                'name' => $this->input->post('name', true),
                'price' => $this->input->post('price', true),
            );
            $this->MdlProducts->Insert($data);
            redirect('products/Products', 'refresh');
        else:
            $content = array();
            $content['sel_prdcats'] = $this->axo_common->Options('menucats', 'catid', 'name');
            $content['sel_tags'] = $this->axo_common->Options('tags', 'tagid', 'desc');
            $this->axo_template->deploy($content, 'products/products/add');
        endif;
    }

    function view($id) {
        $res = $this->MdlProducts->SelectById($id);
        $content = $res[0];
        $content->sel_prdcats = $this->axo_common->Options('menucats', 'catid', 'name', $res[0]->catid);
        $content->sel_tags = $this->axo_common->Options('tags', 'tagid', 'desc', $res[0]->tagid);
        $this->axo_template->deploy($content, 'products/products/view');
    }

    function edit($id) {
        $res = $this->MdlProducts->SelectById($id);
        $content = $res[0];
        $content->sel_prdcats = $this->axo_common->Options('menucats', 'catid', 'name', $res[0]->catid);
        $content->sel_tags = $this->axo_common->Options('tags', 'tagid', 'desc', $res[0]->tagid);
        $this->axo_template->deploy($content, 'products/products/edit');
    }

    function editing($id) {
        $this->form_validation->set_rules('catid', 'Category', 'required');
        $this->form_validation->set_rules('tagid', 'Tag', 'required');
        $this->form_validation->set_rules('name', 'Product name', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');

        if ($this->form_validation->run()):
            $data = array(
                'catid' => $this->input->post('catid', true),
                'tagid' => $this->input->post('tagid', true),
                'name' => $this->input->post('name', true),
                'price' => $this->input->post('price', true),
            );
            $this->MdlProducts->Update($data, $id);
            redirect('products/Products', 'refresh');
        else:
            $res = $this->MdlProducts->SelectById($id);
            $content = array();
            $content = $res[0];
            $content->sel_prdcats = $this->axo_common->Options('menucats', 'catid', 'name', $res[0]->catid);
            $content->sel_tags = $this->axo_common->Options('tags', 'tagid', 'desc', $res[0]->tagid);
            $this->axo_template->deploy($content, 'products/products/edit');
        endif;
    }

    function delete() {
        $res = $this->MdlProducts->select_by('kdiv,nmdiv');
        $divisi = array();
        $i = 0;
        $ada = false;
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['kdiv'])):
                $ada = true;
                $divisi[$i]['kdiv'] = $data['kdiv'];
                $divisi[$i]['nmdiv'] = $data['nmdiv'];
                $i++;
            endif;
        endforeach;
        if (!$ada):
            redirect(base_url() . 'master/divisi');
        else:
            $content = array(
                'divisi' => $divisi
            );
            $this->axo_template->deploy($content, 'master/divisi/delete');
        endif;
    }

    function deleting() {
        $res = $this->MdlProducts->select_id();
        $divisi = array();
        foreach ($res as $data):
            if ($this->input->post('cb-' . $data['kdiv'])):
                $this->MdlProducts->delete($data['kdiv']);
            endif;
        endforeach;
        redirect(base_url() . 'master/divisi');
    }

}

?>
