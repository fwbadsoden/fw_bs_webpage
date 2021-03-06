<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin Model
 *
 * Mittels des Admin Model werden die datenbankabhängigen Funktionen des Admin Moduls gesteuert.
 *
 * @package		com.cp.feuerwehr.models.admin
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 **/

class Admin_model extends CI_Model {
    
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
        $this->load->library('encrypt');
	}	
	
	public function get_menue()
	{
		$menue = array();
		$this->db->where(array('superID' => 0, 'online' => 1, 'backend' => 1))->order_by('orderID', 'asc');
		$query = $this->db->get('menue');
		$i = 0;
		
		foreach($query->result() as $row)
		{
            if($row->priv_key != "") $privileged = $this->cp_auth->is_privileged($row->priv_key);
            else $privileged = TRUE;
            if($privileged)
            {
    			$menue[$i]['name'] 			= $row->name;
    			$menue[$i]['link'] 			= $row->link;
    			$menue[$i]['target'] 		= $row->target;
		        $i++;
            }
		}
        
		return $menue;
	}
	
	public function get_submenue()
	{
		$submenue = array();
		
		// URI Parameter auswerten, um Login-URL abzufangen
		switch($this->uri->segment(2, 'admin'))	// prüft das 2. URI Segment und setzt default 'admin' falls nicht vorhanden
		{
			case 'check_login':		// das gleiche wie bei admin
			case 'admin':				$menueArea = 'admin';	break;
			default:				    $menueArea = $this->uri->segment(2);
		}
		
		$this->db->where(array('superID !=' => 0, 'slug' => $menueArea, 'online' => 1, 'backend' => 1))->order_by('orderID', 'asc');
		$query = $this->db->get('menue');
		$i = 0;
		
		foreach($query->result() as $row)
		{
            if($row->priv_key != "") $privileged = $this->cp_auth->is_privileged($row->priv_key);
            else $privileged = TRUE;
            if($privileged)
            {
			     $submenue[$i]['name'] 		= $row->name;	
			     $submenue[$i]['link'] 		= $row->link;
			     $submenue[$i]['target'] 	= $row->target;	
			     $i++;
            }
		}
		
		return $submenue;
	}
	
	public function insert_log($message)
	{   
		if($message == '' || $message == null) $message = $this->lang('log_admin_noMessage');
		$userdata = $this->cp_auth->cp_get_user_by_id();
    
    	$this->db->insert('admin_log', array('userID' => $userdata->uacc_id, 'datetime' => date('Y-m-d H:i:s'), 'message' => $message));
	}
	
	public function get_log()
	{
		$this->load->helper('html');
		
		$log = array();
		$this->color = '';
		$i = 0;
		
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get('admin_log');
		foreach($query->result() as $row)
		{
			$userdata 			    = $this->cp_auth->cp_get_user_by_id($row->userID);
			
			$log[$i]['logID'] 		= $row->logID;
			$log[$i]['userID'] 		= $row->userID;
			$log[$i]['vorname'] 	= $userdata->first_name;
			$log[$i]['nachname'] 	= $userdata->last_name;
			$log[$i]['email'] 		= $userdata->uacc_email;
			$log[$i]['datetime'] 	= cp_get_ger_datetime($row->datetime);
			$log[$i]['message'] 	= $row->message;	
			$log[$i]['rowColor']	= $this->color = cp_get_color($this->color);
			
			$i++;
		}		
		return $log;
	}
	
	public function insert_quicklink()
	{
		$userID = $this->cp_auth->get_user_id();
	}
	
	public function get_quicklinks()
	{
		$this->load->helper('html');
		$userID = $this->cp_auth->get_user_id();
		
		$links = array();
		$this->color = '';
		$i = 0;
		
		$this->db->order_by('name', 'asc');
		$query = $this->db->get_where('admin_quicklink', array('userID' => $userID));
		foreach($query->result() as $row)
		{
			$this->color 			= cp_get_color($this->color);
			
			$links[$i]['linkID'] 	= $row->linkID;
			$links[$i]['linkZiel'] 	= $row->target;
			$links[$i]['linkName'] 	= $row->name;
			
			$i++;
		}
		return $links;
	}
	
	public function edit_adminmessage()
	{
	   
	}
	
	public function get_adminmessage()
	{
		$this->load->helper('html');
		
		$message = array();
		$this->color = cp_get_color($this->color);
		
		$query = $this->db->get('admin_message');
		$row = $query->row();
		$userdata = $this->cp_auth->cp_get_user_by_id($row->userID);
		$message['datetime']	= cp_get_ger_datetime($row->datetime);
		$message['editor'] 		= $userdata->first_name.' '.$userdata->last_name;
		$message['titel'] 		= $row->title;
		$message['message']		= $row->message;
		$message['rowColor']	= $this->color;
		
		return $message;
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin/admin_model.php */