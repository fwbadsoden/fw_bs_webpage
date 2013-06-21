<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User Controller
 *
 * Controller für die Verwaltung und Anzeige der User ( Backend und Frontend )
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.user
 **/

class User_Admin extends CI_Controller {

	private $userdata;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('admin/admin_model', 'admin');
		
		// Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');	
	}
    
    public function edit_profile()
    {
        $this->session->set_userdata('userprofile_redirect', current_url());
        
        $userdata           = $this->cp_auth->cp_get_user_by_id();
        $header['title']    = 'Benutzerprofil von '.$userdata->first_name.' '.$userdata->last_name;
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $userdata;
		$menue['submenue']	= $this->admin->get_submenue();
        $data['userdata']   = $userdata;
        
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/user/userprofile_admin', $data);
		$this->load->view('backend/templates/admin/footer');
    }
	
	public function user_liste()
	{		
		$this->session->set_userdata('userliste_redirect', current_url()); 
				
		$header['title']    = 'Benutzer im Backend';
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['user']       = $this->cp_auth->get_users_query()->result();	
        
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/user/userliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');		
	}
    
    public function delete_user_verify($userID)
    {
        $header['title']    = 'Benutzer l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
        $data['user']       = $this->cp_auth->get_user($userID);
        $data['type']       = 'user';
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/user/verifyDelete_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
    }
    
    public function delete_group_verify($groupID)
    {
        $header['title']    = 'Gruppe l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
        $sql_where          = array('ugrp_id' => $groupID);
        $data['group']      = $this->cp_auth->get_user_group(FALSE, $sql_where);
        $data['type']       = 'user';
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/user/verifyDelete_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
    }
    
    public function delete_priv_verify($privID)
    {
        $header['title']    = 'Berechtigung l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
        $sql_where          = array('upriv_id' => $privID);
        $data['priv']       = $this->cp_auth->get_privileges(FALSE, $sql_where);
        $data['type']       = 'user';
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/user/verifyDelete_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
    }
	
	public function create_user()
	{
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{
			if($verify = $this->verify_user())
			{
				$this->admin->insert_log(str_replace('%USER%', $this->input->post('username'), lang('log_admin_createUser')));
				$this->userdata = $this->user->create_user();
				/*	
				 *  $this->user['userdata'] = array(userID, username, email, vorname, nachname, creation_date)
				 *  $this->user['authdata'] = intial_password
				 */
				$this->send_initial_login();
			}
		}
		else
			$this->session->set_userdata('usercreate_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title']		= 'User';
			$menue['menue']			= $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue'] 		= $this->admin->get_submenue();
			
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/user/createUser_admin');
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('userliste_redirect'), 'refresh');
	}
	
	public function edit_user($id)
	{
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{
			if($verify = $this->verify_user($id))
			{
				$this->admin->insert_log(str_replace('%USER%', $this->input->post('username'), lang('log_admin_editUser')));
				$this->user->update_user($id);
			}
		}
		else
			$this->session->set_userdata('useredit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{
			$header['title'] 		= 'User';
			$menue['menue']			= $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
			$user['user']			= $this->user->get_user($id);
			$user['id']				= $id;
			
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/user/editUser_admin', $user);
			$this->load->view('backend/templates/admin/footer');	
		}
		else redirect($this->session->userdata('userliste_redirect'), 'refresh');
	}
	
	public function delete_user($id)
	{
		$userdata = $this->user->get_user_list($id);
		$this->admin->insert_log(str_replace('%USER%', $userdata[0]['username'], lang('log_admin_deleteUser')));
		
		$this->user->delete_user($id);
		
		redirect($this->session->userdata('userliste_redirect'), 'refresh');	
	}
	
	public function verify_user($id = 0)
	{
		$this->load->library('form_validation');
		$user_table = $this->user->get_user_table();
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		if($id > 0)
		{
			$this->form_validation->set_rules('username', 'Benutzername', 'required|alpha_numeric|max_length[20]|xss_clean|edit_unique['.$user_table.'.username.'.$id.'.userID]');	
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]|xss_clean|edit_unique['.$user_table.'.email.'.$id.'.userID]');		
		}
		else
		{
			$this->form_validation->set_rules('username', 'Benutzername', 'required|alpha_numeric|max_length[20]|xss_clean|is_unique['.$user_table.'.username]');	
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]|xss_clean|is_unique['.$user_table.'.email]');
		}
		$this->form_validation->set_rules('vorname', 'Vorname', 'required|alpha|max_length[100]|xss_clean');
		$this->form_validation->set_rules('nachname', 'Nachname', 'required|alpha|max_length[100]|xss_clean');
		
		return $this->form_validation->run();
	}
	
	public function switch_online_state($id, $state)
	{
		if($state == 1) 
            $this->cp_auth->deactivate_user($id);
        else 
            $this->cp_auth->activate_user($id, FALSE, FALSE);
            
		redirect($this->session->userdata('userliste_redirect'), 'refresh');	
	}
	
	// JSON Call Attribut eindeutig
	public function json_userattr_unique($id, $value)
	{		
        $return = $this->cp_auth->identity_available($value, $id);
        if($return) $json = 1; else $json = 0;
		echo json_encode($json);
	}
}
?>