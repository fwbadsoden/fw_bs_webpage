<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pages_Admin
 * Controller für die Verwaltung und Anzeige der Inhaltsseiten
 * 
 * @package com.cp.feuerwehr.backend.pages  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Pages_Admin extends CP_Controller {
	private $pageID, $boxID, $rowID;
    
	/**
	 * Pages_Admin::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('pages/pages_model', 'pages');
		$this->load->model('file/file_model', 'file');
		$this->load->model('admin/admin_model', 'admin');
		
		// Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
	}
	
	/**
	 * Pages_Admin::pages_liste()
	 * 
	 * @return
	 */
	public function pages_liste()
	{
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
		$this->session->set_userdata('pageliste_redirect', current_url()); 		
		
		$header['title']      = 'Seiten verwalten';		
		$menue['menue']	      = $this->admin->get_menue();
        $menue['userdata']    = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	  = $this->admin->get_submenue();
		$data['page']         = $this->pages->get_pages();
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(PAGES_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(PAGES_PRIV_DELETE); 
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/pages/pageliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');	        
	}
    
    /**
     * Pages_Admin::create_page()
     * 
     * @return
     */
    public function create_page()
    {
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_EDIT)) redirect('admin/401', 'refresh');
       	if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify= $this->_verify_create())
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
            
            $header['title']    = 'Inhaltsseite anlegen';	
            $menue['menue']	    = $this->admin->get_menue();
            $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    		$menue['submenue']	= $this->admin->get_submenue();
            $data['templates']  = $this->pages->get_templates();
            $data['stages']     = $this->pages->get_stages();
    	
    		$this->load->view('backend/templates/admin/header', $header);
    		$this->load->view('backend/templates/admin/menue', $menue);	
    		$this->load->view('backend/templates/admin/submenue', $menue);	
    		$this->load->view('backend/pages/createPage_admin', $data);
    		$this->load->view('backend/templates/admin/footer');
        }
		else redirect($this->session->userdata('pageliste_redirect'), 'refresh');
    }
    
    /**
     * Pages_Admin::edit_page()
     * 
     * @param integer $id
     * @return
     */
    public function edit_page($id)
    {
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_EDIT)) redirect('admin/401', 'refresh');
        $this->pageID = $id;
        
        if($this->uri->segment($this->uri->total_segments()) == 'save')
		{		
			if($verify= $this->_verify_edit())
			{
				$this->pages->update_page($this->pageID);
			}
		}
		else
			$this->session->set_userdata('pageedit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{
            $this->session->set_userdata('pageedit_redirect', current_url());
            
            $header['title']    = 'Inhaltsseite bearbeiten';
		    $menue['menue']	    = $this->admin->get_menue();
            $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    		$menue['submenue']	= $this->admin->get_submenue();
            $data['page']       = $this->pages->get_page($this->pageID);
            $data['content']    = $this->pages->get_page_content($this->pageID);
            $data['stages']     = $this->pages->get_stages();
    	
    		$this->load->view('backend/templates/admin/header', $header);
    		$this->load->view('backend/templates/admin/menue', $menue);	
    		$this->load->view('backend/templates/admin/submenue', $menue);	
    		$this->load->view('backend/pages/editPageHeader_admin', $data);	
            
            if($data['page']['special_page'] != 1) {
                $this->load->view('backend/pages/editPageRowHeader_admin', $data);
                if(isset($data['content']['rows']))
                {
            		foreach($data['content']['rows'] as $r)
                    {
                        $data['columns'] = $this->pages->get_row_columns($r['rowID']);
                        $data['row'] = $r;
                        $this->load->view('backend/pages/editPageRow_admin', $data);
                    }	
                }
                $this->load->view('backend/pages/editPageRowFooter_admin', $data);
            }
            
    		$this->load->view('backend/pages/editPageFooter_admin', $data);
    		$this->load->view('backend/templates/admin/footer');
        }
		else redirect($this->session->userdata('pageedit_redirect'), 'refresh');
    }
    
    /**
     * Pages_Admin::add_row()
     * 
     * @param integer $pageID
     * @return
     */
    public function add_row($pageID)
    {
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_EDIT)) redirect('admin/401', 'refresh');
        $this->pages->add_row($pageID);
		redirect($this->session->userdata('pageedit_redirect'), 'refresh');
    }
    
    /**
     * Pages_Admin::change_row_order()
     * 
     * @param string $dir
     * @param integer $id
     * @return 
     */
    public function change_row_order($dir, $id)
	{
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_EDIT)) redirect('admin/401', 'refresh');
		$this->pages->change_row_order($dir, $id);		
		redirect($this->session->userdata('pageedit_redirect'), 'refresh');	
	}
    
    /**
     * Pages_Admin::add_box()
     * 
     * @param integer $rowID
     * @param integer $boxID
     * @return
     */
    public function add_box($rowID, $boxID = NULL)
    {        
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_EDIT)) redirect('admin/401', 'refresh');
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
            $header['title']    = 'Inhaltselement hinzuf&uumlgen';	
		    $menue['menue']	    = $this->admin->get_menue();
            $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    		$menue['submenue']	= $this->admin->get_submenue();
            $data['boxes']      = $this->pages->get_allowed_boxes($this->rowID);
    	
    		$this->load->view('backend/templates/admin/header', $header);
    		$this->load->view('backend/templates/admin/menue', $menue);	
    		$this->load->view('backend/templates/admin/submenue', $menue);	
    		$this->load->view('backend/pages/addBox_admin', $data);
    		$this->load->view('backend/templates/admin/footer');
        }
		else redirect($this->session->userdata('pageedit_redirect'), 'refresh');
    }
    
    /**
     * Pages_Admin::_box_content()
     * 
     * @param integer $rowContentID
     * @param integer $boxContentID
     * @return 
     */
    public function edit_box_content($rowContentID, $boxContentID)
    {       
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_EDIT)) redirect('admin/401', 'refresh');    
            $this->session->set_userdata('editboxcontent_submit', current_url());
        
            $header['title']     = 'Inhalt bearbeiten';		
		    $menue['menue']	     = $this->admin->get_menue();
            $menue['userdata']   = $this->cp_auth->cp_get_user_by_id();
    		$menue['submenue']	 = $this->admin->get_submenue();       
            $data['box_meta']    = $this->pages->get_box_meta($rowContentID);
            $data['box_content'] = $this->pages->get_box_content($boxContentID);
            if($data['box_content']['contentType'] == 'IMG') $data['images'] = $this->file->get_images(PAGES_IMG_CONTENT_CATEGORY);
            $tinymce['config']   = 'pages';   
    	
    		$this->load->view('backend/templates/admin/header', $header);     
			$this->load->view('backend/templates/admin/tiny_mce_inc', $tinymce);
    		$this->load->view('backend/templates/admin/menue', $menue);	
    		$this->load->view('backend/templates/admin/submenue', $menue);            
            $this->load->view('backend/pages/editBoxContent'.$data['box_content']['contentType'].'_admin', $data);                 
    		$this->load->view('backend/templates/admin/footer'); 
    }    
    
    /**
     * Pages_Admin::update_box_content()
     * 
     * @param string $boxContent
     * @return
     */
    public function update_box_content($boxContentID)
    {
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_EDIT)) redirect('admin/401', 'refresh');
        $this->pages->update_box_content($boxContentID);
        redirect($this->session->userdata('pageedit_redirect'), 'refresh'); 
    }
    
    /**
     * Pages_Admin::delete_page_verify()
     * 
     * @param integer $pageID
     * @return 
     */
    public function delete_page_verify($pageID)
    {
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_DELETE)) redirect('admin/401', 'refresh');
        $header['title']    = 'Seite l&ouml;schen';		
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
        $data['type']       = 'page';
        $data['id']         = $pageID;
        $data['page_title'] = $this->pages->get_pagename($pageID);
        $data['superID']    = 0;
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/pages/verifyDelete_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
    }    
    
    /**
     * Pages_Admin::delete_page()
     * 
     * @param integer $pageID
     * @return 
     */
    public function delete_page($pageID)
    {
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_DELETE)) redirect('admin/401', 'refresh');
        $this->pages->delete_page($pageID);
		
		redirect($this->session->userdata('pageliste_redirect'), 'refresh');    
    }
    
    /**
     * Pages_Admin::delete_row_verify()
     * 
     * @param integer $rowID
     * @param integer $pageID
     * @return 
     */
    public function delete_row_verify($rowID, $pageID)
    {
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $header['title']    = 'Zeile l&ouml;schen';		
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
        $data['type']       = 'row';
        $data['id']         = $rowID;
        $data['superID']    = $pageID;
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/pages/verifyDelete_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
    }   
    
    /**
     * Pages_Admin::delete_row()
     * 
     * @param integer $rowID
     * @param integer $pageID
     * @return 
     */
    public function delete_row($rowID, $pageID)
    {
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_DELETE)) redirect('admin/401', 'refresh');
        $this->pages->delete_row($rowID, $pageID);
		
		redirect($this->session->userdata('pageedit_redirect'), 'refresh');    
    }
    
    /**
     * Pages_Admin::delete_box_verify()
     * 
     * @param integer $rowContentID
     * @return 
     */
    public function delete_box_verify($rowContentID)
    {
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $header['title']    = 'Box l&ouml;schen';		
		$menue['menue']	    = $this->admin->get_menue();
        $menue['userdata']  = $this->cp_auth->cp_get_user_by_id();
    	$menue['submenue']	= $this->admin->get_submenue();
        $data['type']       = 'box';
        $data['id']         = $rowContentID;
        $data['superID']    = 0;
    	
    	$this->load->view('backend/templates/admin/header', $header);
    	$this->load->view('backend/templates/admin/menue', $menue);	
    	$this->load->view('backend/templates/admin/submenue', $menue);	
    	$this->load->view('backend/pages/verifyDelete_admin', $data);
    	$this->load->view('backend/templates/admin/footer');
    } 
    
    /**
     * Pages_Admin::delete_box()
     * 
     * @param integer $rowContentID
     * @return 
     */
    public function delete_box($rowContentID)
    {
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_DELETE)) redirect('admin/401', 'refresh');
        
        $this->pages->delete_box($rowContentID);
		
		redirect($this->session->userdata('pageedit_redirect'), 'refresh');    
    }
	
	/**
	 * Pages_Admin::_verify_create()
	 * 
	 * @return
	 */
	private function _verify_create()
	{		
		$this->load->library('form_validation');		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');		
		$this->form_validation->set_rules('pagename', 'Seitenname', 'required|max_length[100]|xss_clean');	
        $this->form_validation->set_rules('stage', 'Bildb&uuml;hne', 'xss_clean');	
		return $this->form_validation->run();	
	}
    
    /**
     * Pages_Admin::_verify_edit()
     * 
     * @return
     */
    private function _verify_edit()
    {
        $this->load->library('form_validation');		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');		
		$this->form_validation->set_rules('pagename', 'Seitenname', 'required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('stage', 'Bildb&uuml;hne', 'xss_clean');	
        $this->form_validation->set_rules('stage_image', 'Bildb&uuml;hne', 'xss_clean');	
		return $this->form_validation->run();        
    }
    
    /**
     * Pages_Admin::stage_liste()
     * 
     * @return 
     */
    public function stage_liste()
    {
        if(!$this->cp_auth->is_privileged(STAGES_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
        
        $this->session->set_userdata('stageliste_redirect', current_url()); 		
		
		$header['title']      = 'Bildb&uuml;hnen verwalten';	
		$menue['menue']	      = $this->admin->get_menue();
        $menue['userdata']    = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	  = $this->admin->get_submenue();
		$data['stage']        = $this->pages->get_stages();
        
        // Berechtigungen für Übersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(PAGES_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(PAGES_PRIV_DELETE); 
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/pages/stageliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');
    }
	
	/**
	 * Pages_Admin::switch_online_state()
	 * 
	 * @param integer $id
	 * @param integer $state
	 * @return
	 */
	public function switch_online_state($id, $state)
	{ 		
        if(!$this->cp_auth->is_privileged(PAGES_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($state == 1) $online = 0; else $online = 1;
		
		$this->pages->switch_online_state($id, $online);
		redirect($this->session->userdata('pageliste_redirect'), 'refresh');
	}
	
	/**
	 * Pages_Admin::switch_stage_online_state()
	 * 
	 * @param integer $id
	 * @param integer $state
	 * @return
	 */
	public function switch_stage_online_state($id, $state)
	{ 		
        if(!$this->cp_auth->is_privileged(STAGES_PRIV_EDIT)) redirect('admin/401', 'refresh');
		if($state == 1) $online = 0; else $online = 1;
		
		$this->pages->switch_stage_online_state($id, $online);
		redirect($this->session->userdata('stageliste_redirect'), 'refresh');
	}
}

/* End of file pages_admin.php */
/* Location: ./application/controllers/pages/pages_admin.php */