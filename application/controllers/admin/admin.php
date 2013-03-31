<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin Controller
 *
 * Zentraler Controller für den Backendbereich
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.admin
 **/

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('admin/admin_model', 'admin');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		
		// CP Auth Konfiguration für Admin Controller
		$this->cpauth->init('BACKEND');
		
		$this->session->set_flashdata('redirect', current_url()); 
	}
	
	/**
	 * index Funktion
	 * wird geladen, wenn keine andere Funktion geladen wird
	 * prüft ob der User eingelogged ist, sonst wird er auf die Loginseite umgeleitet
	 *
	 * Ist er eingelogged, wird das Admindashboard angezeigt
     *
     * Wird als URL admin/logout übergeben, erfolgt der Logout
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function index()
	{				
		if($this->cpauth->is_logged_in()) $this->dashboard();
		else $this->login();
	}
	
	/**
	 * mContent Funktion
	 * Landingpage für den Inhaltsbereich
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function mContent()
	{
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
		$header['title'] 		= 'Inhalte bearbeiten';	
		$menue['menue']		= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue(); 
		
		$this->load->view('templates/admin/header', $header);
	//	$this->load->view('templates/admin/styles');
	//	$this->load->view('admin/styles_admin');
		$this->load->view('templates/admin/menue', $menue);
		$this->load->view('templates/admin/submenue', $menue);
		$this->load->view('admin/landingpages/content');
		$this->load->view('templates/admin/footer'); 
	}
	
	/**
	 * mFiles Funktion
	 * Landingpage für den Dateibereich
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function mFiles()
	{
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
		$header['title'] 		= 'Dateien bearbeiten';	
		$menue['menue']		= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue(); 
		
		$this->load->view('templates/admin/header', $header);
	//	$this->load->view('templates/admin/styles');
	//	$this->load->view('admin/styles_admin');
		$this->load->view('templates/admin/menue', $menue);
		$this->load->view('templates/admin/submenue', $menue);
		$this->load->view('admin/landingpages/files');
		$this->load->view('templates/admin/footer');
	}
	
	/**
	 * mMenue Funktion
	 * Landingpage für den Menübereich
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function mMenue()
	{
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
		$header['title'] 		= 'Inhalte bearbeiten';	
		$menue['menue']		= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue(); 
		
		$this->load->view('templates/admin/header', $header);
	//	$this->load->view('templates/admin/styles');
	//	$this->load->view('admin/styles_admin');
		$this->load->view('templates/admin/menue', $menue);
		$this->load->view('templates/admin/submenue', $menue);
		$this->load->view('admin/landingpages/menue');
		$this->load->view('templates/admin/footer');
	}
	
	/**
	 * mSettings Funktion
	 * Landingpage für den Einstellungsbereich
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function mSystem()
	{
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
		$header['title'] 		= 'Inhalte bearbeiten';	
		$menue['menue']		= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue(); 
		
		$this->load->view('templates/admin/header', $header);
	//	$this->load->view('templates/admin/styles');
	//	$this->load->view('admin/styles_admin');
		$this->load->view('templates/admin/menue', $menue);
		$this->load->view('templates/admin/submenue', $menue);
		$this->load->view('admin/landingpages/system');
		$this->load->view('templates/admin/footer');
	}
	
	/**
	 * mUser Funktion
	 * Landingpage für den Benutzerverwaltungsbereich
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function mUser()
	{
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
		$header['title'] 		= 'Inhalte bearbeiten';	
		$menue['menue']		= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue(); 
		
		$this->load->view('templates/admin/header', $header);
	//	$this->load->view('templates/admin/styles');
	//	$this->load->view('admin/styles_admin');
		$this->load->view('templates/admin/menue', $menue);
		$this->load->view('templates/admin/submenue', $menue);
		$this->load->view('admin/landingpages/user');
		$this->load->view('templates/admin/footer');
	}
	
	/**
	 * Dashboard Funktion
	 * Zeigt das Admindashboard an mit dem Admin log, den Quicklinks und der Admin-Nachricht
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	private function dashboard()
	{
		$header['title'] 		= 'Dashboard';	
		$menue['menue']		= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue(); 
		$data['userdata'] 	= $this->cp_auth->cp_get_userdata($this->session->userdata(CPAUTH_SESSION_BACKEND));
		$data['log']		= $this->admin->get_log();
		$data['qlink']		= $this->admin->get_quicklinks();
		$data['message']	= $this->admin->get_adminmessage();
		
		$this->load->view('templates/admin/header', $header);
		$this->load->view('templates/admin/styles');
		$this->load->view('admin/styles_admin');
		$this->load->view('templates/admin/menue', $menue);
		$this->load->view('templates/admin/submenue', $menue);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('templates/admin/footer');
	}
	
	/**
	 * Login Funktion
	 * Zeigt die Login-Seite an
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	private function login($error = '')
	{	
		$header['title'] = 'Backend Login';	
		$data['error'] = $error;
		$this->load->view('templates/admin/header_login', $header);
		$this->load->view('admin/login', $data);
		$this->load->view('templates/admin/footer_login');
	}
	
	/**
	 * check_login Funktion
	 * Überprüft die Logindaten und leitet im Erfolgsfall an das Dashboard um
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function check_login()
	{ 
		$login = $this->cpauth->login();

		if($login['authorize'])
		{ 
			// eingelogged
			$this->admin->insert_log(lang('log_admin_loginOK'));
			$this->dashboard();
		}
		else if($login['initial'])
			$this->change_pw_login('', $login['userID']);
		else
		{
			// Login fehlgeschlagen
			$this->login($login['error']);
		}
	}
	
	/**
	 * forgot_password Funktion
	 * Zeigt die Passwort vergessen Seite an
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function forgot_password()
	{ 
		$this->session->set_flashdata('email', $this->input->post('email'));
		
		$userID = $this->cpauth->get_userid('', $this->input->post('email'));
		if(!$userID /*|| $userID['active'] == 0*/) { }
		else
		{
			$code = $this->cpauth->get_reset_code($userID['userID']);	
			$new_pw = $this->cpauth->reset_password($code['reset_code']);
			
			$this->load->library('email');
			$this->email->cp_send_mail(	array('from' => EMAIL_FROM_ACCOUNT_ACTIVATE, 
			                                 'from_txt' => EMAIL_FROMTXT_ACCOUNT_ACTIVATE),
			                           	$code['email'], 
			                           	lang('email_subject_adminnewpw'), 
			                           	str_replace('%PW%', $new_pw['temp_pw'], lang('email_text_adminnewpw'))
			                           );
			$this->session->set_flashdata('pw_status', 1);
		}
		redirect('admin/admin');
	}
	
	/**
	 * Passwort ändern Funktion
	 * Lässt das Passwort unter Angabe des alten Passworts ändern
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function change_pw_login($error = '', $userID = '')
	{  
		$header['title'] = 'Backend Login - Passwort ändern';	
		$data['error'] = $error;	
		$this->session->set_userdata('check_user_id', $userID);
		
		$this->load->view('templates/admin/header_login', $header);
		if($error == 'success')
			$this->load->view('admin/change_pw_login_success');
		else
			$this->load->view('admin/change_pw_login', $data);
		$this->load->view('templates/admin/footer_login');
	}
	
	public function check_change_pw_login()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		
		$this->form_validation->set_rules('password_old', 'Altes Passwort', 'required|max_length[20]|xss_clean|callback_pw_old_is_not_correct');
		$this->form_validation->set_rules('password_new1', 'Neues Passwort', 'required|max_length[20]|xss_clean|callback_pw_is_like_old');
		$this->form_validation->set_rules('password_new2', 'Passwort wiederholen', 'required|max_length[20]|xss_clean|callback_pw_1_like_2');
		$this->form_validation->set_message('pw_old_is_not_correct', 'Das alte Passwort ist nicht korrekt.');
		$this->form_validation->set_message('pw_is_like_old', 'Das neue Passwort darf nicht dem alten entsprechen.');
		$this->form_validation->set_message('pw_1_like_2', 'Die neuen Passwörter müssen übereinstimmen.');

		if(!$this->form_validation->run())
			$this->change_pw_login('error', $this->session->userdata('check_user_id'));
		else
		{
			$this->cpauth->change_pw($this->session->userdata('check_user_id'), $this->input->post('password_old'), $this->input->post('password_new1'));
			$this->session->unset_userdata('check_user_id');
			$this->change_pw_login('success');
		}
	}
	
	// Callback Funktion für Prüfung bei Passwortänderung
	public function pw_old_is_not_correct($pw)
	{
		return $this->cpauth->check_pw($pw, $this->session->userdata('check_user_id'));
	}
	public function pw_is_like_old($pw)
	{
		if($pw == $this->input->post('password_old')) return false; else return true;
	}
	public function pw_1_like_2($pw)
	{
		if($pw == $this->input->post('password_new1')) return true; else return false;	
	}
	
	/**
	 * Logout Funktion
	 * Ruft die Logout Funktion für den Admin User
	 *
	 * @author Habib Pleines
	 * @version 1.0
	 *
	 **/
	public function logout()
	{
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		$this->cpauth->logout('admin/admin');	
	}
}
?>