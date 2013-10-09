<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Maintenance Controller
 *
 * Controller für Wartungs- und Entwicklungsfunktionalitäten 
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.maintenance
 **/

class Maintenance extends CP_Controller {
		
	/**
	 * Maintenance::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('maintenance/maintenance_model', 'maintain');
		$this->load->model('module/module_model', 'module');
		$this->load->library('CP_auth');
		$this->load->model('admin/admin_model', 'admin');
        
        // Berechtigungsprüfung TEIL 1: eingelogged und Admin
	//	if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
	}

    /**
     * Maintenance::optimize_db()
     * CRON für DB Optimierung
     * 
     * @return
     */
    public function optimize_db()
    {
        // Load the DB utility class
        $this->load->dbutil();
        $result = $this->dbutil->optimize_database();
    }
    
    /**
     * Maintenance::minify()
     * erstellt die min Dateien von CSS und JS
     * 
     * @return
     */
    public function minify()
    {
        $this->load->driver('minify');
        
        $contents = $this->minify->css->min('css/frontend/styles.css');
        $this->minify->save_file($contents, 'css/frontend/styles.min.css');
        
        $contents = $this->minify->css->min('css/backend/admin.css');
        $this->minify->save_file($contents, 'css/backend/admin.min.css');
        
        $contents = $this->minify->css->min('css/backend/login.css');
        $this->minify->save_file($contents, 'css/backend/login.min.css');
        
        $contents = $this->minify->css->min('css/frontend/styles.css');
        $this->minify->save_file($contents, 'css/frontend/styles.min.css');
        
        $contents = $this->minify->css->min('css/frontend/styles.css');
        $this->minify->save_file($contents, 'css/frontend/styles.min.css');
    }
}

?>