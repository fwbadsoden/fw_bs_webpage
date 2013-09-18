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
class Pages extends CP_Controller {
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
        $this->load->model('mannschaft/mannschaft_model', 'm_mannschaft');
        $this->load->library('weather');
		$this->load->helper('load_controller');
	}
    
    public function loader($pageID)
    {
        $this->page_content = $this->m_pages->get_page_content_frontend($pageID);
        if($this->page_content == '404') redirect(base_url('404_override'));
        
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
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->site_mainContent_header();
        
        $c_news->homepage_teaser_1col(0, 1);
        $c_news->homepage_teaser_1col(1, 0);
        $this->site_hr_clear();
        
        $c_einsatz->overview_2col(EINSATZ_STARTPAGE_LIMIT);
        
        $this->site_mainContent_footer();
        
        $this->site_sidebar_homepage();
    
        $this->site_footer();
    }
    
    private function fahrzeug_overview()
    {
        $c_fahrzeug = load_controller('fahrzeug/fahrzeug');
        
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header();
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();  
            
        $c_fahrzeug->fahrzeugliste_3col();
        
        $this->site_footer();
    }
    
    public function fahrzeug_detail()
    {
        $id = $this->uri->segment($this->uri->total_segments());
        $c_fahrzeug = load_controller('fahrzeug/fahrzeug');
        $text = $c_fahrzeug->get_fahrzeug_stage_text($id);
        foreach($this->page_content['stage_images']['images'] as &$value) {
            $value['text'][0] = $text['name'];
            $value['text'][1] = $text['name_lang'];
            $value['text'][2] = $text['short_text'];
        }
        
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header();
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();   
        
        $c_fahrzeug->fahrzeug_detail_3col($id);
        
        $this->site_footer();        
    }
    
    private function einsatz_overview()
    {
        $c_einsatz = load_controller('einsatz/einsatz');
        
        $this->site_header();    
        $this->site_stage();        
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        if(!$year = $this->input->post('year')) $year = date('Y');
        
        $c_einsatz->einsatzliste_2col($year);
    
        $this->site_footer();
    }
    
    private function einsatz_detail()
    {
        $id = $this->uri->segment($this->uri->total_segments());
       // $this->debug->dump($this->page_content['stage_images']['images']);
        $c_einsatz = load_controller('einsatz/einsatz');
        $text = $c_einsatz->get_einsatz_stage_text($id);
        foreach($this->page_content['stage_images']['images'] as &$value) {
            $value['text'][0] = $text['text'][0]; 
            $value['text'][1] = $text['text'][1];
            $value['class_einsatz'] = $text['class'];
        }
        
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header();
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();   
        
        $c_einsatz->einsatz_detail_3col($id);
        
        $this->site_footer();
    }
    
    private function mannschaft_overview()
    {
        $c_mannschaft = load_controller('mannschaft/mannschaft');
        
        $this->site_header();    
        $this->site_stage();        
        
        $this->site_content_header('slidewrapper');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $c_mannschaft->mannschaftliste_3col();
    
        $this->site_footer();
    }
    
    public function termin_overview()
    {
        $c_termin = load_controller('termin/termin');
        
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
                   
        $c_termin->terminliste_1col();
        
        $this->site_footer();
    }
    
    public function presse_overview()
    {
        $c_presse = load_controller('presse/presse');
        
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
                   
        $c_presse->presse_overview();
        
        $this->site_footer();        
    }
    
    private function site_sidebar_homepage()
    { 
        $c_termin = load_controller('termin/termin');
        
        $weather_data['weather']      = $this->weather->get_weather();
        $statistik['mannschaft']      = $this->m_mannschaft->get_mannschaft_anzahl();
        $statistik['fahrzeug_anzahl'] = $this->m_fahrzeug->get_fahrzeug_anzahl();
        
        $this->load->view('frontend/templates/sidebar_header');  
        $this->load->view('frontend/templates/sidebar_report', $statistik);     
        $c_termin->overview_1col(TERMIN_STARTPAGE_LIMIT);
        $this->load->view('frontend/templates/weather', $weather_data);
        $this->load->view('frontend/templates/sidebar_footer');   
    }
    
    private function site_header()
    {
        $c_einsatz = load_controller('einsatz/einsatz');
        $c_termin  = load_controller('termin/termin');
        $c_fahrzeug = load_controller('fahrzeug/fahrzeug');
        
        $this->menue                    = $this->m_menue->get_menue_list('online');
        $header_data['title']           = FRONTEND_TITLE;
        $header_data['menue_meta']      = $this->menue['menue_meta'];
        $header_data['menue']           = $this->menue['menue'];
        $header_data['einsaetze']       = $c_einsatz->get_einsatz_overview(5,0);
        $header_data['termine']         = $c_termin->get_termin_overview(5,0);
        $header_data['fahrzeuge']       = $c_fahrzeug->get_fahrzeug_overview(1);
                
        $this->load->view('frontend/templates/header', $header_data);
    }
    
    private function site_content_header($class = 'slidewrapper')
    {
        $c['class'] = $class;
        $this->load->view('frontend/templates/contentHeader', $c);
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
    
    private function site_homepageContent_header()
    {
        $this->load->view('frontend/templates/homepageContentHeader');
    }
    
    private function site_homepageContent_footer()
    {
        $this->load->view('frontend/templates/homepageContentFooter');
    }
    
    private function site_stage()
    {
        $stage_data['stage_images']     = $this->page_content['stage_images'];          
        $this->load->view('frontend/'.$this->page_content['stage_file'], $stage_data);
    }
    
    private function site_stage_slider()
    {
        $this->load->view('frontend/templates/stages/stage_slider');
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