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
    
    public function create_mitglied() {
        if(!$this->cp_auth->is_privileged(MANNSCHAFT_PRIV_EDIT)) redirect('admin/401', 'refresh');
        
        if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify= $this->_verify())
			{
				$this->admin->insert_log(str_replace('%MITGLIED%', $this->input->post('vorname')." ".$this->input->post('name'), lang('log_admin_createMitglied')));
				$this->mannschaft->create_mitglied();
                delete_files($this->config->item('cache_path'));
			}
		}
		else
			$this->session->set_userdata('mitgliedcreate_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		    = 'Mitglieder';		
    		$menue['menue']	            = $this->admin->get_menue();
			$menue['submenue']		    = $this->admin->get_submenue();
            $menue['userdata']          = $this->cp_auth->cp_get_user_by_id();
            $mitglied['dienstgrade']    = $this->dienstgrad->get_dienstgrad_liste();
            $mitglied['funktionen']     = $this->funktion->get_funktion_liste();
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/mannschaft/createMitglied_admin', $mitglied);
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('mannschaftliste_redirect'), 'refresh');
    }
    
	public function edit_mitglied($id)
	{				
        if(!$this->cp_auth->is_privileged(MANNSCHAFT_PRIV_EDIT)) redirect('admin/401', 'refresh');
        
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{				
			if($verify = $this->_verify())
			{
				$this->admin->insert_log(str_replace('%MITGLIED%', $this->input->post('vorname')." ".$this->input->post('name'), lang('log_admin_editMitglied')));
				$this->mannschaft->update_mitglied($id);
                delete_files($this->config->item('cache_path'));
			}
		}
		else
			$this->session->set_userdata('mitgliededit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		    = 'Mitglied';		
            $menue['menue']	            = $this->admin->get_menue();
            $menue['userdata']          = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		    = $this->admin->get_submenue();
            $mitglied['dienstgrade']    = $this->dienstgrad->get_dienstgrad_liste();
            $mitglied['funktionen']     = $this->funktion->get_funktion_liste();
            $mitglied['teams']          = $this->team->get_team_liste();
            $mitglied['mitglied']       = $this->mannschaft->get_mitglied($id);
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/mannschaft/editMitglied_admin', $mitglied); 
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('mannschaftliste_redirect'), 'refresh');	
	}
    
	public function delete_mitglied_verify($id)
    {
        if(!$this->cp_auth->is_privileged(MANNSCHAFT_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $header['title']    = 'Mitglied l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
		
        $data['mitglied'] = $this->mannschaft->get_mitglied($id);
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/mannschaft/verifyDelete_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
    }
    
	public function delete_mitglied($id)
	{		
        if(!$this->cp_auth->is_privileged(MANNSCHAFT_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
		$mitglieddata = $this->mannschaft->get_mitglied($id);
		$this->admin->insert_log(str_replace('%MITGLIED%', $mitglieddata->vorname." ".$mitglieddata->name, lang('log_admin_deleteMitglied')));

		$this->mannschaft->delete_mitglied($id);
        delete_files($this->config->item('cache_path'));
		
		redirect($this->session->userdata('mannschaftliste_redirect'), 'refresh');
	}
    
	private function _verify()
	{		
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		$this->form_validation->set_rules('name', 'Nachname', 'required|max_length[100]|xss_clean');	
		$this->form_validation->set_rules('vorname', 'Vorname', 'required|max_length[100]|xss_clean'); 
		$this->form_validation->set_rules('geburtstag', 'Geburtsdatum', 'xss_clean'); 
		$this->form_validation->set_rules('beruf', 'Beruf', 'xss_clean'); 
		$this->form_validation->set_rules('geschlecht', 'Geschlecht', 'xss_clean');
		$this->form_validation->set_rules('dienstgradID', 'Dienstgrad', 'required|xss_clean');
		$this->form_validation->set_rules('funktionID', 'Funktion', 'required|xss_clean');
		$this->form_validation->set_rules('show_img', 'Dienstgrad', 'xss_clean');
		$this->form_validation->set_rules('show_beruf', 'Dienstgrad', 'xss_clean');
		$this->form_validation->set_rules('show_geburtstag', 'Dienstgrad', 'xss_clean');
        
		return $this->form_validation->run();	
	}
	public function image_uploader($id, $error = null)
	{		
        if(!$this->cp_auth->is_privileged(MANNSCHAFT_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{
			$this->load->library('image_lib');	
			$this->load->library('image_moo');
                
			$config['upload_path'] = $this->upload_path;
			$config['allowed_types'] = 'jpg|png';
			$config['file_name'] = $this->image_lib->generate_img_name($id);
                
			$this->load->library('upload', $config);		
				
			if(!$this->upload->do_upload('upload_image'))
			{
				$error = $this->upload->display_errors();
			}
			else
			{
				$upload_data = $this->upload->data();                         			
				$filename = $upload_data['file_name'];
				$width = 500;
				$height = 270;		
                    
				$this->load->library('image_moo');
				$this->image_moo->set_jpeg_quality(100);
				// Bild verkleinern 
				$this->image_moo->load($this->upload_path.$filename)->resize($width, $height)->save($this->upload_path.$filename, true);
				// Wasserzeichen hinzufügen
				$this->image_moo->make_watermark_text("(c) Feuerwehr Bad Soden am Taunus", "system/fonts/texb.ttf", 8, "#FFFFFF")->watermark(1)->save($this->upload_path.$filename, true);
                    
                if($this->image_moo->errors) echo $this->image_moo->display_errors();
                    
			    $this->mannschaft->update_image($id, $filename);
                delete_files($this->config->item('cache_path'));
                redirect($this->session->userdata('mannschaftliste_redirect'), 'refresh');
			}
		}
		else
		{			
			if($this->uri->segment($this->uri->total_segments()) != 'save') $this->session->set_userdata('mitgliedimage_submit', current_url());
			
			$header['title'] 		= 'Fahrzeug - Image Uploader';	
		    $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
			$mitglied['mitglied']	= $this->mannschaft->get_mitglied($id);
			$fahrzeug['error']		= $error;
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/tiny_mce_inc');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/mannschaft/image_upload', $mitglied); 
			$this->load->view('backend/templates/admin/footer');
		}
	}
    
	public function switch_online_state($id, $state)
	{ 		
        if(!$this->cp_auth->is_privileged(MANNSCHAFT_PRIV_EDIT)) redirect('admin/401', 'refresh');
        
		if($state == 1) $online = 0; else $online = 1;
		
		$this->mannschaft->switch_online_state($id, $online);
                delete_files($this->config->item('cache_path'));
		redirect($this->session->userdata('mannschaftliste_redirect'), 'refresh');
	}
}

/* End of file mannschaft_admin.php */
/* Location: ./application/controllers/mannschaft/mannschaft_admin.php */