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
     * News::get_news_overview()
     * 
     * @param mixed $limit
     * @param mixed $offset
     * @return
     */
    public function get_news_overview($limit = NEWS_DEFAULT_LIMIT, $offset = NEWS_DEFAULT_OFFSET)
    { 
        return $this->m_news->get_news_overview($limit, $offset);
    }
    
    /**
     * Einsatz::newsliste_2col()
     * 
     * @return
     */
    public function newsliste_2col()
    {        
        if(!$year = $this->input->post('newsJahr'))        $year = date('Y');
        if(!$category_id = $this->input->post('newsArt'))  $category_id = 'all';
        
        if($category_id == 0) $category_id = 'all';
        $i = 0;
        
        // provisorisch
        $year = 'all';
        $category_id = 'all';
        
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
    
    public function news_detail_3col($id)
    {
        $news['news']           = $this->m_news->get_news($id);
        $news['liste']          = $this->m_news->get_latest_news();
        $news['images']         = $this->m_news->get_news_images($id);
        
        if($news['news']->link != "")
            redirect(base_url($news['news']->link));
        
        $this->load->view('frontend/news/newsdetail_3col_header');
        $this->load->view('frontend/news/newsdetail_3col_data', $news);
        $this->load->view('frontend/news/newsdetail_3col_footer');
    }
    
    public function get_news_stage_text($id)
    {
        return $this->m_news->get_news_stage_text($id);
    }
    
    public function get_og_image($id)
    { 
        $this->load->library('opengraph'); 
        $image = $this->m_news->get_og_image($id); 
        
        if($image != "" && $image != null) {
            $og_image = $this->opengraph->create_ogImage($image);
            return $og_image;
        } else {
            return null;
        }
    }
} 
/* End of file news.php */
/* Location: ./application/controllers/news/news.php */