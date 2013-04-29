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
	public function __construct()
	{
		parent::__construct();
	}

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
	
	public function alpha($str)
	{
		return ( ! preg_match("/^([a-zäöü])+$/i", $str)) ? FALSE : TRUE;
	}
	
	public function alpha_numeric($str)
	{
		return ( ! preg_match("/^([a-z0-9äöü])+$/i", $str)) ? FALSE : TRUE;
	}
	
	public function alpha_dash($str)
	{
		return ( ! preg_match("/^([-a-z0-9äöü_-])+$/i", $str)) ? FALSE : TRUE;
	}
	
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
}
?>