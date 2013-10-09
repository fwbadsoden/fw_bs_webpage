<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Menue Controller
 *
 * Controller für die Menüadministration
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.admin
 **/

class Menue_Admin extends CP_Controller {
	
	private $area;

	/**
	 * Menue_Admin::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('admin/admin_model', 'admin');
		$this->load->model('menue/menue_model', 'menue');
		
		// Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
		
		// Menübereich setzen
		if(!strpos(uri_string(), 'backend')) $this->area = 'frontend';
		else $this->area = 'backend';
		
		$this->session->set_flashdata('redirect', current_url()); 
	}
	
	/**
	 * Menue_Admin::menue_liste()
	 * 
	 * @return
	 */
	public function menue_liste()
	{
        if(!$this->cp_auth->is_privileged(MENUE_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
		$this->session->set_userdata('menueliste_redirect', current_url()); 	
	 	
		$header['title']    = 'Menü';		
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['areaUC']     = ucfirst($this->area);
		$data['area']       = $this->area;
		$data['menue_arr']  = $this->menue->get_menue_list('all');
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(MENUE_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(MENUE_PRIV_DELETE);   
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/menue/menueliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');
	}
	
	/**
	 * Menue_Admin::create_menue()
	 * 
	 * @return
	 */
	public function create_menue()
	{
        if(!$this->cp_auth->is_privileged(MENUE_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify = $this->verify())
			{
				$this->menue->create_menue();
			}
		}
		else
			$this->session->set_userdata('menuecreateedit_submit', current_url());	
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{					
			$header['title']     = 'Menü';		
		    $menue['menue']	     = $this->admin->get_menue();
            $menue['userdata']   = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']	 = $this->admin->get_submenue();
			$data['menue_arr']   = $this->menue->get_menue_list();
			$data['mode']        = 'create';
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);	
			$this->load->view('backend/menue/createEditMenue_admin', $data);
			$this->load->view('backend/templates/admin/footer');	
		}
		else redirect($this->session->userdata('menueliste_redirect'), 'refresh');
	}
	
	/**
	 * Menue_Admin::edit_menue()
	 * 
	 * @param mixed $id
	 * @return
	 */
	public function edit_menue($id)
	{
        if(!$this->cp_auth->is_privileged(MENUE_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify = $this->verify())
			{
				$this->menue->update_menue();
			}
		}
		else
			$this->session->set_userdata('menuecreateedit_submit', current_url());	
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{					
			$header['title']     = 'Menü';		
		    $menue['menue']	     = $this->admin->get_menue();
            $menue['userdata']   = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']	 = $this->admin->get_submenue();
			$data['menue_arr']   = $this->menue->get_menue_list();
			$data['mode']        = 'edit';
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);	
			$this->load->view('backend/menue/createEditMenue_admin', $data);
			$this->load->view('backend/templates/admin/footer');	
		}
		else redirect($this->session->userdata('menueliste_redirect'), 'refresh');
	}
    
    /**
     * Menue_Admin::delete_menue_verify()
     * 
     * @param mixed $id
     * @return
     */
    public function delete_menue_verify($id)
    {
        $header['title']    = 'Menüeintrag l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
	    $data['menue_arr']  = $this->menue->get_menue_list();
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/menue/verifyDelete_admin', $data);
    	$this->load->view('backend/templates/admin/footer');        
    }
	
	/**
	 * Menue_Admin::delete_menue()
	 * 
	 * @param mixed $id
	 * @return
	 */
	public function delete_menue($id)
	{
        if(!$this->cp_auth->is_privileged(MENUE_PRIV_DELETE)) redirect('admin/401', 'refresh');
		$this->menue->delete_menue($id);		
		redirect($this->session->userdata('menueliste_redirect'), 'refresh');
	}
	
	/**
	 * Menue_Admin::change_order()
	 * 
	 * @param mixed $dir
	 * @param mixed $id
	 * @return
	 */
	public function change_order($dir, $id)
	{
        if(!$this->cp_auth->is_privileged(MENUE_PRIV_EDIT)) redirect('admin/401', 'refresh');
		$this->menue->change_order($dir, $id);		
		redirect($this->session->userdata('menueliste_redirect'), 'refresh');	
	}
	
	/**
	 * Menue_Admin::switch_online_state()
	 * 
	 * @param mixed $id
	 * @param mixed $online
	 * @return
	 */
	public function switch_online_state($id, $online)
	{
        if(!$this->cp_auth->is_privileged(MENUE_PRIV_EDIT)) redirect('admin/401', 'refresh');
		$this->menue->switch_online_state($id, $online);
		redirect($this->session->userdata('menueliste_redirect'), 'refresh');		
	}
}
?>