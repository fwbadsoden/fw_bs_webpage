<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Abteilung Model
 *
 * Model zum Mannschaft-Modul -> Abteilungen
 *
 * @package		com.cp.feuerwehr.models.mannschaft.abteilung
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 */	
 
class Abteilung_Model extends CI_Model {
	
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
    
    public function get_abteilung_liste()
    {
        $this->db->order_by('orderID', 'ASCENDING');
        $query = $this->db->get('mannschaft_abteilung');
        
        $abteilungen = array();
        $i           = 0;
        foreach($query->result() as $row)
        {
            $abteilung = new Funktion_Model();
            $abteilung->id             = $row->abteilungID;
            $abteilung->name           = $row->name;
            $abteilung->orderID        = $row->orderID;
			$abteilung->row_color      = $this->color = cp_get_color($this->color);
            $abteilungen[$i] = $abteilung;
            $i++;
        }
        return $abteilungen;
    }
    
}

/* End of file abteilung_model.php */
/* Location: ./application/models/mannschaft/abteilung_model.php */