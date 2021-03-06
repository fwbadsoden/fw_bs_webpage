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
	
	public function get_fahrzeug($id, $admin = 0)
	{	
		$this->db->join('fahrzeug_content', 'fahrzeug.fahrzeugID = fahrzeug_content.fahrzeugID');
		$this->db->where('fahrzeug.fahrzeugID', $id);
        if($admin == 0)
            $this->db->where('online', 1);
		$query = $this->db->get('fahrzeug');
		
		$row = $query->row();	
		$fahrzeug['fahrzeugID']				= $id;
		$fahrzeug['fahrzeugName']			= $row->name;
		$fahrzeug['fahrzeugNameLang']		= $row->name_lang;
		$fahrzeug['fahrzeugRufnamePrefix']	= $row->prefix_rufname;
		$fahrzeug['fahrzeugRufname']		= $row->rufname;
        $fahrzeug['fahrzeugShortText']      = $row->short_text;
		$fahrzeug['fahrzeugText']			= $row->text;
        $fahrzeug['fahrzeugGeschichte']     = $row->geschichte;
        $fahrzeug['fahrzeugStatistik']      = $row->statistik;
        $fahrzeug['fahrzeugBaujahr']        = $row->baujahr;
		$fahrzeug['fahrzeugBesatzung']		= $row->besatzung;
		$fahrzeug['fahrzeugHersteller']		= $row->hersteller;
		$fahrzeug['fahrzeugAufbau']			= $row->aufbau;
        $fahrzeug['fahrzeugPumpe']          = $row->pumpe;
        $fahrzeug['fahrzeugLoeschmittel']   = $row->loeschmittel;
        $fahrzeug['fahrzeugBesonderheit']   = $row->besonderheit;
		$fahrzeug['fahrzeugLeistungKW']		= $row->kw;
		$fahrzeug['fahrzeugLeistungPS']		= $row->ps;
		$fahrzeug['fahrzeugLaenge']			= $row->laenge;
		$fahrzeug['fahrzeugBreite']			= $row->breite;
		$fahrzeug['fahrzeugHoehe']			= $row->hoehe;
		$fahrzeug['fahrzeugLeermasse']		= $row->leermasse;
		$fahrzeug['fahrzeugGesamtmasse']	= $row->gesamtmasse;
        $fahrzeug['show_einsaetze']         = $row->show_einsaetze;
        $fahrzeug['retired']                = $row->retired;
				
		return $fahrzeug;
	}
    
    public function get_fahrzeug_stage_text($id)
    {
        $this->db->select('name, name_lang, short_text, retired');
        $this->db->where('fahrzeug.fahrzeugID', $id);
        $this->db->join('fahrzeug_content', 'fahrzeug.fahrzeugID = fahrzeug_content.fahrzeugID');
        $query = $this->db->get('fahrzeug');
        $row = $query->row();
        $text['name']       = $row->name;
        $text['name_lang']  = $row->name_lang;
        $text['short_text'] = $row->short_text;
        if($row->retired == "1")
            $text['retired'] = " a.D.";
        
        return $text;
    }
	
	public function get_fahrzeug_list($online, $retired, $showAll = 0)
	{	
		$this->db->order_by('orderID', 'asc');
        if($online == 1) {
            $this->db->where('online', 1);
        }
        if($retired == 0) {
            $this->db->where('retired', 0);
        }
        if($retired == 1 && $showAll == 0)  {
            $this->db->where('retired', 1);
        }
		$query = $this->db->get('fahrzeug');
		$i = 0;
		$arr_fahrzeug = array();
        
		foreach($query->result() as $row)
		{
			$arr_fahrzeug[$i]['fahrzeugID'] 	= $row->fahrzeugID;
			$arr_fahrzeug[$i]['fahrzeugName'] 	= $row->name;
			$arr_fahrzeug[$i]['fahrzeugNameLang'] 	= $row->name_lang;
			$arr_fahrzeug[$i]['fahrzeugRufnamePrefix'] = $row->prefix_rufname;
			if($row->rufname != '')
			{
				$arr_fahrzeug[$i]['fahrzeugRufname'] = $row->rufname;
			}
			else
				$arr_fahrzeug[$i]['fahrzeugRufname'] = 'n/a';
			$arr_fahrzeug[$i]['online'] 		= $row->online;
			$arr_fahrzeug[$i]['delete'] 		= $this->_is_deletable($row->fahrzeugID);
            $arr_fahrzeug[$i]['ready']          = $this->_is_ready_for_online($row->fahrzeugID);
            $arr_fahrzeug[$i]['orderID']        = $row->orderID;
			$arr_fahrzeug[$i]['row_color']		= $this->color = cp_get_color($this->color);
            $arr_fahrzeug[$i]['retired']        = $row->retired;
			$i++;
		}
		
		return $arr_fahrzeug;
	}
    
    public function hasRetired() {
        
        $this->db->where('online', 1);
        $this->db->where('retired', 1);
        $query = $this->db->get('fahrzeug');
        
        if($query->num_rows() > 0)
            return true;
        else 
            return false;
    }
	
	public function get_fahrzeug_list_id_name($active = 1)
	{
		$this->db->select('fahrzeugID, name')->where('online', $active);
        $this->db->order_by('orderID', 'asc');
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
        $this->db->select('fahrzeugID');
        $this->db->where('online', 1);
        $this->db->where('retired', 0);
        $query = $this->db->get('fahrzeug');
        return $query->num_rows();
    }
    
    public function get_fahrzeug_images($id)
    {
        $this->db->where('small_pic', 0);
        $this->db->where('fahrzeugID', $id);
        $query = $this->db->get('fahrzeug_img');
        $i = 0;
        $images = array();
        foreach($query->result() as $row)
        {
            $images[$i]['description']  = $row->description;
            $images[$i]['text']         = $row->text;
            $images[$i]['img_file']     = $row->img_file;
            $i++;
        }
        return $images;
    }
    
    public function get_fahrzeug_einsaetze($id)
    {
        $this->db->select('einsatz_content.lage as lage, einsatz.name as name, einsatz.einsatzID as id, einsatz.datum_beginn as datum');
        $this->db->limit(5,0);
        $this->db->order_by('datum_beginn', 'DESC');
        $this->db->order_by('uhrzeit_beginn', 'DESC');
        $this->db->where('einsatz_fahrzeug_mapping.fahrzeugID', $id);
        $this->db->join('einsatz_content', 'einsatz_content.einsatzID = einsatz.einsatzID');
        $this->db->join('einsatz_fahrzeug_mapping', 'einsatz_fahrzeug_mapping.einsatzID = einsatz.einsatzID');
        $query = $this->db->get('einsatz'); 
        $i = 0;
        $einsaetze = array();
        foreach($query->result() as $row)
        {
            $einsaetze[$i]['einsatzID'] = $row->id;
            $einsaetze[$i]['name']      = $row->name;
            $einsaetze[$i]['lage']      = $row->lage;
            $einsaetze[$i]['datum']     = $row->datum;
            $i++;
        }
        return $einsaetze;
    }
    
    public function get_setcard_image($id)
    {
        $this->db->where('small_pic', 1);
        $this->db->where('fahrzeugID', $id);
        $query = $this->db->get('fahrzeug_img');
        $row = $query->row();
        
        $img['thumb'] = $row->thumb_file;
        $img['img']   = $row->img_file;
        
        return $img;
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
        if($this->input->post('show_einsaetze') == "1")
            $show_einsaetze = "1";
        else
            $show_einsaetze = "0";
            
		$fahrzeug = array(
			'name'			 => $this->input->post('fahrzeugname'),
			'name_lang'	     => $this->input->post('fahrzeugnamelang'),
			'rufname'		 => $this->input->post('fahrzeugrufname'),
			'prefix_rufname' => $this->input->post('fahrzeugprefix'),
            'show_einsaetze' => $show_einsaetze,
			'online'		 => 0,
            'retired'        => 0
		);
		
		// ++++ TRANSAKTION START ++++ //
		$this->db->trans_start();
		
        // höchste orderID aus DB holen
        $this->db->select_max('orderID');
        $query = $this->db->get('fahrzeug');
        $row = $query->row();
        $fahrzeug['orderID'] = $row->orderID + 1;
        
		$this->db->insert('fahrzeug',  $fahrzeug);
		$fahrzeugID = $this->db->insert_id();	
		
		$fahrzeugContent = array(
            'fahrzeugID'    => $fahrzeugID,
			'text'			=> $this->input->post('fahrzeugtext'),
            'baujahr'       => $this->input->post('fahrzeugbaujahr'),
			'besatzung'		=> $this->input->post('fahrzeugbesatzung'),
			'hersteller'	=> $this->input->post('fahrzeughersteller'),
			'aufbau'		=> $this->input->post('fahrzeugaufbau'),
            'pumpe'         => $this->input->post('fahrzeugpumpe'),
            'loeschmittel'  => $this->input->post('fahrzeugloeschmittel'),
            'besonderheit'  => $this->input->post('fahrzeugbesonderheit'),
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
        if($this->input->post('show_einsaetze') == "1")
            $show_einsaetze = "1";
        else
            $show_einsaetze = "0";
        if($this->input->post('retired') == "1")
            $retired = 1;
        else
            $retired = 0;
            
		$fahrzeug = array(
			'name'			 => $this->input->post('fahrzeugname'),
			'name_lang'	     => $this->input->post('fahrzeugnamelang'),
			'rufname'		 => $this->input->post('fahrzeugrufname'),
			'prefix_rufname' => $this->input->post('fahrzeugprefix'),
            'show_einsaetze' => $show_einsaetze,
            'retired'        => $retired
		);
		
		$fahrzeugContent = array(
			'text'			=> $this->input->post('fahrzeugtext'),
            'baujahr'       => $this->input->post('fahrzeugbaujahr'),
			'besatzung'		=> $this->input->post('fahrzeugbesatzung'),
			'hersteller'	=> $this->input->post('fahrzeughersteller'),
			'aufbau'		=> $this->input->post('fahrzeugaufbau'),
            'pumpe'         => $this->input->post('fahrzeugpumpe'),
            'loeschmittel'  => $this->input->post('fahrzeugloeschmittel'),
            'besonderheit'  => $this->input->post('fahrzeugbesonderheit'),
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
		if($this->_is_deletable($id))
		{
			$this->_delete_images($id);
            $orderID = $this->_get_orderID($id);
		
			$tables = array('fahrzeug', 'fahrzeug_content');
			$this->db->where('fahrzeugID', $id);
			$this->db->delete($tables);
            
            $this->_recalc_orderID($orderID);
		}
	}
	
	public function insert_image($id, $desc, $file, $thumb, $type, $small_pic = 0) 
	{
	    if($small_pic == 1) $this->db->update('fahrzeug_img', array('small_pic' => 0));
		$this->db->insert('fahrzeug_img', array('fahrzeugID' => $id, 'description' => $desc, 'small_pic' => $small_pic, 'img_file' => $file, 'thumb_file' => $thumb, 'filetype' => $type));	
	}
	
	public function update_image($id, $desc, $small_pic = 0)
	{
	    if($small_pic == 1) $this->db->update('fahrzeug_img', array('small_pic' => 0));
		$this->db->where('imgID', $id);
		$this->db->update('fahrzeug_img', array('description' => $desc, 'small_pic' => $small_pic));	
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
	
	private function _delete_images($id)
	{
		$query = $this->db->get_where('fahrzeug_img', array('fahrzeugID' => $id));
		
		foreach($query->result() as $row)
		{
			unlink($this->upload_path.$row->img_file);
			unlink($this->upload_path.$row->thumb_file);
			
			$this->db->delete('fahrzeug_img', array('imgID' => $row->imgID));	
		}
	}
    
    private function _is_ready_for_online($fahrzeugID) {
        $this->db->where('small_pic', "1");
        $this->db->where('fahrzeugID', $fahrzeugID);
        $query = $this->db->get('fahrzeug_img');
        if($query->num_rows() == 0) return 0; else return 1;
    }
	
	private function _is_deletable($fahrzeugID)
	{
		$query = $this->db->get_where('einsatz_fahrzeug_mapping', array('fahrzeugID' => $fahrzeugID));
		if($query->num_rows() == 0) return 1; else return 0;
	}
	
	public function change_order($dir, $id)
	{
		$query = $this->db->get_where('fahrzeug', array('fahrzeugID' => $id));
		$row = $query->row();	
		
		$orderID  = $row->orderID;
		
		if($dir == 'up') $newOrderID = $orderID-1;
		else $newOrderID = $orderID+1;
		
		$query2 = $this->db->get_where('fahrzeug', array('orderID'  => $newOrderID));	
		$row2 = $query2->row();
		
		$this->db->trans_start();
		$this->db->update('fahrzeug', array('orderID' => $orderID), 'fahrzeugID = '.$row2->fahrzeugID);
		$this->db->update('fahrzeug', array('orderID' => $newOrderID), 'fahrzeugID = '.$id);
		$this->db->trans_complete();		
	}
	
	public function switch_online_state($id, $online)
	{
		$this->db->update('fahrzeug', array('online' => $online), 'fahrzeugID = '.$id);
	}
    
    private function _get_orderID($id) {
        $this->db->select('orderID');
        $this->db->where('fahrzeugID', $id);
        $query = $this->db->get('fahrzeug');
        $row = $query->row();
        return $row->orderID;
    }
    
    private function _recalc_orderID($orderID) {
        
        $this->db->order_by('orderID', 'asc');
        $this->db->where('orderID >', $orderID);
        $query = $this->db->get('fahrzeug');
        
        foreach($query->result() as $row) {
            $this->db->where('orderID', $row->orderID);
            $this->db->update('fahrzeug', array('orderID' => $row->orderID -1));
        }
        
    }
}

/* End of file fahrzeug_model.php */
/* Location: ./application/models/fahrzeug/fahrzeug_model.php */