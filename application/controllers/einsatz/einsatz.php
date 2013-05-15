<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Einsatz
 * Controller für die Anzeige der Einsätze
 * 
 * @package com.cp.feuerwehr.frontend.einsatz  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Einsatz extends CI_Controller {

	/**
	 * Einsatz::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
        $this->load->model('einsatz/einsatz_model', 'm_einsatz');  
	}
    
    public function overview_2col($limit = EINSATZ_DEFAULT_LIMIT, $offset = EINSATZ_DEFAULT_OFFSET)
    {
        $einsatz_header['title']        = 'Einsatz-Ticker';
        $einsatz_overview               = $this->m_einsatz->get_einsatz_v_list($limit, $offset);
        
        $this->load->view('frontend/einsatz/overview_2col_header', $einsatz_header);
        foreach($einsatz_overview as $einsatz)
        {
            $this->load->view('frontend/einsatz/overview_2col_data', $einsatz);
        }
        $this->load->view('frontend/einsatz/overview_2col_footer');    
    }
}
?>