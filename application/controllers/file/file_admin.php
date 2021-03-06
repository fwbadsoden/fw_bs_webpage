<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File_Admin
 * Controller f�r die Verwaltung und Anzeige der Dateien und Bilder
 * 
 * @package com.cp.feuerwehr.backend.file 
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class File_Admin extends CP_Controller {
    
	/**
	 * File_Admin::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('file/file_model', 'file');
		$this->load->model('admin/admin_model', 'admin');
		
		// Berechtigungspr�fung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
	}
    
    /**
     * File_Admin::file_liste()
     * 
     * @param mixed $type
     * @return
     */
    public function file_liste($type) // Sp�ter durch jquery File Upload und Schnickschnack zu ersetzen
    {       
        if(!$this->cp_auth->is_privileged(FILE_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
        $this->session->set_userdata($type.'liste_redirect', current_url());  
        
        // Berechtigungen f�r �bersichtsseite weiterreichen
        $data['privileged']['edit'] = $this->cp_auth->is_privileged(FILE_PRIV_EDIT);
        $data['privileged']['delete'] = $this->cp_auth->is_privileged(FILE_PRIV_DELETE);   
        
        switch($type)
        {
            case 'image':   			
        		$header['title']      = 'Bilder verwalten';		
		        $menue['menue']	      = $this->admin->get_menue();
                $menue['userdata']    = $this->cp_auth->cp_get_user_by_id();
        		$menue['submenue']	  = $this->admin->get_submenue();   
                $data['btn_create']   = 'Neues Bild hochladen';     
                $data['headline']     = $header['title'];
                $data['typeID']       = FILE_TYPE_ID_CMSIMAGE;
                $data['type']         = $type;
                $data['files']        = $this->file->get_files(FILE_TYPE_ID_CMSIMAGE);  
                $data['categories']   = $this->file->get_categories(FILE_TYPE_ID_CMSIMAGE);  
        
                $this->load->view('backend/templates/admin/header', $header);
        		$this->load->view('backend/templates/admin/menue', $menue);	
        		$this->load->view('backend/templates/admin/submenue', $menue);	
        		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
        		$this->load->view('backend/file/temp_imageupload_admin', $data);
        		$this->load->view('backend/templates/admin/footer');  
                break;
                
            case 'file': 	
        		$header['title']      = 'Dateien verwalten';		
		        $menue['menue']	      = $this->admin->get_menue();
                $menue['userdata']    = $this->cp_auth->cp_get_user_by_id();
        		$menue['submenue']	  = $this->admin->get_submenue();     
                $data['btn_create']   = 'Neue Datei hochladen';       
                $data['headline']     = $header['title'];
                $data['typeID']       = FILE_TYPE_ID_CMSFILE;
                $data['type']         = $type;
                $data['files']        = $this->file->get_files(FILE_TYPE_ID_CMSFILE);
                $data['categories']   = $this->file->get_categories(FILE_TYPE_ID_CMSFILE);      
        
                $this->load->view('backend/templates/admin/header', $header);
        		$this->load->view('backend/templates/admin/menue', $menue);	
        		$this->load->view('backend/templates/admin/submenue', $menue);	
        		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
        		$this->load->view('backend/file/temp_fileupload_admin', $data);
        		$this->load->view('backend/templates/admin/footer');  
                break;
        }
    }
    
    /**
     * File_Admin::create_file()
     * 
     * @param mixed $type
     * @return
     */
    public function create_file($type)
    {        
        if(!$this->cp_auth->is_privileged(FILE_PRIV_EDIT)) redirect('admin/401', 'refresh');
        if($type == 'image') $data['typeID']       = FILE_TYPE_ID_CMSIMAGE; 
        if($type == 'file')  $data['typeID']       = FILE_TYPE_ID_CMSFILE; 
        
        if($this->uri->segment($this->uri->total_segments()) == 'save')
  		{		
  		    switch($type)
            {
                case 'image':
          		    $this->load->library('image_lib');	
                    $this->load->library('image_moo');
                    
                    $config['upload_path'] = CONTENT_IMG_UPLOAD_PATH;
            	    $config['allowed_types'] = 'jpg|png|gif';
            	    $config['file_name'] = $this->image_lib->generate_img_name($_FILES['upload_image']['tmp_name']);;
                    $sha1 = sha1_file($_FILES["upload_image"]["tmp_name"]);
                                    
                    $this->load->library('upload', $config);
               
            		if(!$this->upload->do_upload('upload_image'))
            		{
                        $data['error'] = $this->upload->display_errors();
            		}
            		else
            		{
            		    $upload_data = $this->upload->data();	
                        $upload_data['sha1'] = $sha1;
                        $upload_data['upload_path'] = $config['upload_path'];
         			    $this->file->insert_file($data['typeID'], $upload_data);
                    }
                    
                    break;
                case 'file':
                    $config['upload_path'] = CONTENT_FILE_UPLOAD_PATH;
            	    $config['allowed_types'] = 'pdf|doc|ppt';
            	    //$config['file_name'] = $this->image_lib->generate_img_name($_FILES['upload_image']['tmp_name']);;
                    $sha1 = sha1_file($_FILES["upload_file"]["tmp_name"]);
                                    
                    $this->load->library('upload', $config);
               
            		if(!$this->upload->do_upload('upload_file'))
            		{
                        $data['error'] = $this->upload->display_errors();
            		}
            		else
            		{
            		    $upload_data = $this->upload->data();	
                        $upload_data['sha1'] = $sha1;
                        $upload_data['upload_path'] = $config['upload_path'];
         			    $this->file->insert_file($data['typeID'], $upload_data);
                    }
                    
                    break;
            }
  		}

        switch($type)
        {
            case 'image':            
                $data['title']        = 'Neues Bild hochladen';	  
                $data['headline']     = $data['title'];
                $data['categories']   = $this->file->get_categories(FILE_TYPE_ID_CMSIMAGE);     
                
        		$this->load->view('backend/file/popup_img_upload', $data);
                break;
            case 'file':
                $data['title']        = 'Neue Datei hochladen';	  
                $data['headline']     = $data['title'];
                $data['categories']   = $this->file->get_categories(FILE_TYPE_ID_CMSFILE);     
                
        		$this->load->view('backend/file/popup_file_upload', $data);
                break;
        }    
    }
    
    /**
     * File_Admin::edit_file()
     * 
     * @param mixed $type
     * @return
     */
    public function edit_file($type)
    {
        if(!$this->cp_auth->is_privileged(FILE_PRIV_EDIT)) redirect('admin/401', 'refresh');
        $this->file->update_file();
        redirect($this->session->userdata($type.'liste_redirect'), 'refresh');
    }
}

/* End of file file_admin.php */
/* Location: ./application/controllers/file/file_admin.php */