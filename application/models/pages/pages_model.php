<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pages Model
 *
 * Mittels des Pages Model werden die datenbankabhängigen Funktionen des Pages Moduls gesteuert.
 *
 * @package		com.cp.feuerwehr.models.pages
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 **/

class Pages_model extends CI_Model {
	
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
    
    public function get_pages()
    {
        $this->db->order_by('pageName', 'asc');
        $query = $this->db->get('page');
        $i = 0;
        $page = array();
        
        foreach($query->result() as $row)
        {
			$this->color = cp_get_color($this->color);
            $page[$i]['pageID'] = $row->pageID;
            $page[$i]['pageName'] = $row->pageName;
            $page[$i]['online'] = $row->online;
            $page[$i]['row_color'] = $this->color;
            $i++;
        }
    }
}
?>