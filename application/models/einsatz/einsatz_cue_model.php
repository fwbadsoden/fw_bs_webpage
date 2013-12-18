<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Einsatzstichwort Model
 *
 * Model zum Einsatz-Modul
 *
 * @package		com.cp.feuerwehr.models.einsatzcue
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 * @author		Patrick Ritter <pa_ritter@arcor.de>
 */	
 
class Einsatz_cue_Model extends CI_Model {
    private $color;
    public $id, $name, $mimic, $example, $aao, $row_color, $deletable;
    
    /**
	 * Konstruktor
	 *
	 *
	 * @access public
	 */
	public function __construct() 
    {
		parent::__construct();	
		$this->load->helper('html');	
	}
    
    public function get_einsatz_cue_list()
    {
        $this->db->order_by('name', 'ASCENDING');
        $query = $this->db->get('einsatz_cue');
        
        $einsatz_cues = array();
        $i = 0;
        
        foreach($query->result() as $row)
        {
            $cue = new Einsatz_cue_Model();
            $cue->id            = $row->cueID;
            $cue->name          = $row->name;
            $cue->mimic         = $row->mimic;
            $cue->example       = $row->example;
            $cue->aao           = $row->aao;
            $cue->row_color     = $this->color = cp_get_color($this->color);
            
            $this->db->where('cueID', $row->cueID);
            $this->db->from('einsatz_content');
            $count = $this->db->count_all_results();
            if($count >= 1)
                $cue->deletable = 0;
            else
                $cue->deletable = 1;
            
            $einsatz_cues[$i]   = $cue;
            $i++;
        }
        return $einsatz_cues;
    }
    
    public function get_cue($id)
    {
        $this->db->where('cueID', $id);
        $query = $this->db->get('einsatz_cue');
        
        $row = $query->row();
        
        $cue = new Einsatz_cue_Model();
        $cue->id                = $id;
        $cue->name              = $row->name;
        $cue->mimic             = $row->mimic;
        $cue->example           = $row->example;
        $cue->aao               = $row->aao;
        
        return $cue;
    }
    
    public function create_cue()
    {
        $cue = array(
            'name'      => $this->input->post('stichwortname'),
            'mimic'     => $this->input->post('stichwortbeschreibung'),
            'example'   => $this->input->post('stichwortbeispiel'),
            'aao'       => $this->input->post('stichwortaao')
        );
		$this->db->insert('einsatz_cue', $cue);
    }
    
    public function update_cue($id)
    {
        $cue = array(
            'name'      => $this->input->post('stichwortname'),
            'mimic'     => $this->input->post('stichwortbeschreibung'),
            'example'   => $this->input->post('stichwortbeispiel'),
            'aao'       => $this->input->post('stichwortaao')
        );		
		$this->db->where('cueID', $id);
		$this->db->update('einsatz_cue', $cue);        
    }
	
	public function delete_cue($id)
	{		
		$this->db->where('cueID', $id);
		$this->db->delete('einsatz_cue');
	}
}

/* End of file einsatz_model.php */
/* Location: ./application/models/einsatz/einsatz_model.php */