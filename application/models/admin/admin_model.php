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
	}	
	
	public function get_menue()
	{
		$menue = array();
		
		$this->db->where(array('superID' => 0, 'online' => 1, 'backend' => 1))->order_by('orderID', 'asc');
		$query = $this->db->get('menue');
		$i = 0;
		
		foreach($query->result() as $row)
		{
			$menue[$i]['name'] 			= $row->name;
			$menue[$i]['link'] 			= $row->link;
			$menue[$i]['target'] 		= $row->target;
			$i++;	
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
			$submenue[$i]['name'] 		= $row->name;	
			$submenue[$i]['link'] 		= $row->link;
			$submenue[$i]['target'] 	= $row->target;
			
			$i++;
		}
		
		return $submenue;
	}
	
	public function insert_log($message)
	{	
		if($message == '' || $message == null) $message = $this->lang('log_admin_noMessage');
		$userdata = $this->cp_auth->cp_get_userdata($this->session->userdata(CPAUTH_SESSION_BACKEND));
		$this->db->insert('admin_log', array('userID' => $userdata['userID'], 'datetime' => date('Y-m-d H:i:s'), 'message' => $message));
	}
	
	public function get_log()
	{
		$this->load->helper('html');
		
		$log = array();
		$color = '';
		$i = 0;
		
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get('admin_log');
		foreach($query->result() as $row)
		{
			$userdata 			= $this->cpauth->get_userdata($row->userID);
			$color 				= cp_get_color($color);
			
			$log[$i]['logID'] 		= $row->logID;
			$log[$i]['userID'] 		= $row->userID;
			$log[$i]['vorname'] 	= $userdata['vorname'];
			$log[$i]['nachname'] 	= $userdata['nachname'];
			$log[$i]['email'] 		= $userdata['email'];
			$log[$i]['datetime'] 	= cp_get_ger_datetime($row->datetime);
			$log[$i]['message'] 	= $row->message;	
			$log[$i]['rowColor']	= $color;
			
			$i++;
		}		
		return $log;
	}
	
	public function insert_quicklink()
	{
		$userdata = $this->cp_auth->cp_get_userdata($this->session->userdata(CPAUTH_SESSION_BACKEND));
	}
	
	public function get_quicklinks()
	{
		$this->load->helper('html');
		$userdata = $this->cp_auth->cp_get_userdata($this->session->userdata(CPAUTH_SESSION_BACKEND));
		
		$links = array();
		$color = '';
		$i = 0;
		
		$this->db->order_by('linkName', 'asc');
		$query = $this->db->get_where('admin_quicklink', array('userID' => $userdata['userID']));
		foreach($query->result() as $row)
		{
			$color 				= cp_get_color($color);
			
			$links[$i]['linkID'] 	= $row->linkID;
			$links[$i]['linkZiel'] 	= $row->target;
			$links[$i]['linkName'] 	= $row->name;
			
			$i++;
		}
		return $links;
	}
	
	public function edit_adminmessage()
	{
		$userdata = $this->cp_auth->cp_get_userdata($this->session->userdata(CPAUTH_SESSION_BACKEND));	
	}
	
	public function get_adminmessage()
	{
		$this->load->helper('html');
		
		$message = array();
		$color = '';
		$color = cp_get_color($color);
		
		$query = $this->db->get('admin_message');
		$row = $query->row();
		$userdata = $this->cpauth->get_userdata($row->userID);
		$message['datetime']	= cp_get_ger_datetime($row->datetime);
		$message['editor'] 		= $userdata['vorname'].' '.$userdata['nachname'];
		$message['titel'] 		= $row->title;
		$message['message']		= $row->message;
		$message['rowColor']	= $color;
		
		return $message;
	}
}
?>