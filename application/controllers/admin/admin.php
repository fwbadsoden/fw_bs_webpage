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
		$this->load->model('admin/admin_model', 'admin');
		$this->load->model('user/user_model', 'user');
        
        // IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded! 
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		$this->auth = new stdClass;
        $this->load->library('flexi_auth');
		
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
		if($this->flexi_auth->is_admin()) $this->dashboard();
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
		if(!$this->flexi_auth->is_admin()) redirect('admin', 'refresh');
		
		$header['title'] 		= 'Inhalte bearbeiten';	
		$menue['menue']		= $this->admin->get_menue();
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
		if(!$this->flexi_auth->is_admin()) redirect('admin', 'refresh');
		
		$header['title'] 		= 'Dateien bearbeiten';	
		$menue['menue']		= $this->admin->get_menue();
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
		if(!$this->flexi_auth->is_admin()) redirect('admin', 'refresh');
		
		$header['title'] 		= 'Inhalte bearbeiten';	
		$menue['menue']		= $this->admin->get_menue();
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
		if(!$this->flexi_auth->is_admin()) redirect('admin', 'refresh');
		
		$header['title'] 		= 'Inhalte bearbeiten';	
		$menue['menue']		= $this->admin->get_menue();
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
		if(!$this->flexi_auth->is_admin()) redirect('admin', 'refresh');
		
		$header['title'] 		= 'Inhalte bearbeiten';	
		$menue['menue']		= $this->admin->get_menue();
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
		$header['title'] 		= 'Dashboard';	
		$menue['menue']		= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue(); 
		$data['userdata'] 	= $this->cp_auth->cp_get_userdata($this->session->userdata(CPAUTH_SESSION_BACKEND));
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
	private function login($error = '')
	{	
		$header['title'] = 'Backend Login';	
		$data['error'] = $error;
		$this->load->view('backend/templates/admin/header_login', $header);
		$this->load->view('backend/admin/login', $data);
		$this->load->view('backend/templates/admin/footer_login');
	}
	
	/**
	 * Admin::check_login()
	 * Überprüft die Logindaten und leitet im Erfolgsfall an das Dashboard um
	 *
	 * @return
	 */
	public function check_login()
	{ 
		$login = $this->user->login($this->input->post('username'), $this->input->post('password'));

		if($login)
		{ 
		    $this->admin->insert_log(lang('log_admin_loginOK'));
            $this->dashboard();
		}
		else
		{
			$this->login($login['error']);
		}
	}
	
	/**
	 * Admin::forgot_password()
	 * Zeigt die Passwort vergessen Seite an
	 *
	 * @return
	 */
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
	 * Admin::change_pw_login()
	 * Lässt das Passwort unter Angabe des alten Passworts ändern
	 *
	 * @param string $error
	 * @param integer $userID
	 * @return
	 */
	public function change_pw_login($error = '', $userID = '')
	{  
		$header['title'] = 'Backend Login - Passwort ändern';	
		$data['error'] = $error;	
		$this->session->set_userdata('check_user_id', $userID);
		
		$this->load->view('backend/templates/admin/header_login', $header);
		if($error == 'success')
			$this->load->view('backend/admin/change_pw_login_success');
		else
			$this->load->view('backend/admin/change_pw_login', $data);
		$this->load->view('backend/templates/admin/footer_login');
	}
	
	/**
	 * Admin::check_change_pw_login()
	 * 
	 * @return
	 */
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
	
	/**
	 * Admin::pw_old_is_not_correct()
     * Callback Funktion für Prüfung bei Passwortänderung
	 * 
	 * @param mixed $pw
	 * @return
	 */
	public function pw_old_is_not_correct($pw)
	{
		return $this->cpauth->check_pw($pw, $this->session->userdata('check_user_id'));
	}
	/**
	 * Admin::pw_is_like_old()
     * Callback Funktion für Prüfung bei Passwortänderung
	 * 
	 * @param mixed $pw
	 * @return
	 */
	public function pw_is_like_old($pw)
	{
		if($pw == $this->input->post('password_old')) return false; else return true;
	}
	/**
	 * Admin::pw_1_like_2()
     * Callback Funktion für Prüfung bei Passwortänderung
	 * 
	 * @param mixed $pw
	 * @return
	 */
	public function pw_1_like_2($pw)
	{
		if($pw == $this->input->post('password_new1')) return true; else return false;	
	}
	
	/**
	 * Admin::logout()
	 * Ruft die Logout Funktion für den Admin User
	 *
	 * @return
	 */
	public function logout()
	{
		$this->flexi_auth->logout('admin/admin');	
	}
}
?>