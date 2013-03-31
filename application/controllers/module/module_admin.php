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

class Module_Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('module/module_model', 'module');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('admin/admin_model', 'admin');
		
		// CP Auth Konfiguration
		$this->cpauth->init('BACKEND');
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
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
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			$this->module->save_settings();
			$this->rewrite_settings();
		}
			
		if($this->uri->segment($this->uri->total_segments()) != 'save')
		{			
	 		$this->session->set_userdata('settingliste_redirect', current_url()); 	
		
			$header['title'] 		= 'Einstellungen';		
			$menue['menue']			= $this->admin->get_menue();
			$menue['submenue']		= $this->admin->get_submenue();
			$data['module'] = $this->module->get_modules();
			$data['setting'] = $this->module->get_settings();
		
			$this->load->view('templates/admin/header', $header);
			$this->load->view('templates/admin/styles');
			$this->load->view('module/styles_module');
			$this->load->view('templates/admin/menue', $menue);	
			$this->load->view('templates/admin/submenue', $menue);
			$this->load->view('templates/admin/jquery-tablesorter-cp');
			$this->load->view('module/settingliste_admin', $data);
			$this->load->view('templates/admin/footer');
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
	 	$this->session->set_userdata('languageliste_redirect', current_url()); 	
	 	
		$header['title'] = 'Texte';		
		$menue['menue']	= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['language'] = $this->module->get_languages();
		$data['module'] = $this->module->get_modules();
	
		$this->load->view('templates/admin/header', $header);
		$this->load->view('templates/admin/styles');
		$this->load->view('module/styles_module');
		$this->load->view('templates/admin/menue', $menue);	
		$this->load->view('templates/admin/submenue', $menue);	
		$this->load->view('templates/admin/jquery-tablesorter-cp');
		$this->load->view('module/languageliste_admin', $data);
		$this->load->view('templates/admin/footer');
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
	 	$this->session->set_userdata('routeliste_redirect', current_url()); 		
		
		$header['title'] = 'CI Routen';		
		$menue['menue']	= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['route'] = $this->module->get_routes();
		$data['module'] = $this->module->get_modules();
	
		$this->load->view('templates/admin/header', $header);
		$this->load->view('templates/admin/styles');
		$this->load->view('module/styles_module');
		$this->load->view('templates/admin/menue', $menue);	
		$this->load->view('templates/admin/submenue', $menue);	
		$this->load->view('templates/admin/jquery-tablesorter-cp');
		$this->load->view('module/routeliste_admin', $data);
		$this->load->view('templates/admin/footer');	
	 }
	 
	public function create_route()
	{		
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
			$menue['menue']			= $this->admin->get_menue();
			$menue['submenue']		= $this->admin->get_submenue();
			$data['module'] = $this->module->get_modules();
		
			$this->load->view('templates/admin/header', $header);
			$this->load->view('templates/admin/styles');
			$this->load->view('module/styles_module');
			$this->load->view('templates/admin/menue', $menue);	
			$this->load->view('templates/admin/submenue', $menue);
			$this->load->view('module/createRoute_admin', $data);
			$this->load->view('templates/admin/footer');
		}
		else redirect($this->session->userdata('routeliste_redirect'), 'refresh');
	}
	 
	public function edit_route($id)
	{		
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
			$menue['menue']			= $this->admin->get_menue();
			$menue['submenue']		= $this->admin->get_submenue();
			$data['module'] = $this->module->get_modules();
			$data['route'] = $this->module->get_route($id);
		
			$this->load->view('templates/admin/header', $header);
			$this->load->view('templates/admin/styles');
			$this->load->view('module/styles_module');
			$this->load->view('templates/admin/menue', $menue);	
			$this->load->view('templates/admin/submenue', $menue);
			$this->load->view('module/editRoute_admin', $data);
			$this->load->view('templates/admin/footer');
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
		$this->module->delete_route($id);
		$this->write_routes();		
		redirect($this->session->userdata('routeliste_redirect'), 'refresh');
	}
	
	public function rewrite_routes()
	{
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
		$this->module->write_route_file();
	}
}

?>