<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Module Controller
 *
 * Controller für die Moduladministration
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.module
 **/

class Module_Admin extends CP_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('module/module_model', 'module');
		$this->load->model('admin/admin_model', 'admin');
		
		// Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
		
		$this->session->set_flashdata('redirect', current_url()); 
	}
	
	/** +++++++++++++++ SETTINGS ++++++++++++++++ */
	
	/**
	 * setting_liste Funktion
	 * Listet alle definierten Konstanten auf und bietet eine komfortable Bearbeitungsmöglichkeit
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	 public function setting_liste()
	 {		
        if(!$this->cp_auth->is_privileged(SETTINGS_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			$this->module->save_settings();
			$this->rewrite_settings();
		}
			
		if($this->uri->segment($this->uri->total_segments()) != 'save')
		{			
	 		$this->session->set_userdata('settingliste_redirect', current_url()); 	
		
			$header['title'] 		= 'Einstellungen';		
		    $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
			$data['setting']        = $this->module->get_settings();
        
            // Berechtigungen für Übersichtsseite weiterreichen
            $data['privileged']['edit'] = $this->cp_auth->is_privileged(SETTINGS_PRIV_EDIT);
            $data['privileged']['delete'] = $this->cp_auth->is_privileged(SETTINGS_PRIV_DELETE); 
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
			$this->load->view('backend/module/settingliste_admin', $data);
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('settingliste_redirect'), 'refresh');
	 }
	
	private function verify_setting()
	{		
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		$this->form_validation->set_rules('constant', 'Konstante', 'required|max_length[255]|xss_clean');	
		$this->form_validation->set_rules('value', 'Wert', 'required|max_length[255]|xss_clean');	

		return $this->form_validation->run();	
	}
	
	public function rewrite_settings()
	{
        if(!$this->cp_auth->is_privileged(SETTINGS_PRIV_EDIT)) redirect('admin/401', 'refresh');
		$this->write_settings();
		redirect($this->session->userdata('settingliste_redirect'), 'refresh');
	}
	
	/**
	 * write_settings Funktion
	 * Schreibt die dynamisch erstellte Konstantendatei
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function write_settings()
	{
        if(!$this->cp_auth->is_privileged(SETTINGS_PRIV_EDIT)) redirect('admin/401', 'refresh');
		$this->module->write_setting_file();
	}
	

	/** +++++++++++++++ Texte +++++++++++++++++ */	
	
	/**
	 * language_liste Funktion
	 * Listet alle definierten Texte auf und bietet eine komfortable Bearbeitungsmöglichkeit
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	 public function language_liste()
	 {
        if(!$this->cp_auth->is_privileged(LANGUAGE_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
	 	$this->session->set_userdata('languageliste_redirect', current_url()); 	
	 	
		$header['title']    = 'Texte';		
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['language']   = $this->module->get_languages();
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(LANGUAGE_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(LANGUAGE_PRIV_DELETE); 
        
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/module/languageliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');
	 }	

	/** +++++++++++++++ ROUTEN +++++++++++++++++ */	
	
	/**
	 * route_liste Funktion
	 * Listet alle definierten Routen auf und bietet eine komfortable Bearbeitungsmöglichkeit
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	 public function route_liste()
	 {
        if(!$this->cp_auth->is_privileged(ROUTE_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
	 	$this->session->set_userdata('routeliste_redirect', current_url()); 		
		
		$header['title']    = 'CI Routen';		
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['route']      = $this->module->get_routes();
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(ROUTE_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(ROUTE_PRIV_DELETE); 
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/module/routeliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');	
	 }
	 
	public function create_route()
	{		
        if(!$this->cp_auth->is_privileged(ROUTE_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify= $this->verify_route())
			{
				$this->module->create_route();
				$this->write_routes();
			}
		}
		else
			$this->session->set_userdata('routecreate_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'Routen';		
		    $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
			$data['module']         = $this->module->get_modules();
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/module/createRoute_admin', $data);
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('routeliste_redirect'), 'refresh');
	}
	 
	public function edit_route($id)
	{		
        if(!$this->cp_auth->is_privileged(ROUTE_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify= $this->verify_route())
			{
				$this->module->update_route($id);
				$this->write_routes();
			}
		}
		else
			$this->session->set_userdata('routeedit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'Routen';		
		    $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
			$data['module']         = $this->module->get_modules();
			$data['route']          = $this->module->get_route($id);
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/module/editRoute_admin', $data);
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('routeliste_redirect'), 'refresh');
	}
	
	private function verify_route()
	{		
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		$this->form_validation->set_rules('route', 'Route', 'required|max_length[255]|xss_clean');	
		$this->form_validation->set_rules('link', 'Link', 'required|max_length[255]|xss_clean');	

		return $this->form_validation->run();	
	}
	
	public function delete_route($id)
	{		
        if(!$this->cp_auth->is_privileged(ROUTE_PRIV_DELETE)) redirect('admin/401', 'refresh');
		$this->module->delete_route($id);
		$this->write_routes();		
		redirect($this->session->userdata('routeliste_redirect'), 'refresh');
	}
    
    public function rewrite_languages()
    {
        if(!$this->cp_auth->is_privileged(LANGUAGE_PRIV_EDIT)) redirect('admin/401', 'refresh');
        $this->write_languages();
		redirect($this->session->userdata('languageliste_redirect'), 'refresh');
    }
	
	public function rewrite_routes()
	{
        if(!$this->cp_auth->is_privileged(ROUTE_PRIV_EDIT)) redirect('admin/401', 'refresh');
		$this->write_routes();
		redirect($this->session->userdata('routeliste_redirect'), 'refresh');
	}
	
	/**
	 * write_routes Funktion
	 * Schreibt die dynamisch erstellte Routendatei
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function write_routes()
	{
        if(!$this->cp_auth->is_privileged(ROUTE_PRIV_EDIT)) redirect('admin/401', 'refresh');
		$this->module->write_route_file();
	}
    
    public function write_languages()
    {
        if(!$this->cp_auth->is_privileged(LANGUAGE_PRIV_EDIT)) redirect('admin/401', 'refresh');
        $this->module->write_language_file();
    }
}

?>