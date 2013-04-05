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
			$this->color = cp_get_color($this->color);
			
			$arr_news_list[$i]['newsID'] 		= $row->newsID;
			$arr_news_list[$i]['catID'] 		= $row->catID;
			$arr_news_list[$i]['editor']		= $row->userID;
			$arr_news_list[$i]['datetime'] 		= cp_get_ger_datetime($row->datetime);
			$arr_news_list[$i]['title'] 		= $row->newsTitle;
			$arr_news_list[$i]['valid_from'] 	= cp_get_ger_datetime($row->validFrom);
			$arr_news_list[$i]['valid_to'] 		= cp_get_ger_datetime($row->validTo);			
			$arr_news_list[$i]['online'] 		= $row->online;
			$arr_news_list[$i]['row_color']		= $this->color;
			
			$i++;
		}
		
		return $arr_news_list;
	}
	
	public function get_news_categories()
	{
		$query = $this->db->get('news_category');
		$cat = array();
		
		foreach($query->result() as $row)
		{
			$cat[$row->categoryID]['title'] = $row->title;
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