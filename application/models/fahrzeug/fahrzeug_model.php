<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fahrzeug Model
 *
 * Model zum Fahrzeug-Modul
 *
 * @package		com.cp.feuerwehr.models.fahrzeug
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 */	
 
class Fahrzeug_Model extends CI_Model {
	
	private $color = '';
    private $upload_path = CONTENT_IMG_FAHRZEUG_UPLOAD_PATH;
	
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
	
	public function get_fahrzeug($id)
	{	
		$this->db->join('fahrzeug_content', 'fahrzeug.fahrzeugID = fahrzeug_content.fahrzeugID');
		$this->db->where('fahrzeug.fahrzeugID', $id);
		$query = $this->db->get('fahrzeug');
		
		$row = $query->row();	
		$fahrzeug['fahrzeugID']				= $id;
		$fahrzeug['fahrzeugName']			= $row->name;
		$fahrzeug['fahrzeugNameLang']		= $row->name_lang;
		$fahrzeug['fahrzeugRufnamePrefix']	= $row->prefix_rufname;
		$fahrzeug['fahrzeugRufname']		= $row->rufname;
		$fahrzeug['fahrzeugText']			= $row->text;
		$fahrzeug['fahrzeugBesatzung']		= $row->besatzung;
		$fahrzeug['fahrzeugHersteller']		= $row->hersteller;
		$fahrzeug['fahrzeugAufbau']			= $row->aufbau;
		$fahrzeug['fahrzeugLeistungKW']		= $row->kw;
		$fahrzeug['fahrzeugLeistungPS']		= $row->ps;
		$fahrzeug['fahrzeugLaenge']			= $row->laenge;
		$fahrzeug['fahrzeugBreite']			= $row->breite;
		$fahrzeug['fahrzeugHoehe']			= $row->hoehe;
		$fahrzeug['fahrzeugLeermasse']		= $row->leermasse;
		$fahrzeug['fahrzeugGesamtmasse']	= $row->gesamtmasse;
				
		return $fahrzeug;
	}
	
	public function get_fahrzeug_list()
	{		
		$this->db->order_by('online', 'desc');
		$this->db->order_by('rufname', 'asc');
		$query = $this->db->get('fahrzeug');
		$i = 0;
		$arr_fahrzeug = array();
		
		foreach($query->result() as $row)
		{
			$arr_fahrzeug[$i]['fahrzeugID'] 	= $row->fahrzeugID;
			$arr_fahrzeug[$i]['fahrzeugName'] 	= $row->name;
			$arr_fahrzeug[$i]['fahrzeugRufnamePrefix'] = $row->prefix_rufname;
			if($row->rufname != '')
			{
				$arr_fahrzeug[$i]['fahrzeugRufname'] = $row->rufname;
			}
			else
				$arr_fahrzeug[$i]['fahrzeugRufname'] = 'n/a';
			$arr_fahrzeug[$i]['online'] 		= $row->online;
			$arr_fahrzeug[$i]['delete'] 		= $this->is_deletable($row->fahrzeugID);
			$arr_fahrzeug[$i]['row_color']		= $this->color = cp_get_color($this->color);
			$i++;
		}
		
		return $arr_fahrzeug;
	}
	
	public function get_fahrzeug_list_id_name($active = 1)
	{
		$this->db->select('fahrzeugID, name')->where('online', $active);
		$query = $this->db->get('fahrzeug');
		$i = 0;
		$arr_fahrzeug = array();
		
		foreach($query->result() as $row)
		{
			$arr_fahrzeug[$i]['id'] = $row->fahrzeugID;
			$arr_fahrzeug[$i]['name'] = $row->name;
			$i++;
		}
		
		return $arr_fahrzeug;
	}
    
    public function get_fahrzeug_anzahl()
    {
        $query = $this->db->get('fahrzeug');
        return $query->num_rows();
    }
	
	public function get_images($id)
	{
		$query = $this->db->get_where('fahrzeug_img', array('fahrzeugID' => $id));	
		$images = array();
		$i = 0;
		
		foreach($query->result() as $row)
		{
			$this->color = cp_get_color($this->color);
			
			$images[$i]['imageID']		= $row->imgID;
			$images[$i]['fahrzeugID']	= $row->fahrzeugID;
			$images[$i]['img_desc']		= $row->description;
			$images[$i]['img_file']		= $row->img_file;
			$images[$i]['img_thumb']	= $row->thumb_file;
            $images[$i]['img_small_pic']  = $row->small_pic;
			$images[$i]['img_type']		= $row->filetype;
			$images[$i]['row_color']	= $this->color;
			
			$i++;
		}
		return $images;
	}
	
