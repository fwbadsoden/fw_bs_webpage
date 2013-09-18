<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Presse
 * Controller für die Anzeige der Presseartikel
 * 
 * @package com.cp.feuerwehr.frontend.presse  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Presse extends CP_Controller {

	/**
	 * Presse::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
        $this->load->model('presse/presse_model', 'm_presse');  
	}
    
    public function get_presse_overview()
    {
        return $this->m_presse->get_articles($limit = PRESSE_DEFAULT_LIMIT, $offset = PRESSE_DEFAULT_OFFSET);
    }
    
    public function overview_2col()
    {
        $presse['articles'] = $this->m_presse->get_articles();
		
		$this->load->view('frontend/presse/overview_2col_contact');
		$this->load->view('frontend/presse/overview_2col_articles', $presse);
    }
    
    public function overview_sidebar()
    {
		$this->load->view('frontend/presse/overview_2col_sidebar');        
    }
}
?>