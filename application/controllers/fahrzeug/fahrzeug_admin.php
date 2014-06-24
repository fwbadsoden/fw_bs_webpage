<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fahrzeug_Admin
 * Controller für die Verwaltung und Anzeige der Fahrzeuge
 * 
 * @package com.cp.feuerwehr.backend.fahrzeug  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Fahrzeug_Admin extends CP_Controller {
	
	private $upload_path;

	/**
	 * Fahrzeug_Admin::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('fahrzeug/fahrzeug_model', 'fahrzeug');
		$this->load->model('admin/admin_model', 'admin');
		
		// Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
		
		$this->upload_path = CONTENT_IMG_FAHRZEUG_UPLOAD_PATH;
	}
	
	/**
	 * Fahrzeug_Admin::fahrzeug_liste()
	 * 
	 * @return
	 */
	public function fahrzeug_liste()
	{
        if(!$this->cp_auth->is_privileged(FAHRZEUG_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
		$this->session->set_userdata('fahrzeugliste_redirect', current_url()); 
				
		$header['title']      = 'Fahrzeuge';		
		$menue['menue']	      = $this->admin->get_menue();
        $menue['userdata']    = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	  = $this->admin->get_submenue();
		$data['fahrzeug']     = $this->fahrzeug->get_fahrzeug_list();
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(FAHRZEUG_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(FAHRZEUG_PRIV_DELETE);
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/fahrzeug/fahrzeugliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');
	}
	
	/**
	 * Fahrzeug_Admin::create_fahrzeug()
	 * 
	 * @return
	 */
	public function create_fahrzeug()
	{
        if(!$this->cp_auth->is_privileged(FAHRZEUG_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify = $this->_verify())
			{
				$this->admin->insert_log(str_replace('%FAHRZEUG%', $this->input->post('fahrzeugName'), lang('log_admin_createFahrzeug')));
				$this->fahrzeug->create_fahrzeug();
                delete_files($this->config->item('cache_path'));
			}
		}
		else
			$this->session->set_userdata('fahrzeugcreate_submit', current_url());	
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'Fahrzeuge';		
		    $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/tiny_mce_inc');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/fahrzeug/createFahrzeug_admin');
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('fahrzeugliste_redirect'), 'refresh');
	}
	
	/**
	 * Fahrzeug_Admin::edit_fahrzeug()
	 * 
	 * @param integer $id
	 * @return
	 */
	public function edit_fahrzeug($id)
	{
        if(!$this->cp_auth->is_privileged(FAHRZEUG_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify = $this->_verify())
			{
				$this->admin->insert_log(str_replace('%FAHRZEUG%', $this->input->post('fahrzeugName'), lang('log_admin_editFahrzeug')));
				$this->fahrzeug->update_fahrzeug($id);
                delete_files($this->config->item('cache_path'));
			}
		}
		else
			$this->session->set_userdata('fahrzeugedit_submit', current_url());	
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'Fahrzeuge';		
		    $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
			$fahrzeug['fahrzeug'] 	= $this->fahrzeug->get_fahrzeug($id);
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/tiny_mce_inc');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/fahrzeug/editFahrzeug_admin', $fahrzeug);
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('fahrzeugliste_redirect'), 'refresh');		
	}
    
    /**
     * Fahrzeug_Admin::delete_fahrzeug_verify()
     * 
     * @param integer $id
     * @return 
     */
     public function delete_fahrzeug_verify($id) {
        if(!$this->cp_auth->is_privileged(FAHRZEUG_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $header['title']    = 'Fahrzeug l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
		
        $data = $this->fahrzeug->get_fahrzeug($id);
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/fahrzeug/verifyDelete_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
     }
	
	/**
	 * Fahrzeug_Admin::delete_fahrzeug()
	 * 
	 * @param integer $id
	 * @return
	 */
	public function delete_fahrzeug($id)
	{
        if(!$this->cp_auth->is_privileged(FAHRZEUG_PRIV_DELETE)) redirect('admin/401', 'refresh');
		$fahrzeugdata = $this->fahrzeug->get_fahrzeug($id);
		$this->admin->insert_log(str_replace('%FAHRZEUG%', $fahrzeugdata['fahrzeugName'], lang('log_admin_deleteFahrzeug')));
		
		$this->fahrzeug->delete_fahrzeug($id);
        delete_files($this->config->item('cache_path'));

		redirect($this->session->userdata('fahrzeugliste_redirect'), 'refresh');
	}
	
	/**
	 * Fahrzeug_Admin::_verify()
	 * 
	 * @return
	 */
	private function _verify()
	{		
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		$this->form_validation->set_rules('fahrzeugname', 'Fahrzeugname', 'required|max_length[255]|xss_clean');	
		$this->form_validation->set_rules('fahrzeugprefix', 'Präfix Funkrufname', 'required|max_length[100]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugrufname', 'Fahrzeugrufname', 'required|max_length[10]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugnamelang', 'Fahrzeugname (lang)', 'required|max_length[50]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugtext', 'Fahrzeugbeschreibung', 'required|xss_clean'); 
        $this->form_validation->set_rules('fahrzeugbaujahr', 'Fahrzeugbaujahr', 'required|max_length[4]|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('fahrzeugbesatzung', 'Fahrzeugbesatzung', 'max_length[3]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeughersteller', 'Fahrzeughersteller', 'required|max_length[50]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugaufbau', 'Fahrzeugaufbau', 'max_length[50]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugpumpe', 'Pumpe(n)', 'max_length[255]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugloeschmittel', 'Löschmittel', 'max_length[255]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugbesonderheit', 'Fahrzeugbesonderheit', 'max_length[255]|xss_clean'); 
		$this->form_validation->set_rules('fahrzeugleistungkw', 'Fahrzeugleistung in KW', 'is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('fahrzeugleistungps', 'Fahrzeugleistung in PS', 'is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('fahrzeughoehe', 'Fahrzeughöhe', 'decimal|xss_clean');
		$this->form_validation->set_rules('fahrzeugbreite', 'Fahrzeugbreite', 'decimal|xss_clean');
		$this->form_validation->set_rules('fahrzeuglaenge', 'Fahrzeuglänge', 'decimal|xss_clean');
		$this->form_validation->set_rules('fahrzeugleermasse', 'Fahrzeug-Leermasse', 'decimal|xss_clean');
		$this->form_validation->set_rules('fahrzeuggesamtmasse', 'Fahrzeug-Gesamtmasse', 'decimal|xss_clean');

		return $this->form_validation->run();	
	}
	
	/**
	 * Fahrzeug_Admin::image_uploader()
	 * 
	 * @param integer $id
	 * @param integer $recursive
	 * @param string $error
	 * @return
	 */
	public function image_uploader($id, $recursive = 0, $error = null)
	{		
        if(!$this->cp_auth->is_privileged(FAHRZEUG_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save' && $recursive == 0)
		{
			if($this->input->post('img_manager') == 'img_upload')
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
					$thumb = $this->image_lib->generate_img_name('thumb'.$id.$config['file_name']);
					$this->load->library('image_moo');
					$this->image_moo->set_jpeg_quality(90);
					// Bild verkleinern 
					$this->image_moo->load($this->upload_path.$filename)->resize($width, $height)->save($this->upload_path.$filename, true);
					// Wasserzeichen hinzufügen
					$this->image_moo->make_watermark_text("(c) Feuerwehr Bad Soden am Taunus", "system/fonts/texb.ttf", 8, "#FFFFFF")->watermark(1)->save($this->upload_path.$filename, true);
					// Thumbnail erstellen
					$this->image_moo->resize($width_t, $height_t)->save($_SERVER["DOCUMENT_ROOT"].'/'.$this->upload_path.$thumb.$ext, true);
                    
                    log_message('debug', 'fahrzeug_admin: Thumbnail-Pfad: '.$_SERVER["DOCUMENT_ROOT"].'/'.$this->upload_path.$thumb.$ext);
                    
                    if($this->image_moo->errors) echo $this->image_moo->display_errors();
                    
					$this->fahrzeug->insert_image($id, $this->input->post('alt'), $filename, $thumb.$ext, str_replace('.', '', $ext), $this->input->post('img_small_pic'));
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
			if($this->uri->segment($this->uri->total_segments()) != 'save') $this->session->set_userdata('fahrzeugimage_submit', current_url());
			
			$header['title'] 		= 'Fahrzeug - Image Uploader';	
		    $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
			$fahrzeug['fahrzeug']	= $this->fahrzeug->get_fahrzeug($id);
			$fahrzeug['images']		= $this->fahrzeug->get_images($id);
			$fahrzeug['error']		= $error;
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/tiny_mce_inc');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/fahrzeug/image_upload', $fahrzeug); 
			$this->load->view('backend/templates/admin/footer');
		}
	}
	
	/**
	 * Fahrzeug_Admin::_image_delete()
	 * 
	 * @return
	 */
	private function _image_delete()
	{
		$this->fahrzeug->delete_image($this->input->post('img_id'));
	}
	
	/**
	 * Fahrzeug_Admin::_update_image_details()
	 * 
	 * @return
	 */
	private function _update_image_details()
	{
		$this->fahrzeug->update_image($this->input->post('img_id'), $this->input->post('img_alt'), $this->input->post('img_small_pic'));
	}
	
	/**
	 * Fahrzeug_Admin::change_order()
	 * 
	 * @param mixed $dir
	 * @param mixed $id
	 * @return
	 */
	public function change_order($dir, $id)
	{
        if(!$this->cp_auth->is_privileged(FAHRZEUG_PRIV_EDIT)) redirect('admin/401', 'refresh');
		$this->fahrzeug->change_order($dir, $id);		
                delete_files($this->config->item('cache_path'));
		redirect($this->session->userdata('fahrzeugliste_redirect'), 'refresh');	
	}
	
	/**
	 * Fahrzeug_Admin::switch_online_state()
	 * 
	 * @param integer $id
	 * @param integer $state
	 * @return
	 */
	public function switch_online_state($id, $state)
	{ 		
        if(!$this->cp_auth->is_privileged(FAHRZEUG_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($state == 1) $online = 0; else $online = 1;
		
		$this->fahrzeug->switch_online_state($id, $online);
                delete_files($this->config->item('cache_path'));
		redirect($this->session->userdata('fahrzeugliste_redirect'), 'refresh');
	}
	
	/**
	 * Fahrzeug_Admin::besatzung()
     * callback für Fahrzeugbesatzung
	 * 
	 * @param string $str
	 * @return
	 */
	public function besatzung($str)
	{
		return ( ! preg_match("1\/[1-8]{1}", $str)) ? FALSE : TRUE;
	}
}

/* End of file fahrzeug_admin.php */
/* Location: ./application/controllers/fahrzeug/fahrzeug_admin.php */