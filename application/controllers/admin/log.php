<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Log Controller
 *
 * Controller zum Anzeigen/Bearbeiten des Application Logs 
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.log
 **/

class Log extends CP_Controller {
  
  public function __construct()
  {
		parent::__construct();
		$this->load->library('CP_auth');
		
        // Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
  }  
  
  public function view()
  {
    $this->load->spark('fire_log/0.8.2');    
  }
}

?>