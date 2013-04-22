<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pages Controller
 *
 * Controller für die Verwaltung und Anzeige der Inhaltsseiten
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.content
 **/

class Pages_Admin extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('pages/pages_model', 'pages');
		$this->load->model('admin/admin_model', 'admin');
		
		// CP Auth Konfiguration
		$this->cpauth->init('BACKEND');
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
	}
	
	public function pages_liste()
	{
		$this->session->set_userdata('pagesliste_redirect', current_url()); 		
		
		$header['title'] = 'Seiten';		
		$menue['menue']	= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['page'] = $this->pages->get_pages();
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/styles');
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/pages/pagesliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');	
	}
}

?>