	public function create_fahrzeug()
	{
		$fahrzeug = array(
			'name'			 => $this->input->post('fahrzeugname'),
			'name_lang'	     => $this->input->post('fahrzeugnamelang'),
			'rufname'		 => $this->input->post('fahrzeugrufname'),
			'prefix_rufname' => $this->input->post('fahrzeugprefix'),
			'online'		 => 0
		);
		
		// ++++ TRANSAKTION START ++++ //
		$this->db->trans_start();
		
		$this->db->insert('fahrzeug',  $fahrzeug);
		$fahrzeugID = $this->db->insert_id();	
		
		$fahrzeugContent = array(
            'fahrzeugID'    => $fahrzeugID,
			'text'			=> $this->input->post('fahrzeugtext'),
			'besatzung'		=> $this->input->post('fahrzeugbesatzung'),
			'hersteller'	=> $this->input->post('fahrzeughersteller'),
			'aufbau'		=> $this->input->post('fahrzeugaufbau'),
			'kw'	        => $this->input->post('fahrzeugleistungkw'),
			'ps'	        => $this->input->post('fahrzeugleistungps'),
			'laenge'		=> $this->input->post('fahrzeuglaenge'),
			'breite'		=> $this->input->post('fahrzeugbreite'),
			'hoehe'			=> $this->input->post('fahrzeughoehe'),
			'leermasse'		=> $this->input->post('fahrzeugleermasse'),
			'gesamtmasse'	=> $this->input->post('fahrzeuggesamtmasse')
		);
		
		$this->db->insert('fahrzeug_content', $fahrzeugContent);
		
		$this->db->trans_complete();
		// ++++ TRANSAKTION ENDE ++++ //
	}
	
	public function update_fahrzeug($id)
	{
		$fahrzeug = array(
			'name'			 => $this->input->post('fahrzeugname'),
			'name_lang'	     => $this->input->post('fahrzeugnamelang'),
			'rufname'		 => $this->input->post('fahrzeugrufname'),
			'prefix_rufname' => $this->input->post('fahrzeugprefix'),
		);
		
		$fahrzeugContent = array(
			'text'			=> $this->input->post('fahrzeugtext'),
			'besatzung'		=> $this->input->post('fahrzeugbesatzung'),
			'hersteller'	=> $this->input->post('fahrzeughersteller'),
			'aufbau'		=> $this->input->post('fahrzeugaufbau'),
			'kw'	        => $this->input->post('fahrzeugleistungkw'),
			'ps'	        => $this->input->post('fahrzeugleistungps'),
			'laenge'		=> $this->input->post('fahrzeuglaenge'),
			'breite'		=> $this->input->post('fahrzeugbreite'),
			'hoehe'			=> $this->input->post('fahrzeughoehe'),
			'leermasse'		=> $this->input->post('fahrzeugleermasse'),
			'gesamtmasse'	=> $this->input->post('fahrzeuggesamtmasse')
		);
		
		// ++++ TRANSAKTION START ++++ //
		$this->db->trans_start();
		
		$this->db->where('fahrzeugID', $id);
		$this->db->update('fahrzeug', $fahrzeug);
		$this->db->where('fahrzeugID', $id);
		$this->db->update('fahrzeug_content', $fahrzeugContent);
		
		$this->db->trans_complete();
		// ++++ TRANSAKTION ENDE ++++ //
	}
	
	public function delete_fahrzeug($id)
	{	
		if($this->is_deletable($id))
		{
			$this->delete_images($id);
		
			$tables = array('fahrzeug', 'fahrzeug_content');
			$this->db->where('fahrzeugID', $id);
			$this->db->delete($tables);
		}
	}
	
	public function insert_image($id, $desc, $file, $thumb, $type, $small_pic = 0) 
	{
	    if($small_pic == 1) $this->db->update('fahrzeug_img', array('small_pic' => 0));
		$this->db->insert('fahrzeug_img', array('fahrzeugID' => $id, 'description' => $desc, 'small_pic' => 1, 'img_file' => $file, 'thumb_file' => $thumb, 'filetype' => $type));	
	}
	
	public function update_image($id, $desc, $small_pic = 0)
	{
	    if($small_pic == 1) $this->db->update('fahrzeug_img', array('small_pic' => 0));
		$this->db->where('imgID', $id);
		$this->db->update('fahrzeug_img', array('description' => $desc, 'small_pic' => 1));	
	}
	
	public function delete_image($id)
	{
		$query = $this->db->get_where('fahrzeug_img', array('imgID' => $id));
		$row = $query->row();
			
		unlink($this->upload_path.$row->img_file);
		unlink($this->upload_path.$row->thumb_file);
		
		$this->db->delete('fahrzeug_img', array('imgID' => $id));	
        if($row->small_pic == 1) $this->db->update('fahrzeug_img', array('small_pic' => 1), array('fahrzeugID' => $row->fahrzeugID), 1);
	}
	
	private function delete_images($id)
	{
		$query = $this->db->get_where('fahrzeug_img', array('fahrzeugID' => $id));
		
		foreach($query->result() as $row)
		{
			unlink($this->upload_path.$row->img_file);
			unlink($this->upload_path.$row->thumb_file);
			
			$this->db->delete('fahrzeug_img', array('imgID' => $row->imgID));	
		}
	}
	
	private function is_deletable($fahrzeugID)
	{
		$query = $this->db->get_where('einsatz_fahrzeug_mapping', array('fahrzeugID' => $fahrzeugID));
		if($query->num_rows() == 0) return 1; else return 0;
	}
	
	public function switch_online_state($id, $online)
	{
		$this->db->update('fahrzeug', array('online' => $online), 'fahrzeugID = '.$id);
	}
}
?>