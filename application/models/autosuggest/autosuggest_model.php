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
    public $id, $keyword, $value;
    private $color;

	/**
	 * Constructor
	 */
    public function __construct()
    {
		parent::__construct();	
		$this->load->helper('html');
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
    
    public function get_value($id)
    {
        $this->db->where('autosuggestID', $id);
        $query = $this->db->get('autosuggest_values');
        $row = $query->row();
        
        $value              = new Autosuggest_model();
        $value->id          = $row->autosuggestID;
        $value->keyword     = $row->keyword;
        $value->value       = $row->value;
        
        return $value;
    }
    
    public function get_value_list($key = null, $order = null)
    {
        if($key != null)
            $this->db->where('keyword', $key);
        if($order != null)
            $this->db->order_by($order[0], $order[1]);
        $query = $this->db->get('autosuggest_values');
        
        $values = array();
        $i=0;
        
        foreach($query->result() as $row)
        {
            $value              = new Autosuggest_model();
            $value->id          = $row->autosuggestID;
            $value->keyword     = $row->keyword;
            $value->value       = $row->value;
            $value->row_color   = $this->color = cp_get_color($this->color);
            
            $values[$i] = $value;
            $i++;
        }
        
        return $values;
    }
    
    public function create_value($key)
    {
        $value = array(
            'keyword' => $key,
            'value'   => $this->input->post('value')
        );
		$this->db->insert('autosuggest_values', $value);
    }
    
    public function update_value($id)
    {
        $value = array(
            'value'   => $this->input->post('value')
        );
        
		$this->db->where('autosuggestID', $id);
		$this->db->update('autosuggest_values', $value);   
    }
    
    public function delete_value($id)
    {
		$this->db->where('autosuggestID', $id);
		$this->db->delete('autosuggest_values');        
    }
}

/* End of file autosuggest.php */
/* Location: ./application/libraries/autosuggest.php */