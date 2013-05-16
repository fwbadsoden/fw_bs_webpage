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
		$this->load->helper('html');
	}
	
	public function news_count()
	{ 
		return $this->db->count_all('news');	
	}

	public function get_news_list($offset=0, $limit=99999)
	{		
		$arr_news_list = array();
		
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get('news', $limit, $offset);
		$i = 0;
		
		foreach($query->result() as $row)
		{	  			
			$arr_news_list[$i]['newsID'] 		= $row->newsID;
			$arr_news_list[$i]['categoryID'] 	= $row->categoryID;
			$arr_news_list[$i]['created_by']	= $row->created_by;
			$arr_news_list[$i]['datetime'] 		= cp_get_ger_datetime($row->datetime);
			$arr_news_list[$i]['title'] 		= $row->title;
			$arr_news_list[$i]['valid_from'] 	= cp_get_ger_datetime($row->valid_from);
			$arr_news_list[$i]['valid_to'] 		= cp_get_ger_datetime($row->valid_to);			
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
	
	public function get_editor_sign($id)
	{
		$query = $this->db->get_where(CPAUTH_DB_ADMIN_USER_TABLE, array('userID' => $id));
		$row = $query->row();
		if($this->db->affected_rows() == 1)
			return $row->editor_sign;
		else 
			return 'n/a';
	}
}