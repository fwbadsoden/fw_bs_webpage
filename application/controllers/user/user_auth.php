<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User Auth Controller
 *
 * Controller für die Authentifizierungsfunktionen
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.user_auth
 **/

class User_Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('user/user_model', 'user'); 
        $this->load->model('admin/admin_model', 'admin'); 
		$this->load->helper('load_controller');
    }
	
	/**
	 * User_Auth::check_login()
	 * Überprüft die Logindaten und leitet im Erfolgsfall an das Dashboard um
	 *
	 * @return
	 */
	public function check_login()
	{ 
		$login = $this->cp_auth->login($this->input->post('username'), $this->input->post('password'));
        $messages = $this->cp_auth->get_messages_array('public');
		if($login)
		{ 
		    $this->admin->insert_log(lang('log_admin_loginOK'));
            redirect('admin/admin');
		}
		else
		{
            $c_admin = load_controller('admin/admin');
			$c_admin->login(1, $messages);
		}
	}
	
	/**
	 * User_Auth::forgot_password()
	 * Setzt das Passwort zurück und sendet es dem User zu
	 *
	 * @return
	 */
	public function forgot_password()
	{ 
		$this->session->set_flashdata('email', $this->input->post('email'));
		
        $userdata = $this->cp_auth->get_user_by_identity($this->input->post('email'));
        
		if(!is_numeric($userdata->uacc_id)) { }
		else
		{
            $response = $this->cp_auth->forgotten_password($this->input->post('email'));		
			if($response) $this->session->set_flashdata('pw_status', 1);
		}
		redirect('admin/admin');
	}
}
?>