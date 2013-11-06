<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CPAuth Model
 *
 * Model zur Authentifizierungssteuerung.
 *
 * @package		com.cp.feuerwehr.models.cpauth
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 */	
 
class CPAuth_Model extends CI_Model {
	
//	user defined:
public  $program				= 	'default';			//	program name (for example, ezsell, ezstore, user-defined program)
public  $protected_pages 		= 	array();			//	pages to protect along with access level

private $db_user_table			= CPAUTH_DB_USER_TABLE;
private $db_auth_table			= CPAUTH_DB_AUTH_TABLE;

private $session_name   		= CPAUTH_SESSION_FRONTEND;
private $cookie_name_autologin  = CPAUTH_COOKIE_FRONTEND;

private $roles = array('user', 'admin');

//	other user defined variables:
private $cookie_expire			=	'86500';			//	when to expire cookies
private	$cookie_domain			=	'';					//	cookie domain

//cpauth defined:
private $user		 			=	array();	//	user info in database

	/**
	 * Konstruktor
	 *
	 * Läd die CP_auth Library für Hashfunktionalität
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->helper('string');
	}
	
	/**
	 * Initialisierung des Models
	 *
	 * Läd die korrekten Datenbanktabellen zur Abbildung von Frontend/Backend
	 * Standardmäßig werden die Frontendtabellen geladen, um den Backendzugriff nur durch explizite Angabe aufrufbar zu machen.
	 *
	 * Input area (FRONTEND/BACKEND)
	 *
	 * @access public
	 */
	public function init($area) {		
		// Login Area defines Tables useda
		if($area == 'BACKEND')
		{
			$this->db_user_table = CPAUTH_DB_ADMIN_USER_TABLE;
			$this->db_auth_table = CPAUTH_DB_ADMIN_AUTH_TABLE;
			
			// Session prüfen/öffnen
			$this->session_name = CPAUTH_SESSION_BACKEND;
			$this->cookie_name_autologin  = CPAUTH_COOKIE_BACKEND;
			if ($this->session->userdata($this->session_name)) {
				$this->user = $this->session->userdata($this->session_name);
			}
		}
		// else FRONTEND als default)
		else
		{			
			// Session prüfen/öffnen
			if ($this->session->userdata($this->session_name)) {
				$this->user = $this->session->userdata($this->session_name);		
			}
		}
	}
	
	/**
	 * Logout
	 *
	 * Setzt die Session zurück, verwirft - falls gesetzt - das Cookie und leitet zum angegebenen Ziel weiter
	 *
	 * @access public
	 */
	public function logout($redirect = '', $drop_cookie = true) {
		$this->session->sess_destroy();
		if ($drop_cookie == true) $this->_drop_userinfo();
		if (!empty($redirect)) redirect($redirect);
	}
	
	/**
	 * Login
	 *
	 * Baut bei korrekten Logindaten die Usersession auf.
	 * Wird die Methode ohne Parameter (login()) aufgerufen, dann werden die Werte POST username und POST password verwendet, andernfalls können die Werte auch als Parameter übergeben werden
	 * Rückgabe ist ein Array mit den Werten authorize und error. In error steht im Fehlerfall der Fehlertext
	 * Mittels Übergabe des Cookie_Hash kann auch via Cookie eingelogged werden
	 *
	 * Input username (string), password (string), give_new_key (boolean), cookie_hash (string), get_all_user_info (boolean)
	 * Output authorization (array)
	 *
	 * @access public
	 * @returns array(authorize, error)
	 */
	public function login($un = null, $pw = null, $give_new_key = false, $cookie_hash = '', $get_all_user_info = true) {
		$un = (empty($un)) ? $this->input->post('username') : $un;
		$pw = (empty($pw)) ? $this->input->post('password') : $pw;
		$this->load->helper('email');
		if(valid_email($un)) $where = 'lower(email)'; else $where = 'lower(username)';
		
		// Prüfen ob Username existiert und Salt auslesen
		$this->db->select('salt, username')->from($this->db_user_table)->join($this->db_auth_table, $this->db_auth_table.'.userID = '.$this->db_user_table.'.userID')->where($where, strtolower($un))->where('active', 1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			$userdata = $query->row();
			$hashed_pw = $this->cp_auth->cp_hash_password($pw, $userdata->salt);
			$username = $userdata->username;

			// Weitere Loginprüfung
			unset($query, $userdata);
		 	if ($get_all_user_info == false) {
				$this->db->select($this->db_user_table.'.userID');
			} else {
				$this->db->select($this->db_user_table.'.userID as userID, '.$this->db_user_table.'.*, '.$this->db_auth_table.'.is_initial');
			}
			if (empty($cookie_hash)) {
				$this->db->join($this->db_auth_table, $this->db_auth_table.'.userID = '.$this->db_user_table.'.userID');
				$query = $this->db->get_where($this->db_user_table, array('lower(username)' => strtolower($username), 'password' => $hashed_pw));
			} else {
				$this->db->join($this->db_user_table, $this->db_auth_table.'.userID = '.$this->db_user_table.'.userID', 'left');
				$query = $this->db->get_where($this->db_auth_table, array('cookie_hash' => $cookie_hash));
			}			
				
			if ($query->num_rows() > 0) {
				$userdata = $query->row();
				
				if($userdata->is_initial == 1)
					return array('authorize' => false, 'initial' => true, 'userID' => $userdata->userID);
				
				$this->_update_session($userdata);
				
				// Update User with current loginDate
				$this->db->where('userID', $userdata->userID);
				$this->db->update($this->db_auth_table, array('last_login' => date('Y-m-d H:i:s')));
				
				return array('authorize' => true, 'initial' => false);
			} else {
				return array('authorize' => false, 'initial' => false, 'error' => lang('error_cpauth_loginfalse'));
			}
		} else {
			return array('authorize' => false, 'intial' => false, 'error' => lang('error_cpauth_loginfalse'));
		}
	}
	
