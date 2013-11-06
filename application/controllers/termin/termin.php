<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Termin
 * Controller für die Anzeige der Termine
 * 
 * @package com.cp.feuerwehr.frontend.termin  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Termin extends CP_Controller {

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
    
    /**
     * Termin::get_termin_overview()
     * 
     * @param mixed $limit
     * @param mixed $offset
     * @return
     */
    public function get_termin_overview($limit = TERMIN_DEFAULT_LIMIT, $offset = TERMIN_DEFAULT_OFFSET)
    {
        return $this->m_termin->get_termin_v_list($limit, $offset);
    }
    
    /**
     * Termin::overview_1col()
     * 
     * @param mixed $limit
     * @param mixed $offset
     * @return
     */
    public function overview_1col($limit = TERMIN_DEFAULT_LIMIT, $offset = TERMIN_DEFAULT_OFFSET, $first = 0)
    {
        $termin_overview = $this->m_termin->get_termin_v_list($limit, $offset);
        $termin['title'] = 'Termine';
        if($first == 1) $termin['class'] = 'first'; 
        $this->load->view('frontend/termin/overview_1col_header', $termin);
        foreach($termin_overview as $termin)
        {
            $this->load->view('frontend/termin/overview_1col_data', $termin);
        }
        $this->load->view('frontend/termin/overview_1col_footer');    
    }
    
    /**
     * Termin::terminliste_1col()
     * 
     * @return
     */
    public function terminliste_1col()
    {
        $termine = $this->m_termin->get_termin_v_list_all_by_month();
        $monate['monate'] = $this->m_termin->get_termin_months_for_filter();
        $i = 1;
        $j = 0;
        
        $this->load->view('frontend/termin/terminliste_1col_filter', $monate);
        foreach($termine as $key => $month)
        {   
            $monat['monat'] = $key;
            $this->load->view('frontend/termin/terminliste_1col_anchor', $monat);
            if($j != 0) $this->load->view('frontend/termin/terminliste_1col_month', $monat);
            $this->load->view('frontend/termin/terminliste_1col_header');
            foreach($month as $termin)
            {   
                $termin['count'] = $i;
                $this->load->view('frontend/termin/terminliste_1col_data', $termin);
                $i++;
            }
            $this->load->view('frontend/termin/terminliste_1col_footer');
            $j++;
        }
    }
}
/* End of file termin.php */
/* Location: ./application/controllers/termin/termin.php */