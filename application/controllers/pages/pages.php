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
        
        if(ENVIRONMENT=='development') $this->output->enable_profiler(TRUE);
    }
    
    /**
     * Pages::homepage()
     * 
     * @return
     */
    public function homepage()
    {
        $c_einsatz = load_controller('einsatz/einsatz');
        $c_news    = load_controller('news/news');
        
        $this->_site_header();    
        $this->_site_stage();        
        
        $this->_site_content_header();
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->_site_mainContent_header();
        
        $c_news->homepage_teaser_1col(0, 1);
        $c_news->homepage_teaser_1col(1, 0);
        $this->_site_hr_clear();
        
        $c_einsatz->overview_2col(EINSATZ_STARTPAGE_LIMIT);
        
        $this->_site_mainContent_footer();
        
        $this->_site_sidebar_homepage();
    
        $this->_site_footer();
    }
    
    /**
     * Pages::fahrzeug_overview()
     * 
     * @return
     */
    public function fahrzeug_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);    
        $c_fahrzeug = load_controller('fahrzeug/fahrzeug');
        
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();  
            
        $c_fahrzeug->fahrzeugliste_3col(0);
        
        $this->_site_footer();
    }
    
    /**
     * Pages::fahrzeug_overview_ad()
     * 
     * @return
     */
    public function fahrzeug_overview_ad()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);    
        $c_fahrzeug = load_controller('fahrzeug/fahrzeug');
        
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();  
            
        $c_fahrzeug->fahrzeugliste_3col(1);
        
        $this->_site_footer();
    }
    
    /**
     * Pages::fahrzeug_detail()
     * 
     * @return
     */
    public function fahrzeug_detail()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);        
        
        $id = $this->uri->segment($this->uri->total_segments());
        $c_fahrzeug = load_controller('fahrzeug/fahrzeug');
        $text = $c_fahrzeug->get_fahrzeug_stage_text($id);
        foreach($this->page_content['stage_images']['images'] as &$value) {
            $value['text'][0] = $text['name'];
            $value['text'][1] = $text['name_lang'];
            $value['text'][2] = $text['short_text'];
        }
        
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header();
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();   
        
        $c_fahrzeug->fahrzeug_detail_3col($id);
        
        $this->_site_footer();        
    }
    
    /**
     * Pages::einsatz_overview()
     * 
     * @return
     */
    public function einsatz_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(0);
        
        $c_einsatz = load_controller('einsatz/einsatz');
        
        $this->_site_header();    
        $this->_site_stage();        
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        if(!$year = $this->input->post('year')) $year = date('Y');
        
        $c_einsatz->einsatzliste_2col($year);
    
        $this->_site_footer();
    }
    
    /**
     * Pages::einsatz_detail()
     * 
     * @return
     */
    public function einsatz_detail()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
       
        $id = $this->uri->segment($this->uri->total_segments());
        
        $c_einsatz = load_controller('einsatz/einsatz');
        $text = $c_einsatz->get_einsatz_stage_text($id);
        foreach($this->page_content['stage_images']['images'] as &$value) {
            if(isset($text['text'][0])) $value['text'][0]       = $text['text'][0];
            else                        $value['text'][0]       = ''; 
            if(isset($text['text'][1])) $value['text'][1]       = $text['text'][1];
            else                        $value['text'][1]       = '';
            if(isset($text['class']))   $value['class_einsatz'] = $text['class'];
            else                        $value['class_einsatz'] = '';
        }
 
        $this->_site_header($facebook_infos);
        $this->_site_stage();
        $this->_site_content_header();
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();   
        
        $c_einsatz->einsatz_detail_3col($id);
        
        $this->_site_footer();
    }
    
    /**
     * Pages::news_overview()
     * 
     * @return
     */
    public function news_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $c_news = load_controller('news/news');
        
        $this->_site_header();    
        $this->_site_stage();        
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        if(!$year = $this->input->post('year')) $year = date('Y');
        
        $c_news->newsliste_2col($year);
        
        $this->_site_sidebar_small();
    
        $this->_site_footer();
    }
    
    public function news_detail()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $id = $this->uri->segment($this->uri->total_segments());
        $c_news = load_controller('news/news');
        $text = $c_news->get_news_stage_text($id);
        foreach($this->page_content['stage_images']['images'] as &$value) {
            if(isset($text['text'][0])) $value['text'][0]    = $text['text'][0];
            else                        $value['text'][0]    = ''; 
            if(isset($text['text'][1])) $value['text'][1]    = $text['text'][1];
            else                        $value['text'][1]    = '';
            if(isset($text['class']))   $value['class_news'] = $text['class'];
            else                        $value['class_news'] = '';
        }
        
        $og_image = $c_news->get_og_image($id);
        $facebook_infos = array();
        $facebook_infos[0] = $og_image;
        
        $this->_site_header($facebook_infos);
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();   
        
        $c_news->news_detail_3col($id);
        
        $this->_site_footer();
    }
    
    /**
     * Pages::mannschaft_overview()
     * 
     * @return
     */
    public function mannschaft_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $c_mannschaft = load_controller('mannschaft/mannschaft');
        
        $this->_site_header();    
        $this->_site_stage();        
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $c_mannschaft->mannschaftliste_3col();
    
        $this->_site_footer();
    }
    
    /**
     * Pages::termin_overview()
     * 
     * @return
     */
    public function termin_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $c_termin = load_controller('termin/termin');
        
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
                   
        $c_termin->terminliste_1col();
        
        $this->_site_footer();
    }
    
    /**
     * Pages::presse_overview()
     * 
     * @return
     */
    public function presse_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $c_presse = load_controller('presse/presse');
        
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->_site_mainContent_header();
        $c_presse->overview_2col();
        $this->_site_mainContent_footer();
        $c_presse->overview_sidebar();
        $this->_site_footer();        
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
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/leistungsgruppe_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::rettungshunde_overview()
     * 
     * @return
     */
    public function rettungshunde_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage(); 
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/rettungshunde_overview');
        $this->_site_footer();     
    }
    
    /**
     * Pages::verein_overview()
     * 
     * @return
     */
    public function verein_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();    
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/verein_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::geschichte_overview()
     * 
     * @return
     */
    public function geschichte_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/geschichte_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::aao_overview()
     * 
     * @return
     */
    public function aao_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/aao_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::einsatzgebiet_overview()
     * 
     * @return
     */
    public function einsatzgebiet_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/einsatzgebiet_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::gesetze_overview()
     * 
     * @return
     */
    public function gesetze_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/gesetze_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::aufgaben_overview()
     * 
     * @return
     */
    public function aufgaben_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/aufgaben_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::impressum_overview()
     * 
     * @return
     */
    public function impressum_overview()
    {   
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/impressum_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::mfw_overview()
     * 
     * @return
     */
    public function mfw_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/mfw_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::jugend_overview()
     * 
     * @return
     */
    public function jugend_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/jugend_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::jugend_aktivitaeten_overview()
     * 
     * @return
     */
    public function jugend_aktivitaeten_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/jugend_aktivitaeten_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::jugend_ausbildung_overview()
     * 
     * @return
     */
    public function jugend_ausbildung_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/jugend_ausbildung_overview');
        $this->_site_footer();  
    }
    
    /**
     * Pages::mitmachen_overview()
     * 
     * @return
     */
    public function mitmachen_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/mitmachen_overview');
        $this->_site_footer();  
    }   
    
    /**
     * Pages::tippsbeinotfaellen_overview()
     * 
     * @return
     */
    public function tippsbeinotfaellen_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_tippsbeinotfaellen_overview');
        $this->_site_footer();  
    } 
    
    /**
     * Pages::buergerinfos_overview()
     * 
     * @return
     */
    public function buergerinfos_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_overview');
        $this->_site_footer();  
    } 
    
    /**
     * Pages::hausnummern_overview()
     * 
     * @return
     */
    public function hausnummern_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_hausnummern_overview');
        $this->_site_footer();  
    } 
    
    /**
     * Pages::rauchmelder_overview()
     * 
     * @return
     */
    public function rauchmelder_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_rauchmelder_overview');
        $this->_site_footer();  
    } 
    
    /**
     * Pages::blaulicht_overview()
     * 
     * @return
     */
    public function blaulicht_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_blaulicht_overview');
        $this->_site_footer();  
    } 
    
    /**
     * Pages::sonderrechte_overview()
     * 
     * @return
     */
    public function sonderrechte_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_sonderrechte_overview');
        $this->_site_footer();  
    } 
    
    /**
     * Pages::unwetter_overview()
     * 
     * @return
     */
    public function unwetter_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_unwetter_overview');
        $this->_site_footer();  
    } 
    
    /**
     * Pages::kontakt_overview()
     * 
     * @return
     */
    public function kontakt_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/kontakt_overview');
        $this->_site_footer();  
    }  
    
    /**
     * Pages::links_overview()
     * 
     * @return
     */
    public function links_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/links_overview');
        $this->_site_footer();  
    }    
    
    /**
     * Pages::nachdembrand_overview()
     * 
     * @return
     */
    public function nachdembrand_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/buergerinfos_nachdembrand_overview');
        $this->_site_footer();  
    } 
    
    public function ifrt_overview()
    {
        if(ENVIRONMENT=='production') $this->output->cache(60);
        $this->_site_header();
        $this->_site_stage();
        
        $this->_site_content_header('slidewrapper smallstage');
        
        if($this->page_content['stage_images']['count_images'] > 1)
            $this->_site_stage_slider();    
        
        $this->load->view('frontend/temp_content_pages/ifrt_overview');
        $this->_site_footer();                        
    }
    
