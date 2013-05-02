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
    
    /**
	 * File_Admin::__construct()
	 * 
	 * @return
	 */
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
       
    /**
     * File_Admin::image_liste()
     * 
     * @return void
     */
    public function image_liste()
    {
        $this->session->set_userdata('imageliste_redirect', current_url()); 		
		
		$header['title']      = 'Bilder verwalten';		
		$menue['menue']	      = $this->admin->get_menue();
		$menue['submenue']	  = $this->admin->get_submenue();   
        $data['btn_create']   = 'Neue(s) Bild(er) hochladen';     
        $data['headline']     = $header['title'];
        $data['typeID']       = FILE_TYPE_ID_CMSIMAGE;
        $data['files']        = $this->file->get_files(FILE_TYPE_ID_CMSIMAGE);  
        $data['categories']   = $this->file->get_categories(FILE_TYPE_ID_CMSIMAGE);   
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/file/fileliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');    
    }
    
    /**
     * File_Admin::file_liste()
     * 
     * @return void
     */
    public function file_liste()
    {
        $this->session->set_userdata('fileliste_redirect', current_url()); 		
		
		$header['title']      = 'Dateien verwalten';		
		$menue['menue']	      = $this->admin->get_menue();
		$menue['submenue']	  = $this->admin->get_submenue();     
        $data['btn_create']   = 'Neue Datei(en) hochladen';       
        $data['headline']     = $header['title'];
        $data['typeID']       = FILE_TYPE_ID_CMSFILE;
        $data['files']        = $this->file->get_files(FILE_TYPE_ID_CMSFILE);
        $data['categories']   = $this->file->get_categories(FILE_TYPE_ID_CMSFILE); 
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/file/fileliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');           
    }
    
    public function upload_image()
    {
        $this->session->set_userdata('fileupload_redirect', current_url()); 
        	
        $header['title']      = 'Bild(er) hochladen';		
		$menue['menue']	      = $this->admin->get_menue();
		$menue['submenue']	  = $this->admin->get_submenue(); 
        $data['typeID']       = FILE_TYPE_ID_CMSIMAGE;  
        $data['categories']   = $this->file->get_categories(FILE_TYPE_ID_CMSIMAGE); 
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-fileupload-cp');
		$this->load->view('backend/file/fileupload_admin', $data);
		$this->load->view('backend/templates/admin/footer');
    }
    
    public function upload_file()
    {
        $this->session->set_userdata('fileupload_redirect', current_url()); 	
        
        $header['title']      = 'Datei(en) hochladen';		
		$menue['menue']	      = $this->admin->get_menue();
		$menue['submenue']	  = $this->admin->get_submenue();    
        $data['typeID']       = FILE_TYPE_ID_CMSFILE;
        $data['categories']   = $this->file->get_categories(FILE_TYPE_ID_CMSFILE); 
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-fileupload-cp');
		$this->load->view('backend/file/fileupload_admin', $data);
		$this->load->view('backend/templates/admin/footer');
    }
}