<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin
 * 
 * Zentraler Controller für den Backendbereich
 * 
 * @package com.cp.feuerwehr.backend.admin 
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Admin extends CI_Controller {

	/**
	 * Admin::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();             
                        
        $this->load->library('CP_auth');        
		$this->load->model('admin/admin_model', 'admin');       
        
		$this->session->set_flashdata('redirect', current_url()); 
	}
	
	/**
	 * Admin::index()
	 * wird geladen, wenn keine andere Funktion geladen wird
	 * prüft ob der User eingelogged ist, sonst wird er auf die Loginseite umgeleitet
	 *
	 * Ist er eingelogged, wird das Admindashboard angezeigt
     *
     * Wird als URL admin/logout übergeben, erfolgt der Logout
	 *
	 * @return
	 *
	 **/
	public function index()
	{				
		if($this->cp_auth->is_logged_in_admin()) $this->dashboard();
		else $this->login();
	}
	
	/**
	 *Admin::mContent()
	 * Landingpage für den Inhaltsbereich
	 *
	 * @return
	 */
	public function mContent()
	{
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
        if(!$this->cp_auth->is_privileged('NAV:CONTENT:DISPLAY')) redirect('admin/401', 'refresh');
		
		$header['title'] 	= 'Inhalte bearbeiten';	
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue(); 
		
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
		$this->load->view('backend/admin/landingpages/content');
		$this->load->view('backend/templates/admin/footer'); 
	}
	
	/**
	 * Admin::mFiles()
	 * Landingpage für den Dateibereich
	 *
	 * @return
	 */
	public function mFiles()
	{
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
        if(!$this->cp_auth->is_privileged('NAV:FILE:DISPLAY')) redirect('admin/401', 'refresh');
		
		$header['title'] 	= 'Dateien bearbeiten';	
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue(); 
		
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
		$this->load->view('backend/admin/landingpages/files');
		$this->load->view('backend/templates/admin/footer');
	}
	
	/**
	 * Admin::mMenue()
	 * Landingpage für den Menübereich
	 *
	 * @return
	 */
	public function mMenue()
	{
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
        if(!$this->cp_auth->is_privileged('NAV:MENUE:DISPLAY')) redirect('admin/401', 'refresh');
		
		$header['title'] 	= 'Inhalte bearbeiten';	
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue(); 
		
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
		$this->load->view('backend/admin/landingpages/menue');
		$this->load->view('backend/templates/admin/footer');
	}
	
	/**
	 * Admin::mSystem()
	 * Landingpage für den Einstellungsbereich
	 *
	 * @return
	 */
	public function mSystem()
	{
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
        if(!$this->cp_auth->is_privileged('NAV:SYSTEM:DISPLAY')) redirect('admin/401', 'refresh');
		
		$header['title'] 	= 'Inhalte bearbeiten';	
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue(); 
		
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
		$this->load->view('backend/admin/landingpages/system');
		$this->load->view('backend/templates/admin/footer');
	}
	
	/**
	 * Admin::mUser()
	 * Landingpage für den Benutzerverwaltungsbereich
	 *
	 * @return
	 */
	public function mUser()
	{
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
        if(!$this->cp_auth->is_privileged('NAV:USER:DISPLAY')) redirect('admin/401', 'refresh');
		
		$header['title'] 	= 'Inhalte bearbeiten';	
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue(); 
		
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
		$this->load->view('backend/admin/landingpages/user');
		$this->load->view('backend/templates/admin/footer');
	}
	
	/**
	 * Admin::dashboard()
	 * Zeigt das Admindashboard an mit dem Admin log, den Quicklinks und der Admin-Nachricht
	 *
	 * @return
	 */
	private function dashboard()
	{
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
        
		$header['title'] 	= 'Dashboard';	
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue(); 
		$data['userdata'] 	= $menue['userdata'];
		$data['log']		= $this->admin->get_log();
		$data['qlink']		= $this->admin->get_quicklinks();
		$data['message']	= $this->admin->get_adminmessage();
		
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
		$this->load->view('backend/admin/dashboard', $data);
		$this->load->view('backend/templates/admin/footer');
	}
	
	/**
	 * Admin::login()
	 * Zeigt die Login-Seite an
	 *
	 * @param string $error
	 * @return
	 */
	public function login($area = 'login', $messages = NULL)
	{	
		$header['title'] = 'Backend Login';
  
        $data['area'] = $area;
		$data['messages'] = $messages;
		$this->load->view('backend/templates/admin/header_login', $header);
		$this->load->view('backend/admin/login', $data);
		$this->load->view('backend/templates/admin/footer_login');
	}
	
	/**
	 * Admin::logout()
	 * Ruft die Logout Funktion für den Admin User
	 *
	 * @return
	 */
	public function logout()
	{
		$this->cp_auth->logout();
        redirect('admin/admin');	
	}
}
?>