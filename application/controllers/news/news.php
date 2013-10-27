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

class News extends CP_Controller {

	/**
	 * News::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('news/news_model', 'm_news');
	}
    
    /**
     * News::homepage_teaser_1col()
     * 
     * @param mixed $offset
     * @param integer $first
     * @return
     */
    public function homepage_teaser_1col($offset, $first = 0)
    {
        if($first == 1) $class['class'] = 'BildTextTeaser first';
        else $class['class'] = 'BildTextTeaser';
        
        $news = $this->m_news->homepage_teaser_1col($offset);
        
        $this->load->view('frontend/news/teaser_1col_header', $class);
        $this->load->view('frontend/news/teaser_1col_data', $news);
        $this->load->view('frontend/news/teaser_1col_footer');
    }
    
    /**
     * Einsatz::newsliste_3col()
     * 
     * @return
     */
    public function newsliste_3col()
    {        
        if(!$year = $this->input->post('newsJahr'))        $year = date('Y');
        if(!$category_id = $this->input->post('newsArt'))  $category_id = 'all';
        
        if($category_id == 0) $category_id = 'all';
        $i = 0;
        
        $news_arr             = $this->m_news->get_news_overview('all', 'all', $year, $category_id);
        $filter['categories'] = $this->m_news->get_news_categories();
        
        $this->load->view('frontend/news/newsliste_2col_header');
        
        for($i = 0; $i < count($news_arr); $i++)
        {
            $news = $news_arr[$i]; 
            $this->load->view('frontend/news/newsliste_2col_data', $news); 
        }
        $this->load->view('frontend/news/newsliste_2col_footer');
    }
} 
?>