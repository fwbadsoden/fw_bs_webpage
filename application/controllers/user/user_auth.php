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
			$c_admin->login('login', $messages);
		}
	}
	
	/**
	 * User_Auth::forgot_password()
	 * Sendet dem User einen Token zum zurücksetzen des Passworts zu
	 *
	 * @return
	 */
	public function forgot_password()
	{ 
        $c_admin = load_controller('admin/admin');
    
		$result = $this->cp_auth->forgotten_password($this->input->post('email'));
        $messages = $this->cp_auth->get_messages_array('public');		  
        if(!$result)
            $c_admin->login('password', $messages);
        else {
            $header['title'] = 'Backend Login';

		    $data['message'] = $messages;
		    $this->load->view('backend/templates/admin/header_login', $header);
		    $this->load->view('backend/admin/new_password', $data);
		    $this->load->view('backend/templates/admin/footer_login');    
        }
	}
    
    /** 
     * User_Auth::reset_forgotten_password()
     * Bei korrekt übermitteltem Token wird dem User eine Email mit dem neuen Passwort zugesendet
     * 
     * @return
     */
    public function reset_forgotten_password($userID, $token)
    {
        $this->cp_auth->forgotten_password_complete($userID, $token, FALSE, TRUE);
        $messages = $this->cp_auth->get_messages_array('public');
        
  		$header['title'] = 'Backend Login';

		$data['message'] = $messages;
		$this->load->view('backend/templates/admin/header_login', $header);
		$this->load->view('backend/admin/new_password', $data);
		$this->load->view('backend/templates/admin/footer_login');
    }
}
?>