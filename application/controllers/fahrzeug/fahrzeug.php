<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fahrzeug
 * Controller für die Anzeige der Fahrzeuge
 * 
 * @package com.cp.feuerwehr.frontend.fahrzeug  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Fahrzeug extends CP_Controller {
    /**
	 * Fahrzeug::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
        $this->load->model('fahrzeug/fahrzeug_model', 'm_fahrzeug');  
	}
    
    public function get_fahrzeug_overview($online = 'all')
    {
        return $this->m_fahrzeug->get_fahrzeug_list($online);
    }
}
?>