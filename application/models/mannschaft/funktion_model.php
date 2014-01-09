<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Funktion Model
 *
 * Model zum Mannschaft-Modul -> Funktionen
 *
 * @package		com.cp.feuerwehr.models.mannschaft.funktion
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 */	
 
class Funktion_Model extends CI_Model {
	
	private $color = '';
    public $id, $name, $orderID;
	
	/**
	 * Konstruktor
	 *
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
		$this->load->helper('html');        
	}
    
    public function get_funktion_liste()
    {
        $this->db->order_by('orderID', 'ASCENDING');
        $query = $this->db->get('mannschaft_fuehrungsfunktion');
        
        $funktionen = array();
        $i           = 0;
        foreach($query->result() as $row)
        {
            $funktion = new Funktion_Model();
            $funktion->id             = $row->funktionID;
            $funktion->name           = $row->name;
            $funktion->orderID        = $row->orderID;
			$funktion->row_color      = $this->color = cp_get_color($this->color);
            $funktionen[$i] = $funktion;
            $i++;
        }
        return $funktionen;
    }
    
}

/* End of file funktion_model.php */
/* Location: ./application/models/mannschaft/funktion_model.php */