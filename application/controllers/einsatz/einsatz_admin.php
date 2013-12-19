<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Einsatz_Admin
 * Controller für die Verwaltung und Anzeige der Einsätze
 * 
 * @package com.cp.feuerwehr.backend.einsatz  
 * @author Habib Pleines <habib@familiepleines.de>
 * @author Patrick Ritter <pa_ritter@arcor.de.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Einsatz_Admin extends CP_Controller {
	
	private $upload_path;

	/**
	 * Einsatz_Admin::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('einsatz/einsatz_model', 'einsatz');
		$this->load->model('einsatz/einsatz_cue_model', 'einsatz_cue');
		$this->load->model('fahrzeug/fahrzeug_model', 'fahrzeug');
		$this->load->model('admin/admin_model', 'admin');
		$this->load->model('autosuggest/autosuggest_model', 'autosuggest');
		
        // Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
		
		$this->upload_path = CONTENT_IMG_EINSATZ_UPLOAD_PATH;
	}
		
	/**
	 * Einsatz_Admin::einsatz_liste()
	 * 
	 * @param integer $year
	 * @return
	 */
	public function einsatz_liste($year = 'act')
	{ 		
        if(!$this->cp_auth->is_privileged(EINSATZ_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
		$this->session->set_userdata('einsatzliste_redirect', current_url()); 
				
		$header['title']    = 'Einsätze';		
		if($year == 'act') $year = date('Y');
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['einsatz']    = $this->einsatz->get_einsatz_list($year);
		$data['years']	    = $this->einsatz->get_einsatz_years();	
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(EINSATZ_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(EINSATZ_PRIV_DELETE);
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/einsatz/einsatzliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');	
	}
	
	/**
	 * Einsatz_Admin::create_einsatz()
	 * 
	 * @return
	 */
	public function create_einsatz()
	{		
        if(!$this->cp_auth->is_privileged(EINSATZ_PRIV_EDIT)) redirect('admin/401', 'refresh');
        
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify= $this->_verify())
			{
				$this->admin->insert_log(str_replace('%EINSATZ%', $this->input->post('einsatzname'), lang('log_admin_createEinsatz')));
				$this->einsatz->create_einsatz();
                delete_files($this->config->item('cache_path'));
			}
		}
		else
			$this->session->set_userdata('einsatzcreate_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		    = 'Einsätze';		
    		$menue['menue']	            = $this->admin->get_menue();
			$menue['submenue']		    = $this->admin->get_submenue();
            $menue['userdata']          = $this->cp_auth->cp_get_user_by_id();
			$einsatz['fahrzeuge'] 	    = $this->fahrzeug->get_fahrzeug_list_id_name(1);
			$einsatz['types'] 		    = $this->einsatz->get_einsatz_type_list();
			$einsatz['templates']	    = $this->einsatz->get_einsatz_templates();
            $einsatz['cues']            = $this->einsatz_cue->get_einsatz_cue_list();
            $autosuggest['weitere_kraefte'] = $this->autosuggest->get_values(AUTOSUGGEST_KEY_MOFO);
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/tiny_mce_inc');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
            $this->load->view('backend/einsatz/autosuggest', $autosuggest);
			$this->load->view('backend/einsatz/createEinsatz_admin', $einsatz);
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('einsatzliste_redirect'), 'refresh');
	}
	
	/**
	 * Einsatz_Admin::edit_einsatz()
	 * 
	 * @param integer $id
	 * @return
	 */
	public function edit_einsatz($id)
	{				
        if(!$this->cp_auth->is_privileged(EINSATZ_PRIV_EDIT)) redirect('admin/401', 'refresh');
        
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{				
			if($verify = $this->_verify())
			{
				$this->admin->insert_log(str_replace('%EINSATZ%', $this->input->post('einsatzname'), lang('log_admin_editEinsatz')));
				$this->einsatz->update_einsatz($id);
                delete_files($this->config->item('cache_path'));
			}
		}
		else
			$this->session->set_userdata('einsatzedit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		    = 'Einsätze';		
            $menue['menue']	            = $this->admin->get_menue();
            $menue['userdata']          = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		    = $this->admin->get_submenue();
			$einsatz['fahrzeuge'] 	    = $this->fahrzeug->get_fahrzeug_list_id_name(1);
			$einsatz['types'] 		    = $this->einsatz->get_einsatz_type_list();
			$einsatz['einsatz']		    = $this->einsatz->get_einsatz($id);
            $einsatz['cues']            = $this->einsatz_cue->get_einsatz_cue_list();
            $autosuggest['weitere_kraefte'] = $this->autosuggest->get_values(AUTOSUGGEST_KEY_MOFO);
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/tiny_mce_inc');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
            $this->load->view('backend/einsatz/autosuggest', $autosuggest);
			$this->load->view('backend/einsatz/editEinsatz_admin', $einsatz); 
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('einsatzliste_redirect'), 'refresh');	
	}

	/**
	 * Einsatz_Admin::delete_einsatz_verify()
	 * 
	 * @param integer $einsatzId
	 * @return
	 */
	public function delete_einsatz_verify($einsatzId)
    {
        if(!$this->cp_auth->is_privileged(EINSATZ_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $header['title']    = 'Einsatz l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
		
        $data = $this->einsatz->get_einsatz_raw($einsatzId);
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/einsatz/verifyDelete_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
    }
	
	/**
	 * Einsatz_Admin::delete_einsatz()
	 * 
	 * @param integer $id
	 * @return
	 */
	public function delete_einsatz($id)
	{		
        if(!$this->cp_auth->is_privileged(EINSATZ_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
		$einsatzdata = $this->einsatz->get_einsatz_raw($id);
		$this->admin->insert_log(str_replace('%EINSATZ%', $einsatzdata['einsatzName'], lang('log_admin_deleteEinsatz')));

		$this->einsatz->delete_einsatz($id);
		
		redirect($this->session->userdata('einsatzliste_redirect'), 'refresh');
	}
	
	/**
	 * Einsatz_Admin::_verify()
	 * 
	 * @return
	 */
	private function _verify()
	{		
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		$this->form_validation->set_rules('einsatzname', 'Einsatzname', 'required|max_length[255]|xss_clean');	
		$this->form_validation->set_rules('einsatzdatum_beginn', 'Einsatzbeginn (Datum)', 'required|callback_einsatzdatum_beginn'); 
		$this->form_validation->set_rules('einsatzuhrzeit_beginn', 'Einsatzbeginn (Uhrzeit)', 'required|callback_einsatzuhrzeit_beginn'); 
		$this->form_validation->set_rules('einsatzdatum_ende', 'Einsatzende (Datum)', 'required|callback_einsatzdatum_ende'); 
		$this->form_validation->set_rules('einsatzuhrzeit_ende', 'Einsatzende (Uhrzeit)', 'required|callback_einsatzuhrzeit_ende'); 
		$this->form_validation->set_rules('anzahl', 'Anzahl Einsatzkräfte', 'required|is_natural_no_zero|xss_clean'); 
		$this->form_validation->set_rules('einsatzlage', 'Lagemeldung', 'required|xss_clean');
		$this->form_validation->set_rules('einsatzbericht', 'Einsatzbericht', 'required|xss_clean');
		$this->form_validation->set_rules('einsatzort', 'Einsatzort', 'xss_clean');
		$this->form_validation->set_rules('weitereeinsatzkraefte', 'Weitere Einsatzkräfte', 'xss_clean'); 
		$this->form_validation->set_rules('einsatztyp', 'Einsatzart', 'required|is_natural_no_zero'); 
		$this->form_validation->set_rules('einsatzstichwort', 'Einsatzstichwort', 'required|is_natural_no_zero');

		return $this->form_validation->run();	
	}
    
    /**
     * Einsatz_Admin::cue_liste()
     * 
     * @return void
     */
    public function cue_liste()
    {
        if(!$this->cp_auth->is_privileged(EINSATZCUE_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
		$this->session->set_userdata('cueliste_redirect', current_url()); 
				
		$header['title']    = 'Einsatzstichwörter';	
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['cues']	    = $this->einsatz_cue->get_einsatz_cue_list();	
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(EINSATZCUE_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(EINSATZCUE_PRIV_DELETE);
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/einsatz/cueliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');        
    }
	
	/**
	 * Einsatz_Admin::create_cue()
	 * 
	 * @return
	 */
	public function create_cue()
	{		
        if(!$this->cp_auth->is_privileged(EINSATZCUE_PRIV_EDIT)) redirect('admin/401', 'refresh');
        
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify= $this->_verify_cue())
			{
				$this->admin->insert_log(str_replace('%EINSATZSTICHWORT%', $this->input->post('stichwortname'), lang('log_admin_createEinsatzStichwort')));
				$this->einsatz_cue->create_cue();
			}
		}
		else
			$this->session->set_userdata('cuecreate_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		    = 'Einsatzstichwörter';		
    		$menue['menue']	            = $this->admin->get_menue();
			$menue['submenue']		    = $this->admin->get_submenue();
            $menue['userdata']          = $this->cp_auth->cp_get_user_by_id();
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/einsatz/createCue_admin');
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('cueliste_redirect'), 'refresh');
	}
	
	/**
	 * Einsatz_Admin::edit_cue()
	 * 
	 * @param integer $id
	 * @return
	 */
	public function edit_cue($id)
	{				
        if(!$this->cp_auth->is_privileged(EINSATZCUE_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{				
			if($verify = $this->_verify_cue($id))
			{ 
				$this->admin->insert_log(str_replace('%EINSATZSTICHWORT%', $this->input->post('stichwortname'), lang('log_admin_editEinsatzStichwort')));
				$this->einsatz_cue->update_cue($id);
			}
		}
		else
			$this->session->set_userdata('cueedit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		    = 'Einsatzstichwörter';		
            $menue['menue']	            = $this->admin->get_menue();
            $menue['userdata']          = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		    = $this->admin->get_submenue();
			$cue['cue']		            = $this->einsatz_cue->get_cue($id);
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/einsatz/editCue_admin', $cue); 
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('cueliste_redirect'), 'refresh');	
	}

	/**
	 * Einsatz_Admin::delete_cue_verify()
	 * 
	 * @param integer $cueID
	 * @return
	 */
	public function delete_cue_verify($cueID)
    {
        if(!$this->cp_auth->is_privileged(EINSATZCUE_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $header['title']    = 'Einsatzstichwort l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
		
        $data['cue'] = $this->einsatz_cue->get_cue($cueID);
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/einsatz/verifyDeleteCue_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
    }
	
	/**
	 * Einsatz_Admin::delete_cue()
	 * 
	 * @param integer $id
	 * @return
	 */
	public function delete_cue($id)
	{		
        if(!$this->cp_auth->is_privileged(EINSATZCUE_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $cue = $this->einsatz_cue->get_cue($id);
		$this->admin->insert_log(str_replace('%EINSATZSTICHWORT%', $cue->name, lang('log_admin_deleteEinsatzStichwort')));

		$this->einsatz_cue->delete_cue($id);
		
		redirect($this->session->userdata('cueliste_redirect'), 'refresh');
	}
	
	/**
	 * Einsatz_Admin::_verify_cue()
	 * 
	 * @return
	 */
	private function _verify_cue($id = 0)
	{		
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
        if($id > 0)
        {
            $params = 'einsatz_cue.name.'.$id.'.cueID';
            $this->form_validation->set_rules('stichwortname', 'Stichwort', 'required|max_length[15]|edit_unique['.$params.']|xss_clean');
        }
        else
            $this->form_validation->set_rules('stichwortname', 'Stichwort', 'required|max_length[15]|is_unique[einsatz_cue.name]|xss_clean');  
		$this->form_validation->set_rules('stichwortbeschreibung','Beschreibung', 'required|max_length[255]|xss_clean');	
		$this->form_validation->set_rules('stichwortbeispiel', 'Beispiel', 'xss_clean');	
		$this->form_validation->set_rules('stichwortaao', 'AAO', 'max_length[255]|xss_clean');		

		return $this->form_validation->run();	
	}
    
    /**
     * Einsatz_Admin::mofo_liste()
     * autosuggest values for "more forces"
     * 
     * @return void
     */
    public function mofo_liste()
    {
        if(!$this->cp_auth->is_privileged(EINSATZMOFO_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
		$this->session->set_userdata('mofoliste_redirect', current_url()); 
				
		$header['title']    = 'Weitere Einsatzkräfte';	
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	= $this->admin->get_submenue();
        $order = array('value', 'ASCENDING');
        $data['mofos']      = $this->autosuggest->get_value_list(AUTOSUGGEST_KEY_MOFO, $order);
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(EINSATZMOFO_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(EINSATZMOFO_PRIV_DELETE);
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/einsatz/mofoliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');        
    }
	
	/**
	 * Einsatz_Admin::create_mofo()
     * autosuggest values for "more forces"
	 * 
	 * @return
	 */
	public function create_mofo()
	{		
        if(!$this->cp_auth->is_privileged(EINSATZMOFO_PRIV_EDIT)) redirect('admin/401', 'refresh');
        
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify= $this->_verify_mofo())
			{
				$this->autosuggest->create_value(AUTOSUGGEST_KEY_MOFO);
			}
		}
		else
			$this->session->set_userdata('mofocreate_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		    = 'Einsatzstichwörter';		
    		$menue['menue']	            = $this->admin->get_menue();
			$menue['submenue']		    = $this->admin->get_submenue();
            $menue['userdata']          = $this->cp_auth->cp_get_user_by_id();
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/einsatz/createMofo_admin');
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('mofoliste_redirect'), 'refresh');
	}
	
	/**
	 * Einsatz_Admin::edit_mofo()
     * autosuggest values for "more forces"
	 * 
	 * @param integer $id
	 * @return
	 */
	public function edit_mofo($id)
	{				
        if(!$this->cp_auth->is_privileged(EINSATZMOFO_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{				
			if($verify = $this->_verify_mofo($id))
			{ 
				$this->autosuggest->update_value($id);
			}
		}
		else
			$this->session->set_userdata('mofoedit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		    = 'Einsatzstichwörter';		
            $menue['menue']	            = $this->admin->get_menue();
            $menue['userdata']          = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		    = $this->admin->get_submenue();
			$mofo['mofo']		        = $this->autosuggest->get_value($id);
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/einsatz/editMofo_admin', $mofo); 
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('mofoliste_redirect'), 'refresh');	
	}

	/**
	 * Einsatz_Admin::delete_mofo_verify()
     * autosuggest values for "more forces"
	 * 
	 * @param integer $autosuggestID
	 * @return
	 */
	public function delete_mofo_verify($autosuggestID)
    {
        if(!$this->cp_auth->is_privileged(EINSATZMOFO_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $header['title']    = 'Vorschlagswert l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
		
        $data['mofo'] = $this->autosuggest->get_value($autosuggestID);
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/einsatz/verifyDeleteMofo_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
    }
	
	/**
	 * Einsatz_Admin::delete_mofo()
     * autosuggest values for "more forces"
	 * 
	 * @param integer $id
	 * @return
	 */
	public function delete_mofo($id)
	{		
        if(!$this->cp_auth->is_privileged(EINSATZMOFO_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
		$this->autosuggest->delete_value($id);
		
		redirect($this->session->userdata('mofoliste_redirect'), 'refresh');
	}
	
	/**
	 * Einsatz_Admin::_verify_mofo()
     * autosuggest values for "more forces"
	 * 
	 * @return
	 */
	private function _verify_mofo($id = 0)
	{		
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
			
		$this->form_validation->set_rules('value', 'Wert', 'max_length[255]|xss_clean');		

		return $this->form_validation->run();	
	}
	
	/**
	 * Einsatz_Admin::image_uploader()
	 * 
	 * @param integer $id
	 * @param integer $recursive
	 * @param string $error
	 * @return
	 */
	public function image_uploader($id, $recursive = 0, $error = null)
	{		
        if(!$this->cp_auth->is_privileged(EINSATZ_PRIV_EDIT)) redirect('admin/401', 'refresh');
        
		if($this->uri->segment($this->uri->total_segments()) == 'save' && $recursive == 0)
		{	
			if($this->input->post('img_manager') == 'img_upload')
			{ 	
                $this->load->library('image_lib');	
				$this->load->library('image_moo');
                
				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = 'jpg|png';
				$config['file_name'] = $this->image_lib->generate_img_name($id);;
                
				$this->load->library('upload', $config);
				
				if(!$this->upload->do_upload('upload_image'))
				{
					$error = $this->upload->display_errors();
				}
				else
				{
					$upload_data = $this->upload->data();			
					$filename = $upload_data['file_name'];
					$raw_name = $upload_data['raw_name'];
					$ext = $upload_data['file_ext'];
					if($upload_data['image_width'] > $upload_data['image_height'])
					{
						$width_t = 160;
						$height_t = 120;			
						$width = 1024;
						$height = 768;
					}
					else
					{
						$width_t = 120;
						$height_t = 160;			
						$width = 768; 
						$height = 1024; 		
					}
					$thumb = $this->image_lib->generate_img_name($id);
					$this->image_moo->set_jpeg_quality(90);
					// Bild verkleinern 
					$this->image_moo->load($this->upload_path.$filename)->resize($width, $height)->save($this->upload_path.$filename, true);
					// Wasserzeichen hinzufügen
					$this->image_moo->make_watermark_text("(c) Feuerwehr Bad Soden am Taunus", "system/fonts/texb.ttf", 8, "#FFFFFF")->watermark(1)->save($this->upload_path.$filename, true);
					// Thumbnail erstellen
					$this->image_moo->resize($width_t, $height_t)->save($this->upload_path.$thumb.$ext, true);
					
					$this->einsatz->insert_image($id, $this->input->post('alt'), $filename, $thumb.$ext, str_replace('.', '', $ext), $this->input->post('photographer_upload'));
				}
			}
			else if($this->input->post('img_manager') == 'img_edit')
			{
				if($this->input->post('image_submit') == 'img_save')
					$this->_update_image_details();
				else if($this->input->post('image_submit') == 'img_delete')
					$this->_image_delete();
			}
				
			// Rekursion, um die Liste wieder anzuzeigen
			$this->image_uploader($id, 1, $error);
		}
		else
		{			
			if($this->uri->segment($this->uri->total_segments()) != 'save') $this->session->set_userdata('einsatzimage_submit', current_url());
			
			$header['title'] 		= 'Einsatz - Image Uploader';
            $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
			$einsatz['einsatz']		= $this->einsatz->get_einsatz_raw($id);
			$einsatz['images']		= $this->einsatz->get_images($id);
			$einsatz['error']		= $error;
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/tiny_mce_inc');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/einsatz/image_upload', $einsatz); 
			$this->load->view('backend/templates/admin/footer');
		}
	}
	
	/**
	 * Einsatz_Admin::_image_delete()
	 * 
	 * @return
	 */
	private function _image_delete()
	{
		$this->load->helper('file');

		$this->einsatz->delete_image($this->input->post('img_id'));
	}
	
	/**
	 * Einsatz_Admin::_update_image_details()
	 * 
	 * @return
	 */
	private function _update_image_details()
	{
		$this->einsatz->update_image($this->input->post('img_id'), $this->input->post('img_alt'), $this->input->post('photographer'));
	}
	
	/**
	 * Einsatz_Admin::switch_online_state()
	 * 
	 * @param integer $id
	 * @param integer $state
	 * @param integer $year
	 * @return
	 */
	public function switch_online_state($id, $state, $year)
	{ 		
        if(!$this->cp_auth->is_privileged(EINSATZ_PRIV_EDIT)) redirect('admin/401', 'refresh');
        
		if($state == 1) $online = 0; else $online = 1;
		
		$this->einsatz->switch_online_state($id, $online);
		redirect($this->session->userdata('einsatzliste_redirect'), 'refresh');
	}
	
	/**
	 * Einsatz_Admin::json_get_einsatz_template()
     * JSON call get_template für Einsatzerstellung
	 * 
	 * @param integer $id
	 * @return
	 */
	public function json_get_einsatz_template($id)
	{
		$template = $this->einsatz->get_einsatz_templates($id);
		//build the JSON array for return
		$json = array(array('field' => 'einsatzname', 
							'value' => $template[$id]['einsatz_name']), 
					  array('field' => 'einsatzlage', 
							'value' => $template[$id]['einsatz_lage']),
					  array('field' => 'einsatzart', 
							'value' => $template[$id]['einsatz_art']), 
					  array('field' => 'einsatzfahrzeug', 
							'value' => $template[$id]['einsatz_fahrzeug'])
							);
		echo json_encode($json );
	}
	
	/**
	 * Einsatz_Admin::einsatzdatum_beginn()
     * callback für Einsatzdatum
	 * 
	 * @param string $datum
	 * @return
	 */
	public function einsatzdatum_beginn($datum)
	{
		$this->form_validation->set_message('einsatzdatum_beginn', 'Bitte einen gültigen %s angeben.');
		return cp_is_valid_eng_date($datum);		
	}
	
	/**
	 * Einsatz_Admin::einsatzdatum_ende()
     * callback für Einsatzdatum
	 * 
	 * @param string $datum
	 * @return
	 */
	public function einsatzdatum_ende($datum)
	{
		$this->form_validation->set_message('einsatzdatum_ende', 'Bitte ein gültiges %s angeben.');
		return cp_is_valid_eng_date($datum);		
	}
	
	/**
	 * Einsatz_Admin::einsatzuhrzeit_beginn()
     * callback für Einsatzbeginn
	 * 
	 * @param string $zeit
	 * @return
	 */
	public function einsatzuhrzeit_beginn($zeit)
	{
		$this->form_validation->set_message('einsatzuhrzeit_beginn', 'Bitte einen gültigen %s angeben.');
		return cp_is_valid_time($zeit);	
	}
	
	/**
	 * Einsatz_Admin::einsatzuhrzeit_ende()
     * callback für Einsatzende
	 * 
	 * @param string $zeit
	 * @return
	 */
	public function einsatzuhrzeit_ende($zeit)
	{
		$this->form_validation->set_message('einsatzuhrzeit_ende', 'Bitte ein gültiges %s angeben.');
		return cp_is_valid_time($zeit);
	}
}
/* End of file einsatz.php */
/* Location: ./application/controllers/einsatz/einsatz_admin.php */