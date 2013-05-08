<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File_Admin
 * Controller für die Verwaltung und Anzeige der Dateien und Bilder
 * 
 * @package com.cp.feuerwehr.backend.file 
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class File_Admin extends CI_Controller {
    
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('file/file_model', 'file');
		$this->load->model('admin/admin_model', 'admin');
		
		// CP Auth Konfiguration
		$this->cpauth->init('BACKEND');
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
	}
    
    public function file_liste($type) // Später durch jquery File Upload und Schnickschnack zu ersetzen
    {       
        $this->session->set_userdata($type.'liste_redirect', current_url());  
        switch($type)
        {
            case 'image':   			
        		$header['title']      = 'Bilder verwalten';		
        		$menue['menue']	      = $this->admin->get_menue();
        		$menue['submenue']	  = $this->admin->get_submenue();   
                $data['btn_create']   = 'Neues Bild hochladen';     
                $data['headline']     = $header['title'];
                $data['typeID']       = FILE_TYPE_ID_CMSIMAGE;
                $data['files']        = $this->file->get_files(FILE_TYPE_ID_CMSIMAGE);  
                $data['categories']   = $this->file->get_categories(FILE_TYPE_ID_CMSIMAGE);     
        
                $this->load->view('backend/templates/admin/header', $header);
        		$this->load->view('backend/templates/admin/menue', $menue);	
        		$this->load->view('backend/templates/admin/submenue', $menue);	
        		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
        		$this->load->view('backend/file/temp_imageupload_admin', $data);
        		$this->load->view('backend/templates/admin/footer');  
                break;
                
            case 'file': 	
        		$header['title']      = 'Dateien verwalten';		
        		$menue['menue']	      = $this->admin->get_menue();
        		$menue['submenue']	  = $this->admin->get_submenue();     
                $data['btn_create']   = 'Hochladen';       
                $data['headline']     = $header['title'];
                $data['typeID']       = FILE_TYPE_ID_CMSFILE;
                $data['files']        = $this->file->get_files(FILE_TYPE_ID_CMSFILE);
                $data['categories']   = $this->file->get_categories(FILE_TYPE_ID_CMSFILE);      
        
                $this->load->view('backend/templates/admin/header', $header);
        		$this->load->view('backend/templates/admin/menue', $menue);	
        		$this->load->view('backend/templates/admin/submenue', $menue);	
        		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
        		$this->load->view('backend/file/temp_fileupload_admin', $data);
        		$this->load->view('backend/templates/admin/footer');  
                break;
        }
    }
    
    public function create_file($type)
    {
        
    }
    
    public function edit_file($type)
    {
        $this->file->update_file();
        redirect($this->session->userdata($type.'liste_redirect'), 'refresh');
    }
}