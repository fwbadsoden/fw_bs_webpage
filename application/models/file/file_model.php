<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * File Model
 *
 * Mittels des File Model werden die datenbankabhängigen Funktionen des File Moduls gesteuert.
 *
 * @package		com.cp.feuerwehr.models.file
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 **/

class File_model extends CI_Model {
	
	private $color = '';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->helper('html');
	}
    
    public function get_types()
    {
        $query = $this->db->get('file_type');
        $i=0;
        foreach($query->result() as $row)
        {
            $types[$i]['typeID'] = $row->typeID;
            $types[$i]['name'] = $row->name;
        }
        return $types;
    }
    
    public function get_type($typeID)
    {
        $query = $this->db->get_where('file_type', array('typeID' => $typeID));
        $row = $query->row();
        $type = array(
            'typeID' => $id,
            'name'  => $row->name()
        );
        return $type;
    }
    
    public function get_files($typeID)
    {
        $this->db->order_by('name', 'asc');
        $query = $this->db->get_where('file', array('typeID' => $typeID));
        $files = array();
        $i=0;
        
        foreach($query->result() as $row)
        {			
            $files[$i]['fileID']        = $row->fileID;
            $files[$i]['typeID']        = $row->typeID;
            $files[$i]['categoryID']    = $row->categoryID;
            $files[$i]['name']          = $row->name;
            $files[$i]['description']   = $row->description;
            $files[$i]['fullpath']      = $row->fullpath;
            $files[$i]['filename']      = $row->filename; 
            $files[$i]['extension']     = $row->extension;
            $files[$i]['mimetype']      = $row->mimetype;
            $files[$i]['title']         = $row->title;
            $files[$i]['size']          = $row->size;
            $files[$i]['width']         = $row->width;
            $files[$i]['height']        = $row->height;
            $files[$i]['created']       = $row->created;
            $files[$i]['created_by']    = $row->created_by;
            $files[$i]['modified']      = $row->modified;
            $files[$i]['modified_by']   = $row->modified_by;
			$files[$i]['row_color']		= $this->color          = cp_get_color($this->color);
            $i++;
        }
        
        return $files;
    }
    
    public function get_categories($typeID)
    {
        $this->db->order_by('name', 'asc');
        $query = $this->db->get_where('file_category', array('typeID' => $typeID));
        $categories = array();
        
        foreach($query->result() as $row)
        {
            $categories[$row->categoryID]['categoryID'] = $row->categoryID;
            $categories[$row->categoryID]['name'] = $row->name;
        }
        
        return $categories;
    }
    
    public function update_file()
    {
        $file = array();
        $file['description'] = $this->input->post('description');
        $file['title'] = $this->input->post('title');
        $file['modified'] = date("Y-m-d H:i:s");
        $file['modified_by'] = $this->cp_auth->cp_get_userid($this->session->userdata(CPAUTH_SESSION_BACKEND));
        
        $this->db->update('file', $file, array('fileID' => $this->input->post('file_id')));
    }
    
    public function insert_file($typeID, $upload_data)
    {
        $this->load->helper('inflector');
        
        $file = array(
            'typeID' => $typeID,       
            'categoryID' => $this->input->post('category'),                
            'name' => strtolower(underscore($upload_data['client_name'])),           
            'description' => $this->input->post('description'),              
            'fullpath' => $upload_data['full_path'],                  
            'filename' => $upload_data['file_name'],                  
            'extension' => $upload_data['file_ext'],                  
            'mimetype' => $upload_data['file_type'],                 
            'title' => $this->input->post('title'),                 
            'size' => $upload_data['file_size'],               
            'sha1' => $upload_data['sha1'],          
            'created' => date("Y-m-d H:i:s"),              
            'created_by' => $this->cp_auth->cp_get_userid($this->session->userdata(CPAUTH_SESSION_BACKEND)) 
        );
        if($upload_data['is_image'] == 1)
        {                        
            $file['width']  = $upload_data['image_width'];             
            $file['height'] = $upload_data['image_height'];
        }
        $this->db->insert('file', $file);        
    }
 }