<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Autosuggest Class
 *
 * Model zum lesen der Autosuggestwerte aus der Datenbank 
 * an Hand des übergebenen Keys
 *
 * @package		com.cp.feuerwehr.models.autosuggest
 * @subpackage	Library
 * @category	Library
 * @author		Habib Pleines
 */
class Autosuggest_model extends CI_Model {

	/**
	 * Constructor
	 */
    public function __construct()
    {
        
    }
    
    public function get_values($key)
    {
        $this->db->select('value');
        $this->db->where('keyword', $key);
        $query = $this->db->get('autosuggest_values');
        
        $values = array();
        $i = 0;
        
        foreach($query->result() as $row)
        {
            $values[$i] = $row->value;
            $i++;
        }
        
        return $values;
    }
}

/* End of file autosuggest.php */
/* Location: ./application/libraries/autosuggest.php */