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
class Einsatz extends CP_Controller {

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
    
    /**
     * Einsatz::get_einsatz_overview()
     * 
     * @param mixed $limit
     * @param mixed $offset
     * @return
     */
    public function get_einsatz_overview($online, $limit = EINSATZ_DEFAULT_LIMIT, $offset = EINSATZ_DEFAULT_OFFSET)
    { 
        return $this->m_einsatz->get_einsatz_overview($online, $limit, $offset);
    }
    
    /**
     * Einsatz::overview_2col()
     * 
     * @param mixed $limit
     * @param mixed $offset
     * @return
     */
    public function overview_2col($limit = EINSATZ_DEFAULT_LIMIT, $offset = EINSATZ_DEFAULT_OFFSET)
    {
        $einsatz_header['title']        = 'Einsatz-Ticker';
        $einsaetze                      = $this->m_einsatz->get_einsatz_overview(1, $limit, $offset);
        
        $this->load->view('frontend/einsatz/overview_2col_header', $einsatz_header);
        foreach($einsaetze['einsaetze'] as $einsatz)
        {
            $this->load->view('frontend/einsatz/overview_2col_data', $einsatz);
        }
        $this->load->view('frontend/einsatz/overview_2col_footer');    
    }
    
    /**
     * Einsatz::einsatzliste_2col()
     * 
     * @return
     */
    public function einsatzliste_2col()
    {        
        if(!$year = $this->input->post('einsatzJahr')) $year = date('Y');
        if(!$type = $this->input->post('einsatzArt')) $type = 'all';
        
        if($type == 0) $type = 'all';
        $month['num'] = null;
        $monthOld = null;
        $i = 0;
        
        $einsatz_header['title']        = 'Unsere Einsätze';
        $einsaetze                      = $this->m_einsatz->get_einsatz_overview('all', 'all', 'all', $year, $type);
        $filter['types']                = $einsaetze['types'] = $this->m_einsatz->get_einsatz_type_list();
        $filter['years']                = $this->m_einsatz->get_einsatz_years();
        
        $this->load->view('frontend/einsatz/einsatzliste_2col_filter', $filter);
        $this->load->view('frontend/einsatz/einsatzliste_2col_statistik', $einsaetze);
        $this->load->view('frontend/einsatz/einsatzliste_2col_header', $einsatz_header);
        
        for($i = 0; $i < count($einsaetze['einsaetze']); $i++)
        {
            $einsatz = $einsaetze['einsaetze'][$i];
            if($einsatz->online == 1)
            {
                if(($i+1) == count($einsaetze['einsaetze'])) $einsatzNext = null;
                else $einsatzNext = $einsaetze['einsaetze'][$i+1];
                
                if($month['num'] != substr($einsatz->datum_beginn, 5, 2)) {
                    if($monthOld == null) $monthOld = substr($einsatz->datum_beginn, 5, 2);
                    $month['num'] = substr($einsatz->datum_beginn, 5, 2);
                    $month['name'] = cp_get_month_name($month['num']);  
                    $month['year'] = substr($einsatz->datum_beginn, 0, 4);
                    $this->load->view('frontend/einsatz/einsatzliste_2col_month', $month);
                    if($monthOld != $month['num']) {
                        $this->load->view('frontend/templates/hr_clear');
                        $monthOld = $month['num'];
                    }
                }
                if($einsatzNext == null)
                    $einsatz->special_class = ' lastRow';
                elseif(substr($einsatz->datum_beginn, 5, 2) != substr($einsatzNext->datum_beginn, 5, 2))
                    $einsatz->special_class = ' lastRow';
                $this->load->view('frontend/einsatz/einsatzliste_2col_data', $einsatz); 
            } 
        }
        $this->load->view('frontend/einsatz/einsatzliste_2col_footer');
    }
    
    /**
     * Einsatz::einsatz_detail_3col()
     * 
     * @param mixed $id
     * @return
     */
    public function einsatz_detail_3col($id)
    { 
        $einsatz['einsatz']   = $this->m_einsatz->get_einsatz($id);
        $einsatz['fahrzeuge'] = $this->m_einsatz->get_einsatz_fahrzeuge($id);
        $einsatz['bilder']    = $this->m_einsatz->get_einsatz_images($id);
        
        $this->load->view('frontend/einsatz/einsatzdetail_3col_factsheet', $einsatz);
        $this->load->view('frontend/einsatz/einsatzdetail_3col_data', $einsatz); 
    }
    
    /**
     * Einsatz::get_einsatz_stage_text()
     * 
     * @param mixed $id
     * @return string
     */
    public function get_einsatz_stage_text($id)
    {
        return $this->m_einsatz->get_einsatz_stage_text($id);
    } 
    
    /**
     * Einsatz::get_einsatz_anzahl()
     * 
     * @param mixed $year
     * @return integer
     */
    public function get_einsatz_anzahl($year)
    {
        return $this->m_einsatz->get_einsatz_anzahl($year);
    }
}
/* End of file einsatz.php */
/* Location: ./application/controllers/einsatz/einsatz.php */