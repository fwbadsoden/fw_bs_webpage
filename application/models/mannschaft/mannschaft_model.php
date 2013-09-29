<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Mannschaft Model
 *
 * Model zum Mannschaft-Modul
 *
 * @package		com.cp.feuerwehr.models.mannschaft
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 */	
 
class Mannschaft_Model extends CI_Model {
	
	private $color = '';
    private $upload_path = CONTENT_IMG_MANNSCHAFT_UPLOAD_PATH;
    public $mannschaftID, $name, $img, $geburtstag, $beruf, $dienstgrad_name, $dienstgrad_img, 
           $funktion_name, $teamID, $team_name, $anzahl, $anzahl_m, $anzahl_w;
	
	/**
	 * Konstruktor
	 *
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
        
	}
    
    public function get_mannschaft_overview($teamID = 'all')
    {
        if($teamID == TEAM_ID_LEADER) {
            $this->db->where('teamID', $teamID);
            $this->db->order_by('funktion_orderID', 'DESC');
            $this->db->order_by('name', 'ASC');         
        }
        if($teamID == TEAM_ID_TEAM) {
            $this->db->where('teamID', $teamID);
            $this->db->order_by('name', 'ASC');
        }
       
        $query = $this->db->get('v_mannschaft');
        $i = 0; $j = 0; $k = 0;
        $mannschaft = array();
        
        foreach($query->result() as $row)
        {
            $mitglied = new Mannschaft_model();
            $mitglied->mannschaftID     = $row->mannschaftID;
            $mitglied->name             = $row->name;
            $mitglied->vorname          = $row->vorname;
            $mitglied->img              = $row->img;
            $mitglied->geburtstag       = $row->geburtstag;
            $mitglied->beruf            = $row->beruf;
            $mitglied->geschlecht       = $row->geschlecht;
            $mitglied->dienstgrad_name  = $row->dienstgrad_name;
            $mitglied->dienstgrad_name_m = $row->dienstgrad_name_m;
            $mitglied->dienstgrad_name_w = $row->dienstgrad_name_w;
            $mitglied->dienstgrad_img   = $row->dienstgrad_img;
            $mitglied->funktion_name    = $row->funktion_name;
            $mitglied->teamID           = $row->teamID;
            $mitglied->team_name        = $row->team_name;
            
            $mannschaft[$i] = $mitglied;
            $i++;
        }
        return $mannschaft;
    }
    
    public function get_mannschaft_anzahl()
    {
        $this->db->select('geschlecht');
        $query = $this->db->get('v_mannschaft');    
        $mitglied = new Mannschaft_model();
        $mitglied->anzahl   = 0;
        $mitglied->anzahl_m = 0;
        $mitglied->anzahl_w = 0;
        
        foreach($query->result() as $row)
        {
            if($row->geschlecht == 'w')
                $mitglied->anzahl_w++;
            else
                $mitglied->anzahl_m++;
            $mitglied->anzahl++;
        }
        return $mitglied;
    }
}
?>