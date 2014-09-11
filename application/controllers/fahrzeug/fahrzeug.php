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
    
    /**
     * Fahrzeug::get_fahrzeug_overview()
     * 
     * @param string $online
     * @return
     */
    public function get_fahrzeug_overview($online = 'all', $retired)
    {
        return $this->m_fahrzeug->get_fahrzeug_list($online, $retired);
    }
    
    public function hasRetired() {
        return $this->m_fahrzeug->hasRetired();
    }
    
    /**
     * Fahrzeug::fahrzeugliste_3col()
     * 
     * @return
     */
    public function fahrzeugliste_3col($retired)
    {
        if($retired == 1) {
            $fahrzeuge = $this->get_fahrzeug_overview(1, 1);  
        }          
        else {
            $fahrzeuge = $this->get_fahrzeug_overview(1, 0);
        }
        $i = 1;
        
        $this->load->view('frontend/fahrzeug/fahrzeugliste_3col_header');
        foreach($fahrzeuge as $f)
        {
            if($i > 3) $i = 1;
            $fahrzeug['fahrzeug'] = $f;
            $fahrzeug['listcount'] = $i;
            $fahrzeug['image'] = $this->m_fahrzeug->get_setcard_image($f['fahrzeugID']);
            $this->load->view('frontend/fahrzeug/fahrzeugliste_3col_data', $fahrzeug);
            $i++;
        }
        $this->load->view('frontend/fahrzeug/fahrzeugliste_3col_footer');
    }
    
    /**
     * Fahrzeug::fahrzeug_detail_3col()
     * 
     * @param mixed $id
     * @return
     */
    public function fahrzeug_detail_3col($id)
    {
        $fahrzeug['fahrzeug']   = $this->m_fahrzeug->get_fahrzeug($id);
        $fahrzeuge              = $this->m_fahrzeug->get_fahrzeug_list(1, 0);
        $einsaetze['einsaetze'] = $this->m_fahrzeug->get_fahrzeug_einsaetze($id);
        $fahrzeug['images']     = $this->m_fahrzeug->get_fahrzeug_images($id);
        
        // Factsheet
        $this->load->view('frontend/fahrzeug/fahrzeugdetail_3col_factsheet', $fahrzeug);
        // Tabreiter-Block
        $this->load->view('frontend/fahrzeug/fahrzeugdetail_3col_tabstrip', $fahrzeug);
        // Fahrzeugübersicht
        $this->load->view('frontend/fahrzeug/fahrzeugdetail_3col_overview', $fahrzeuge);
        // TO BE DONE: Fahrzeugausrüstung
        // $this->load->view('frontend/fahrzeug/fahrzeugdetail_3col_equipment', $fahrzeug);
        // Fahrzeugbilder
        $this->load->view('frontend/fahrzeug/fahrzeugdetail_3col_pictures', $fahrzeug);
        // Einsatzübersicht
        if($fahrzeug['fahrzeug']['show_einsaetze'] == 1)
            $this->load->view('frontend/fahrzeug/fahrzeugdetail_3col_einsaetze', $einsaetze);        
    }
    
    /**
     * Fahrzeug::get_fahrzeug_stage_text()
     * 
     * @param mixed $id
     * @return
     */
    public function get_fahrzeug_stage_text($id)
    {
        return $this->m_fahrzeug->get_fahrzeug_stage_text($id);
    }
}
/* End of file fahrzeug.php */
/* Location: ./application/controllers/fahrzeug/fahrzeug.php */