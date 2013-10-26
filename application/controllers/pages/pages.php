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
    
    /**
     * Pages::loader()
     * 
     * @param mixed $pageID
     * @return
     */
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
    
    /**
     * Pages::homepage()
     * 
     * @return
     */
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
    
    /**
     * Pages::fahrzeug_overview()
     * 
     * @return
     */
    private function fahrzeug_overview()
    {
        $c_fahrzeug = load_controller('fahrzeug/fahrzeug');
        
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();  
            
        $c_fahrzeug->fahrzeugliste_3col();
        
        $this->site_footer();
    }
    
    /**
     * Pages::fahrzeug_detail()
     * 
     * @return
     */
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
    
    /**
     * Pages::einsatz_overview()
     * 
     * @return
     */
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
    
    /**
     * Pages::einsatz_detail()
     * 
     * @return
     */
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
    
    /**
     * Pages::news_overview()
     * 
     * @return
     */
    private function news_overview()
    {
        $c_news = load_controller('news/news');
        
        $this->site_header();    
        $this->site_stage();        
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        if(!$year = $this->input->post('year')) $year = date('Y');
        
        $c_news->newsliste_3col($year);
    
        $this->site_footer();
    }
    
    /**
     * Pages::mannschaft_overview()
     * 
     * @return
     */
    private function mannschaft_overview()
    {
        $this->output->cache(60);
        $c_mannschaft = load_controller('mannschaft/mannschaft');
        
        $this->site_header();    
        $this->site_stage();        
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $c_mannschaft->mannschaftliste_3col();
    
        $this->site_footer();
    }
    
    /**
     * Pages::termin_overview()
     * 
     * @return
     */
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
    
    /**
     * Pages::presse_overview()
     * 
     * @return
     */
    public function presse_overview()
    {
        $c_presse = load_controller('presse/presse');
        
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->site_mainContent_header();
        $c_presse->overview_2col();
        $this->site_mainContent_footer();
        $c_presse->overview_sidebar();
        $this->site_footer();        
    }
    
/*****************************************************************************
*
*   INHALTSSEITEN -> NACH GOLIVE DYNAMISIEREN
*
******************************************************************************/    
    
    /**
     * Pages::leistungsgruppe_overview()
     * 
     * @return
     */
    public function leistungsgruppe_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/leistungsgruppe_overview');
        $this->site_footer();  
    }
    
    /**
     * Pages::rettungshunde_overview()
     * 
     * @return
     */
    public function rettungshunde_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage(); 
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/rettungshunde_overview');
        $this->site_footer();     
    }
    
    /**
     * Pages::verein_overview()
     * 
     * @return
     */
    public function verein_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();    
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/verein_overview');
        $this->site_footer();  
    }
    
    /**
     * Pages::geschichte_overview()
     * 
     * @return
     */
    public function geschichte_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/geschichte_overview');
        $this->site_footer();  
    }
    
    /**
     * Pages::aao_overview()
     * 
     * @return
     */
    public function aao_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/aao_overview');
        $this->site_footer();  
    }
    
    /**
     * Pages::einsatzgebiet_overview()
     * 
     * @return
     */
    public function einsatzgebiet_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/einsatzgebiet_overview');
        $this->site_footer();  
    }
    
    /**
     * Pages::gesetze_overview()
     * 
     * @return
     */
    public function gesetze_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/gesetze_overview');
        $this->site_footer();  
    }
    
    /**
     * Pages::aufgaben_overview()
     * 
     * @return
     */
    public function aufgaben_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/aufgaben_overview');
        $this->site_footer();  
    }
    
    /**
     * Pages::impressum_overview()
     * 
     * @return
     */
    public function impressum_overview()
    {   
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/impressum_overview');
        $this->site_footer();  
    }
    
    /**
     * Pages::jugend_overview()
     * 
     * @return
     */
    public function jugend_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/jugend_overview');
        $this->site_footer();  
    }
    
    /**
     * Pages::jugend_aktivitaeten_overview()
     * 
     * @return
     */
    public function jugend_aktivitaeten_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/jugend_aktivitaeten_overview');
        $this->site_footer();  
    }
    
    /**
     * Pages::jugend_ausbildung_overview()
     * 
     * @return
     */
    public function jugend_ausbildung_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/jugend_ausbildung_overview');
        $this->site_footer();  
    }
    
    /**
     * Pages::mitmachen_overview()
     * 
     * @return
     */
    public function mitmachen_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/mitmachen_overview');
        $this->site_footer();  
    }   
    
    /**
     * Pages::tippsbeinotfaellen_overview()
     * 
     * @return
     */
    public function tippsbeinotfaellen_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_tippsbeinotfaellen_overview');
        $this->site_footer();  
    } 
    
    /**
     * Pages::buergerinfos_overview()
     * 
     * @return
     */
    public function buergerinfos_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_overview');
        $this->site_footer();  
    } 
    
    /**
     * Pages::hausnummern_overview()
     * 
     * @return
     */
    public function hausnummern_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_hausnummern_overview');
        $this->site_footer();  
    } 
    
    /**
     * Pages::blaulicht_overview()
     * 
     * @return
     */
    public function blaulicht_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_blaulicht_overview');
        $this->site_footer();  
    } 
    
    /**
     * Pages::sonderrechte_overview()
     * 
     * @return
     */
    public function sonderrechte_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_sonderrechte_overview');
        $this->site_footer();  
    } 
    
    /**
     * Pages::unwetter_overview()
     * 
     * @return
     */
    public function unwetter_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_unwetter_overview');
        $this->site_footer();  
    } 
    
    /**
     * Pages::kontakt_overview()
     * 
     * @return
     */
    public function kontakt_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/kontakt_overview');
        $this->site_footer();  
    }  
    
    /**
     * Pages::links_overview()
     * 
     * @return
     */
    public function links_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/links_overview');
        $this->site_footer();  
    }    
    
    /**
     * Pages::nachdembrand_overview()
     * 
     * @return
     */
    public function nachdembrand_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_nachdembrand_overview');
        $this->site_footer();  
    } 
    
    public function ifrt_overview()
    {
        $this->output->cache(60);
        $this->site_header();
        $this->site_stage();
        
        $this->site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/ifrt_overview');
        $this->site_footer();                        
    }
    
