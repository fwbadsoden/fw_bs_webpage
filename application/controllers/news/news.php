<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * News Controller
 *
 * Controller für die Anzeige der News
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.frontend.news
 **/

class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('news/news_model', 'news');
	}
    
    public function homepage_teaser_1col($offset)
    {
        $this->db->select('newsID, title, teaser, teaser_image_fullpath, teaser_image_width, teaser_image_height, teaser_image_title');
        $this->db->limit(1, $offset);
        $query = $this->db->get('v_news');
        $row = $query->row();
        
        $news = array(
            'newsID'                => $row->newsID,
            'title'                 => $row->title,
            'teaser'                => $row->teaser,
            'teaser_image_fullpath' => $row->teaser_image_fullpath,
            'teaser_image_width'    => $row->teaser_image_width,
            'teaser_image_height'   => $row->teaser_image_height,
            'teaser_image_title'    => $row->teaser_image_title
        );
        
        $this->load->view('frontend/news/teaser_1col_header');
        $this->load->view('frontend/news/teaser_1col_data', $news);
        $this->load->view('frontend/news/teaser_1col_footer');
    }
} 
?>