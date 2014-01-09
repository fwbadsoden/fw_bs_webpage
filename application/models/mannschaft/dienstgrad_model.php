<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dienstgrad Model
 *
 * Model zum Mannschaft-Modul -> Dienstgrade
 *
 * @package		com.cp.feuerwehr.models.mannschaft.dienstgrad
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 */	
 
class Dienstgrad_Model extends CI_Model {
	
	private $color = '';
    public $id, $name, $name_w, $name_m, $img, $orderID;
	
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
    
    public function get_dienstgrad_liste()
    {
        $this->db->order_by('orderID', 'ASCENDING');
        $query = $this->db->get('mannschaft_dienstgrad');
        
        $dienstgrade = array();
        $i           = 0;
        foreach($query->result() as $row)
        {
            $dienstgrad = new Dienstgrad_Model();
            $dienstgrad->id             = $row->dienstgradID;
            $dienstgrad->name           = $row->name;
            $dienstgrad->name_w         = $row->name_w;
            $dienstgrad->name_m         = $row->name_m;
            $dienstgrad->img            = $row->img;
            $dienstgrad->orderID        = $row->orderID;
			$dienstgrad->row_color	    = $this->color = cp_get_color($this->color);
            $dienstgrade[$i] = $dienstgrad;
            $i++;
        }
        return $dienstgrade;
    }
    
}

/* End of file dienstgrad_model.php */
/* Location: ./application/models/mannschaft/dienstgrad_model.php */