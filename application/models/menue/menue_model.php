<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Menue Model
 *
 * Model zum Menue-Modul
 *
 * @package		com.cp.feuerwehr.models.menue
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 */	
 
class Menue_Model extends CI_Model {
	
	private $color = '';
	private $area;
	
	/**
	 * Konstruktor
	 *
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
		
		$this->load->helper('html');
		
		// Menübereich setzen
		if(!strpos(uri_string(), 'backend')) $this->area = 'frontend';
		else $this->area = 'backend';
	}
	
	public function get_menue_list($online)
	{
		$menue            = array();
		$menue_meta       = array();
        $menue_shortlink  = array();
        $count            = 0;
		$count_meta       = 0;
        $count_shortlink  = 0;
		
        $where = array($this->area => 1, 'superID' => 0, 'section' => 'main');
        if($online == 'online') $where['online'] = 1;
        
		$this->db->order_by('orderID', 'asc');
		$query = $this->db->get_where('menue', $where);
		$count = $query->num_rows();
		$i = 0;
		foreach($query->result() as $row)
		{
			$menue[$i]['menueID']            = $row->menueID;
			$menue[$i]['name']               = $row->name;
			$menue[$i]['link']               = $row->link;
			$menue[$i]['target']             = $row->target;
			$menue[$i]['slug']               = $row->slug;
			$menue[$i]['special_function']   = $row->special_function;
			$menue[$i]['online']             = $row->online;
			$menue[$i]['orderID']            = $row->orderID;
			$menue[$i]['row_color']	         = $this->color = cp_get_color($this->color);
			
            $where = array('superID' => $row->menueID);
            if($online == 'online') $where['online'] = 1;
			$this->db->order_by('orderID', 'asc');
			$query2 = $this->db->get_where('menue', $where);
			
			$menue[$i]['subItems'] = $query2->num_rows();
			
			if($query2->num_rows() != 0)
			{			
				$j=0;
				
				foreach($query2->result() as $row2)
				{
					$menue[$i]['submenue'][$j]['menueID']          = $row2->menueID;
					$menue[$i]['submenue'][$j]['name']             = $row2->name;
					$menue[$i]['submenue'][$j]['link']             = $row2->link;
					$menue[$i]['submenue'][$j]['target']           = $row2->target;
					$menue[$i]['submenue'][$j]['slug']             = $row2->slug;
                    $menue[$i]['submenue'][$j]['special_function'] = $row->special_function;
					$menue[$i]['submenue'][$j]['online']           = $row2->online;
					$menue[$i]['submenue'][$j]['orderID']          = $row2->orderID;
					$menue[$i]['submenue'][$j]['row_color']		   = $this->color = cp_get_color($this->color);
					$j++;	
				}	
			}				
			$i++;
		}
		
        $where = array($this->area => 1, 'section' => 'meta');
        if($online == 'online') $where['online'] = 1;
		$this->db->order_by('orderID', 'asc');
		$query = $this->db->get_where('menue', $where);
		
		$i = 0;
		$count_meta = $query->num_rows();
		
		foreach($query->result() as $row)
		{
			$menue_meta[$i]['menueID'] = $row->menueID;
			$menue_meta[$i]['name'] = $row->name;
			$menue_meta[$i]['link'] = $row->link;
			$menue_meta[$i]['target'] = $row->target;
			$menue_meta[$i]['slug'] = $row->slug;
			$menue_meta[$i]['online'] = $row->online;
			$menue_meta[$i]['orderID'] = $row->orderID;
			$menue_meta[$i]['row_color']	= $this->color = cp_get_color($this->color);			
			$i++;
		}		
		
        $where = array($this->area => 1, 'section' => 'shortlink');
        if($online == 'online') $where['online'] = 1;
		$this->db->order_by('orderID', 'asc');
		$query = $this->db->get_where('menue', $where);
		
		$i = 0;
		$count_shortlink = $query->num_rows();
		
		foreach($query->result() as $row)
		{
			$menue_shortlink[$i]['menueID'] = $row->menueID;
			$menue_shortlink[$i]['name'] = $row->name;
			$menue_shortlink[$i]['link'] = $row->link;
			$menue_shortlink[$i]['target'] = $row->target;
			$menue_shortlink[$i]['slug'] = $row->slug;
			$menue_shortlink[$i]['online'] = $row->online;
			$menue_shortlink[$i]['orderID'] = $row->orderID;
			$menue_shortlink[$i]['row_color']	= $this->color = cp_get_color($this->color);			
			$i++;
		}	
			
		$menue_ret['menue'] 		  = $menue;
		$menue_ret['menue_meta'] 	  = $menue_meta;
		$menue_ret['menue_shortlink'] = $menue_shortlink;
		$menue_ret['count'] 		  = $count;
		$menue_ret['count_meta'] 	  = $count_meta;
        $menue_ret['count_shortlink'] = $count_shortlink;
		
		return $menue_ret;
	}
	
	public function create_menue()
	{
		
	}
	
	public function update_menue()
	{
		
	}
	
	public function delete_menue($id)
	{		
		// prüfen, ob es sich um einen Oberpunkt handelt
		$query = $this->db->get_where('menue', array('menueID' => $id));
		$row = $query->row();	
		if($row->superID == 0)
			$this->db->delete('menue', array('superID' => $id));
		$this->db->delete('menue', array('menueID' => $id));
	}
	
	public function change_order($dir, $id)
	{
		$query = $this->db->get_where('menue', array('menueID' => $id));
		$row = $query->row();	
		
		$orderID  = $row->orderID;
		$superID  = $row->superID;
		$backend  = $row->backend;
		$frontend = $row->frontend;
		$section  = $row->section;
		
		if($dir == 'up') $newOrderID = $orderID-1;
		else $newOrderID = $orderID+1;
		
		$query2 = $this->db->get_where('menue', array('superID'  => $superID, 
													  'orderID'  => $newOrderID, 
													  'frontend' => $frontend, 
													  'backend'  => $backend, 
													  'section'  => $section));	
		$row2 = $query2->row();
		
		$this->db->trans_start();
		$this->db->update('menue', array('orderID' => $orderID), 'menueID = '.$row2->menueID);
		$this->db->update('menue', array('orderID' => $newOrderID), 'menueID = '.$id);
		$this->db->trans_complete();		
	}
	
	public function switch_online_state($id, $online)
	{
		$this->db->update('menue', array('online' => $online), 'menueID = '.$id);
	}
}
?>