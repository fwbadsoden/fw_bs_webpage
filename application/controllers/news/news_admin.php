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
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('news/news_model', 'news');
		$this->load->model('admin/admin_model', 'admin');
		
		// CP Auth Konfiguration
		$this->cpauth->init('BACKEND');
	}
	
	public function news_liste()
	{ 
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
		$this->session->set_userdata('newsliste_redirect', current_url()); 
		
		$header['title'] 			= 'News';		
		$menue['menue']				= $this->admin->get_menue();
		$menue['submenue']			= $this->admin->get_submenue();
		$data['news'] 				= $this->news->get_news_list();
		
		// Pagination Config
		$this->config->set_item('total_rows', $this->news->news_count());
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
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
        
        $this->session->set_userdata('kategorieliste_redirect', current_url());
        
        $header['title']        = 'News Kategorien';      
		$menue['menue']			= $this->admin->get_menue();
		$menue['submenue']		= $this->admin->get_submenue();
		$data['categories']		= $this->news->get_news_categories();  
        
        $this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/news/kategorieliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');
    }
}
?>