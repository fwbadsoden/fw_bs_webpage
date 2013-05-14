<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Frontend
 * zentraler Controller f�r den Frontendbereich
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
		$this->load->model('menue/menue_model', 'menue');   
        $this->load->model('pages/pages_model', 'pages');      
	}
    
    /**
     * Frontend::index()
     * Startseite
     * 
     * @return void
     */
    public function index()
    {
        // Models laden
        $this->load->model('einsatz/einsatz_model', 'einsatz');   
        $this->load->model('termin/termin_model', 'termin');  
        
        $menue = $this->menue->get_menue_list('online');
        
        // Daten f�r Seitenkopf
        $header_data['title']           = FRONTEND_TITLE;
        $header_data['menue_meta']      = $menue['menue_meta'];
        $header_data['menue']           = $menue['menue'];
        
        // Daten f�r Bildb�hne
        $stage_data['stage_images']     = $this->pages->get_stage_images(1);
        
        // Daten f�r den Inhalt
        $content['einsatz_overview']    = $this->einsatz->get_einsatz_v_list(EINSATZ_STARTPAGE_LIMIT);
        $content['termin_overview']     = $this->termin->get_termin_v_list(TERMIN_STARTPAGE_LIMIT);
        
        // Daten f�r Footer
        $footer_data['title']           = FRONTEND_TITLE;
        $footer_data['menue_shortlink'] = $menue['menue_shortlink'];
             
        // Views laden     
        $this->load->view('frontend/templates/header', $header_data);
        $this->load->view('frontend/templates/stage', $stage_data);
        $this->load->view('frontend/pages/homepage', $content);
        $this->load->view('frontend/templates/footer', $footer_data);
    }
    
    public function page_loader()
    {
        $page_data = $this->pages->get_page_content_frontend($pageID);
        
    }
 }
 ?>