/*****************************************************************************
*
*   INHALTSSEITEN -> ENDE
*
******************************************************************************/    
    
    /**
     * Pages::_site_sidebar_homepage()
     * 
     * @return
     */
    private function _site_sidebar_homepage()
    { 
        $c_termin = load_controller('termin/termin');
        $c_einsatz = load_controller('einsatz/einsatz');
        
        $weather_data['weather']      = $this->weather->get_weather();
        $statistik['mannschaft']      = $this->m_mannschaft->get_mannschaft_anzahl();
        $statistik['fahrzeug_anzahl'] = $this->m_fahrzeug->get_fahrzeug_anzahl();
        $statistik['einsatz_anzahl']  = $c_einsatz->get_einsatz_anzahl(date('Y'));
        
        $this->load->view('frontend/templates/sidebar_header');  
        $this->load->view('frontend/templates/sidebar_report', $statistik);    
        $c_termin->overview_1col(TERMIN_STARTPAGE_LIMIT); 
 //       $this->load->view('frontend/templates/sidebar_facebook');
        $this->load->view('frontend/templates/weather', $weather_data);
        $this->load->view('frontend/templates/sidebar_footer');   
    }    
    
    /**
     * Pages::_site_sidebar_small()
     * 
     * @return
     */
    private function _site_sidebar_small()
    { 
        $c_termin = load_controller('termin/termin');
        
        $weather_data['weather']      = $this->weather->get_weather();
        
        $this->load->view('frontend/templates/sidebar_header');      
        $c_termin->overview_1col(TERMIN_STARTPAGE_LIMIT, TERMIN_DEFAULT_OFFSET, 1);
        $this->load->view('frontend/templates/weather', $weather_data);
        $this->load->view('frontend/templates/sidebar_footer');   
    }
    
    /**
     * Pages::_site_header()
     * 
     * @return
     */
    private function _site_header($facebook_infos = null)
    {           
        $c_einsatz  = load_controller('einsatz/einsatz');
        $c_termin   = load_controller('termin/termin');
        $c_news     = load_controller('news/news');
        $c_fahrzeug = load_controller('fahrzeug/fahrzeug');
        $c_presse   = load_controller('presse/presse');
        
        $this->menue                        = $this->m_menue->get_menue_list('online');
        $header_data['menue_meta']          = $this->menue['menue_meta'];
        $header_data['menue']               = $this->menue['menue'];
        $header_data['einsaetze']           = $c_einsatz->get_einsatz_overview(1,5,0);
        $header_data['news']                = $c_news->get_news_overview(5,0);
        $header_data['termine']             = $c_termin->get_termin_overview(5,0);
        $header_data['fahrzeuge']           = $c_fahrzeug->get_fahrzeug_overview(1, 0);
        $header_data['fahrzeugeAusserDienst'] = $c_fahrzeug->get_fahrzeug_overview(1, 1);
        $header_data['hasRetiredFahrzeuge'] = $c_fahrzeug->hasRetired();
        $header_data['articles']            = $c_presse->get_presse_overview();
        $header_data['facebook_infos']      = $facebook_infos;
                        
        $this->load->view('frontend/templates/header', $header_data);
    }
    
    /**
     * Pages::_site_content_header()
     * 
     * @param string $class
     * @return
     */
    private function _site_content_header($class = 'slidewrapper')
    {
        $c['class'] = $class;
        $this->load->view('frontend/templates/contentHeader', $c);
    }
    
    /**
     * Pages::_site_content_footer()
     * 
     * @return
     */
    private function _site_content_footer()
    {
        $this->load->view('frontend/templates/contentFooter');
    }
    
    /**
     * Pages::_site_mainContent_header()
     * 
     * @return
     */
    private function _site_mainContent_header()
    {
        $this->load->view('frontend/templates/mainContentHeader');
    }
    
    /**
     * Pages::_site_mainContent_footer()
     * 
     * @return
     */
    private function _site_mainContent_footer()
    {
        $this->load->view('frontend/templates/mainContentFooter');
    }
    
    /**
     * Pages::_site_homepageContent_header()
     * 
     * @return
     */
    private function _site_homepageContent_header()
    {
        $this->load->view('frontend/templates/homepageContentHeader');
    }
    
    /**
     * Pages::_site_homepageContent_footer()
     * 
     * @return
     */
    private function _site_homepageContent_footer()
    {
        $this->load->view('frontend/templates/homepageContentFooter');
    }
    
    /**
     * Pages::_site_stage()
     * 
     * @return
     */
    private function _site_stage()
    {
        $stage_data['stage_images']     = $this->page_content['stage_images'];          
        $this->load->view('frontend/'.$this->page_content['stage_file'], $stage_data);
    }
    
    /**
     * Pages::_site_stage_slider()
     * 
     * @return
     */
    private function _site_stage_slider()
    {
        $this->load->view('frontend/templates/stages/stage_slider');
    }
    
    /**
     * Pages::_site_footer()
     * 
     * @return
     */
    private function _site_footer()
    {
        $footer_data['title']           = FRONTEND_TITLE;
        $footer_data['menue_shortlink'] = $this->menue['menue_shortlink'];
        
        $this->load->view('frontend/templates/footer', $footer_data);
    }
    
    /**
     * Pages::_site_hr_clear()
     * 
     * @return
     */
    private function _site_hr_clear()
    {
        $this->load->view('frontend/templates/hr_clear');
    }
 }
/* End of file pages.php */
/* Location: ./application/controllers/pages/pages.php */
