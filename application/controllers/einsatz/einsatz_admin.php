<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Einsatz Controller
 *
 * Controller für die Verwaltung und Anzeige der Einsätze
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.einsatz
 **/

class Einsatz_Admin extends CI_Controller {
	
	private $upload_path;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('einsatz/einsatz_model', 'einsatz');
		$this->load->model('fahrzeug/fahrzeug_model', 'fahrzeug');
		$this->load->model('admin/admin_model', 'admin');
		
		// CP Auth Konfiguration
		$this->cpauth->init('BACKEND');
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
		$this->upload_path = 'images/content/einsaetze/';
	}
		
	public function einsatz_liste($year = 'act')
	{ 		
		$this->session->set_userdata('einsatzliste_redirect', current_url()); 
				
		$header['title'] = 'Einsätze';		
		if($year == 'act') $year = date('Y');
		$menue['menue']	= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['einsatz'] = $this->einsatz->get_einsatz_list($year);
		$data['years']	 = $this->einsatz->get_einsatz_years();	
	
		$this->load->view('templates/admin/header', $header);
		$this->load->view('templates/admin/styles');
		$this->load->view('einsatz/styles_einsatz');
		$this->load->view('templates/admin/menue', $menue);	
		$this->load->view('templates/admin/submenue', $menue);	
		$this->load->view('templates/admin/jquery-tablesorter-cp');
		$this->load->view('einsatz/einsatzliste_admin', $data);
		$this->load->view('templates/admin/footer');	
	}
	
	public function create_einsatz()
	{		
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify= $this->verify())
			{
				$this->admin->insert_log(str_replace('%EINSATZ%', $this->input->post('einsatzname'), lang('log_admin_createEinsatz')));
				$this->einsatz->create_einsatz();
			}
		}
		else
			$this->session->set_userdata('einsatzcreate_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'Einsätze';		
			$menue['menue']			= $this->admin->get_menue();
			$menue['submenue']		= $this->admin->get_submenue();
			$einsatz['fahrzeuge'] 	= $this->fahrzeug->get_fahrzeug_list_id_name(1);
			$einsatz['types'] 		= $this->einsatz->get_einsatz_type_list();
			$einsatz['templates']	= $this->einsatz->get_einsatz_templates();
		
			$this->load->view('templates/admin/header', $header);
			$this->load->view('templates/admin/styles');
			$this->load->view('einsatz/styles_einsatz');
			$this->load->view('templates/admin/menue', $menue);	
			$this->load->view('templates/admin/submenue', $menue);
			$this->load->view('einsatz/createEinsatz_admin', $einsatz);
			$this->load->view('einsatz/tiny_mce_inc');
			$this->load->view('templates/admin/footer');
		}
		else redirect($this->session->userdata('einsatzliste_redirect'), 'refresh');
	}
	
	public function edit_einsatz($id)
	{				
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{				
			if($verify = $this->verify())
			{
				$this->admin->insert_log(str_replace('%EINSATZ%', $this->input->post('einsatzname'), lang('log_admin_editEinsatz')));
				$this->einsatz->update_einsatz($id);
			}
		}
		else
			$this->session->set_userdata('einsatzedit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'Einsätze';		
			$menue['menue']			= $this->admin->get_menue();
			$menue['submenue']		= $this->admin->get_submenue();
			$einsatz['fahrzeuge'] 	= $this->fahrzeug->get_fahrzeug_list_id_name(1);
			$einsatz['types'] 		= $this->einsatz->get_einsatz_type_list();
			$einsatz['einsatz']		= $this->einsatz->get_einsatz($id);
		
			$this->load->view('templates/admin/header', $header);
			$this->load->view('templates/admin/styles');
			$this->load->view('einsatz/styles_einsatz');
			$this->load->view('templates/admin/menue', $menue);	
			$this->load->view('templates/admin/submenue', $menue);
			$this->load->view('einsatz/editEinsatz_admin', $einsatz); 
			$this->load->view('einsatz/tiny_mce_inc');
			$this->load->view('templates/admin/footer');
		}
		else redirect($this->session->userdata('einsatzliste_redirect'), 'refresh');	
	}
	
	public function delete_einsatz($id)
	{		
		$einsatzdata = $this->einsatz->get_einsatz($id);
		$this->admin->insert_log(str_replace('%EINSATZ%', $einsatzdata['einsatzName'], lang('log_admin_deleteEinsatz')));

		$this->einsatz->delete_einsatz($id);
		
		redirect($this->session->userdata('einsatzliste_redirect'), 'refresh');
	}
	
	private function verify()
	{		
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		$this->form_validation->set_rules('einsatzname', 'Einsatzname', 'required|max_length[255]|xss_clean');	
		$this->form_validation->set_rules('einsatzdatum', 'Einsatzdatum', 'required|callback_einsatzdatum'); 
		$this->form_validation->set_rules('einsatzbeginn', 'Einsatzbeginn', 'required|callback_einsatzbeginn'); 
		$this->form_validation->set_rules('einsatzende', 'Einsatzende', 'required|callback_einsatzende'); 
		$this->form_validation->set_rules('einsatzlage', 'Einsatzlage', 'required|xss_clean');
		$this->form_validation->set_rules('einsatzgeschehen', 'Einsatzgeschehen', 'required|xss_clean');
		$this->form_validation->set_rules('weitereeinsatzkraefte', 'Weitere Kräfte', 'xss_clean'); 
		$this->form_validation->set_rules('anzahl', 'Anzahl Einsatzkräfte', 'required|is_natural_no_zero|xss_clean');

		return $this->form_validation->run();	
	}
	
	public function image_uploader($id, $recursive = 0, $error = null)
	{		
		if($this->uri->segment($this->uri->total_segments()) == 'save' && $recursive == 0)
		{	
			if($this->input->post('img_manager') == 'img_upload')
			{ 
				$config['upload_path'] = $this->upload_path;
				$config['allowed_types'] = 'jpg|png';
				$config['encrypt_name'] = TRUE;
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
					$thumb = $this->cp_auth->cp_generate_hash($id.$this->cp_auth->cp_generate_salt());
					$this->load->library('image_moo');
					$this->image_moo->set_jpeg_quality(90);
					// Bild verkleinern 
					$this->image_moo->load($this->upload_path.$filename)->resize($width, $height)->save($this->upload_path.$filename, true);
					// Wasserzeichen hinzufügen
					$this->image_moo->make_watermark_text("(c) Feuerwehr Bad Soden am Taunus", "system/fonts/texb.ttf", 8, "#FFFFFF")->watermark(1)->save($this->upload_path.$filename, true);
					// Thumbnail erstellen
					$this->image_moo->resize($width_t, $height_t)->save($this->upload_path.$thumb.$ext, true);
					
					$this->einsatz->insert_image($id, $this->input->post('alt'), $filename, $thumb.$ext, str_replace('.', '', $ext));
				}
			}
			else if($this->input->post('img_manager') == 'img_edit')
			{
				if($this->input->post('image_submit') == 'img_save')
					$this->update_image_details();
				else if($this->input->post('image_submit') == 'img_delete')
					$this->image_delete();
			}
				
			// Rekursion, um die Liste wieder anzuzeigen
			$this->image_uploader($id, 1, $error);
		}
		else
		{			
			if($this->uri->segment($this->uri->total_segments()) != 'save') $this->session->set_userdata('einsatzimage_submit', current_url());
			
			$header['title'] 		= 'Einsatz - Image Uploader';		
			$menue['menue']			= $this->admin->get_menue();
			$menue['submenue']		= $this->admin->get_submenue();
			$einsatz['einsatz']		= $this->einsatz->get_einsatz($id);
			$einsatz['images']		= $this->einsatz->get_images($id);
			$einsatz['error']		= $error;
		
			$this->load->view('templates/admin/header', $header);
			$this->load->view('templates/admin/styles');
			$this->load->view('einsatz/styles_einsatz');
			$this->load->view('templates/admin/menue', $menue);	
			$this->load->view('templates/admin/submenue', $menue);
			$this->load->view('einsatz/image_upload', $einsatz); 
			$this->load->view('einsatz/tiny_mce_inc');
			$this->load->view('templates/admin/footer');
		}
	}
	
	private function image_delete()
	{
		$this->load->helper('file');

		$this->einsatz->delete_image($this->input->post('img_id'));
	}
	
	private function update_image_details()
	{
		$this->einsatz->update_image($this->input->post('img_id'), $this->input->post('img_alt'));
	}
	
	public function switch_online_state($id, $state, $year)
	{ 		
		if($state == 1) $online = 0; else $online = 1;
		
		$this->einsatz->switch_online_state($id, $online);
		redirect($this->session->userdata('einsatzliste_redirect'), 'refresh');
	}
	
	// JSON call get_template für Einsatzerstellung
	public function json_get_einsatz_template($id)
	{
		$template = $this->einsatz->get_einsatz_templates($id);
		//build the JSON array for return
		$json = array(array('field' => 'einsatzname', 
							'value' => $template[$id]['einsatz_name']), 
					  array('field' => 'einsatzlage', 
							'value' => $template[$id]['einsatz_lage']),
					  array('field' => 'einsatzgeschehen', 
							'value' => $template[$id]['einsatz_geschehen']),
					  array('field' => 'einsatzart', 
							'value' => $template[$id]['einsatz_art']), 
					  array('field' => 'einsatzfahrzeug', 
							'value' => $template[$id]['einsatz_fahrzeug'])
							);
		echo json_encode($json );
	}
	
	// callback für Einsatzdatum
	public function einsatzdatum($datum)
	{
		$this->form_validation->set_message('einsatzdatum', 'Bitte ein gültiges %s angeben.');
		return cp_is_valid_date($datum);		
	}
	
	// callback für Einsatzbeginn
	public function einsatzbeginn($zeit)
	{
		$this->form_validation->set_message('einsatzbeginn', 'Bitte einen gültigen %s angeben.');
		return cp_is_valid_time($zeit);	
	}
	
	// callback für Einsatzende
	public function einsatzende($zeit)
	{
		$this->form_validation->set_message('einsatzende', 'Bitte ein gültiges %s angeben.');
		return cp_is_valid_time($zeit);
	}
}
?>