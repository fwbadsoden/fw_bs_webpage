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
	
	/**
	 * File_model::__construct()
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->helper('html');
	}
    
    /**
     * File_model::get_types()
     * 
     * @return
     */
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
    
    public function get_files($typeID)
    {
        $this->db->order_by('name', 'asc');
        $query = $this->db->get_where('file', array('typeID' => $typeID));
        $files = array();
        $i=0;
        
        foreach($query->result() as $row)
        {			
            $files[$i]['fileID']        = $row->fileID;
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
        $i=0;
        
        foreach($query->result() as $row)
        {
            $categories[$i]['categoryID'] = $row->categoryID;
            $categories[$i]['name'] = $row->name;
            $i++;
        }
        
        return $categories;
    }
 }