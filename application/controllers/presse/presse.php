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
    
    public function presse_overview()
    {
        
    }
}
?>