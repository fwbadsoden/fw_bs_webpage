<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Information
 * 
 * Controller für die Bereitstellung allgemeiner Informationen im Backend
 * 
 * @package com.cp.feuerwehr.backend.information 
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Information_Admin extends CP_Controller {

	/**
	 * Information::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();                
        $this->load->library('CP_auth');        
		$this->load->model('information/information_model', 'm_info');  
		$this->load->model('admin/admin_model', 'm_admin');     
        
		$this->session->set_flashdata('redirect', current_url()); 
	}
    
    public function email_liste()
    {
        if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
        if(!$this->cp_auth->is_privileged('NAV:CONTENT:DISPLAY')) redirect('admin/401', 'refresh');
        
        $emails['emails'] = $this->m_info->get_email_list();
		
		$header['title'] 	= 'Informationen anzeigen';	
		$menue['menue']	    = $this->m_admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->m_admin->get_submenue(); 
		
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/information/emailliste_admin', $emails);
		$this->load->view('backend/templates/admin/footer');
    }
}
?>