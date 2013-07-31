<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * News Controller
 *
 * Controller für die Verwaltung und Anzeige der News
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.news
 **/

class News_Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->library('pagination');
		$this->load->model('news/news_model', 'news');
		$this->load->model('admin/admin_model', 'admin');
		
		// Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
	}
	
	public function news_liste()
	{ 		
        if(!$this->cp_auth->is_privileged(NEWS_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
		$this->session->set_userdata('newsliste_redirect', current_url()); 
		
		$header['title'] 			= 'News';		
		$menue['menue']	            = $this->admin->get_menue();
        $menue['userdata']          = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']			= $this->admin->get_submenue();
		$data['news'] 				= $this->news->get_news_list();
        $data['news_count']         = $this->news->get_news_count();
        $data['news_categories']    = $this->news->get_news_categories();
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(NEWS_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(NEWS_PRIV_DELETE); 
		
		// Pagination Config
		$this->config->set_item('total_rows', $data['news_count']);
		if(is_int($this->uri->segment($this->uri->total_segments()))) 
		{
			$uri = current_url();
			$uri = str_replace($this->uri->segment('/'.$this->uri->total_segments()), '', $uri);
		}
		else $uri = current_url();
		
		$base_url = base_url();
		$config['base_url'] = $uri;
		$this->pagination->initialize($config);
		// End Pagination Config
		
		$data['news_pagination'] 	= $this->pagination->create_links();
		$this->config->set_item('base_url', $base_url);		
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/news/newsliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');	
	}
    
    public function kategorie_liste()
    {
        if(!$this->cp_auth->is_privileged(NEWS_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
        $this->session->set_userdata('kategorieliste_redirect', current_url());
        
        $header['title']        = 'News Kategorien';      
		$menue['menue']	        = $this->admin->get_menue();
        $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']		= $this->admin->get_submenue();
		$data['categories']		= $this->news->get_news_categories(); 
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(NEWS_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(NEWS_PRIV_DELETE);  
        
        $this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/news/kategorieliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');
    }
}
?>