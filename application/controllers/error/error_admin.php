<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Error_admin
 * 
 * Zentraler Controller für Backendfehler
 * 
 * @package com.cp.feuerwehr.backend.error 
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Error_admin extends CP_Controller {

	/**
	 * Error_admin::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
        $this->load->library('CP_auth');   
		$this->load->model('admin/admin_model', 'admin');                 
	}
    
    /**
     * Error_admin::error_404()
     * not authorized page
     * 
     * @return void
     */
    public function error_401()
    {
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
		
		$header['title'] 	= 'Keine Berechtigung';	
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue(); 
		
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
		$this->load->view('backend/error/e401');
		$this->load->view('backend/templates/admin/footer');         
    }
}
?>