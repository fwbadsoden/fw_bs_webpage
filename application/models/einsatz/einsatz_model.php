<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Einsatz Model
 *
 * Model zum Einsatz-Modul
 *
 * @package		com.cp.feuerwehr.models.einsatz
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 */	
 
class Einsatz_Model extends CI_Model {
	
	private $counterT = 0;
	private $counterF = 0;
	private $arr_fahrzeuge_db = array();
	private $color = '';
    private $upload_path = CONTENT_IMG_EINSATZ_UPLOAD_PATH;
    
    public $id, $name, $datum_beginn, $datum_ende, $uhrzeit_beginn, $uhrzeit_ende, $lfd_nr, $online, $type_count,
           $einsatz_nr, $lage, $bericht, $weitere_kraefte, $cue_name, $cue_mimic, $ort,
           $anzahl_kraefte, $typeID, $type_name, $type_short_name, $row_color, $special_class;
	
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
    
    public function get_einsatz_overview($limit = EINSATZ_DEFAULT_LIMIT, $offset = EINSATZ_DEFAULT_OFFSET, $year = 'all', $type = 'all')
    {
        if(is_numeric($limit) && is_numeric($offset)) 
            $this->db->limit($limit, $offset);
        if(is_numeric($year))
			$this->db->where(array('substring(datum_beginn,1,4)' => $year));
        if(strlen($type) == 1)
            $this->db->where(array('typeID' => $type));
        $this->db->order_by('datum_beginn', 'desc');
        $this->db->order_by('uhrzeit_beginn', 'desc');
		$this->db->order_by('lfd_nr', 'desc');
            
        $query = $this->db->get('v_einsatz');
        $einsaetze = array();
        $i = 0;
        $type_count = array();
        
        foreach($query->result() as $row)
        {
            $this->db->select('imgID');
            $query2 = $this->db->get_where('einsatz_img', array('einsatzID' => $row->einsatzID)); 
            
            $einsatz = new Einsatz_model();
            $einsatz->id            = $row->einsatzID;
            $einsatz->name          = $row->name;
            $einsatz->einsatz_nr    = $row->einsatz_nr;
            $einsatz->lfd_nr        = $row->lfd_nr;
            $einsatz->datum_beginn  = $row->datum_beginn;
            $einsatz->uhrzeit_beginn = $row->uhrzeit_beginn;
            $einsatz->datum_ende    = $row->datum_ende;
            $einsatz->uhrzeit_ende  = $row->uhrzeit_ende;
            $einsatz->row_color     = $this->color                  = cp_get_color($this->color);
            $einsatz->year          = $year;
            $einsatz->lage          = $row->lage;
            $einsatz->bericht       = $row->bericht;
            $einsatz->ort           = $row->ort;
            $einsatz->type_name     = $row->type_name;
            $einsatz->type_short_name = $row->type_short_name;
            $einsatz->type_class    = $row->type_class;
            $einsatz->cue_name      = $row->cue_name;
            $einsatz->cue_mimic     = $row->cue_mimic;
            $einsatz->img_count     = $query2->num_rows();
            
            $einsaetze[$i]          = $einsatz;
            
            if(!isset($type_count[$row->type_short_name])) $type_count[$row->type_short_name] = 0;
            $type_count[$row->type_short_name]++;
            $i++;
        }
        
        $ret_einsaetze['einsaetze'] = $einsaetze;
        $ret_einsaetze['statistik'] = $type_count;
        
        return $ret_einsaetze;
    }
	
    public function get_einsatz_stage_text($id)
    {
        $this->db->select('name, type_name, type_class');
        $query = $this->db->get_where('v_einsatz', array('einsatzID' => $id));
        $row = $query->row();
        
        $text['text'][0] = $row->name;
        $text['text'][1] = $row->type_name;
        $text['class']   = $row->type_class;
        return $text;
    }
    
