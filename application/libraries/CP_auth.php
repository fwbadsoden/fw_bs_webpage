<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CP Auth
 *
 * Library mit Authentifizierungsfunktionen.
 *
 * @package		com.cp.feuerwehr.libraries.auth
 * @subpackage	Library
 * @category	Library
 * @author		Habib Pleines
 */	

// Konstanten
define('CP_SALT_LENGTH', 15);
define('CP_DEFAULT_SALT', 'MGVmZDI4YzE1mYI');
define('CP_KEY', 'g6Hs8KlEwSppPOeDWtZHjf4H8J2');
define('CP_RANDOM_PW_LENGTH', 8);

class CP_auth
{
	/**
	 * Passworthash aus Passwort und Salt generieren
	 *
	 * Input Password (string), Salt (string)
	 * Output Passworthash (string 172)
	 *
	 * @access public
	 * @returns string
	 */	 
	public function cp_hash_password($phrase, $salt = CP_DEFAULT_SALT)
	{
		return base64_encode(bin2hex(mhash(MHASH_SHA512,$salt.CP_KEY.$phrase))).$salt;
	}
	
	/**
	 * Hash aus Phrasegenerieren
	 *
	 * Input Phrase (string)
	 * Output Hash (string 32)
	 *
	 * @access public
	 * @returns string
	 */	
	public function cp_generate_hash($phrase)
	{
		return md5($phrase);	
	}
	
	/**
	 * Salt generieren
	 *
	 * Output Salt (string 15)
	 *
	 * @access public
	 * @returns string
	 */	 
	public function cp_generate_salt()
	{
		return substr(base64_encode(bin2hex(mhash(MHASH_SHA512,uniqid(rand(), true).CP_KEY.microtime()))), 0, CP_SALT_LENGTH);
	}	
	
	/**
	 * Passwort überprüfen
	 *
	 * @access public
	 * @returns boolean
	 */
	public function cp_check_pw($postPW, $dbPW, $dbSalt)
	{
		if($this->cp_hash_password($postPW, $dbSalt) == $dbPW)
			return true;
		else
			return false;
	}
	
	
	/**
	 * Get Userdata from Session
	 *
	 * Liefert ein Array mit den Userdaten aus der Session
	 * benötigt als Parameter $this->session->userdata('session_name')
	 *
	 * @access public
	 * @returns array
	 */
	 public function cp_get_userdata($data)
	 {
	 	$userdata = array();
		
	 	$userdata['userID'] = $data->userID;
	 	$userdata['vorname'] = $data->vorname;
	 	$userdata['nachname'] = $data->nachname;
	 	$userdata['email'] = $data->email;
	 	$userdata['username'] = $data->username;
	 	
	 	return $userdata;
	 }
	 
	 public function cp_get_userid($data)
	 {
	 	return $data->userID;
	 }
	 
	 public function cp_get_random_pw()
	 {
	 	$CI =& get_instance();
	 	$CI->load->helper('string');
	 	return random_string('alnum', CP_RANDOM_PW_LENGTH);
	 }
}
?>