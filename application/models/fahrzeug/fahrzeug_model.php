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
		$this->db->select('*');
		$this->db->join('fahrzeug_content', 'fahrzeug.fahrzeugID = fahrzeug_content.fahrzeugID');
		$this->db->where('fahrzeug.fahrzeugID', $id);
		$query = $this->db->get('fahrzeug');
		
		$row = $query->row();	
		$fahrzeug['fahrzeugID']				= $id;
		$fahrzeug['fahrzeugName']			= $row->fahrzeugName;
		$fahrzeug['fahrzeugRufnamePrefix']	= $row->fahrzeugRufnamePrefix;
		$fahrzeug['fahrzeugRufname']		= $row->fahrzeugRufname;
		$fahrzeug['fahrzeugText']			= $row->fahrzeugText;
		$fahrzeug['fahrzeugBesatzung']		= $row->fahrzeugBesatzung;
		$fahrzeug['fahrzeugHersteller']		= $row->fahrzeugHersteller;
		$fahrzeug['fahrzeugAufbau']			= $row->fahrzeugAufbau;
		$fahrzeug['fahrzeugLeistungKW']		= $row->fahrzeugLeistungKW;
		$fahrzeug['fahrzeugLeistungPS']		= $row->fahrzeugLeistungPS;
		$fahrzeug['fahrzeugLaenge']			= $row->fahrzeugLaenge;
		$fahrzeug['fahrzeugBreite']			= $row->fahrzeugBreite;
		$fahrzeug['fahrzeugHoehe']			= $row->fahrzeugHoehe;
		$fahrzeug['fahrzeugLeermasse']		= $row->fahrzeugLeermasse;
		$fahrzeug['fahrzeugGesamtmasse']	= $row->fahrzeugGesamtmasse;
				
		return $fahrzeug;
	}
	
	public function get_fahrzeug_list()
	{		
		$this->db->order_by('online', 'desc');
		$this->db->order_by('fahrzeugID', 'asc');
		$query = $this->db->get('fahrzeug');
		$i = 0;
		$arr_fahrzeug = array();
		
		foreach($query->result() as $row)
		{
			$this->color = cp_get_color($this->color);
			$arr_fahrzeug[$i]['fahrzeugID'] 	= $row->fahrzeugID;
			$arr_fahrzeug[$i]['fahrzeugName'] 	= $row->fahrzeugName;
			$arr_fahrzeug[$i]['fahrzeugRufnamePrefix'] = $row->fahrzeugRufnamePrefix;
			if($row->fahrzeugRufname != '')
			{
				$arr_fahrzeug[$i]['fahrzeugRufname'] = $row->fahrzeugRufname;
			}
			else
				$arr_fahrzeug[$i]['fahrzeugRufname'] = 'n/a';
			$arr_fahrzeug[$i]['online'] 		= $row->online;
			$arr_fahrzeug[$i]['delete'] 		= $this->is_deletable($row->fahrzeugID);
			$arr_fahrzeug[$i]['row_color']		= $this->color;
			$i++;
		}
		
		return $arr_fahrzeug;
	}
	
	public function get_fahrzeug_list_id_name($active = 1)
	{
		$this->db->select('fahrzeugID, fahrzeugName')->where('online', $active);
		$query = $this->db->get('fahrzeug');
		$i = 0;
		$arr_fahrzeug = array();
		
		foreach($query->result() as $row)
		{
			$arr_fahrzeug[$i]['id'] = $row->fahrzeugID;
			$arr_fahrzeug[$i]['name'] = $row->fahrzeugName;
			$i++;
		}
		
		return $arr_fahrzeug;
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
			$images[$i]['img_desc']		= $row->imgDesc;
			$images[$i]['img_file']		= $row->imgFile;
			$images[$i]['img_thumb']	= $row->imgFileThumbnail;
			$images[$i]['img_type']		= $row->fileType;
			$images[$i]['row_color']	= $this->color;
			
			$i++;
		}
		return $images;
	}
	
	public function create_fahrzeug()
	{
		$fahrzeug = array(
			'fahrzeugName'			=> $this->input->post('fahrzeugname'),
			'fahrzeugRufname'		=> $this->input->post('fahrzeugrufname'),
			'fahrzeugRufnamePrefix' => $this->input->post('fahrzeugprefix'),
			'online'				=> 0
		);
		
		// ++++ TRANSAKTION START ++++ //
		$this->db->trans_start();
		
		$this->db->insert('fahrzeug',  $fahrzeug);
		$fahrzeugID = $this->db->insert_id();	
		
		$fahrzeugContent = array(
			'fahrzeugText'			=> $this->input->post('fahrzeugtext'),
			'fahrzeugBesatzung'		=> $this->input->post('fahrzeugbesatzung'),
			'fahrzeugHersteller'	=> $this->input->post('fahrzeughersteller'),
			'fahrzeugAufbau'		=> $this->input->post('fahrzeugaufbau'),
			'fahrzeugLeistungKW'	=> $this->input->post('fahrzeugleistungkw'),
			'fahrzeugLeistungPS'	=> $this->input->post('fahrzeugleistungps'),
			'fahrzeugLaenge'		=> $this->input->post('fahrzeuglaenge'),
			'fahrzeugBreite'		=> $this->input->post('fahrzeugbreite'),
			'fahrzeugHoehe'			=> $this->input->post('fahrzeughoehe'),
			'fahrzeugLeermasse'		=> $this->input->post('fahrzeugleermasse'),
			'fahrzeugGesamtmasse'	=> $this->input->post('fahrzeuggesamtmasse')
		);
		
		$this->db->insert('fahrzeug_content', $fahrzeugContent);
		
		$this->db->trans_complete();
		// ++++ TRANSAKTION ENDE ++++ //
	}
	
	public function update_fahrzeug($id)
	{
		$fahrzeug = array(
			'fahrzeugName'			=> $this->input->post('fahrzeugname'),
			'fahrzeugRufname'		=> $this->input->post('fahrzeugrufname'),
			'fahrzeugRufnamePrefix' => $this->input->post('fahrzeugprefix'),
		);
		
		$fahrzeugContent = array(
			'fahrzeugText'			=> $this->input->post('fahrzeugtext'),
			'fahrzeugBesatzung'		=> $this->input->post('fahrzeugbesatzung'),
			'fahrzeugHersteller'	=> $this->input->post('fahrzeughersteller'),
			'fahrzeugAufbau'		=> $this->input->post('fahrzeugaufbau'),
			'fahrzeugLeistungKW'	=> $this->input->post('fahrzeugleistungkw'),
			'fahrzeugLeistungPS'	=> $this->input->post('fahrzeugleistungps'),
			'fahrzeugLaenge'		=> $this->input->post('fahrzeuglaenge'),
			'fahrzeugBreite'		=> $this->input->post('fahrzeugbreite'),
			'fahrzeugHoehe'			=> $this->input->post('fahrzeughoehe'),
			'fahrzeugLeermasse'		=> $this->input->post('fahrzeugleermasse'),
			'fahrzeugGesamtmasse'	=> $this->input->post('fahrzeuggesamtmasse')
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
	
	public function insert_image($id, $desc, $file, $thumb, $type) 
	{
		$this->db->insert('fahrzeug_img', array('fahrzeugID' => $id, 'imgDesc' => $desc, 'imgFile' => $file, 'imgFileThumbnail' => $thumb, 'fileType' => $type));	
	}
	
	public function update_image($id, $desc)
	{
		$this->db->where('imgID', $id);
		$this->db->update('fahrzeug_img', array('imgDesc' => $desc));	
	}
	
	public function delete_image($id)
	{
		$query = $this->db->get_where('fahrzeug_img', array('imgID' => $id));
		$row = $query->row();
			
		unlink($this->upload_path.$row->imgFile);
		unlink($this->upload_path.$row->imgFileThumbnail);
		
		$this->db->delete('fahrzeug_img', array('imgID' => $id));	
	}
	
	public function delete_images($id)
	{
		$query = $this->db->get_where('fahrzeug_img', array('fahrzeugID' => $id));
		
		foreach($query->result() as $row)
		{
			unlink($this->upload_path.$row->imgFile);
			unlink($this->upload_path.$row->imgFileThumbnail);
			
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