	public function get_einsatz_years()
	{
		$years = array();
		
		$query = $this->db->query('SELECT DISTINCT substring( datum_beginn, 1, 4 ) as datum FROM '.$this->db->dbprefix('einsatz')); 
		
		foreach ($query->result() as $row)
		{ 
			$years[] = $row->datum;
		}
		rsort($years);
		return $years;
	}
    
    public function get_einsatz_fahrzeuge($id)
    {
        $this->db->join('fahrzeug', 'einsatz_fahrzeug_mapping.fahrzeugID = fahrzeug.fahrzeugID');
        $query = $this->db->get_where('einsatz_fahrzeug_mapping', array('einsatzID' => $id, 'online' => 1));
        $fahrzeuge = array();
        foreach($query->result() as $row)
        {
            $this->db->select('img_file');
            $query2 = $this->db->get_where('fahrzeug_img', array('small_pic' => 1, 'fahrzeugID' => $row->fahrzeugID), 1);
            $row2 = $query2->row();
          
            $fahrzeuge[$row->fahrzeugID]['img']             = $row2->img_file;
            $fahrzeuge[$row->fahrzeugID]['fahrzeugID']      = $row->fahrzeugID;
            $fahrzeuge[$row->fahrzeugID]['name']            = $row->name;
            $fahrzeuge[$row->fahrzeugID]['name_lang']       = $row->name_lang;
            $fahrzeuge[$row->fahrzeugID]['prefix_rufname']  = $row->prefix_rufname;
            $fahrzeuge[$row->fahrzeugID]['rufname']         = $row->rufname;
        }
        
        return $fahrzeuge;
    }
    
    public function get_einsatz_count($year = 0)
    {
        if ($year == 0) $year = date('Y');
        $query = $this->db->get_where('einsatz', array('substring(datum_beginn,0,4)' => $year));
        return $query->num_rows();
    }
	
	public function get_einsatz_list($year)
	{		
		$arr_einsatz_list = array();
		
        $this->db->order_by('datum_beginn', 'desc');
        $this->db->order_by('uhrzeit_beginn', 'desc');
		$this->db->order_by('lfd_nr', 'desc');
		if(is_numeric($year))
			$this->db->where(array('substring(datum_beginn,1,4)' => $year));		
		$query = $this->db->get('einsatz');
		
		$i = 0;
		
		foreach($query->result() as $row)
		{
            $this->db->select('imgID');
            $query2 = $this->db->get_where('einsatz_img', array('einsatzID' => $row->einsatzID)); 
		
 			$arr_einsatz_list[$i]['lfdNr'] 			= $row->lfd_nr;
  			$arr_einsatz_list[$i]['einsatzNr'] 		= $row->einsatz_nr;
  			$arr_einsatz_list[$i]['einsatzID'] 		= $row->einsatzID;
  			$arr_einsatz_list[$i]['einsatzName'] 	= $row->name;
  			$arr_einsatz_list[$i]['datum_beginn']	= cp_get_ger_date($row->datum_beginn);
  			$arr_einsatz_list[$i]['uhrzeit_beginn'] = $row->uhrzeit_beginn;
  			$arr_einsatz_list[$i]['datum_ende']   	= cp_get_ger_date($row->datum_ende);
  			$arr_einsatz_list[$i]['uhrzeit_ende']   = $row->uhrzeit_ende;
  			$arr_einsatz_list[$i]['online'] 		= $row->online;
  			$arr_einsatz_list[$i]['row_color']		= $this->color = cp_get_color($this->color);
  			$arr_einsatz_list[$i]['year']			= $year;
            $arr_einsatz_list[$i]['imgCount']       = $query2->num_rows();
 		
			$i++;
		}
		return $arr_einsatz_list;
	}
	
