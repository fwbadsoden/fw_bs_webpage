<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Frontend
 * zentraler Controller für den Frontendbereich
 * 
 * @package com.cp.feuerwehr.frontend.frontend  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Frontend extends CI_Controller {
    
	/**
	 * Frontend::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('menue/menue_model', 'm_menue');   
        $this->load->model('pages/pages_model', 'm_pages');      
	}
    
    /**
     * Frontend::loader()
     * Loader
     * 
     * @return void
     */
    public function loader()
    {
        $uri_segments = $this->uri->rsegment_array();
        // $uri_segments[0] fehlt, da des erste Segment der Ordner des Controller ist
        var_dump($uri_segments);
        $controller = $uri_segments[3];
        $function   = $uri_segments[4];
            
        if(count($uri_segments) > 4) {
            $j = 0;
            $args = array();
            for($i = 4; $i <= (count($uri_segments)); $i++) {
                $args[$j] = $uri_segments[$i];
                $j++;
            }
            echo "<br>"; var_dump($args);  
        } die();
        
        if($controller == $this->router->class) {
            // dynamisch Funktionen des Frontend Controllers laden
            $this->$function($args);
        }
        else {
            if($loader == 'page') {
                // dynamisch Inhaltseiten laden
                $this->load->controller('pages/pages', $pages);
                $this->pages->loader($id);
            }
            else {
                // dynamisch Modulseiten laden
            }
        }
    }
    
    private function homepage()
    {
        // Models laden 
        $this->load->controller('einsatz/einsatz', 'c_einsatz');  
        $this->load->controller('termin/termin', 'c_termin');  
        
        // Views laden 
        $this->site_header();    
        $this->site_stage(PAGES_HOMEPAGE_STAGE_ID);
        
        $this->load->view('frontend/pages/homepage', $content);
        $this->c_termin->overview_1col(TERMIN_STARTPAGE_LIMIT);
        $this->c_einsatz->overview_2col(EINSATZ_STARTPAGE_LIMIT);
        
        $this->site_footer();
    }
    
    private function site_header()
    {
        $menue = $this->m_menue->get_menue_list('online');
        $header_data['title']           = FRONTEND_TITLE;
        $header_data['menue_meta']      = $menue['menue_meta'];
        $header_data['menue']           = $menue['menue'];
                
        $this->load->view('frontend/templates/header', $header_data);
    }
    
    private function site_stage($stageID)
    {
        $stage_data['stage_images']     = $this->m_pages->get_stage_images($stageID);  
             
        $this->load->view('frontend/templates/stage', $stage_data);
    }
    
    private function site_footer()
    {
        $footer_data['title']           = FRONTEND_TITLE;
        $footer_data['menue_shortlink'] = $menue['menue_shortlink'];
        
        $this->load->view('frontend/templates/footer', $footer_data);
    }
    
   // private function sidebar
 }
 ?>