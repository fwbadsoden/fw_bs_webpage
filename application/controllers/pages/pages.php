<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pages
 * Controller für die Anzeige der Inhaltsseiten
 * 
 * @package com.cp.feuerwehr.frontend.pages  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Pages extends CI_Controller {
    private $page_content, $menue;
    
	/**
	 * Pages::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pages/pages_model', 'm_pages');
		$this->load->model('menue/menue_model', 'm_menue');
        $this->load->model('fahrzeug/fahrzeug_model', 'm_fahrzeug');   
        $this->load->library('weather');
		$this->load->helper('load_controller');
	}
    
    public function loader($pageID)
    {
        $this->page_content = $this->m_pages->get_page_content_frontend($pageID);
        if($this->page_content == '404') redirect(base_url('404_override'));
       
       // echo "<pre>"; var_dump ($this->page_content); echo "</pre>";
        
        if($this->page_content['special_page'] == 1) {
            $this->{$this->page_content['special_function']}();
        }
        else {
            
        }
    }
    
    private function homepage()
    {
        $c_einsatz = load_controller('einsatz/einsatz');
        $c_news    = load_controller('news/news');
        
        $this->site_header();    
        $this->site_stage();        
        
        $this->site_content_header();
        
        if($this->page_content['stage']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->site_mainContent_header();
        
        $c_news->homepage_teaser_1col(0);
        $c_news->homepage_teaser_1col(1);
        $this->site_hr_clear();
        
        $c_einsatz->overview_2col(EINSATZ_STARTPAGE_LIMIT);
        
        $this->site_mainContent_footer();
        
        $this->site_sidebar_homepage();
        
        
        
        $this->site_footer();
    }
    
    private function site_sidebar_homepage()
    { 
        $c_termin = load_controller('termin/termin');
        
        $weather_data['weather']      = $this->weather->get_weather();
        $statistik['fahrzeug_anzahl'] = $this->m_fahrzeug->get_fahrzeug_anzahl();
        
        $this->load->view('frontend/templates/sidebar_header');  
        $this->load->view('frontend/templates/sidebar_report', $statistik);     
        $c_termin->overview_1col(TERMIN_STARTPAGE_LIMIT);
        $this->load->view('frontend/templates/weather', $weather_data);
        $this->load->view('frontend/templates/sidebar_footer');   
    }
    
    private function site_header()
    {
        $this->menue                    = $this->m_menue->get_menue_list('online');
        $header_data['title']           = FRONTEND_TITLE;
        $header_data['menue_meta']      = $this->menue['menue_meta'];
        $header_data['menue']           = $this->menue['menue'];
                
        $this->load->view('frontend/templates/header', $header_data);
    }
    
    private function site_content_header()
    {
        $this->load->view('frontend/templates/contentHeader');
    }
    
    private function site_content_footer()
    {
        $this->load->view('frontend/templates/contentFooter');
    }
    
    private function site_mainContent_header()
    {
        $this->load->view('frontend/templates/mainContentHeader');
    }
    
    private function site_mainContent_footer()
    {
        $this->load->view('frontend/templates/mainContentFooter');
    }
    
    private function site_stage()
    {
        $stage_data['stage_images']     = $this->page_content['stage'];  
             
        $this->load->view('frontend/templates/stage', $stage_data);
    }
    
    private function site_stage_slider()
    {
        $this->load->view('frontend/templates/stage_slider');
    }
    
    private function site_footer()
    {
        $footer_data['title']           = FRONTEND_TITLE;
        $footer_data['menue_shortlink'] = $this->menue['menue_shortlink'];
        
        $this->load->view('frontend/templates/footer', $footer_data);
    }
    
    private function site_hr_clear()
    {
        $this->load->view('frontend/templates/hr_clear');
    }
 }
 ?>