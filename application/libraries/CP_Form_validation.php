<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CP Auth
 *
 * Library mit Formvalidierungsfunktionen.
 *
 * @package		com.cp.feuerwehr.libraries.form_validation
 * @subpackage	Library
 * @category	Library
 * @author		Habib Pleines
 */	

Class CP_Form_validation extends CI_Form_validation
{
	/**
	 * CP_Form_validation::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
	}

    /**
     * CP_Form_validation::edit_unique()
     * validiert ein Element auf eine Datenbanktabelle, um zu prüfen, dass es eindeutig ist
     * params enthält an [0] den Tabellennamen, an [1] den Feldnamen,
     * an [2] die ID des zu überprüfenden Wertes, an [3] den Namen des ID Feldes in der Tabelle
     * 
     * @param mixed $value
     * @param mixed $params
     * @return
     */
    public function edit_unique($value, $params) 
	{
	    $CI =& get_instance();
	    $CI->load->database();
		
	    list($table, $field, $current_id, $db_id_field) = explode(".", $params);
	
	    $query = $CI->db->select()->from($table)->where($field, $value)->limit(1)->get();
	
	    if ($query->row() && $query->row()->$db_id_field != $current_id)
	    {
	        return FALSE;
	    }
	}   
	
	/**
	 * CP_Form_validation::alpha()
	 * 
	 * @param mixed $str
	 * @return
	 */
	public function alpha($str)
	{
		return ( ! preg_match("/^([a-zäöü])+$/i", $str)) ? FALSE : TRUE;
	}
	
	/**
	 * CP_Form_validation::alpha_numeric()
	 * 
	 * @param mixed $str
	 * @return
	 */
	public function alpha_numeric($str)
	{
		return ( ! preg_match("/^([a-z0-9äöü])+$/i", $str)) ? FALSE : TRUE;
	}
	
	/**
	 * CP_Form_validation::alpha_dash()
	 * 
	 * @param mixed $str
	 * @return
	 */
	public function alpha_dash($str)
	{
		return ( ! preg_match("/^([-a-z0-9äöü_-])+$/i", $str)) ? FALSE : TRUE;
	}
	
	/**
	 * CP_Form_validation::decimal()
	 * 
	 * @param mixed $str
	 * @return
	 */
	public function decimal($str)
	{
		//First check if decimal
	    if(!preg_match('/^[\-+]?[0-9]+\,[0-9]+$/', $str))
	    {
	        //Now check if integer
	        return (bool) parent::integer($str);
	    }
	
	    return TRUE;
	}

    // Check identity is available
    protected function identity_available($identity, $user_id = FALSE)
    {
		if (!$this->CI->flexi_auth->identity_available($identity, $user_id))
		{
			$status_message = $this->CI->lang->line('form_validation_duplicate_identity');
			$this->CI->form_validation->set_message('identity_available', $status_message);
			return FALSE;
		}
        return TRUE;
    }
  
    // Check email is available
    protected function email_available($email, $user_id = FALSE)
    {
		if (!$this->CI->flexi_auth->email_available($email, $user_id))
		{
			$status_message = $this->CI->lang->line('form_validation_duplicate_email');
			$this->CI->form_validation->set_message('email_available', $status_message);
			return FALSE;
		}
        return TRUE;
    }
  
    // Check username is available
    protected function username_available($username, $user_id = FALSE)
    {
		if (!$this->CI->flexi_auth->username_available($username, $user_id))
		{
			$status_message = $this->CI->lang->line('form_validation_duplicate_username');
			$this->CI->form_validation->set_message('username_available', $status_message);
			return FALSE;
		}
        return TRUE;
    }
  
    // Validate a password matches a specific users current password.
    protected function validate_current_password($current_password, $identity)
    {
		if (!$this->CI->flexi_auth->validate_current_password($current_password, $identity))
		{
			$status_message = $this->CI->lang->line('form_validation_current_password');
			$this->CI->form_validation->set_message('validate_current_password', $status_message);
			return FALSE;
		}
        return TRUE;
    }
	
    // Validate Password
     protected function validate_password($password)
    {
		$password_length = strlen($password);
		$min_length = $this->CI->flexi_auth->min_password_length();

		// Check password length is valid and that the password only contains valid characters.
		if ($password_length >= $min_length && $this->CI->flexi_auth->valid_password_chars($password))
		{
			return TRUE;
		}
		
		$status_message = $this->CI->lang->line('password_invalid');
		$this->CI->form_validation->set_message('validate_password', $status_message);
		return FALSE;
    }
 
    // Validate reCAPTCHA
    protected function validate_recaptcha()
    {
		if (!$this->CI->flexi_auth->validate_recaptcha())
		{
			$status_message = $this->CI->lang->line('captcha_answer_invalid');
			$this->CI->form_validation->set_message('validate_recaptcha', $status_message);
			return FALSE;
		}
        return TRUE;
    }
 
    // Validate Math Captcha
    protected function validate_math_captcha($input)
    {
		if (!$this->CI->flexi_auth->validate_math_captcha($input))
		{
			$status_message = $this->CI->lang->line('captcha_answer_invalid');
			$this->CI->form_validation->set_message('validate_math_captcha', $status_message);
			return FALSE;
		}
        return TRUE;
    }
}
?>