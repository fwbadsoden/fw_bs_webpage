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
    
    public function create_news()
    {
       // $title_lc = strtolower($this->input->post('title'));
       // str_replace(' ', '-', $title_lc);
       // $this->db->select('slug');
       // $this->db->like('slug', $title_lc);
       // $query = $this->db->get('news');
        //if($query->num_rows() == 0)
        //    $slug = $title_lc;
        //else
        //    $slug = $title_lc.'-'.$query_num_rows()+1;
        $news = array(
            'categoryID'    => $this->input->post('category_id'),
          //  'slug'          => $slug,
            'title'         => $this->input->post('title'),
            'valid_from'    => $this->input->post('valid_from'),
            'valid_from_time' => $this->input->post('valid_from_time'),
            'valid_to'      => $this->input->post('valid_to'),
            'valid_to_time' => $this->input->post('valid_to_time'),
            'created_by'    => $this->cp_auth->get_user_id(),
            'created'       => date("Y-m-d H:i:s"),
            'online'        => 0
        );
        
        $this->db->trans_start();        
        $this->db->insert('news', $news);
        $id = $this->db->insert_id();
        
        $news_content = array(
            'newsID'        => $id,
            'teaser'        => $this->input->post('teaser'),
            'text'          => $this->input->post('text'),
            'teaser_image'  => $this->input->post('teaser_img')
        );  
        
        $this->db->insert('news_content', $news_content);
        
        $this->db->trans_complete();
    }
    
    public function update_news($id)
    {
      //  $title_lc = strtolower($this->input->post('title'));
      //  str_replace(' ', '-', $title_lc);
      //  $this->db->select('slug');
      //  $this->db->like('slug', $title_lc);
      //  $query = $this->db->get('news');
      //  if($query->num_rows() == 0)
      //      $slug = $title_lc;
      //  else
       //     $slug = $title_lc.'-'.$query->num_rows()+1;
        
        $news = array(
            'categoryID'    => $this->input->post('category_id'),
         //   'slug'          => $slug,
            'title'         => $this->input->post('title'),
            'valid_from'    => $this->input->post('valid_from'),
            'valid_from_time' => $this->input->post('valid_from_time'),
            'valid_to'      => $this->input->post('valid_to'),
            'valid_to_time' => $this->input->post('valid_to_time'),
            'modified_by'   => $this->cp_auth->get_user_id(),
            'modified'      => date("Y-m-d H:i:s")
        );
        
        $this->db->trans_start();     
        $this->db->where('newsID', $id);   
        $this->db->update('news', $news);
        
        $news_content = array(
            'newsID'        => $id,
            'teaser'        => $this->input->post('teaser'),
            'text'          => $this->input->post('text')
        );  
        
        $this->db->where('newsID', $id); 
        $this->db->update('news_content', $news_content);
        
        $this->db->trans_complete();        
    }
    
    public function delete_news($id)
    {   
        $this->db->trans_start();
        $this->db->where('newsID', $id);
        $this->db->delete('news'); 
        $this->db->where('newsID', $id);
        $this->db->delete('news_content'); 
        $this->db->trans_complete();     
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
		
		$this->db->order_by('valid_from', 'desc');
		$query = $this->db->get('news', $limit, $offset);
		$i = 0;
        
        $CI =& get_instance();
        $CI->load->library('CP_auth');
        
		foreach($query->result() as $row)
		{	  		
            $user = $this->cp_auth->get_user_by_id_query($row->created_by)->result();
 
			$arr_news_list[$i]['newsID'] 		= $row->newsID;
			$arr_news_list[$i]['categoryID'] 	= $row->categoryID;
			$arr_news_list[$i]['created_by']  	= $user[0]->first_name.' '.$user[0]->last_name;
			$arr_news_list[$i]['title'] 		= $row->title;
			$arr_news_list[$i]['valid_from'] 	= $row->valid_from;
            $arr_news_list[$i]['valid_from_time'] = $row->valid_from_time;	
			$arr_news_list[$i]['valid_to'] 		= $row->valid_to;	
            $arr_news_list[$i]['valid_to_time'] = $row->valid_to_time;		
			$arr_news_list[$i]['online'] 		= $row->online;
			$arr_news_list[$i]['row_color']		= $this->color = cp_get_color($this->color);
			
			$i++;
		}
		
		return $arr_news_list;
	}
    
    public function get_news($id)
    {
        $this->db->where('news.newsID', $id);
        $this->db->join('news_content', 'news.newsID = news_content.newsID');
        $query = $this->db->get('news');
        $row = $query->row();
        
        $news['newsID']         = $row->newsID;
        $news['categoryID']     = $row->categoryID;
        $news['title']          = $row->title;
        $news['valid_from']     = $row->valid_from;
        $news['valid_from_time'] = $row->valid_from_time;
        $news['valid_to']       = $row->valid_to;
        $news['valid_to_time']  = $row->valid_to_time;
        $news['teaser']         = $row->teaser;
        $news['text']           = $row->text;
        
        return $news;
    }
	
	public function get_news_categories()
	{
		$query = $this->db->get('news_category');
		$cat = array();
        $i = 0;
		
		foreach($query->result() as $row)
		{
			$cat[$row->categoryID]['categoryID'] = $row->categoryID;
			$cat[$row->categoryID]['title']      = $row->title;
			$cat[$row->categoryID]['row_color']  = $this->color = cp_get_color($this->color);
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
	
	public function switch_online_state($newsID, $online)
	{
		$this->db->update('news', array('online' => $online), 'newsID = '.$newsID);
	}
}