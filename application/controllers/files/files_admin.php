<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Files_Admin
 * Controller für die Verwaltung und Anzeige der Dateien und Bilder
 * 
 * @package com.cp.feuerwehr.backend.files  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Files_Admin extends CI_Controller {
    
    /**
	 * Files_Admin::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('files/files_model', 'files');
		$this->load->model('admin/admin_model', 'admin');
		
		// CP Auth Konfiguration
		$this->cpauth->init('BACKEND');
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
	}
       
    /**
     * Files_Admin::image_liste()
     * 
     * @return void
     */
    public function image_liste()
    {
           
    }
    
    /**
     * Files_Admin::file_liste()
     * 
     * @return void
     */
    public function file_liste()
    {
           
    }
}