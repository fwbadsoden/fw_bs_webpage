<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * User Model
 *
 * Model für den Usercontroller.
 * Kapselt die Funktionalität des Flexi_auth_model
 *
 * @package		com.cp.feuerwehr.models.user
 * @subpackage	Model
 * @category	Model
 * @author
 * 		Habib Pleines
 */	
include_once( APPPATH . 'models/user/flexi_auth_model.php' );
 
class User_Model extends Flexi_auth_model {
	private $color = '';
	
	/**
	 * Konstruktor
	 *
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
		
		$this->load->helper('string');
		$this->load->helper('html');
        $this->load->library('CP_auth');
	}    
	
	public function get_user_list($id = 0)
	{		
		if($id != 0) $this->db->where('userID', $id);
		$this->db->order_by('last_name', 'asc');
		$query = $this->db->get($this->db_user_table);
		$i = 0;
		
		foreach($query->result() as $row)
		{
			$counter = $i + 1;
			$this->user[$i]['row_color']	= $this->color = cp_get_color($this->color);
			$this->user[$i]['id']			= $counter;
			$this->user[$i]['userID'] 		= $row->userID;	
			$this->user[$i]['username'] 	= $row->username;	
			$this->user[$i]['email'] 		= $row->email;	
			$this->user[$i]['vorname'] 		= $row->first_name;	
			$this->user[$i]['nachname'] 	= $row->last_name;	
			$this->user[$i]['active'] 		= $row->active;	
			
			$i++;
		}
		return $this->user;
	}
    
    public function get_user_fullname($id)
    {
        $this->db->select('last_name, first_name');
        $query = $this->db->get_where($this->db_user_table, array('userID' => $id));
		$row = $query->row();
	
        $name = $row->vorname.' '.$row->nachname;
        return $name;
    }
	
	public function get_user($id)
	{
		$query = $this->db->get_where($this->db_user_table, array('userID' => $id));
		$row = $query->row();
		
		$userdata = array(
			'userID'		=> $id,
			'username'		=> $row->username,
			'vorname'		=> $row->first_name,
			'nachname'		=> $row->last_name,
			'email'			=> $row->email
		);
		return $userdata;
	}	
}

/* End of file user_model.php */
/* Location: ./application/models/user/user_model.php */