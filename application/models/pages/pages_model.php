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
    
    public function get_templates($online = 'all')
    {
        if($online != all) $this->db->where(array('online' => $online));
        $query = $this->db->get('page_template');
        $i = 0;
        $templates = array();
        
        foreach($query->result() as $row)
        {
            $templates[$i]['templateID'] = $row->templateID;
            $templates[$i]['templateName'] = $row->templateName;
            $templates[$i]['columnCount'] = $row->columnCount;
            $templates[$i]['columnCount'] = $row->online;
            $i++;
        }
               
        return $templates;
    }
    
    public function get_pages()
    {
        $this->db->order_by('pageName', 'asc');
        $query = $this->db->get('page');
        $i = 0;
        $pages = array();
        
        foreach($query->result() as $row)
        {
			$this->color = cp_get_color($this->color);
            $pages[$i]['pageID'] = $row->pageID;
            $pages[$i]['pageName'] = $row->pageName;
            $pages[$i]['online'] = $row->online;
            $pages[$i]['row_color'] = $this->color;
            $i++;
        }
        
        return $pages;
    }
    
    public function get_page($id)
    {
        $query = $this->db->get_where('page', array('pageID' => $id));
		$row = $query->row();
        
        $page['pageID'] = $id;
        $page['pageName'] = $row->pageName;
        
        return $page;      
    }
    
    public function create_page()
    {
        $page = array(
            'pageName' => $this->input->post('pagename'),
            'online'   => 0
        );
        
        $this->db->insert('page', $page);
        $pageID = $this->db->insert_id();
        
        return $pageID;
    }
    
    public function update_page($id)
    {
        $page = array(
            'pageName' => $this->input->post('pagename')
        );
        
        $this->db->where('pageID', $id);
		$this->db->update('page', $page);
    }
	
	public function switch_online_state($id, $online)
	{
		$this->db->update('page', array('online' => $online), 'pageID = '.$id);
	}
}
?>