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
		$this->load->model('menue/menue_model', 'menue');   
        $this->load->model('pages/pages_model', 'pages');      
	}
    
    public function index()
    {
        $menue = $this->menue->get_menue_list();
        $header_data['title']           = FRONTEND_TITLE;
        $header_data['menue_meta']      = $menue['menue_meta'];
        $header_data['menue']           = $menue['menue'];
        
        // eigene ladefunktion für Frontend bauen /PERFORMANCE!!!
        $page_data                      = $this->pages->get_page_content(FRONTEND_STARTPAGE_ID);
        $footer_data['title']           = FRONTEND_TITLE;
        $footer_data['menue_shortlink'] = $menue['menue_shortlink'];
             
        $this->load->view('frontend/templates/header', $header_data);
        $this->load->view('frontend/pages/stage/
        $this->load->view('frontend/templates/footer', $footer_data);
    }
 }
 ?>