	public function get_einsatz($id)
	{
		$this->db->where('einsatzID', $id);
		$query = $this->db->get('v_einsatz');
		
	    $row = $query->row();
		$einsatz['einsatzID'] 				= $id;
		$einsatz['einsatzNr'] 				= $row->einsatz_nr;
		$einsatz['ldf_nr'] 	        		= $row->lfd_nr;
		$einsatz['einsatzName'] 			= $row->name;
		$einsatz['datum_beginn'] 			= $row->datum_beginn;
		$einsatz['uhrzeit_beginn'] 			= $row->uhrzeit_beginn;
		$einsatz['datum_ende'] 				= $row->datum_ende;
		$einsatz['uhrzeit_ende'] 			= $row->uhrzeit_ende;
		$einsatz['einsatzort'] 			    = $row->ort;
        $einsatz['einsatzlage']             = $row->lage;
		$einsatz['einsatzbericht'] 			= $row->bericht;
		$einsatz['einsatzkraefteFreitext']	= $row->weitere_kraefte;
		$einsatz['anzahlEinsatzkraefte']	= $row->anzahl_kraefte;
        $einsatz['cueID']                   = $row->cueID;
        $einsatz['cue_name']                = $row->cue_name;
        $einsatz['cue_mimic']               = $row->cue_mimic;
		$einsatz['typeID']                  = $row->typeID;
        $einsatz['type_name']               = $row->name;
        $einsatz['type_shortname']          = $row->type_short_name;
        
		$this->db->where('einsatzID', $id);
		$query = $this->db->get('einsatz_fahrzeug_mapping');
		$i = 0;
		foreach($query->result() as $row)
		{
			$einsatz['fahrzeug'][$row->fahrzeugID] = 1;
			$i++;
		}
		return $einsatz;
	}
    
    public function get_einsatz_cue_list()
    {
        $query = $this->db->get('einsatz_cue');
        $i = 0;
        $arr_cue = array();
        
        foreach($query->result() as $row)
        {
            $arr_cue[$i]['cue_id']          = $row->cueID;
            $arr_cue[$i]['name']            = $row->name;
            $arr_cue[$i]['mimic']           = $row->mimic;
            $i++;
        }
        
        return $arr_cue;
    }
	
	public function get_einsatz_type_list()
	{
		$query = $this->db->get('einsatz_type');
		$i = 0;
		$arr_type = array();
		
		foreach($query->result() as $row)
		{
			$arr_type[$i]['typeID']          = $row->typeID;
			$arr_type[$i]['typeName']        = $row->name;
			$arr_type[$i]['typeShortname']   = $row->short_name;	
            $arr_type[$i]['typePlural']      = $row->name_plural;
            $arr_type[$i]['class']           = $row->class;
			$i++;
		}
		
		return $arr_type;
	}
	
	public function get_images($id)
	{
		$query = $this->db->get_where('einsatz_img', array('einsatzID' => $id));	
		$images = array();
		$i = 0;
		
		foreach($query->result() as $row)
		{
			$this->color= cp_get_color($this->color);
			
			$images[$i]['imageID']		= $row->imgID;
			$images[$i]['einsatzID']	= $row->einsatzID;
			$images[$i]['img_desc']		= $row->description;
			$images[$i]['img_file']		= $row->img_file;
			$images[$i]['img_thumb']	= $row->thumb_file;
			$images[$i]['img_type']		= $row->filetype;
			$images[$i]['row_color']	= $this->color;
			
			$i++;
		}
		return $images;
	}
	
