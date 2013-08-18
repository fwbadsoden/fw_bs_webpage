<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * News Model
 *
 * Mittels des News Model wird die Datenbankanbindung des News Moduls gesteuert.
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.news
 **/

class News_model extends CI_Model {

	private $color = '';

	/**
	 * Konstruktor
	 *
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->helper('html');
	}
    
    public function create_kategorie()
    {
        $kategorie = array(
            'title' => $this->input->post('title'),
            'created_by' => $this->cp_auth->get_user_id(),
            'created' => date("Y-m-d H:i:s")
        );
        
        $this->db->insert('news_category', $kategorie);
    }
    
    public function update_kategorie($id)
    {
        $kategorie = array(
            'title' => $this->input->post('title'),
            'modified_by' => $this->cp_auth->get_user_id(),
            'modified' => date("Y-m-d H:i:s")
        );
        
        $this->db->update('news_category', $kategorie, array('categoryID' => $id));
    }
	
	public function get_news_count()
	{ 
		$query = $this->db->get_where('news', array('online' => 1));
        return $query->num_rows(); 	
	}

	public function get_news_list($offset=0, $limit=99999)
	{		
		$arr_news_list = array();
		
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get('news', $limit, $offset);
		$i = 0;
        
        $CI =& get_instance();
        $CI->load->model('user/user_model', 'user');
        $this->user->init('backend');
        
		foreach($query->result() as $row)
		{	  			
			$arr_news_list[$i]['newsID'] 		= $row->newsID;
			$arr_news_list[$i]['categoryID'] 	= $row->categoryID;
			$arr_news_list[$i]['created_by']  	= $this->user->get_user_fullname($row->created_by);
			$arr_news_list[$i]['title'] 		= $row->title;
			$arr_news_list[$i]['valid_from'] 	= $row->valid_from;
			$arr_news_list[$i]['valid_to'] 		= $row->valid_to;			
			$arr_news_list[$i]['online'] 		= $row->online;
			$arr_news_list[$i]['row_color']		= $this->color = cp_get_color($this->color);
			
			$i++;
		}
		
		return $arr_news_list;
	}
	
	public function get_news_categories()
	{
		$query = $this->db->get('news_category');
		$cat = array();
        $i = 0;
		
		foreach($query->result() as $row)
		{
			$cat[$i]['categoryID'] = $row->categoryID;
			$cat[$i]['title']      = $row->title;
			$cat[$i]['row_color']  = $this->color = cp_get_color($this->color);
            $i++;
		}
		
		return $cat;
	}
    
    public function get_news_category($id)
    {
        $this->db->where('categoryID', $id);
        $query = $this->db->get('news_category');
        $row = $query->row();
        
        $category['categoryID'] = $row->categoryID;
        $category['title']      = $row->title;
        
        return $category;
    }
    
    public function delete_category($id)
    {
        $this->db->where('categoryID', $id);
        $this->db->delete('news_category');
    }
}