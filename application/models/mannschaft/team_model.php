<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Team Model
 *
 * Model zum Mannschaft-Modul -> Teams
 *
 * @package		com.cp.feuerwehr.models.mannschaft.team
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 */	
 
class Team_Model extends CI_Model {
	
	private $color = '';
    public $id, $name;
	
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
    
    public function get_team_liste()
    {
        $this->db->order_by('name', 'ASCENDING');
        $query = $this->db->get('mannschaft_team');
        
        $teams = array();
        $i           = 0;
        foreach($query->result() as $row)
        {
            $team = new Funktion_Model();
            $team->id             = $row->teamID;
            $team->name           = $row->name;
			$team->row_color      = $this->color = cp_get_color($this->color);
            $teams[$i] = $team;
            $i++;
        }
        return $teams;
    }
    
}

/* End of file team_model.php */
/* Location: ./application/models/mannschaft/team_model.php */