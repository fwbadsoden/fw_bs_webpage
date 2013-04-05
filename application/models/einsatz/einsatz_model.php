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
	private $arr_types_db = array();
	private $arr_fahrzeuge_db = array();
	private $color = '';
	
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
	
	public function get_einsatz_years()
	{
		$years = array();
		
		$query = $this->db->query('SELECT DISTINCT substring( datum, 1, 4 ) as datum FROM '.$this->db->dbprefix('einsatz')); 
		
		foreach ($query->result() as $row)
		{ 
			$years[] = $row->datum;
		}
		rsort($years);
		return $years;
	}
	
	public function get_einsatz_list($year)
	{		
		$arr_einsatz_list = array();
		
		if(is_numeric($year))
		{
			$this->db->order_by('lfdNr', 'desc');
			$query = $this->db->get_where('einsatz', array('substring(datum,1,4)' => $year));
		}
		else
		{
			$query = $this->db->get('einsatz');
		}
		
		$i = 0;
		
		foreach($query->result() as $row)
		{
			$this->color = cp_get_color($this->color);
			
			$arr_einsatz_list[$i]['lfdNr'] 			= $row->lfdNr;
			$arr_einsatz_list[$i]['einsatzNr'] 		= $row->einsatzNr;
			$arr_einsatz_list[$i]['einsatzID'] 		= $row->einsatzID;
			$arr_einsatz_list[$i]['einsatzName'] 	= $row->einsatzName;
			$arr_einsatz_list[$i]['datum']	 		= cp_get_ger_date($row->datum);
			$arr_einsatz_list[$i]['beginn'] 		= $row->beginn;
			$arr_einsatz_list[$i]['ende']	 		= $row->ende;
			$arr_einsatz_list[$i]['online'] 		= $row->online;
			$arr_einsatz_list[$i]['row_color']		= $this->color;
			$arr_einsatz_list[$i]['year']			= $year;
			
			$i++;
		}
		return $arr_einsatz_list;
	}
	
	public function get_einsatz($id)
	{
		$this->db->select('*');
		$this->db->join('einsatz_content', 'einsatz.einsatzID = einsatz_content.einsatzID');
		$this->db->where('einsatz.einsatzID', $id);
		$query = $this->db->get('einsatz');
		
		$row = $query->row();
		$einsatz['einsatzID'] 				= $id;
		$einsatz['einsatzNr'] 				= $row->einsatzNr;
		$einsatz['einsatzName'] 			= $row->einsatzName;
		$einsatz['datum'] 					= $row->datum;
		$einsatz['beginn'] 					= $row->beginn;
		$einsatz['ende'] 					= $row->ende;
		$einsatz['einsatzlage'] 			= $row->einsatzlage;
		$einsatz['einsatzgeschehen'] 		= $row->einsatzgeschehen;
		$einsatz['einsatzkraefteFreitext']	= $row->einsatzkraefteFreitext;
		$einsatz['anzahlEinsatzkraefte']	= $row->anzahlEinsatzkraefte;
		
		$this->db->where('einsatzID', $id);
		$query = $this->db->get('einsatz_type_mapping');
		$i = 0;
		foreach($query->result() as $row)
		{
			$einsatz['type'][$row->typeID]	= 1;
			$i++;
		}
		
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
	
	public function get_einsatz_type_list()
	{
		$query = $this->db->get('einsatz_type');
		$i = 0;
		$arr_type = array();
		
		foreach($query->result() as $row)
		{
			$arr_type[$i]['typeID'] = $row->typeID;
			$arr_type[$i]['typeName'] = $row->typeName;
			$arr_type[$i]['typeShortname'] = $row->typeShortname;	
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
			$images[$i]['img_desc']		= $row->imgDesc;
			$images[$i]['img_file']		= $row->imgFile;
			$images[$i]['img_thumb']	= $row->imgFileThumbnail;
			$images[$i]['img_type']		= $row->fileType;
			$images[$i]['row_color']	= $this->color;
			
			$i++;
		}
		return $images;
	}
	
	public function create_einsatz()
	{ 
		$einsatz = array(
			'einsatzName' 	=> $this->input->post('einsatzname'),
			'datum'			=> cp_get_eng_date($this->input->post('einsatzdatum')),
			'beginn'		=> $this->input->post('einsatzbeginn'),
			'ende'			=> $this->input->post('einsatzende'),
			'einsatzNr'     => $this->input->post('einsatznr'),
			'lfdNr'			=> 0,
			'online'		=> 0
		);
		
		$this->db->select_max('lfdNr');
		$query = $this->db->get_where('einsatz', array('substr(datum,1,4)' => substr($einsatz['datum'],0,4)));
		$row = $query->row();	
		
		// ++++ TRANSAKTION START ++++ //
		$this->db->trans_start();	
		
		if($row->lfdNr != null)		$einsatz['lfdNr'] 	= $row->lfdNr;
		else								   $einsatz['lfdNr']   = 1;
		$this->db->insert('einsatz', $einsatz);
		$einsatzID = $this->db->insert_id();		

		$einsatzContent = array(
			'einsatzID'					=> $einsatzID,
			'einsatzlage'				=> $this->input->post('einsatzlage'),
			'einsatzgeschehen'			=> $this->input->post('einsatzgeschehen'),
			'einsatzkraefteFreitext'	=> $this->input->post('weitereeinsatzkraefte'),
			'anzahlEinsatzkraefte'		=> $this->input->post('anzahl')
		);
		$this->db->insert('einsatz_content', $einsatzContent);
		
		array_walk($this->input->post(), array($this, 'callback_einsatz_find_mappings'));
		foreach($this->arr_types_db as $t)
		{
			$this->db->insert('einsatz_type_mapping', array('einsatzID' => $einsatzID, 'typeID' => $t));	
		}
		foreach($this->arr_fahrzeuge_db as $f)
		{
			$this->db->insert('einsatz_fahrzeug_mapping', array('einsatzID' => $einsatzID, 'fahrzeugID' => $f));	
		}		
		$this->recalc_lfdnr(substr($einsatz['datum'],0,4));
		
		$this->db->trans_complete();
		// ++++ TRANSAKTION ENDE ++++ //

	}
	
	public function update_einsatz($id)
	{
		$einsatz = array(
			'einsatzName' 	=> $this->input->post('einsatzname'),
			'datum'			=> cp_get_eng_date($this->input->post('einsatzdatum')),
			'beginn'		=> $this->input->post('einsatzbeginn'),
			'ende'			=> $this->input->post('einsatzende'),
			'einsatznr'     => $this->input->post('einsatznr')
		);		
		$einsatzContent = array(
			'einsatzlage'				=> $this->input->post('einsatzlage'),
			'einsatzgeschehen'			=> $this->input->post('einsatzgeschehen'),
			'einsatzkraefteFreitext'	=> $this->input->post('weitereeinsatzkraefte'),
			'anzahlEinsatzkraefte'		=> $this->input->post('anzahl')
		);
		
		// ++++ TRANSAKTION START ++++ //
		$this->db->trans_start();
		
		$this->db->where('einsatzID', $id);
		$this->db->update('einsatz', $einsatz);
		$this->db->where('einsatzID', $id);
		$this->db->update('einsatz_content', $einsatzContent);
		$this->db->where('einsatzID', $id);
		$this->db->delete('einsatz_type_mapping', array('einsatzID' => $id));
		$this->db->where('einsatzID', $id);
		$this->db->delete('einsatz_fahrzeug_mapping', array('einsatzID' => $id));
		
		array_walk($this->input->post(), array($this, 'callback_einsatz_find_mappings'));
		foreach($this->arr_types_db as $t)
		{
			$this->db->insert('einsatz_type_mapping', array('einsatzID' => $id, 'typeID' => $t));	
		}
		foreach($this->arr_fahrzeuge_db as $f)
		{
			$this->db->insert('einsatz_fahrzeug_mapping', array('einsatzID' => $id, 'fahrzeugID' => $f));	
		}
		$this->recalc_lfdnr(substr($einsatz['datum'],0,4));
		
		$this->db->trans_complete();
		// ++++ TRANSAKTION ENDE ++++ //
	}
	
	public function delete_einsatz($id)
	{		
		$this->delete_images($id);	
		$this->db->select('datum');
		$query = $this->db->get_where('einsatz', array('einsatzID' => $id));
		$row = $query->row();
		$tables = array('einsatz', 'einsatz_content', 'einsatz_type_mapping', 'einsatz_fahrzeug_mapping');
		$this->db->where('einsatzID', $id);
		$this->db->delete($tables);
		$return = $this->recalc_lfdnr(substr($row->datum,0,4));
	}
	
	public function insert_image($id, $desc, $file, $thumb, $type) 
	{
		$this->db->insert('einsatz_img', array('einsatzID' => $id, 'imgDesc' => $desc, 'imgFile' => $file, 'imgFileThumbnail' => $thumb, 'fileType' => $type));	
	}
	
	public function update_image($id, $desc)
	{
		$this->db->where('imgID', $id);
		$this->db->update('einsatz_img', array('imgDesc' => $desc));	
	}
	
	public function delete_image($id)
	{
		$query = $this->db->get_where('einsatz_img', array('imgID' => $id));
		$row = $query->row();
			
		unlink($this->upload_path.$row->imgFile);
		unlink($this->upload_path.$row->imgFileThumbnail);
		
		$this->db->delete('einsatz_img', array('imgID' => $id));	
	}
	
	public function delete_images($id)
	{
		$query = $this->db->get_where('einsatz_img', array('einsatzID' => $id));
		
		foreach($query->result() as $row)
		{
			unlink($this->upload_path.$row->imgFile);
			unlink($this->upload_path.$row->imgFileThumbnail);
			
			$this->db->delete('einsatz_img', array('imgID' => $row->imgID));	
		}
	}
	
	public function get_einsatz_templates($id = 0)
	{	
		if($id !=0)	$this->db->where('templateID', $id);
		$this->db->order_by('templateName', 'ASC');
		$query = $this->db->get('einsatz_template');
		$templates = array();
			
		foreach($query->result() as $row)
		{
			$templates[$row->templateID]['template_id'] 		= $row->templateID;
			$templates[$row->templateID]['template_name'] 		= $row->templateName;
			$templates[$row->templateID]['einsatz_name']		= $row->einsatzName;
			$templates[$row->templateID]['einsatz_lage']		= $row->einsatzlage;
			$templates[$row->templateID]['einsatz_geschehen']	= $row->einsatzgeschehen;
			$templates[$row->templateID]['einsatz_art']			= $row->einsatzart;
			$templates[$row->templateID]['einsatz_fahrzeug']	= $row->fahrzeug;
		}
		return $templates;
	}
	
	private function callback_einsatz_find_mappings($value, $key)
	{ 	
		$check = explode('_', $key);
		if($check[0] == 't') // TYPE
		{	
			// Sicherheitscheck, dass rechts nur noch Nummer stehen
			if(is_numeric($check[1]))
			{	
				$this->arr_types_db[$this->counterT] = $value;				
				$this->counterT++;
			}
		}
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
		$this->db->order_by('datum', 'asc');
		$query = $this->db->get_where('einsatz', array('substr(datum,1,4)' => $year));
		$lfdNr = 1;
		$arr_einsatz = array();
		$i = 0;
		
		foreach($query->result() as $row)
		{
			$arr_einsatz[$i]['einsatzID'] = $row->einsatzID;
			$arr_einsatz[$i]['sort'] = $row->datum.' '.$row->beginn;
			$i++;			
		}
		
		usort($arr_einsatz, function($a, $b) 	{ $ad = new DateTime($a['sort']);
												  $bd = new DateTime($b['sort']);
												
												  if ($ad == $bd) {
												    return 0;
												  }
												
												  return $ad > $bd ? 1 : -1;
												});
		
		foreach($arr_einsatz as $einsatz)
		{
			$this->db->where('einsatzID', $einsatz['einsatzID']);
			$this->db->update('einsatz', array('lfdNr' => $lfdNr));
			$lfdNr++;	
		}
	}
	
	public function switch_online_state($einsatzID, $online)
	{
		$this->db->update('einsatz', array('online' => $online), 'einsatzID = '.$einsatzID);
	}
}
?>