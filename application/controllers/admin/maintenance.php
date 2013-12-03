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
        $this->load->model('einsatz/einsatz_model', 'einsatz');        
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
    
    public function recalc($year)
    {
        // Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
        $this->einsatz->recalc_maintain($year);   
    }
    
    public function cache_liste()
    {
        // Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');        
        if(!$this->cp_auth->is_privileged(CACHE_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
        
        $this->load->helper('file');
        $files = get_dir_file_info($this->config->item('cache_path'));
		$this->session->set_userdata('cacheliste_redirect', current_url()); 
        
        $header['title']                = "Cache anzeigen";
		$menue['menue']	                = $this->admin->get_menue();
        $menue['userdata']              = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	            = $this->admin->get_submenue(); 
        $data['files']                  = $files;
        $data['privileged']['delete']   = $this->cp_auth->is_privileged(CACHE_PRIV_DELETE);
		
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
		$this->load->view('backend/maintenance/cache_liste', $data);
		$this->load->view('backend/templates/admin/footer');
    }
    
    public function delete_cache($file)
    {
        if($file == 'all')
        {
            delete_files($this->config->item('cache_path')); 
        }
        else
        {
            unlink($this->config->item('cache_path').$file);
            
        }
        redirect($this->session->userdata('cacheliste_redirect'), 'refresh');
    }
    
    public function phpinfo()
    {
        // Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin() or ENVIRONMENT != 'development') redirect('admin', 'refresh');
        phpinfo();   
    }
    
    public function generate_names($name)
    {
        echo strtoupper(md5($name));
    }
}

/* End of file maintenance.php */
/* Location: ./application/controllers/admin/maintenance.php */