<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Mannschaft
 * Controller für die Anzeige der Mannschaft
 * 
 * @package com.cp.feuerwehr.frontend.mannschaft  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Mannschaft extends CP_Controller {
    /**
	 * Mannschaft::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
        $this->load->model('mannschaft/mannschaft_model', 'm_mannschaft');  
	}
    
    public function mannschaftliste_3col()
    {
        $mannschaft['fuehrung'] = $this->m_mannschaft->get_mannschaft_overview(TEAM_ID_LEADER);
        $mannschaft['team']     = $this->m_mannschaft->get_mannschaft_overview(TEAM_ID_TEAM);
        
        $this->load->view('frontend/mannschaft/mannschaftliste_3col_filter');
        $this->load->view('frontend/mannschaft/mannschaftliste_3col_data', $mannschaft);
    }
}

?>