	/**
	 * Aktualisierung der Session
	 *
	 * Aktualisiert die Session mit den aktuellen Userdaten
	 *
	 * Input cp_array(array)
	 *
	 * @access private
	 */
	private function _update_session($cp_array) {
		$cp[$this->session_name] = $cp_array;
		$this->session->set_userdata($cp);
		$this->user = $cp_array;
		
	}
	
	/**
	 * Session prüfen
	 *
	 * Prüft, ob es eine aktive User-Session gibt.
	 *
	 * Output login_ok (boolean)
	 *
	 * @access private
	 */	 
	 public function is_logged_in()
	 {
	 	if(!empty($this->user)) return true;
	 	else return false;
	 }	

	/** Passwort vergessen besteht aus 2 Steps: */
	// STEP 1:
	
	/**
	 * Reset Code generieren
	 *
	 * Generiert an Hand der User ID einen Reset Code und gibt den Code und die Emailadresse zurück
	 *
	 * Input userID (int)
	 *
	 * @access public
	 * @return array(reset_code,email)
	 */
	public function get_reset_code($userID) {
		if (empty($userID)) return false;
		
		$reset_code = $this->_generate_activation_code('$art/&/§"$%§"$§$)65754234%('.random_string('unique').$userID);
		
		$this->db->where('userID', $userID);
		$this->db->update($this->db_auth_table, array('reset_code' => $reset_code));
		
		$this->db->select('email');
		$query = $this->db->get_where($this->db_user_table, array('userID' => $userID));
		$eml = $query->row();
		$email = $eml->email;
		return array('reset_code' => $reset_code, 'email' => $email);
	}
	
	/**
	 * Initialpasswort erstellen
	 *
	 * Generiert ein initiales Passwort und gibt Passwort, Username und Email zurück
	 *
	 * Input userID (int)
	 *
	 * @access public
	 * @returns array(pw,username,email)
	 */	
	 public function set_initial_password($userID)
	 {
	 	if (empty($userID)) return false;	
	 	
	    $initial_pw = $this->cp_auth->cp_get_random_pw();	 	
		$salt = $this->cp_auth->cp_generate_salt();
		$hashed_pw = $this->cp_auth->cp_hash_password($initial_pw, $salt);	
		
		$this->db->where('userID', $userID);
		$this->db->insert($this->db_auth_table, array('userID' => $userID, 'password' => $hashed_pw, 'is_initial' => 1, 'reset_code' => '', 'salt' => $salt));

		return $initial_pw;
	 }
	
	/**
	 * Passwortreset
	 *
	 * Generiert ein temporäres neues Passwort und gibt Passwort, Username und Email zurück für den übergebenen Reset Code
	 *
	 * Input code (string)
	 *
	 * @access public
	 * @returns array(pw,username,email)
	 */
	public function reset_password($code) 
    {
		if (empty($code)) return false;
		
		//	get user email to send new pw
		
		$this->db->select($this->db_user_table.'.email, '.$this->db_user_table.'.username');
		$this->db->join($this->db_user_table, $this->db_user_table.'.userID = '.$this->db_auth_table.'.userID', 'left');
		$query = $this->db->get_where($this->db_auth_table, array('reset_code' => $code));
		$result = $query->row();
		if (empty($result)) return false;
		
		$email = $result->email;
		$un = $result->username;
		
		$temp_pw = $this->cp_auth->cp_get_random_pw();
		$salt = $this->cp_auth->cp_generate_salt();
		$hashed_pw = $this->cp_auth->cp_hash_password($temp_pw, $salt);
		$this->db->where('reset_code', $code);
		$this->db->update($this->db_auth_table, array('password' => $hashed_pw, 'reset_code' => '', 'salt' => $salt));
		
		return array('temp_pw' => $temp_pw, 'username' => $un, 'email' => $email);
	}
	
