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
    public $mitgliedID, $name, $vorname, $img, $show_img, $geburtstag, $show_geburtstag, $beruf, $show_beruf, $dienstgrad_name, $dienstgrad_img, 
           $geschlecht, $funktion_name, $teamID, $team_name, $anzahl, $anzahl_m, $anzahl_w, $row_color, $online;
	
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
    
    public function get_mannschaft_liste()
    {
        $this->db->select('mannschaftID, name, vorname, online');
        $query = $this->db->get('v_mannschaft');
        
        $team = array();
        $i    = 0;
        foreach($query->result() as $row)
        {
            $mannschaft = new Mannschaft_Model();
            $mannschaft->mitgliedID     = $row->mannschaftID;
            $mannschaft->name           = $row->name;
            $mannschaft->vorname        = $row->vorname;
            $mannschaft->online         = $row->online;
			$mannschaft->row_color	    = $this->color = cp_get_color($this->color);
            $team[$i] = $mannschaft;
            $i++;
        }
        return $team;
    }
    
    public function get_mannschaft_overview($teamID = 'all')
    {
        $this->db->where('online', 1);
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
            $mitglied->mitgliedID       = $row->mannschaftID;
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
            $mitglied->show_img         = $row->show_img;
            $mitglied->show_beruf       = $row->show_beruf;
            $mitglied->show_geburtstag  = $row->show_geburtstag;
            
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
    
    public function get_mitglied($id) {
        
        $this->db->where('mannschaftID', $id);
        $query = $this->db->get('mannschaft');
        $row = $query->row();
        
        $mitglied = new Mannschaft_Model();
        $mitglied->mitgliedID       = $row->mannschaftID;
        $mitglied->name             = $row->name;
        $mitglied->vorname          = $row->vorname;
        $mitglied->img              = $row->img;
        $mitglied->show_img         = $row->show_img;
        $mitglied->geschlecht       = $row->geschlecht;
        $mitglied->geburtstag       = $row->geburtstag;
        $mitglied->show_geburtstag  = $row->show_geburtstag;
        $mitglied->show_beruf       = $row->show_beruf;
        $mitglied->beruf            = $row->beruf;
        $mitglied->geschlecht       = $row->geschlecht;
        $mitglied->abteilungID      = $row->abteilungID;
        $mitglied->dienstgradID     = $row->dienstgradID;
        $mitglied->funktionID       = $row->funktionID;
        $mitglied->teamID           = $row->teamID;
        
        return $mitglied;
    }
    
    public function create_mitglied() {
        
        if($this->input->post('funktionID') != 0)
            $teamID = TEAM_ID_LEADER;
        else
            $teamID = TEAM_ID_TEAM;
            
        $mitglied = array(
            'abteilungID'       => 1,
            'dienstgradID'      => $this->input->post('dienstgradID'),
            'funktionID'        => $this->input->post('funktionID'),
            'teamID'            => $teamID,
            'img'               => 'dummy.jpg',
            'name'              => $this->input->post('name'),
            'vorname'           => $this->input->post('vorname'),
            'show_img'          => $this->input->post('show_img'),
            'geschlecht'        => $this->input->post('geschlecht'),
            'geburtstag'        => $this->input->post('geburtstag'),
            'show_geburtstag'   => $this->input->post('show_geburtstag'),
            'beruf'             => $this->input->post('beruf'),
            'show_beruf'        => $this->input->post('show_beruf'),
            'online'            => $this->input->post('online')
        );
        
        $this->db->insert('mannschaft', $mitglied);
    }
    
    public function update_mitglied($id) {
        
        if($this->input->post('funktionID') != 0)
            $teamID = TEAM_ID_LEADER;
        else
            $teamID = TEAM_ID_TEAM;
        
        $mitglied = array(
            'dienstgradID'      => $this->input->post('dienstgradID'),
            'funktionID'        => $this->input->post('funktionID'),
            'teamID'            => $teamID,
            'name'              => $this->input->post('name'),
            'vorname'           => $this->input->post('vorname'),
            'show_img'          => $this->input->post('show_img'),
            'geschlecht'        => $this->input->post('geschlecht'),
            'geburtstag'        => $this->input->post('geburtstag'),
            'show_geburtstag'   => $this->input->post('show_geburtstag'),
            'beruf'             => $this->input->post('beruf'),
            'show_beruf'        => $this->input->post('show_beruf')
        );
        
        $this->db->where('mannschaftID', $id);
        $this->db->update('mannschaft', $mitglied);
    }
    
    public function delete_mitglied($id) {
        
        $this->db->where('mannschaftID', $id);
        $query = $this->db->get('mannschaft');
        $row = $query->row();
        
        if($row->img != "" && $row->img != "dummy.jgp")
            $this->_delete_image($id);
        $this->db->where('mannschaftID', $id);
        $this->db->delete("mannschaft");
    }
    
    public function update_image($id, $filename) {
        
        $this->db->where('mannschaftID', $id);
        $this->db->update('mannschaft', array('img' => $filename));
    }
    
    private function _delete_image($id) {
        
        $this->db->select('img');
        $query = $this->db->get_where('mannschaft', array('mannschaftID' => $id));
		
		$row = $query->row();
		unlink($this->upload_path.$row->img);
    }
	
	public function switch_online_state($id, $online)
	{
		$this->db->update('mannschaft', array('online' => $online), 'mannschaftID = '.$id);
	}
}

/* End of file mannschaft_model.php */
/* Location: ./application/models/mannschaft/mannschaft_model.php */