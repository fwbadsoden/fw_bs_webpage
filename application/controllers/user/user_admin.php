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
        $this->load->model('module/module_model', 'module');
		
		// Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');	
	}
    
    public function edit_profile()
    {
        $message = NULL;        
        if($this->uri->segment($this->uri->total_segments()) == 'save')
		{
            if($verify = $this->verify_profile())
            {
                $userdata = array(
                    'modified'    => date('Y-m-d H:i:s'),
                    'modified_by' => $this->cp_auth->get_user_id()
                );
                $profiledata = array(
                    'uprof_users_uacc_fk' => $this->cp_auth->get_user_id(),
                    'last_name'  => $this->input->post('nachname'),
                    'first_name' => $this->input->post('vorname'),
                    'initials'   => $this->input->post('initials')
                );
                if($_POST['pw_old'] != '') { 
                    $user = $this->cp_auth->cp_get_user_by_id();
                    if($pw_change = $this->cp_auth->change_password($user->uacc_email, $this->input->post('pw_old'), $this->input->post('pw_new1')))
                        $message = $this->cp_auth->status_messages('public');
                    else 
                        $message = $this->cp_auth->error_messages('public');
                }
                    
    			$this->cp_auth->update_user($this->cp_auth->get_user_id(), $userdata);
    			$this->cp_auth->update_custom_user_data('user_profile', FALSE, $profiledata);
            }
		}
        else
            $this->session->set_userdata('userprofile_redirect', current_url());
        
        if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false || isset($pw_change))
		{    
            $userdata           = $this->cp_auth->cp_get_user_by_id();        
            $header['title']    = 'Benutzerprofil von '.$userdata->first_name.' '.$userdata->last_name;
    		$menue['menue']	    = $this->admin->get_menue();
            $menue['userdata']  = $userdata;
    		$menue['submenue']	= $this->admin->get_submenue();
            $data['userdata']   = $userdata;
            $data['message']    = $message;
            
    		$this->load->view('backend/templates/admin/header', $header);
    		$this->load->view('backend/templates/admin/menue', $menue);	
    		$this->load->view('backend/templates/admin/submenue', $menue);	
    		$this->load->view('backend/user/userprofile_admin', $data);
    		$this->load->view('backend/templates/admin/footer');
        }
        else 
            redirect($this->session->userdata('userprofile_redirect', 'refresh'));
    }
	
	public function user_liste()
	{		
		$this->session->set_userdata('userliste_redirect', current_url()); 
				
		$header['title']    = 'Benutzer im Backend';
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue();
        $this->db->order_by('uacc_username', 'ASC');
		$data['user']       = $this->cp_auth->get_users_query()->result();	
        $data['group']      = $this->cp_auth->cp_get_group_names();
        
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/user/userliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');		
	}
    
    public function priv_liste()
    {
        $this->session->set_userdata('privliste_redirect', current_url());
        
        $header['title']    = 'Berechtigungen im Backend';
        $menue['menue']     = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
        $menue['submenue']  = $this->admin->get_submenue();
        $this->db->order_by('upriv_name', 'ASC');
        $data['priv']       = $this->cp_auth->get_privileges_query()->result();
        $data['module']     = $this->module->get_modules();
        
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/user/privliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');       
    }
    
    public function group_liste()
    {
        $this->session->set_userdata('groupliste_redirect', current_url());
        
        $header['title']    = 'Berechtigungsgruppen im Backend';
        $menue['menue']     = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
        $menue['submenue']  = $this->admin->get_submenue();
        $this->db->order_by('ugrp_name', 'ASC');
        $data['group']      = $this->cp_auth->get_groups_query()->result();
        
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/user/groupliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');       
    }
    
    public function delete_user_verify($userID)
    {
        $header['title']    = 'Benutzer l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
        $data['user']       = $this->cp_auth->cp_get_user_by_id($userID);
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
        $data['type']       = 'group';
    	
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
        $priv_data          = $this->cp_auth->get_privileges_query(FALSE, $sql_where)->result();
        $data['priv']       = $priv_data[0];
        $data['type']       = 'priv';
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
                $this->load->helper('string');
				$this->admin->insert_log(str_replace('%USER%', $this->input->post('username'), lang('log_admin_createUser')));
                $userdata = array(
                    'last_name'   => $this->input->post('nachname'),
                    'first_name'  => $this->input->post('vorname'),
                    'gender'      => $this->input->post('geschlecht'),
                    'initials'    => $this->input->post('initialen'),
                    'created'     => date('Y-m-d H:i:s'),
                    'created_by'  => $this->cp_auth->get_user_id()
                );
                $initial_pw = random_string('alnum', 8);
				$userID = $this->cp_auth->insert_user($this->input->post('email'), $this->input->post('username'), $initial_pw, $userdata, $this->input->post('gruppe'), TRUE);
                
				$email_data = array(
                    'username' => $this->input->post('username'),
                    'email'    => $this->input->post('email'),
                    'intial_pw' => $initial_pw
                );
                $this->cp_auth->send_email($this->input->post('email'), 'Ihr neuer Account auf feuerwehr-bs.de', 'new_account.tpl.php', $email_data);
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
            $data['group']          = $this->cp_auth->get_groups_query()->result();
			
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/user/createUser_admin', $data);
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
                $userdata = array(
                    'uacc_group_fk'   => $this->input->post('gruppe'),
                    'uacc_username'   => $this->input->post('username'),
                    'uacc_email'      => $this->input->post('email'),
                    'modified'   => date('Y-m-d H:i:s'),
                    'modified_by' => $this->cp_auth->get_user_id()
                );
                $profiledata = array(
                    'uprof_users_uacc_fk' => $id,
                    'last_name'  => $this->input->post('nachname'),
                    'first_name' => $this->input->post('vorname'),
                    'initials'   => $this->input->post('initialen'),
                    'gender'     => $this->input->post('geschlecht')
                );
				$this->cp_auth->update_user($id, $userdata);
				$this->cp_auth->update_custom_user_data('user_profile', FALSE, $profiledata);
			}
		}
		else
			$this->session->set_userdata('useredit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{
            $userdata               = $this->cp_auth->cp_get_user_by_id($id);
			$header['title'] 		= 'User';
			$menue['menue']			= $this->admin->get_menue();
            $menue['userdata']      = $userdata;
			$menue['submenue']		= $this->admin->get_submenue();
			$data['userdata']		= $userdata;
            $data['group']          = $this->cp_auth->get_groups_query()->result();
			
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/user/editUser_admin', $data);
			$this->load->view('backend/templates/admin/footer');	
		}
		else redirect($this->session->userdata('userliste_redirect'), 'refresh');
	}
	
	public function delete_user($id)
	{
		$user = $this->cp_auth->cp_get_user_by_id($id);
		$this->admin->insert_log(str_replace('%USER%', $user->uacc_username, lang('log_admin_deleteUser')));
		
		$this->cp_auth->delete_user($id);
		
		redirect($this->session->userdata('userliste_redirect'), 'refresh');	
	}
    
    public function create_priv()
    {
        if($this->uri->segment($this->uri->total_segments()) == 'save')
		{
			if($verify = $this->verify_priv())
			{
                $this->load->helper('string');
				$this->admin->insert_log(str_replace('%PRIV%', $this->input->post('name'), lang('log_admin_createPriv')));
                $privdata = array(
                    'moduleID'    => $this->input->post('modul'),
                    'created'     => date('Y-m-d H:i:s'),
                    'created_by'  => $this->cp_auth->get_user_id()
                );
				$this->cp_auth->insert_privilege(strtoupper($this->input->post('name')), $this->input->post('description'), $privdata);
			}
		}
		else
			$this->session->set_userdata('privcreate_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title']		= 'Berechtigung';
			$menue['menue']			= $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue'] 		= $this->admin->get_submenue();
            $data['module']     = $this->module->get_modules();
			
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/user/createPriv_admin', $data);
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('privliste_redirect'), 'refresh');
    }
	
	public function edit_priv($id)
	{
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{
			if($verify = $this->verify_priv($id))
			{
				$this->admin->insert_log(str_replace('%PRIV%', $this->input->post('name'), lang('log_admin_editPriv')));
                $privdata = array(
                    'upriv_name'  => strtoupper($this->input->post('name')),
                    'upriv_desc'  => $this->input->post('description'),
                    'moduleID'    => $this->input->post('modul'),
                    'modified'    => date('Y-m-d H:i:s'),
                    'modified_by' => $this->cp_auth->get_user_id()
                );
                
				$this->cp_auth->update_privilege($id, $privdata);
			}
		}
		else
			$this->session->set_userdata('privedit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{
			$header['title'] 		= 'Berechtigung';
			$menue['menue']			= $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
            $sql_where              = array('upriv_id' => $id);
            $data['privdata']       = $this->cp_auth->get_privileges(FALSE, $sql_where);
            $data['module']         = $this->module->get_modules();
			
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/user/editPriv_admin', $data);
			$this->load->view('backend/templates/admin/footer');	
		}
		else redirect($this->session->userdata('privliste_redirect'), 'refresh');
	}
	
	public function delete_priv($id)
	{
        $sql_where              = array('upriv_id' => $id);
        $privdata               = $this->cp_auth->get_privileges_query(FALSE, $sql_where)->result();
		$this->admin->insert_log(str_replace('%PRIV%', $privdata[0]->upriv_name, lang('log_admin_deletePriv')));
		
		$this->cp_auth->delete_privilege($id);
		
		redirect($this->session->userdata('privliste_redirect'), 'refresh');	
	}
    
    public function create_group()
    {
        if($this->uri->segment($this->uri->total_segments()) == 'save')
		{
			if($verify = $this->verify_group())
			{
                $this->load->helper('string');
				$this->admin->insert_log(str_replace('%GROUP%', $this->input->post('name'), lang('log_admin_createGroup')));
                $groupdata = array(
                    'created'     => date('Y-m-d H:i:s'),
                    'created_by'  => $this->cp_auth->get_user_id()
                );
				$this->cp_auth->insert_group(strtoupper($this->input->post('name')), $this->input->post('description'), $groupdata);
                $id = $this->db->insert_id();
                foreach($_POST as $key => $p) {
                    if(substr($key, 0, 2) == 'p_')
                        $this->cp_auth->insert_user_group_privilege($id, $value);
                }
			}
		}
		else
			$this->session->set_userdata('groupcreate_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title']		= 'Berechtigungsgruppe';
			$menue['menue']			= $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue'] 		= $this->admin->get_submenue();
            $this->db->order_by('upriv_name', 'ASC');
            $data['privs']          = $this->cp_auth->get_privileges_query()->result();
			
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/user/createGroup_admin', $data);
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('groupliste_redirect'), 'refresh');
    }
	
	public function edit_group($id)
	{
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{
			if($verify = $this->verify_group($id))
			{
				$this->admin->insert_log(str_replace('%GROUP%', $this->input->post('name'), lang('log_admin_editGroup')));
                $groupdata = array(
                    'ugrp_name'   => strtoupper($this->input->post('name')),
                    'ugrp_desc'   => $this->input->post('description'),
                    'moduleID'    => $this->input->post('modul'),
                    'modified'    => date('Y-m-d H:i:s'),
                    'modified_by' => $this->cp_auth->get_user_id()
                );
                if($this->input->post('admin') == 'yes')
                    $groupdata['ugrp_admin']  = 1;
                else 
                    $groupdata['upgrp_admin'] = 0;
                
				$this->cp_auth->update_group($id, $groupdata);
                
                // first delete all old priv assignments (perhaps later switch to update process rather delete all)
                $sql_where = array('upriv_groups_ugrp_fk' => $id);
                $this->cp_auth->delete_user_group_privilege($sql_where);
                
                foreach($_POST as $key => $p) {
                    if(substr($key, 0, 2) == 'p_') {            
                        $sql_where   = array('upriv_groups_ugrp_fk' => $id, 'upriv_groups_upriv_fk' => $p);
                        $group_priv = $this->cp_auth->get_user_group_privileges_query(FALSE, $sql_where)->result(); 
                        if(!$group_priv)
                            $this->cp_auth->insert_user_group_privilege($id, $p);
                    }
                }
			}
		}
		else
			$this->session->set_userdata('groupedit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{
			$header['title'] 		= 'Berechtigungsgruppe';
			$menue['menue']			= $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
            $sql_where              = array('ugrp_id' => $id);
            $data['groupdata']      = $this->cp_auth->get_groups_query(FALSE, $sql_where)->result();
            $this->db->order_by('upriv_name', 'ASC');
            $data['privs']          = $this->cp_auth->get_privileges_query()->result();
            $sql_where              = array('upriv_groups_ugrp_fk' => $id);
            $data['group_privs']    = $this->cp_auth->get_user_group_privileges_query(FALSE, $sql_where)->result(); 

			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/user/editGroup_admin', $data);
			$this->load->view('backend/templates/admin/footer');	
		}
		else redirect($this->session->userdata('groupliste_redirect'), 'refresh');
	}
	
	public function delete_group($id)
	{
        $sql_where              = array('ugrp_id' => $id);
        $groupdata              = $this->cp_auth->get_groups_query(FALSE, $sql_where)->result();
		$this->admin->insert_log(str_replace('%GROUP%', $groupdata->name, lang('log_admin_deleteGroup')));
		
		$this->cp_auth->delete_group($id);
		
		redirect($this->session->userdata('groupliste_redirect'), 'refresh');	
	}
	
	public function verify_profile()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]|xss_clean|identity_unique['.$this->cp_auth->get_user_id().']');
        $this->form_validation->set_rules('initialen', 'Initialen', 'max_length[10]|xss_clean|edit_unique[user_profile.initials.'.$this->cp_auth->get_user_id().'.uprof_users_uacc_fk]');
        $this->form_validation->set_rules('vorname', 'Vorname', 'required|alpha|max_length[100]|xss_clean');
		$this->form_validation->set_rules('nachname', 'Nachname', 'required|alpha|max_length[100]|xss_clean');
        	
        if($_POST['pw_old'] != '' OR $_POST['pw_new1'] != '' OR $_POST['pw_new2'] != '') {	
    		$this->form_validation->set_rules('pw_old', 'Altes Passwort', 'required|xss_clean');		
    		$this->form_validation->set_rules('pw_new1', 'Neues Passwort', 'required|xss_clean');
    		$this->form_validation->set_rules('pw_new2', 'Passwort wiederholen', 'required|matches[pw_new1]|xss_clean');
		}
        
		return $this->form_validation->run();
	}
	
	public function verify_user($id = 0)
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		if($id > 0)
		{
			$this->form_validation->set_rules('username', 'Benutzername', 'required|alpha_numeric|max_length[20]|xss_clean|identity_unique['.$id.']');	
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]|xss_clean|identity_unique['.$id.']');	
            $this->form_validation->set_rules('initialen', 'Initialen', 'max_length[10]|xss_clean|edit_unique[user_profile.initials.'.$id.'.uprof_users_uacc_fk]');	
		}
		else
		{
			$this->form_validation->set_rules('username', 'Benutzername', 'required|alpha_numeric|max_length[20]|xss_clean|identity_unique');	
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]|xss_clean|identity_unique');
            $this->form_validation->set_rules('initialen', 'Initialen', 'max_length[10]|xss_clean|is_unique[user_profile.initials');
		}
		$this->form_validation->set_rules('vorname', 'Vorname', 'required|alpha|max_length[100]|xss_clean');
		$this->form_validation->set_rules('nachname', 'Nachname', 'required|alpha|max_length[100]|xss_clean');
		
		return $this->form_validation->run();
	}
	
	public function verify_priv($id = 0)
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		if($id > 0)
		{
			$this->form_validation->set_rules('name', 'Berechtigungsname', 'required|priv_name|max_length[20]|xss_clean|edit_unique[user_privilege.upriv_name.'.$id.'.upriv_id');					
		}
		else
		{
			$this->form_validation->set_rules('name', 'Berechtigungsname', 'required|priv_name|max_length[20]|xss_clean|is_unique[user_privilege.upriv_name');
		}
		$this->form_validation->set_rules('description', 'Beschreibung', 'required|max_length[100]|xss_clean');	
		
		return $this->form_validation->run();
	}
	
	public function verify_group($id = 0)
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		$this->form_validation->set_rules('name', 'Gruppenname', 'required|alpha_dash|max_length[20]|xss_clean');
		$this->form_validation->set_rules('description', 'Beschreibung', 'required|max_length[100]|xss_clean');	
		
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
    
    // callback für identity unique 
    public function identity_unique($identity, $id = 0)
    {
        if($id == 0)
            return $this->cp_auth->identity_available($identity, $this->cp_auth->get_user_id());
        else
            return $this->cp_auth->identity_available($identity);
    }
}
?>