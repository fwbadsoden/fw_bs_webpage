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

class News_Admin extends CP_Controller {

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
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/news/newsliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');	
	}
    
    public function create_news()
    {
        if(!$this->cp_auth->is_privileged(NEWS_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify = $this->verify())
			{
				$this->admin->insert_log(str_replace('%NEWS%', $this->input->post('title'), lang('log_admin_createNews')));
				$this->news->create_news();
			}
		}
		else
			$this->session->set_userdata('newscreate_submit', current_url());	
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'News';		
		    $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
            $news['categories']     = $this->news->get_news_categories();
		
			$this->load->view('backend/templates/admin/header', $header);            
			$this->load->view('backend/templates/admin/tiny_mce_inc');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/news/createNews_admin', $news);
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('newsliste_redirect'), 'refresh');        
    }
    
    public function edit_news($id)
    {
        if(!$this->cp_auth->is_privileged(NEWS_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify = $this->verify())
			{
				$this->admin->insert_log(str_replace('%NEWS%', $this->input->post('title'), lang('log_admin_editNews')));
				$this->news->update_news($id);
			}
		}
		else
			$this->session->set_userdata('newsedit_submit', current_url());	
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'News';		
		    $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
            $news['news']           = $this->news->get_news_admin($id);
            $news['categories']     = $this->news->get_news_categories();
            		
			$this->load->view('backend/templates/admin/header', $header);      
			$this->load->view('backend/templates/admin/tiny_mce_inc');
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/news/editNews_admin', $news);
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('newsliste_redirect'), 'refresh');           
    }
    
    public function verify()
    {
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		$this->form_validation->set_rules('title', 'Titel', 'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('stage_title', 'Titel', 'trim|required|max_length[15]|xss_clean');
		$this->form_validation->set_rules('valid_from', 'Gültig ab', 'required|xss_clean');	
		$this->form_validation->set_rules('teaser', 'Teaser', 'required|xss_clean');	
		$this->form_validation->set_rules('text', 'Text', 'xss_clean');				

		return $this->form_validation->run();
    }
    
    public function delete_news($id)
    {
        if(!$this->cp_auth->is_privileged(NEWS_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $this->news->delete_news($id);
		
		redirect($this->session->userdata('newsliste_redirect'), 'refresh');	
    }
    
    public function delete_news_verify($id)
    {
        if(!$this->cp_auth->is_privileged(NEWS_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $header['title']    = 'News l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
        $data['news']       = $this->news->get_news_admin($id);
        $data['type']       = 'news';
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/news/verifyDelete_admin', $data);
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
    
    public function create_kategorie()
    {
        if(!$this->cp_auth->is_privileged(NEWS_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify = $this->_verify_kategorie())
			{
				$this->admin->insert_log(str_replace('%NEWSCAT%', $this->input->post('title'), lang('log_admin_createNewsKategorie')));
				$this->news->create_kategorie();
			}
		}
		else
			$this->session->set_userdata('kategoriecreate_submit', current_url());	
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'News-Kategorien';		
		    $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/news/createNewsKategorie_admin');
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('kategorieliste_redirect'), 'refresh');        
    }
    
    public function edit_kategorie($id)
    {
        if(!$this->cp_auth->is_privileged(NEWS_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify = $this->_verify_kategorie())
			{
				$this->admin->insert_log(str_replace('%NEWSCAT%', $this->input->post('title'), lang('log_admin_editNewsKategorie')));
				$this->news->update_kategorie($id);
			}
		}
		else
			$this->session->set_userdata('kategorieedit_submit', current_url());	
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title'] 		= 'News-Kategorien';		
		    $menue['menue']	        = $this->admin->get_menue();
            $menue['userdata']      = $this->cp_auth->cp_get_user_by_id();
			$menue['submenue']		= $this->admin->get_submenue();
            $category['kategorie']  = $this->news->get_news_category($id);
            		
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/menue', $menue);	
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/news/editNewsKategorie_admin', $category);
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('kategorieliste_redirect'), 'refresh');        
    }	
    
    private function _verify_kategorie()
	{		
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		$this->form_validation->set_rules('title', 'Kategorietitel', 'required|max_length[255]|xss_clean');	

		return $this->form_validation->run();	
	}
    
    public function delete_kategorie_verify($id)
    {
        if(!$this->cp_auth->is_privileged(NEWS_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $header['title']    = 'Kategorie l&ouml;schen';		
    	$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
        $data['category']   = $this->news->get_news_category($id);
        $data['type']       = 'category';
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/news/verifyDelete_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
    }
    
    public function delete_category($id)
    {
        if(!$this->cp_auth->is_privileged(NEWS_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $this->news->delete_category($id);
		
		redirect($this->session->userdata('kategorieliste_redirect'), 'refresh');	
    }
    
	public function switch_online_state($id, $state, $year)
	{ 		
        if(!$this->cp_auth->is_privileged(NEWS_PRIV_EDIT)) redirect('admin/401', 'refresh');
        
		if($state == 1) $online = 0; else $online = 1;
		
		$this->news->switch_online_state($id, $online);
		redirect($this->session->userdata('newsliste_redirect'), 'refresh');
	}
}

/* End of file news_admin.php */
/* Location: ./application/controllers/news/news_admin.php */