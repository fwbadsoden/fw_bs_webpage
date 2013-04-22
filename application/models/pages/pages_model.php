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
        if($online != 'all') $this->db->where(array('online' => $online));
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
    
    public function get_page_content($id)
    {
        $content = array();
        
        $query = $this->db->get_where('page', array('pageID' => $id));
        $row = $query->row();
        
        $content['pageID'] = $id;
        $content['templateID'] = $row->templateID;
        
        $query = $this->db->get_where('page_template', array('templateID' => $row->templateID));
        $row = $query->row();
        
        $content['columnCount'] = $row->columnCount;
        
        // eventuell durch JOIN ersetzen
        $this->db->order_by('orderID', 'asc');
        $query = $this->db->get_where('page_row', array('pageID' => $id));
        $i=0;
        foreach($query->result() as $row)
        {
            $content['rows'][$i]['rowID'] = $row->rowID;
            $content['rows'][$i]['rowName'] = $row->orderID;
            
            $this->db->order_by('contentID', 'asc');
            $query2 = $this->db->get_where('page_row_content', array('rowID' => $row->rowID));
            $j = 0;
            
            foreach($query2->result() as $row)
            {
                $content['rows'][$i]['boxes'][$j]['contentID'] = $row->contentID;
                                
                $query3 = $this->db->get_where('page_box', array('boxID' => $row->boxID));
                $row_box = $query3->row();
                
                $content['rows'][$i]['boxes'][$j]['boxID'] = $row_box->boxID;
                $content['rows'][$i]['boxes'][$j]['boxName'] = $row_box->boxName;
                $content['rows'][$i]['boxes'][$j]['columnCount'] = $row_box->columnCount;
                $content['rows'][$i]['boxes'][$j]['specialBox'] = $row_box->specialBox;
                $content['rows'][$i]['boxes'][$j]['boxImg'] = $row_box->boxImg;
                $content['rows'][$i]['boxes'][$j]['boxTags'] = $row_box->boxTags;
                $j++;
            }
            $i++;
        }
        
        return $content;
    }
    
    public function get_allowed_boxes($id)
    {
        // aktuelle Anzahl der "vollen" Spalten in der Zeile ermitteln
        $this->db->join('page_box', 'page_box.boxID = page_row_content.boxID');
        $query = $this->db->get_where('page_row_content', array('rowID' => $id));
        $fullColumns = 0;
        foreach($query->result() as $row)
        {
            $fullColumns += $row->columnCount;
        }
        
        $this->db->join('page', 'page.pageID = page_row.pageID');
        $query = $this->db->get_where('page_row', array('rowID' => $id));
        $row = $query->row();
        
        $templateID = $row->templateID;
        $pageID = $row->pageID;
        
        $query = $this->db->get_where('page_template', array('templateID' => $templateID));
        $row = $query->row();
        $columnCount = $row->columnCount;
        
        $this->db->join('page_box_allowed_templates_mapping batm', 'batm.boxID = page_box.boxID', 'inner');
        $this->db->where('batm.templateID', $templateID);
        $this->db->where('page_box.online', 1);
        $query = $this->db->get('page_box');
        $i=0;
        $boxes = array();
        
        foreach($query->result() as $row)
        {
            if(($fullColumns + $row->columnCount) <= $columnCount) 
            {
                $boxes[$i]['boxID'] = $row->boxID;
                $boxes[$i]['pageID'] = $pageID;
                $boxes[$i]['boxName'] = $row->boxName;
                $boxes[$i]['columnCount'] = $row->columnCount;
                $boxes[$i]['boxImg'] = $row->boxImg;
                $boxes[$i]['specialBox'] = $row->specialBox;
                $i++;
            }
        }
        
        return $boxes;
    }
    
    public function add_row($pageID)
    {
        $this->db->order_by('orderID', 'desc');
        $query = $this->db->get_where('page_row', array('pageID' => $pageID));
        $row = $query->row();
        
        $newOrderID = $row->orderID + 1;
        
        $row = array(
            'pageID' => $pageID,
            'orderID' => $newOrderID
        );        
        $this->db->insert('page_row', $row);
    }
    
    public function add_box($rowID, $boxID)
    {
        $box = array(
            'boxID' => $boxID,
            'rowID' => $rowID
        );
        $this->db->insert('page_row_content', $box);
    }
    
    public function create_page()
    {
        $page = array(
            'pageName' => $this->input->post('pagename'),
            'online'   => 0,
            'templateID' => $this->input->post('templateid')
        );
        $this->db->insert('page', $page);
        $pageID = $this->db->insert_id();
        
        return $pageID;
    }
    
    public function update_page($id)
    {
        $page = array(
            'pageName' => $this->input->post('pagename'),
            'templateID' => $this->input->post('templateid')
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