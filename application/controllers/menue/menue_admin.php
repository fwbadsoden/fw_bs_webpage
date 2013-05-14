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

class Menue_Admin extends CI_Controller {
	
	private $area;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('admin/admin_model', 'admin');
		$this->load->model('menue/menue_model', 'menue');
		
		// CP Auth Konfiguration für Admin Controller
		$this->cpauth->init('BACKEND');
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
		// Menübereich setzen
		if(!strpos(uri_string(), 'backend')) $this->area = 'frontend';
		else $this->area = 'backend';
		
		$this->session->set_flashdata('redirect', current_url()); 
	}
	
	public function menue_liste()
	{
		$this->session->set_userdata('menueliste_redirect', current_url()); 	
	 	
		$header['title'] = 'Menü';		
		$menue['menue']	= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['areaUC'] = ucfirst($this->area);
		$data['area'] = $this->area;
		$data['menue_arr'] = $this->menue->get_menue_list('all');
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/menue/menueliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');
	}
	
	public function create_menue()
	{
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
			$header['title'] = 'Menü';		
			$menue['menue']	= $this->admin->get_menue();
			$menue['submenue']	= $this->admin->get_submenue();
			$data['menue_arr'] = $this->menue->get_menue_list();
			$data['mode'] = 'create';
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);	
			$this->load->view('backend/menue/createEditMenue_admin', $data);
			$this->load->view('backend/templates/admin/footer');	
		}
		else redirect($this->session->userdata('menueliste_redirect'), 'refresh');
	}
	
	public function edit_menue($id)
	{
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
			$header['title'] = 'Menü';		
			$menue['menue']	= $this->admin->get_menue();
			$menue['submenue']	= $this->admin->get_submenue();
			$data['menue_arr'] = $this->menue->get_menue_list();
			$data['mode'] = 'edit';
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);	
			$this->load->view('backend/menue/createEditMenue_admin', $data);
			$this->load->view('backend/templates/admin/footer');	
		}
		else redirect($this->session->userdata('menueliste_redirect'), 'refresh');
	}
	
	public function delete_menue($id)
	{
		$this->menue->delete_menue($id);		
		redirect($this->session->userdata('menueliste_redirect'), 'refresh');
	}
	
	public function change_order($dir, $id)
	{
		$this->menue->change_order($dir, $id);		
		redirect($this->session->userdata('menueliste_redirect'), 'refresh');	
	}
	
	public function switch_online_state($id, $online)
	{
		$this->menue->switch_online_state($id, $online);
		redirect($this->session->userdata('menueliste_redirect'), 'refresh');		
	}
}
?>