	public function create_einsatz()
	{ 
		$einsatz = array(
			'name' 	        => $this->input->post('einsatzname'),
			'datum_beginn'	=> $this->input->post('einsatzdatum_beginn'),
			'uhrzeit_beginn'=> $this->input->post('einsatzuhrzeit_beginn'),
			'datum_ende'	=> $this->input->post('einsatzdatum_ende'),
			'uhrzeit_ende'  => $this->input->post('einsatzuhrzeit_ende'),
			'einsatz_nr'    => $this->input->post('einsatznr'),
			'lfd_nr'		=> 0,
			'online'		=> 0
		);
		
		$this->db->select_max('lfd_nr');
		$query = $this->db->get_where('einsatz', array('substr(datum_beginn,1,4)' => substr($einsatz['datum_beginn'],0,4)));
		$row = $query->row();	
		
		// ++++ TRANSAKTION START ++++ //
		$this->db->trans_start();	
		
		if($row->lfd_nr != null)		$einsatz['lfd_nr'] 	= $row->lfd_nr;
		else							$einsatz['lfd_nr']   = 1;
		$this->db->insert('einsatz', $einsatz);
		$einsatzID = $this->db->insert_id();		

		$einsatzContent = array(
			'einsatzID'			=> $einsatzID,
            'lage'              => $this->input->post('einsatzlage'),
			'bericht'			=> $this->input->post('einsatzbericht'),
            'ort'               => $this->input->post('einsatzort'),
			'weitere_kraefte'	=> $this->input->post('weitereeinsatzkraefte'),
			'anzahl_kraefte'	=> $this->input->post('anzahl'),
            'typeID'            => $this->input->post('einsatztyp'),
            'cueID'             => $this->input->post('einsatzstichwort')
		);
		$this->db->insert('einsatz_content', $einsatzContent);
		
		array_walk($this->input->post(), array($this, 'callback_einsatz_find_mappings'));
		foreach($this->arr_fahrzeuge_db as $f)
		{
			$this->db->insert('einsatz_fahrzeug_mapping', array('einsatzID' => $einsatzID, 'fahrzeugID' => $f));	
		}		
		$this->recalc_lfdnr(substr($einsatz['datum_beginn'],0,4));
		
		$this->db->trans_complete();
		// ++++ TRANSAKTION ENDE ++++ //

	}
	
	public function update_einsatz($id)
	{ 
		$einsatz = array(
			'name' 	         => $this->input->post('einsatzname'),
			'datum_beginn'	 => $this->input->post('einsatzdatum_beginn'),
			'uhrzeit_beginn' => $this->input->post('einsatzuhrzeit_beginn'),
			'datum_ende'	 => $this->input->post('einsatzdatum_ende'),
			'uhrzeit_ende'   => $this->input->post('einsatzuhrzeit_ende'),
			'einsatz_nr'     => $this->input->post('einsatznr')
		);		
		$einsatzContent = array(
            'lage'              => $this->input->post('einsatzlage'),
			'bericht'			=> $this->input->post('einsatzbericht'),
            'ort'               => $this->input->post('einsatzort'),
			'geschehen'			=> $this->input->post('einsatzgeschehen'),
			'weitere_kraefte'	=> $this->input->post('weitereeinsatzkraefte'),
			'anzahl_kraefte'	=> $this->input->post('anzahl'),
            'typeID'            => $this->input->post('einsatztyp'),
            'cueID'             => $this->input->post('einsatzstichwort')
		);
		
		// ++++ TRANSAKTION START ++++ //
		$this->db->trans_start();
		
		$this->db->where('einsatzID', $id);
		$this->db->update('einsatz', $einsatz);
		$this->db->where('einsatzID', $id);
		$this->db->update('einsatz_content', $einsatzContent);
        echo $this->db->last_query();
		$this->db->where('einsatzID', $id);
		$this->db->delete('einsatz_fahrzeug_mapping', array('einsatzID' => $id));
		
		array_walk($this->input->post(), array($this, 'callback_einsatz_find_mappings'));
		foreach($this->arr_fahrzeuge_db as $f)
		{
			$this->db->insert('einsatz_fahrzeug_mapping', array('einsatzID' => $id, 'fahrzeugID' => $f));	
		}
		$this->recalc_lfdnr(substr($einsatz['datum_beginn'],0,4));
		
		$this->db->trans_complete();
		// ++++ TRANSAKTION ENDE ++++ //
	}
	
	public function delete_einsatz($id)
	{		
		$this->delete_images($id);	
		$this->db->select('datum_beginn');
		$query = $this->db->get_where('einsatz', array('einsatzID' => $id));
		$row = $query->row();
		$tables = array('einsatz', 'einsatz_content', 'einsatz_fahrzeug_mapping');
		$this->db->where('einsatzID', $id);
		$this->db->delete($tables);
		$return = $this->recalc_lfdnr(substr($row->datum_beginn,0,4));
	}
	
