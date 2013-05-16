<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User Model
 *
 * Model für den Usercontroller.
 *
 * @package		com.cp.feuerwehr.models.user
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 */	
 
class User_Model extends CI_Model {
		
	private $db_user_table				= '';
	private $db_auth_table				= '';
	private $db_access_keys_table   	= '';
	private $delete_tables_admin		= '';
	
	private $user		 				=	array();	//	user info in database	
	private $color						= '';
	
	/**
	 * Konstruktor
	 *
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
		
		$this->load->library('CP_auth');
		$this->load->helper('string');
		$this->load->helper('html');
	}
	
	public function init($area)
	{
		switch ($area)
		{
			case 'backend':		$this->db_user_table 		= CPAUTH_DB_ADMIN_USER_TABLE;
								$this->db_auth_table 		= CPAUTH_DB_ADMIN_AUTH_TABLE;
								$this->db_access_keys_table = CPAUTH_DB_ADMIN_ACCESSKEYS_TABLE;
								$this->delete_tables_admin	= 1;
								break;
			case 'frontend':	$this->db_user_table 		= CPAUTH_DB_USER_TABLE;
								$this->db_auth_table 		= CPAUTH_DB_AUTH_TABLE;	
								$this->db_access_keys_table = CPAUTH_DB_ACCESSKEYS_TABLE;
								$this->delete_tables_admin	= 0;
								break;
		}
	}
	
	public function get_user_list($id = 0)
	{		
		if($id != 0) $this->db->where('userID', $id);
		$this->db->order_by('nachname', 'asc');
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
			$this->user[$i]['vorname'] 		= $row->vorname;	
			$this->user[$i]['nachname'] 	= $row->nachname;	
			$this->user[$i]['active'] 		= $row->active;	
			
			$i++;
		}
		return $this->user;
	}
    
    public function get_user_fullname($id)
    {
        $this->db->select('nachname, vorname');
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
			'vorname'		=> $row->vorname,
			'nachname'		=> $row->nachname,
			'email'			=> $row->email
		);
		return $userdata;
	}
	
	public function create_user()
	{
		$this->user['userdata'] = array(
			'username' 		=> $this->input->post('username'),
			'email'			=> strtolower($this->input->post('email')),
			'vorname'		=> $this->input->post('vorname'),
			'nachname'		=> $this->input->post('nachname'),
			'creation_date' => date('Y-m-d', time())
		);
		
		$this->db->insert($this->db_user_table, $this->user['userdata']);
		$this->user['userdata']['userID'] = $this->db->insert_id();
		
		$CI =& get_instance();
		$CI->load->model('cpauth/cpauth_model', 'cpauth');
		$this->user['authdata']['initial_pw'] = $CI->cpauth->set_initial_password($this->user['userdata']['userID']);
		
		return $this->user;
	}
	
	public function update_user($id)
	{
		$user = array(
			'username'		=> $this->input->post('username'),
			'email'			=> strtolower($this->input->post('email')),
			'vorname'		=> $this->input->post('vorname'),
			'nachname'		=> $this->input->post('nachname')
		);
		
		$this->db->where('userID', $id);
		$this->db->update($this->db_user_table, $user);
	}
	
	public function delete_user($id)
	{
		$this->db->trans_start();
		$tables = array($this->db_user_table, $this->db_auth_table, $this->db_access_keys_table);
		$this->db->where('userID', $id);
		$this->db->delete($tables);	
		if($this->delete_tables_admin == 1)	
		{
			$tables = array('admin_quicklink', 'admin_log');
			$this->db->where('userID', $id);
			$this->db->delete($tables);			
		}
		$this->db->trans_complete();
	}
	
	public function switch_online_state($userID, $active)
	{
		$this->db->update($this->db_user_table, array('active' => $active), 'userID = '.$userID);
	}
	
	public function is_attr_unique($area, $attr, $value, $id)
	{
		$this->init($area);
		if($id > 0) $this->db->where('userID !=', $id);
		$this->db->where($attr, strtolower($value));
		$query = $this->db->get($this->db_user_table);
		if($query->num_rows() == 0) return '1'; else return '0';	
	}
	
	public function get_user_table()
	{
		return $this->db_user_table;	
	}
}

?>