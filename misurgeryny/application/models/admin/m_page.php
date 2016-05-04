<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_page extends CI_Model {

	function insert($post){
		$data = array(
			'page_title' => $post['page_title'],
			'url_key' => $post['url_key'],
			'status' => $post['status'],
            'parent_id' => $post['parent_id'],
			'content' => $post['page_content'],
			'keywords' => $post['meta_keywords'],
			'desc' => $post['meta_desc'],
			'date_add' => date('Y-m-d H:i:s'),
			'date_upd' => date('Y-m-d H:i:s'),
			'class' => $post['class']
		);

		if($this->db->insert('page', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function get_all($perpage = null, $offset = null){
		$data = array();
                
                if (!is_null($perpage) && !is_null($offset))
		{
                    $this->db->limit($perpage,$offset);
                }
                
		$q = $this->db->get('page');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$row['date_add'] = date('M d, Y g:i:s A',strtotime($row['date_add']));
				$row['date_upd'] = date('M d, Y g:i:s A',strtotime($row['date_upd']));
				$row['status'] = ($row['status']==='1')?'Enabled':'Disabled';
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	function get($id){
		$data = array();
		$this->db->limit(1);
		$this->db->where('id_page', $id);
		$q = $this->db->get('page');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function get_count(){
		return $this->db->count_all('page');
	}
	
	function update($post){            
		$data = array(
			'page_title' => $post['page_title'],
			'url_key' => $post['url_key'],
			'status' => $post['status'],
            'parent_id' => $post['parent_id'],
			'content' => $post['page_content'],
			'keywords' => $post['meta_keywords'],
			'desc' => $post['meta_desc'],
			'date_upd' => date('Y-m-d H:i:s'),
                        // Encode to JSON so we can save to one field in table.
                        'related_pages' => @json_encode($post['related_pages'])
		);

        if (isset($post['class']))
        {
            $data['class'] = $post['class'];
        }

		$this->db->where('id_page', $post['id_page']);
		if($this->db->update('page', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function delete($id){
		$this->db->where('id_page', $id);
		if($this->db->delete('page')){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function checkUrlKey($url_key, $id){
		$data = array();
		$q = $this->db->get_where('page', array('url_key' => $url_key, 'id_page !=' => $id), 1);
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}

    function get_parent_dropdown()
    {
        $parents = $this->get_top_pages();
        
        foreach ($parents->result() as $parent)
        {
            $dropdown[$parent->id_page] = $parent->page_title;

            $children = $this->get_children($parent->id_page);

            if ($children->num_rows() > 0)
            {
                foreach ($children->result() as $child)
                {
                    $dropdown[$child->id_page] = '--' . $child->page_title;
                }
            }
        }

        return $dropdown;
    }

    function get_top_pages()
    {
        $this->db->where('parent_id', 0);
        
        return $this->db->get('page');
    }

    function get_children($page_id)
    {
        $this->db->where('parent_id', $page_id);  

        return $this->db->get('page');
    }
}

/* End of file m_page.php */
/* Location: ./application/models/admin/m_page.php */