	public function insert_image($id, $desc, $file, $thumb, $type) 
	{
		$this->db->insert('einsatz_img', array('einsatzID' => $id, 'description' => $desc, 'img_file' => $file, 'thumb_file' => $thumb, 'filetype' => $type));	
	}
	
	public function update_image($id, $desc)
	{
		$this->db->where('imgID', $id);
		$this->db->update('einsatz_img', array('description' => $desc));	
	}
	
	public function delete_image($id)
	{
		$query = $this->db->get_where('einsatz_img', array('imgID' => $id));
		$row = $query->row();
			
		unlink($this->upload_path.$row->img_file);
		unlink($this->upload_path.$row->thumb_file);
		
		$this->db->delete('einsatz_img', array('imgID' => $id));	
	}
	
	public function delete_images($id)
	{
		$query = $this->db->get_where('einsatz_img', array('einsatzID' => $id));
		
		foreach($query->result() as $row)
		{
			unlink($this->upload_path.$row->img_file);
			unlink($this->upload_path.$row->thumb_file);
			
			$this->db->delete('einsatz_img', array('imgID' => $row->imgID));	
		}
	}
	
	public function get_einsatz_templates($id = 0)
	{	
		if($id !=0)	$this->db->where('templateID', $id);
		$this->db->order_by('tmpl_name', 'ASC');
		$query = $this->db->get('einsatz_template');
		$templates = array();
			
		foreach($query->result() as $row)
		{
			$templates[$row->templateID]['template_id'] 		= $row->templateID;
			$templates[$row->templateID]['template_name'] 		= $row->tmpl_name;
			$templates[$row->templateID]['einsatz_name']		= $row->name;
			$templates[$row->templateID]['einsatz_lage']		= $row->lage;
			$templates[$row->templateID]['einsatz_art']			= $row->art;
			$templates[$row->templateID]['einsatz_fahrzeug']	= $row->fahrzeug;
		}
		return $templates;
	}
	
	private function callback_einsatz_find_mappings($value, $key)
	{ 	
		$check = explode('_', $key);
		if($check[0] == 'f') // Fahrzeug
		{
			// Sicherheitscheck, dass rechts nur noch Nummer stehen
			if(is_numeric($check[1]))
			{
				$this->arr_fahrzeuge_db[$this->counterF] = $value;				
				$this->counterF++;
			}
		}
	}
	
	private function recalc_lfdnr($year)
	{
		$this->db->order_by('datum_beginn', 'asc');
		$query = $this->db->get_where('einsatz', array('substr(datum_beginn,1,4)' => $year));
		$lfdNr = 1;
		$arr_einsatz = array();
		$i = 0;
		
		foreach($query->result() as $row)
		{
			$arr_einsatz[$i]['einsatzID'] = $row->einsatzID;
			$arr_einsatz[$i]['sort'] = $row->datum_beginn.' '.$row->uhrzeit_beginn;
			$i++;			
		}
		
        usort($arr_einsatz, function($a, $b) 	{ $ad = new DateTime($a['sort']);
												  $bd = new DateTime($b['sort']);

												  if ($ad == $bd) {
												    return 0;
												  }

												  return $ad > $bd ? 1 : -1;
												});
        
//        $function = create_function('$a, $b', '$ad = new DateTime($a["sort"])
//                                               $bd = new DateTime($b["sort"])
//                                               if ($ad == $bd) {
//												    return 0;
//						                       }
//                                               return $ad > $bd ? 1 : -1');
//		usort($arr_einsatz, $function);
		
		foreach($arr_einsatz as $einsatz)
		{
			$this->db->where('einsatzID', $einsatz['einsatzID']);
			$this->db->update('einsatz', array('lfd_nr' => $lfdNr));
			$lfdNr++;	
		}
	}
	
	public function switch_online_state($einsatzID, $online)
	{
		$this->db->update('einsatz', array('online' => $online), 'einsatzID = '.$einsatzID);
	}
}
?>