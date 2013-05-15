<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Termin
 * Controller für die Anzeige der Einsätze
 * 
 * @package com.cp.feuerwehr.frontend.einsatz  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Termin extends CI_Controller {

	/**
	 * Termin::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
        $this->load->model('termin/termin_model', 'm_termin');  
	}
    
    public function overview_1col($limit = TERMIN_DEFAULT_LIMIT, $offset = TERMIN_DEFAULT_OFFSET)
    {
        $termin_overview = $this->m_termin->get_termin_v_list($limit, $offset);
        $termin['title'] = 'Termine';
        $this->load->view('frontend/termin/overview_1col_header', $termin);
        foreach($termin_overview as $termin)
        {
            $this->load->view('frontend/termin/overview_1col_data', $termin);
        }
        $this->load->view('frontend/termin/overview_1col_footer');    
    }
}
?>