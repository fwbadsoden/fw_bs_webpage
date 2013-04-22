<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pages Controller
 *
 * Controller für die Verwaltung und Anzeige der Inhaltsseiten
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.content
 **/

class Pages_Admin extends CI_Controller {
	private $pageID, $boxID, $rowID;
    
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('pages/pages_model', 'pages');
		$this->load->model('admin/admin_model', 'admin');
		
		// CP Auth Konfiguration
		$this->cpauth->init('BACKEND');
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
	}
	
	public function pages_liste()
	{
		$this->session->set_userdata('pageliste_redirect', current_url()); 		
		
		$header['title'] = 'Seiten';		
		$menue['menue']	= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['page'] = $this->pages->get_pages();
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/styles');
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/pages/pageliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');	        
	}
    
    public function create_page()
    {
       	if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify= $this->verify_create())
			{
				$this->pageID = $this->pages->create_page();
                redirect(site_url('admin/content/page/edit/'.$this->pageID));
			}
		}
		else
			$this->session->set_userdata('pagecreate_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{
            $this->session->set_userdata('pagecreate_redirect', current_url());
            
            $header['title'] = 'Inhaltsseite anlegen';		
    		$menue['menue']	= $this->admin->get_menue();
    		$menue['submenue']	= $this->admin->get_submenue();
            $data['templates'] = $this->pages->get_templates();
    	
    		$this->load->view('backend/templates/admin/header', $header);
    		$this->load->view('backend/templates/admin/styles');
    		$this->load->view('backend/templates/admin/menue', $menue);	
    		$this->load->view('backend/templates/admin/submenue', $menue);	
    		$this->load->view('backend/pages/createPage_admin', $data);
    		$this->load->view('backend/templates/admin/footer');
        }
		else redirect($this->session->userdata('pageliste_redirect'), 'refresh');
    }
    
    public function edit_page($id)
    {
        $this->pageID = $id;
        
        if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify= $this->verify_edit())
			{
				$this->pages->update_page($this->pageID);
			}
		}
		else
			$this->session->set_userdata('pageedit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{
            $this->session->set_userdata('pageedit_redirect', current_url());
            
            $header['title'] = 'Inhaltsseite bearbeiten';		
    		$menue['menue']	= $this->admin->get_menue();
    		$menue['submenue']	= $this->admin->get_submenue();
            $data['page'] = $this->pages->get_page($this->pageID);
            $data['templates'] = $this->pages->get_templates();
            $data['content'] = $this->pages->get_page_content($this->pageID);
    	
    		$this->load->view('backend/templates/admin/header', $header);
    		$this->load->view('backend/templates/admin/styles');
    		$this->load->view('backend/templates/admin/menue', $menue);	
    		$this->load->view('backend/templates/admin/submenue', $menue);	
    		$this->load->view('backend/pages/editPageHeader_admin', $data);	
            
    		foreach($data['content']['rows'] as $r)
            {
                $data['row'] = $r;
                $this->load->view('backend/pages/editPageRow_admin', $data);
            }	
    		$this->load->view('backend/pages/editPageFooter_admin', $data);
    		$this->load->view('backend/templates/admin/footer');
        }
		else redirect($this->session->userdata('pageliste_redirect'), 'refresh');
    }
    
    public function add_row($pageID)
    {
        $this->pages->add_row($pageID);
		redirect($this->session->userdata('pageedit_redirect'), 'refresh');
    }
    
    public function add_box($rowID, $boxID = 0)
    {        
        $this->rowID = $rowID;
        $this->boxID = $boxID;
        
        if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			$this->pages->add_box($this->rowID, $this->boxID);
		}
		else
			$this->session->set_userdata('pageaddbox_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save')
		{
            //$this->session->set_userdata('pageaddbox_redirect', current_url());
            
            $header['title'] = 'Inhaltselement hinzuf&uumlgen';		
    		$menue['menue']	= $this->admin->get_menue();
    		$menue['submenue']	= $this->admin->get_submenue();
            $data['boxes'] = $this->pages->get_allowed_boxes($this->rowID);
    	
    		$this->load->view('backend/templates/admin/header', $header);
    		$this->load->view('backend/templates/admin/styles');
    		$this->load->view('backend/templates/admin/menue', $menue);	
    		$this->load->view('backend/templates/admin/submenue', $menue);	
    		$this->load->view('backend/pages/addBox_admin', $data);
    		$this->load->view('backend/templates/admin/footer');
        }
		else redirect($this->session->userdata('pageedit_redirect'), 'refresh');
    }
	
	private function verify_create()
	{		
		$this->load->library('form_validation');		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');		
		$this->form_validation->set_rules('pagename', 'Seitenname', 'required|max_length[100]|xss_clean');	
		return $this->form_validation->run();	
	}
    
    private function verify_edit()
    {
        $this->load->library('form_validation');		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');		
		$this->form_validation->set_rules('pagename', 'Seitenname', 'required|max_length[100]|xss_clean');	
		return $this->form_validation->run();        
    }
	
	public function switch_online_state($id, $state)
	{ 		
		if($state == 1) $online = 0; else $online = 1;
		
		$this->pages->switch_online_state($id, $online);
		redirect($this->session->userdata('pageliste_redirect'), 'refresh');
	}
}

?>