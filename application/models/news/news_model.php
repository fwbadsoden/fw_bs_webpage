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
    
    public  $id, $title, $stage_title, $valid_from, $category_title, $link, $teaser, $text, $teaser_image_fullpath, $teaser_image_mimetype, $teaser_image_width,
            $teaser_image_height, $teaser_image_title, $category_id, $row_color;
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
    
    public function get_news_overview($limit = NEWS_DEFAULT_LIMIT, $offset = NEWS_DEFAULT_OFFSET, $year = 'all', $category = 'all')
    {
        if(is_numeric($limit) && is_numeric($offset)) 
            $this->db->limit($limit, $offset);
        if(is_numeric($year))
			$this->db->where(array('substring(valid_from,1,4)' => $year));
        if($category != 'all')
            $this->db->where(array('category_id' => $category));
        $this->db->order_by('valid_from', 'desc');
            
        $query = $this->db->get('v_news');
        $news_arr = array();
        $i = 0;
    
        foreach($query->result() as $row)
        {            
            $news = new News_model();
            $news->id                       = $row->newsID;
            $news->title                    = $row->title;
            $news->stage_title              = $row->stage_title;
            $news->valid_from               = $row->valid_from;
            $news->category_id              = $row->category_id;
            $news->category_title           = $row->category_title;
            $news->link                     = $row->link;
            $news->teaser                   = $row->teaser;
            $news->text                     = $row->text;
            $news->row_color                = $this->color                  = cp_get_color($this->color);
            $news->teaser_image_fullpath    = $row->teaser_image_fullpath;
            $news->teaser_image_mimetype    = $row->teaser_image_mimetype;
            $news->teaser_image_width       = $row->teaser_image_width;
            $news->teaser_image_height      = $row->teaser_image_height;
            $news->teaser_image_title       = $row->teaser_image_title;
   
            $news_arr[$i]                   = $news;
            $i++;
        }
        
        return $news_arr;
    }
    
    public function homepage_teaser_1col($offset)
    {
        $this->db->select('newsID, title, stage_title, teaser, text, teaser_image_fullpath, teaser_image_width, teaser_image_height, teaser_image_title, link');
        $this->db->limit(1, $offset);
        $query = $this->db->get('v_news');
        $row = $query->row();
        
        $news = array(
            'newsID'                => $row->newsID,
            'title'                 => $row->title,
            'stage_title'           => $row->stage_title,
            'link'                  => $row->link,
            'teaser'                => $row->teaser,
            'text'                  => $row->text, // für Prüfung auf mehr lesen button
            'teaser_image_fullpath' => $row->teaser_image_fullpath,
            'teaser_image_width'    => $row->teaser_image_width,
            'teaser_image_height'   => $row->teaser_image_height,
            'teaser_image_title'    => $row->teaser_image_title
        );
        
        return $news;
    }
    
    public function get_news_stage_text($id)
    {
        $this->db->select('stage_title, title');
        $this->db->where('newsID', $id);
        $query = $this->db->get('v_news');        
        $row = $query->row();
        
        $text['text'][0] = $row->stage_title;
        $text['text'][1] = $row->title;
        
        return $text;
    }
    
    public function get_news($id)
    {
        $this->db->where('newsID', $id);
        $query = $this->db->get('v_news');
        
        $row = $query->row();
        
        $news = new News_model;
        $news->id                       = $row->newsID;
        $news->title                    = $row->title;
        $news->stage_title              = $row->stage_title;
        $news->valid_from               = $row->valid_from;
        $news->category_id              = $row->category_id;
        $news->category_title           = $row->category_title;
        $news->link                     = $row->link;
        $news->teaser                   = $row->teaser;
        $news->text                     = $row->text;
        $news->teaser_image_fullpath    = $row->teaser_image_fullpath;
        $news->teaser_image_mimetype    = $row->teaser_image_mimetype;
        $news->teaser_image_width       = $row->teaser_image_width;
        $news->teaser_image_height      = $row->teaser_image_height;
        $news->teaser_image_title       = $row->teaser_image_title;
        
        return $news;
    }
    
    public function get_latest_news()
    {
        $this->db->select('newsID, title');
        $this->db->order_by('valid_from', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get('v_news');
        
        $news_arr = array();
        $i = 0;
        foreach($query->result() as $row)
        {
            $news = new News_model;
            $news->id                   = $row->newsID;
            $news->title                = $row->title;
            $news_arr[$i] = $news;
            $i++;
        }
        return $news_arr;
    }
    
    public function get_news_images($id)
    {
        $this->db->where('newsID', $id);
        $query = $this->db->get('v_news_images');
        
        $images = array();
        $i=0;
        
        foreach($query->result() as $row)
        {
            $image['name']          = $row->name;
            $image['description']   = $row->description;	
            $image['fullpath']      = $row->fullpath;	
            $image['filename']      = $row->filename;
            $image['title']         = $row->title;
            $images[$i] = $image;
            $i++;
        }
        return $images;
    }
    
    public function create_news()
    {
        $news = array(
            'categoryID'    => $this->input->post('category_id'),
            'title'         => $this->input->post('title'),
            'stage_title'   => $this->input->post('stage_title'),
            'valid_from'    => $this->input->post('valid_from'),
            'valid_from_time' => $this->input->post('valid_from_time'),
            'valid_to'      => '9999-12-31',
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
        $news = array(
            'categoryID'    => $this->input->post('category_id'),
            'title'         => $this->input->post('title'),
            'stage_title'   => $this->input->post('stage_title'),
            'valid_from'    => $this->input->post('valid_from'),
            'valid_from_time' => $this->input->post('valid_from_time'),
            'valid_to'      => '9999-12-31',
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
    
    public function get_news_admin($id)
    {
        $this->db->where('news.newsID', $id);
        $this->db->join('news_content', 'news.newsID = news_content.newsID');
        $query = $this->db->get('news');
        $row = $query->row();
                
        $news['newsID']         = $row->newsID;
        $news['categoryID']     = $row->categoryID;
        $news['title']          = $row->title;
        $news['stage_title']    = $row->stage_title;
        $news['link']           = $row->link;
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