	/**
	 * Passwort ändern
	 *
	 * Ändert das Passwort auf das gewählte neue Passwort
	 *
	 * Input userID (int), old_pw (string), new_pw (string)
	 *
	 * @access public
	 * @returns int
	 */
	public function change_pw($userID, $old_pw, $new_pw) 
    {
		$this->db->where('userID', $userID);
		$new_salt = $this->cp_auth->cp_generate_salt();
		$this->db->update($this->db_auth_table, array('password' => $this->cp_auth->cp_hash_password($new_pw, $new_salt), 'salt' => $new_salt, 'is_initial' => 0));
		return $this->db->affected_rows();
	}
	
	/** 
	 * Passwort prüfen
	 *
	 * prüft, ob das angegebene Passwort dem in der Datenbank hinterlegten entspricht
	 *
	 * Input password (string)
	 *
	 * @access public
	 * @returns boolean
	 */
	public function check_pw($pw, $userID)
	{
		$this->db->where('userID', $userID);
		$this->db->select('password, salt');
		$query = $this->db->get($this->db_auth_table);
		$row = $query->row();
		if($this->cp_auth->cp_hash_password($pw, $row->salt) == $row->password) return true; else return false;
	}
	
	/**
	 * get UserID
	 *
	 * Gibt an Hand von Username oder Emailadresse die UserID zurück
	 *
	 * Input username (string), email (string)
	 *
	 * @access public
	 * @return array(userID, active)/false
	 */
	public function get_userid($username = '', $email = '') 
    {
		if (empty($username) && empty($email)) return false;
		$un_added = false;
		if (!empty($username)) {
			$this->db->where('username', $username);
			$un_added = true;
		}
		if (!empty($email))
			if ($un_added) $this->db->orwhere('email', $email); else $this->db->where('email', $email);
			
		$this->db->select($this->db_user_table.'.userID as userID, '.$this->db_user_table.'.username, '.$this->db_user_table.'.email, '.$this->db_user_table.'.creation_date');
		
		//	check if active user
		$this->db->join($this->db_auth_table, $this->db_user_table.'.userID = '.$this->db_auth_table.'.userID', 'left');

		$query = $this->db->get($this->db_user_table);
		$userdata = $query->row();

		if (!empty($userdata)) $user = array('userID' => $userdata->userID); else $user = false;
		
		return $user;
	}
	
	/**
	 * get Userdata via UserID
	 *
	 * Gibt an Hand von UserID die Userdaten zurück
	 *
	 * Input userID (int)
	 *
	 * @access public
	 * @return array
	 */
	public function get_userdata($userID)
	{
		$this->db->select('username, email, vorname, nachname');
		$query = $this->db->get_where($this->db_user_table, array('userID' => $userID));	
		
		$row = $query->row();
		$arr_return =  array('username' => $row->username,
		             		'email'	=> $row->email,
		             		'vorname'  => $row->vorname,
		             		'nachname' => $row->nachname);
		return $arr_return;
	}
	
	private function _drop_userinfo() 
    {
		delete_cookie($this->cookie_name_autologin);
	}	
	
	/**
	 * User merken
	 *
	 * Webseite "merkt" sich den User mittels Cookie
	 *
	 * Input user (array), reset_cookie (boolean)
	 *
	 * @access public
	 * @returns boolean
	 */
	public function remember_user($user = null, $reset_cookie = false) 
    {
		$user = (empty($user)) ? $this->user : $user;
		if (empty($user)) return false;
		
		$this->db->select($this->db_user_table.'.userID as userID, '.$this->db_user_table.'.*, '.$this->db_auth_table.'.cookie_hash, '.$this->db_auth_table.'.password');
		$this->db->join($this->db_user_table, $this->db_user_table.'.userID = '.$this->db_auth_table.'.userID', 'left');
		$this->db->limit(1);
		$query = $this->db->get_where($this->db_auth_table, array('userID' => $user->userID));
		$db_user = $query->row();
		
		//	stopping point if no user found
		if (empty($db_user)) return false;
		
		//	no cookie hash found, so make new one and save
		//	or if reset cookie is specified
		if (empty($db_user->cookie_hash) || $reset_cookie == true) {
			//	make very unique cookie hash for auto-login
			$salt = microtime();
			$db_user->cookie_hash = $this->cp_auth->cp_generate_hash($db_user->username.$db_user->userID.$db_user->password.$db_user->email, $salt);
			$this->db->where('userID', $db_user->userID);
			$this->db->limit(1);
			$this->db->update($this->db_auth_table, array('cookie_hash' => $db_user->cookie_hash));
		}
		
		//	set cookie with very unique cookie hash
		$cookie = array(
		                   'name'   => $this->cookie_name_autologin,
		                   'value'  => $db_user->cookie_hash,
		                   'expire' => $this->cookie_expire,
		                   'domain' => $this->cookie_domain,
		                   'path'   => '/',
		                   'prefix' => ''
		);
		set_cookie($cookie);
		
		return true;
	}	
	
	// generate activation_code from userdata
	private function _generate_activation_code($phrase)
	{	
		return $this->cp_auth->cp_generate_hash($phrase);	
	}	
}

/* End of file cpauth_model.php */
/* Location: ./application/models/cpauth/cpauth_model.php */