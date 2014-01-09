<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Mannschaft_Admin
 * Controller für die Verwaltung und Anzeige der Mannschaft
 * 
 * @package com.cp.feuerwehr.backend.mannschaft  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Mannschaft_Admin extends CP_Controller {
	
	private $upload_path;

	/**
	 * Mannschaft_Admin::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('mannschaft/mannschaft_model', 'mannschaft');
		$this->load->model('mannschaft/dienstgrad_model', 'dienstgrad');
		$this->load->model('mannschaft/team_model', 'team');
		$this->load->model('mannschaft/funktion_model', 'funktion');
		$this->load->model('mannschaft/abteilung_model', 'abteilung');
		$this->load->model('admin/admin_model', 'admin');
		
		// Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
		
		$this->upload_path = CONTENT_IMG_MANNSCHAFT_UPLOAD_PATH;
	}
        
    public function mannschaft_liste()
    {
        if(!$this->cp_auth->is_privileged(MANNSCHAFT_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
		$this->session->set_userdata('mannschaftliste_redirect', current_url()); 
				
		$header['title']      = 'Mannschaft';		
		$menue['menue']	      = $this->admin->get_menue();
        $menue['userdata']    = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	  = $this->admin->get_submenue();
        $data['mannschaft']   = $this->mannschaft->get_mannschaft_liste();
        $data['dienstgrade']  = $this->dienstgrad->get_dienstgrad_liste();
        $data['funktionen']   = $this->funktion->get_funktion_liste();
        $data['abteilungen']  = $this->abteilung->get_abteilung_liste();
        $data['teams']        = $this->team->get_team_liste();
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(MANNSCHAFT_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(MANNSCHAFT_PRIV_DELETE);
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/mannschaft/mannschaftliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');
    }
}

/* End of file mannschaft_admin.php */
/* Location: ./application/controllers/mannschaft/mannschaft_admin.php */