/*****************************************************************************
*
*   INHALTSSEITEN -> ENDE
*
******************************************************************************/    
    
    /**
     * Pages::site_sidebar_homepage()
     * 
     * @return
     */
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
    
    /**
     * Pages::site_header()
     * 
     * @return
     */
    private function site_header()
    {           
        $c_einsatz = load_controller('einsatz/einsatz');
        $c_termin  = load_controller('termin/termin');
        $c_fahrzeug = load_controller('fahrzeug/fahrzeug');
        $c_presse = load_controller('presse/presse');
        
        $this->menue                    = $this->m_menue->get_menue_list('online');
        $header_data['title']           = FRONTEND_TITLE;
        $header_data['menue_meta']      = $this->menue['menue_meta'];
        $header_data['menue']           = $this->menue['menue'];
        $header_data['einsaetze']       = $c_einsatz->get_einsatz_overview(1,5,0);
        $header_data['termine']         = $c_termin->get_termin_overview(5,0);
        $header_data['fahrzeuge']       = $c_fahrzeug->get_fahrzeug_overview(1);
        $header_data['articles']        = $c_presse->get_presse_overview();
                        
        $this->load->view('frontend/templates/header', $header_data);
    }
    
    /**
     * Pages::site_content_header()
     * 
     * @param string $class
     * @return
     */
    private function site_content_header($class = 'slidewrapper')
    {
        $c['class'] = $class;
        $this->load->view('frontend/templates/contentHeader', $c);
    }
    
    /**
     * Pages::site_content_footer()
     * 
     * @return
     */
    private function site_content_footer()
    {
        $this->load->view('frontend/templates/contentFooter');
    }
    
    /**
     * Pages::site_mainContent_header()
     * 
     * @return
     */
    private function site_mainContent_header()
    {
        $this->load->view('frontend/templates/mainContentHeader');
    }
    
    /**
     * Pages::site_mainContent_footer()
     * 
     * @return
     */
    private function site_mainContent_footer()
    {
        $this->load->view('frontend/templates/mainContentFooter');
    }
    
    /**
     * Pages::site_homepageContent_header()
     * 
     * @return
     */
    private function site_homepageContent_header()
    {
        $this->load->view('frontend/templates/homepageContentHeader');
    }
    
    /**
     * Pages::site_homepageContent_footer()
     * 
     * @return
     */
    private function site_homepageContent_footer()
    {
        $this->load->view('frontend/templates/homepageContentFooter');
    }
    
    /**
     * Pages::site_stage()
     * 
     * @return
     */
    private function site_stage()
    {
        $stage_data['stage_images']     = $this->page_content['stage_images'];          
        $this->load->view('frontend/'.$this->page_content['stage_file'], $stage_data);
    }
    
    /**
     * Pages::site_stage_slider()
     * 
     * @return
     */
    private function site_stage_slider()
    {
        $this->load->view('frontend/templates/stages/stage_slider');
    }
    
    /**
     * Pages::site_footer()
     * 
     * @return
     */
    private function site_footer()
    {
        $footer_data['title']           = FRONTEND_TITLE;
        $footer_data['menue_shortlink'] = $this->menue['menue_shortlink'];
        
        $this->load->view('frontend/templates/footer', $footer_data);
    }
    
    /**
     * Pages::site_hr_clear()
     * 
     * @return
     */
    private function site_hr_clear()
    {
        $this->load->view('frontend/templates/hr_clear');
    }
 }
 ?>