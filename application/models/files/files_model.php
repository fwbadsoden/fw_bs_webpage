<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Files Model
 *
 * Mittels des Files Model werden die datenbankabhängigen Funktionen des Files Moduls gesteuert.
 *
 * @package		com.cp.feuerwehr.models.files
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 **/

class Files_model extends CI_Model {
	
	private $color = '';
	
	/**
	 * Konstruktor
	 *
	 *
	 * @access public
	 */
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
 }