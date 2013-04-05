<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fahrzeug Controller
 *
 * Controller für die Verwaltung und Anzeige der Fahrzeuge
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.fahrzeug
 **/

class Fahrzeug_Admin extends CI_Controller {
	
	private $upload_path;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('fahrzeug/fahrzeug_model', 'fahrzeug');
		$this->load->model('admin/admin_model', 'admin');
		
		// CP Auth Konfiguration
		$this->cpauth->init('BACKEND');
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
		$this->upload_path = 'images/content/fahrzeuge/';
	}
	
	public function fahrzeug_liste()
	{
		$this->session->set_userdata('fahrzeugliste_redirect', current_url()); 
				
		$header['title'] = 'Fahrzeuge';		
		$menue['menue']	= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['fahrzeug'] = $this->fahrzeug->get_fahrzeug_list();
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/styles');
		$this->load->view('backend/fahrzeug/styles_fahrzeug');
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/fahrzeug/fahrzeugliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');
	}
	
	public function create_fahrzeug()
	{
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify = $this->verify())
			{
				$this->admin->insert_log(str_replace('%FAHRZEUG%', $this->input->post('fahrzeugName'), lang('log_admin_createFahrzeug')));
				$this->fahrzeug->create_fahrzeug();
			}
		}
		else
			$this->session->set_userdata('fahrzeugcreate_submit', current_url());	
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'Fahrzeuge';		
			$menue['menue']			= $this->admin->get_menue();
			$menue['submenue']		= $this->admin->get_submenue();
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/styles');
			$this->load->view('backend/fahrzeug/styles_fahrzeug');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/fahrzeug/createFahrzeug_admin');
			$this->load->view('backend/fahrzeug/tiny_mce_inc');
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('fahrzeugliste_redirect'), 'refresh');
	}
	
	public function edit_fahrzeug($id)
	{
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify = $this->verify())
			{
				$this->admin->insert_log(str_replace('%FAHRZEUG%', $this->input->post('fahrzeugName'), lang('log_admin_editFahrzeug')));
				$this->fahrzeug->update_fahrzeug($id);
			}
		}
		else
			$this->session->set_userdata('fahrzeugedit_submit', current_url());	
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'Fahrzeuge';		
			$menue['menue']			= $this->admin->get_menue();
			$menue['submenue']		= $this->admin->get_submenue();
			$fahrzeug['fahrzeug'] 	= $this->fahrzeug->get_fahrzeug($id);
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/styles');
			$this->load->view('backend/fahrzeug/styles_fahrzeug');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/fahrzeug/editFahrzeug_admin', $fahrzeug);
			$this->load->view('backend/fahrzeug/tiny_mce_inc');
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('fahrzeugliste_redirect'), 'refresh');		
	}
	
	public function delete_fahrzeug($id)
	{
		$fahrzeugdata = $this->fahrzeug->get_fahrzeug($id);
		$this->admin->insert_log(str_replace('%FAHRZEUG%', $fahrzeugdata['fahrzeugName'], lang('log_admin_deleteFahrzeug')));
		
		$this->fahrzeug->delete_fahrzeug($id);

		redirect($this->session->userdata('fahrzeugliste_redirect'), 'refresh');
	}
	
	private function verify()
	{		
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		$this->form_validation->set_rules('fahrzeugname', 'Fahrzeugname', 'required|max_length[255]|xss_clean');	
		$this->form_validation->set_rules('fahrzeugprefix', 'Präfix Funkrufname', 'required|max_length[100]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugrufname', 'Fahrzeugrufname', 'required|max_length[10]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugtext', 'Fahrzeugbeschreibung', 'required|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugbesatzung', 'Fahrzeugbesatzung', 'max_length[3]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeughersteller', 'Fahrzeughersteller', 'required|max_length[50]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugaufbau', 'Fahrzeugaufbau', 'max_length[50]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugleistungkw', 'Fahrzeugleistung in KW', 'is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('fahrzeugleistungps', 'Fahrzeugleistung in PS', 'is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('fahrzeughoehe', 'Fahrzeughöhe', 'decimal|xss_clean');
		$this->form_validation->set_rules('fahrzeugbreite', 'Fahrzeugbreite', 'decimal|xss_clean');
		$this->form_validation->set_rules('fahrzeuglaenge', 'Fahrzeuglänge', 'decimal|xss_clean');
		$this->form_validation->set_rules('fahrzeugleermasse', 'Fahrzeug-Leermasse', 'decimal|xss_clean');
		$this->form_validation->set_rules('fahrzeuggesamtmasse', 'Fahrzeug-Gesamtmasse', 'decimal|xss_clean');

		return $this->form_validation->run();	
	}
	
	public function image_uploader($id, $recursive = 0, $error = null)
	{		
		if($this->uri->segment($this->uri->total_segments()) == 'save' && $recursive == 0)
		{	
			if($this->input->post('img_manager') == 'img_upload')
			{ 
				echo "Schritt 1 - ";
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
					
					$this->fahrzeug->insert_image($id, $this->input->post('alt'), $filename, $thumb.$ext, str_replace('.', '', $ext));
				}
			}
			else if($this->input->post('img_manager') == 'img_edit')
			{
				echo "Schritt 2 - ";
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
				echo "Schritt 3 - ";
			if($this->uri->segment($this->uri->total_segments()) != 'save') $this->session->set_userdata('fahrzeugimage_submit', current_url());
			
			$header['title'] 		= 'Fahrzeug - Image Uploader';		
			$menue['menue']			= $this->admin->get_menue();
			$menue['submenue']		= $this->admin->get_submenue();
			$fahrzeug['fahrzeug']		= $this->fahrzeug->get_fahrzeug($id);
			$fahrzeug['images']		= $this->fahrzeug->get_images($id);
			$fahrzeug['error']		= $error;
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/styles');
			$this->load->view('backend/fahrzeug/styles_fahrzeug');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/fahrzeug/image_upload', $fahrzeug); 
			$this->load->view('backend/fahrzeug/tiny_mce_inc');
			$this->load->view('backend/templates/admin/footer');
		}
	}
	
	private function image_delete()
	{
		$this->load->helper('file');
		
		$query = $this->db->get_where('fahrzeug_img', array('imgID' => $this->input->post('img_id')));
		$row = $query->row();
		unlink($this->upload_path.$row->imgFile);
		unlink($this->upload_path.$row->imgFileThumbnail);
		$this->fahrzeug->delete_image($this->input->post('img_id'));
	}
	
	private function update_image_details()
	{
		$this->fahrzeug->update_image($this->input->post('img_id'), $this->input->post('img_alt'));
	}
	
	public function switch_online_state($id, $state)
	{ 		
		if($state == 1) $online = 0; else $online = 1;
		
		$this->fahrzeug->switch_online_state($id, $online);
		redirect($this->session->userdata('fahrzeugliste_redirect'), 'refresh');
	}
	
	// callback für Fahrzeugbesatzung
	public function besatzung($str)
	{
		return ( ! preg_match("1\/[1-8]{1}", $str)) ? FALSE : TRUE;
	}
}
?>