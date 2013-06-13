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
            $templates[$i]['templateID']        = $row->templateID;
            $templates[$i]['templateName']      = $row->name;
            $templates[$i]['special_page']      = $row->special_page;
            $templates[$i]['special_function']  = $row->special_function;
            $templates[$i]['columnCount']       = $row->column_count;
            $templates[$i]['sidebar']           = $row->sidebar;
            $templates[$i]['online']            = $row->online;
            $i++;
        }
               
        return $templates;
    }
    
    public function get_pages()
    {
        $this->db->order_by('name', 'asc');
        $query = $this->db->get('page');
        $i = 0;
        $pages = array();
        
        foreach($query->result() as $row)
        {
            $pages[$i]['pageID']            = $row->pageID;
            $pages[$i]['pageName']          = $row->name;
            $pages[$i]['pageTitle']         = $row->title;
            $pages[$i]['special_page']      = $row->special_page;
            $pages[$i]['special_function']  = $row->special_function;
            $pages[$i]['column_count']      = $row->column_count;
            $pages[$i]['sidebar']           = $row->sidebar;;
            $pages[$i]['stageID']           = $row->stageID;
            $pages[$i]['online']            = $row->online;
            $pages[$i]['row_color']         = $this->color = cp_get_color($this->color);
            $pages[$i]['is_deletable']      = $this->is_page_deletable($row->pageID);
            $i++;
        }
        
        return $pages;
    }
    
    public function get_page($id)
    {
        $query = $this->db->get_where('page', array('pageID' => $id));
		$row = $query->row();
        
        $page['pageID']             = $id;
        $page['pageName']           = $row->name;
        $page['pageTitle']          = $row->title;
        $page['special_page']       = $row->special_page;
        $page['special_function']   = $row->special_function;
        $page['column_count']       = $row->column_count;
        $page['sidebar']            = $row->sidebar;
        $page['templateID']         = $row->templateID;
        $page['stageID']            = $row->stageID;
        $page['is_deletable']       = $this->is_page_deletable($id);
        
        return $page;      
    }
    
    public function get_pagename($id)
    {
        $this->db->select('name');
        $query = $this->db->get_where('page', array('pageID' => $id));
        $row   = $query->row();
        
        return $row->name;
    }
    
    public function is_page_deletable($id)
    {
        $query = $this->db->get_where('menue', array('frontend_pageID' => $id));
        $num_rows = $query->num_rows();
        
        if($num_rows == 0) return true; else return false;
    }
    
    public function get_page_content_frontend($id)
    {
        $content = array();
        $query = $this->db->get_where('v_page', array('pageID' => $id));
        if($query->num_rows() == 0) return '404';
        $row_counter = 0;
        $box_counter = 0;
        $rowID = 0;
        $boxContentID = 0;
        
        foreach($query->result() as $key => $row) {
            if($key == 0) {
                $content['pageID']           = $id;
                $content['title']            = $row->title;
                $content['column_count']     = $row->column_count;
                $content['stage']            = $this->get_stage_images($row->stageID); 
                $content['special_page']     = $row->special_page;
                $content['special_function'] = $row->special_function; 
                $content['sidebar']          = $row->sidebar; 
            }
            if($row->special_page == 0) {
                if($row->rowID != $rowID) {
                    $rowID = $row->rowID;
                    $row_counter++;
                }
                $content['row'][$row_counter]['box'][$box_counter]['special_box']       = $row->special_box;
                $content['row'][$row_counter]['box'][$box_counter]['box_tags']          = $row->box_tags;
                $content['row'][$row_counter]['box'][$box_counter]['box_controller']    = $row->box_controller;
                $content['row'][$row_counter]['box'][$box_counter]['box_function']      = $row->box_function;
                $content['row'][$row_counter]['box'][$box_counter]['box_content_type']  = $row->box_content_type;
                if($row->box_content != '')
                    $content['row'][$row_counter]['box'][$box_counter]['box_content']       = $row->box_content;
                else {                    
                    $content['row'][$row_counter]['box'][$box_counter]['box_image']         = $row->box_image;
                    $content['row'][$row_counter]['box'][$box_counter]['box_image_mime']    = $row->box_image_mime;
                    $content['row'][$row_counter]['box'][$box_counter]['box_image_title']   = $row->box_image_title;
                    $content['row'][$row_counter]['box'][$box_counter]['box_image_width']   = $row->box_image_width;
                    $content['row'][$row_counter]['box'][$box_counter]['box_image_height']  = $row->box_image_height;
                }
                $box_counter++;                                           
            }    
        }
        return $content;
    }
    
    public function get_page_content($id)
    {
        $content = array();
        
        $query = $this->db->get_where('page', array('pageID' => $id));
        $row   = $query->row();
        
        $content['pageID']      = $id;
        $content['templateID']  = $row->templateID;
        $content['pageName']    = $row->name;
        $content['pageTitle']   = $row->title;
        $content['stageID']     = $row->stageID;
        $content['columnCount'] = $row->column_count;
        $content['sidebar']     = $row->sidebar;
        
        $query = $this->db->get_where('page_template', array('templateID' => $row->templateID));
        $row   = $query->row();
        
        $content['templateName']    = $row->name;
        
        // eventuell durch JOIN ersetzen
        $this->db->order_by('orderID', 'asc');
        $query = $this->db->get_where('page_row', array('pageID' => $id));
        $content['rowCount'] = $query->num_rows();
        $i=0;
        
        foreach($query->result() as $row)
        {
            $content['rows'][$i]['rowID']   = $row->rowID;
            $content['rows'][$i]['orderID'] = $row->orderID;
            
            $this->db->order_by('rowContentID', 'asc');
            $query2 = $this->db->get_where('page_row_content', array('rowID' => $row->rowID));
            $j = 0;
            
            foreach($query2->result() as $row)
            {                                
                $query3  = $this->db->get_where('page_box', array('boxID' => $row->boxID));
                $row_box = $query3->row();          
                $query4  = $this->db->get_where('page_box_content', array('rowContentID' => $row->rowContentID));   
             
                $content['rows'][$i]['boxes'][$j]['rowContentID']   = $row->rowContentID;                 
                $content['rows'][$i]['boxes'][$j]['boxID']          = $row_box->boxID;
                $content['rows'][$i]['boxes'][$j]['boxName']        = $row_box->name;
                $content['rows'][$i]['boxes'][$j]['columnCount']    = $row_box->column_count;
                $content['rows'][$i]['boxes'][$j]['specialBox']     = $row_box->specialbox;
                $content['rows'][$i]['boxes'][$j]['boxImg']         = $row_box->box_img;
                $content['rows'][$i]['boxes'][$j]['boxTags']        = $row_box->box_tags; 
                $content['rows'][$i]['boxes'][$j]['boxTagsNames']   = $row_box->box_tag_names;  
                $k = 0;
                foreach($query4->result() as $row_content)
                { 
                    $content['rows'][$i]['boxes'][$j]['content'][$k]['boxContentID'] = $row_content->boxContentID;
                    $content['rows'][$i]['boxes'][$j]['content'][$k]['contentType']  = $row_content->content_type;
                    $k++;              
                }                
                $j++;
            }
            $i++;
        }
        
        return $content;
    }
    
    public function get_allowed_boxes($id)
    {
        // aktuelle Anzahl der "vollen" Spalten in der Zeile und noch freie Spalten ermitteln
        $columns = $this->get_row_columns($id);
        $ids = $this->get_superIDs_from_rowID($id);
        
        $this->db->order_by('page_box.column_count', 'desc');
        $this->db->join('page_box_allowed_templates_mapping batm', 'batm.boxID = page_box.boxID', 'inner');
        $this->db->where('batm.templateID', $ids['templateID']);
        $this->db->where('page_box.online', 1);
        $query = $this->db->get('page_box');
        $i=0;
        $boxes = array();
        
        foreach($query->result() as $row)
        {
            if($columns['empty'] >= $row->column_count) 
            {
                $boxes[$i]['boxID']         = $row->boxID;
                $boxes[$i]['pageID']        = $ids['pageID'];
                $boxes[$i]['boxName']       = $row->name;
                $boxes[$i]['columnCount']   = $row->column_count;
                $boxes[$i]['boxImg']        = $row->box_img;
                $boxes[$i]['specialBox']    = $row->specialbox;
                $i++;
            }
        }
        
        return $boxes;
    }
    
    private function get_superIDs_from_rowID($rowID)
    {
        $this->db->join('page', 'page.pageID = page_row.pageID');
        $query = $this->db->get_where('page_row', array('rowID' => $rowID));
        $row   = $query->row();
        
        $ids['templateID'] = $row->templateID;
        $ids['pageID'] = $row->pageID;
        
        return $ids;
    }
    
    public function get_box_meta($rowContentID)
    {
        $this->db->join('page_box', 'page_box.boxID = page_row_content.boxID');
        $this->db->where('page_row_content.rowContentID', $rowContentID);
        $query = $this->db->get('page_row_content');
        $row   = $query->row();
        
        $box_meta = array(
            'boxID'         => $row->boxID,
            'boxName'       => $row->name,
            'columnCount'   => $row->column_count,
            'specialBox'    => $row->specialbox,
            'boxTags'       => $row->box_tags,
            'boxTagsNames'  => $row->box_tag_names,
            'boxImg'        => $row->box_img
        );
        
        return $box_meta;        
    }
    
    public function get_box_content($boxContentID)
    {
        $query = $this->db->get_where('page_box_content', array('boxContentID' => $boxContentID));
        $row   = $query->row();
        $content = array();

        $content['boxContentID']    = $boxContentID;
        $content['contentType']     = $row->content_type;
        $content['createdBy']       = $row->created_by;
        $content['created']         = $row->created;
        $content['modifiedBy']      = $row->modified_by;
        $content['modified']        = $row->modified;
        $content['image']           = $row->img;
        $content['content']         = $row->content;
        
        return $content;
    }
    
    public function get_row_columns($rowID)
    {
        // aktuelle Anzahl der "vollen" Spalten in der Zeile ermitteln
        $this->db->join('page_box', 'page_box.boxID = page_row_content.boxID');
        $query = $this->db->get_where('page_row_content', array('rowID' => $rowID));
        $fullColumns = 0;
        foreach($query->result() as $row)
        {
            $fullColumns += $row->column_count;
        }
        
        $ids = $this->get_superIDs_from_rowID($rowID);
        
        $query = $this->db->get_where('page', array('templateID' => $ids['templateID']));
        $row   = $query->row();
        
        $columns['full']  = $fullColumns;
        $columns['empty'] = $row->column_count - $fullColumns;
        
        return $columns;  
    }
    
    public function get_stages()
    {
        $this->db->order_by('name', 'asc');
        $query  = $this->db->get('page_stage');
        $stages = array();
        $i=0;
        
        foreach($query->result() as $row)
        {
            $stages[$i]['stageID']      = $row->stageID;
            $stages[$i]['name']         = $row->name;
            $stages[$i]['online']       = $row->online;
            $stages[$i]['row_color']    = $this->color = cp_get_color($this->color);
            
            $i++;
        }
        
        return $stages;
    }
    
    public function get_stage_images($id)
    {
        $this->db->select('page_stage_images.text as text, page_stage_images.class as class, page_stage_images.orderID as orderID, file.fullpath, file.title');
        $this->db->order_by('page_stage_images.orderID', 'asc');
        $this->db->join('page_stage_images', 'page_stage_images.stageID = page_stage.stageID');
        $this->db->join('file', 'file.fileID = page_stage_images.fileID');
        $this->db->join('page_stage_template', 'page_stage_template.templateID = page_stage.templateID');
        $query = $this->db->get_where('page_stage', array('page_stage.stageID' => $id));
        
        $stage_images = array();
        $i = 0;
        
        $stage_images['count_images'] = $query->num_rows();
        foreach($query->result() as $row)
        {
            $stage_images['images'][$i]['text']  = explode(PAGES_STAGE_TEXT_SEPARATOR, $row->text);
            $stage_images['images'][$i]['title'] = $row->title;
            $stage_images['images'][$i]['file']  = $row->fullpath;
            $stage_images['images'][$i]['class']  = $row->class;
            $stage_images['images'][$i]['orderID']  = $row->orderID;
            $i++;
        }
        
        return $stage_images;
    }
    
    public function add_row($pageID)
    {
        $this->db->order_by('orderID', 'desc');
        $query = $this->db->get_where('page_row', array('pageID' => $pageID));
        $row = $query->row();
        
        if($query->num_rows() == 0) $newOrderID = 1;
        else $newOrderID = $row->orderID + 1;
        
        $row = array(
            'pageID'  => $pageID,
            'orderID' => $newOrderID
        );        
        $this->db->insert('page_row', $row);
    }
    
    public function change_row_order($dir, $rowID)
    {
        $query = $this->db->get_where('page_row', array('rowID' => $rowID));
		$row   = $query->row();	
		
		$orderID = $row->orderID;
		$pageID  = $row->pageID;
		
		if($dir == 'up') $newOrderID = $orderID-1;
		else $newOrderID = $orderID+1;
		
		$query2 = $this->db->get_where('page_row', array('orderID' => $newOrderID, 
  													     'pageID' => $pageID));	
		$row2   = $query2->row();
		
		$this->db->trans_start();
		$this->db->update('page_row', array('orderID' => $orderID), 'rowID = '.$row2->rowID);
		$this->db->update('page_row', array('orderID' => $newOrderID), 'rowID = '.$rowID);
		$this->db->trans_complete();
    }
    
    public function add_box($rowID, $boxID)
    {
        $box = array(
            'boxID' => $boxID,
            'rowID' => $rowID
        );
        
        $this->db->insert('page_row_content', $box);
        $insertID = $this->db->insert_id();
        $box_meta = $this->get_box_meta($insertID);                    
        
        if($box_meta['specialBox'] != 1)
        {        
            $boxTags = explode(PAGES_BOX_TAGS_SEPARATOR, $box_meta['boxTags']);  
            foreach($boxTags as $b)
            {
                $boxContent = array(
                    'rowContentID'   => $insertID,
                    'content_type'   => $b,
                    'created_by'     => $this->cp_auth->get_user_id(),  
                    'created'        => date("Y-m-d H:i:s")
                );       
                $this->db->insert('page_box_content', $boxContent);
            }
        }
    } 
    
    public function update_box_content($boxContentID)
    { 
        $boxContent['modified_by'] = $this->cp_auth->get_user_id();  
        $boxContent['modified']   = date("Y-m-d H:i:s");  
        
        if(!$this->input->post('content_txt')) $boxContent['content'] = NULL;
        else $boxContent['content']    = $this->input->post('content_txt');
        
        if(!$this->input->post('content_img')) $boxContent['img'] = NULL;
        else $boxContent['img']        = $this->input->post('content_img');
        
        $this->db->update('page_box_content', $boxContent, array('boxContentID' => $boxContentID));
    }
    
    public function create_page()
    {
        $query = $this->db->get_where('page_template', array('templateID' => $this->input->post('templateid')));
        $row = $query->row();
        $page = array(
            'name'              => $this->input->post('pagename'),
            'title'             => $this->input->post('pagetitle'),
            'stageID'           => $this->input->post('stageid'),
            'special_page'      => $row->special_page,
            'special_function'  => $row->special_function,
            'column_count'      => $row->column_count,
            'sidebar'           => $row->sidebar,
            'online'            => 0,
            'templateID'        => $this->input->post('templateid')
        );
        $this->db->insert('page', $page);
        $pageID = $this->db->insert_id();
        
        return $pageID;
    }
    
    public function update_page($id)
    { 
        $page = array(
            'name'    => $this->input->post('pagename'),
            'title'   => $this->input->post('pagetitle'),
            'stageID' => $this->input->post('stageid'),
        );
		$this->db->update('page', $page, array('pageID' => $id));
    }
    
    public function delete_page($pageID)
    {
        $query = $this->db->get_where('page_row', array('pageID' => $pageID));
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $this->delete_row($row->rowID, $pageID);
            }
        }
        $this->db->delete('page', array('pageID' => $pageID));
    }
    
    public function delete_row($rowID, $pageID)
    {
        $query = $this->db->get_where('page_row_content', array('rowID' => $rowID));
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $this->delete_box($row->rowContentID);
            }
        }        
        $this->db->delete('page_row', array('rowID' => $rowID));
        
        /* neu sortieren */
        $query = $this->db->get_where('page_row', array('pageID' => $pageID));
        if($query->num_rows() > 0)
        {
            $i = 1;
            foreach($query->result() as $row)
            {
                $this->db->update('page_row', array('orderID' => $i), array('rowID' => $row->rowID));
                $i++;
            }
        }
    }
    
    public function delete_box($rowContentID)
    {
        $query = $this->db->get_where('page_box_content', array('rowContentID' => $rowContentID));        
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $this->delete_box_content($rowContentID);
            }
        }   
        $this->db->delete('page_row_content', array('rowContentID' => $rowContentID));         
    }
    
    private function delete_box_content($rowContentID)
    {
        $this->db->delete('page_box_content', array('rowContentID' => $rowContentID)); 
    }
	
	public function switch_online_state($id, $online)
	{
		$this->db->update('page', array('online' => $online), 'pageID = '.$id);
	}
	
	public function switch_stage_online_state($id, $online)
	{
		$this->db->update('stage', array('online' => $online), 'stageID = '.$id);
	}
}
?>