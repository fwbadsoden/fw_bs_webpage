<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Maintenance Controller
 *
 * Controller für Wartungs- und Entwicklungsfunktionalitäten 
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.maintenance
 **/

class Maintenance extends CP_Controller {
		
	public function __construct()
	{
		parent::__construct();
		$this->load->model('maintenance/maintenance_model', 'maintain');
		$this->load->model('module/module_model', 'module');
		$this->load->library('CP_auth');
		$this->load->model('admin/admin_model', 'admin');
        
        // Berechtigungsprüfung TEIL 1: eingelogged und Admin
	//	if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
	}

    public function optimize_db()
    {
        // Load the DB utility class
        $this->load->dbutil();
        $result = $this->dbutil->optimize_database();
    }

    public function recalc($year)
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

		
		foreach($arr_einsatz as $einsatz)
		{
			$this->db->where('einsatzID', $einsatz['einsatzID']);
			$this->db->update('einsatz', array('lfd_nr' => $lfdNr));
			$lfdNr++;	
		}
    }
//    
////    // Anlegen von Usern ohne die Adminoberfläche
////    public function create_user()
////    {
////        $user_data = array(
////        	'created_by' => '1'
////        );
////        $userID = $this->cp_auth->insert_user('habib.pleines@objective-partner.de', 'tarzan', 'q9mlb015', $user_data);
////        $this->cp_auth->activate_user($userID, FALSE, FALSE);
////    }
////	
//
//
//	
//	public function get_einsatz_bilder()
//	{
//		$this->load->library('image_lib');
//		$this->load->helper('string');
//		$this->load->helper('file');
//        
//		$query = $this->db->get('OLD_einsatz_img');
//      
//		foreach($query->result() as $row)
//		{
//			$contents = file_get_contents('http://www.feuerwehr-bs.de/data/einsaetze/'.$row->id.'gr.jpg');
//			setlocale(LC_TIME, 'de_DE');
//			$filename = $this->image_lib->generate_img_name('GR'.$row->id);
//			$savename = $filename.".jpg";
//			$savefile = fopen($savename, "w");
//			#fwrite($savefile, $contents);
//			#fclose($savefile);
//			
//			write_file('images/content/einsatz/'.$savename, $contents);
//			$savename = ""; $savefile = ""; $contents = ""; 
//			
//			$contentskl = file_get_contents('http://www.feuerwehr-bs.de/data/einsaetze/'.$row->id.'.jpg');
//			setlocale(LC_TIME, 'de_DE');
//			$filenamekl = $this->image_lib->generate_img_name('KL'.$row->id);
//			$savenamekl =$filenamekl.".jpg";
//			$savefilekl = fopen($savenamekl, "w");
//			write_file('images/content/einsatz/'.$savenamekl, $contentskl);
//			$savenamekl = ""; $savefilekl = ""; $contentskl = ""; 
//			$image = array(
//			   'einsatzID' => $row->newid ,
//			   'description' => $row->pic ,
//			   'img_file' => $filename.".jpg",
//			   'thumb_file' => $filenamekl.".jpg",
//			   'fileType' => 'jpg'
//			);
//			$this->db->insert('einsatz_img', $image);
//		}
//	}
//    
//    public function correct_image_id()
//    {
//        $query = $this->db->get('OLD_einsaetze');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('einsatz', $row->id);
//            $this->db->update('OLD_einsatz_img', array('newid' => $row->newid));
//        }
//    }
//    
//    public function set_correct_date()
//    {
//        $where = 'zeit2 < zeit';
//        $this->db->where($where);
//        $query = $this->db->get('OLD_einsaetze');
//        echo $query->num_rows();
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsaetze', array( 'datum2' => date("Y-m-d", strtotime($row->datum) + (3600 * 24))));
//        }
//    }
//    
//    public function set_type_id()
//    {
//        $this->db->like('art', 'GG');
//        $query = $this->db->get('OLD_einsaetze');
//        
//        echo $query->num_rows();
//        foreach($query->result() as $row)
//        {
//                $this->db->where('id', $row->id);
//                $this->db->update('OLD_einsaetze', array('done' => 1, 'art' => 4));
//        }
//    }
//	
//	public function db_einsatz()
//	{
//	    $this->db->order_by('datum', 'ASC');
//        $this->db->order_by('zeit', 'ASC');
//		$query = $this->db->get('OLD_einsaetze');
//        $i = 1;
//		foreach ($query->result() as $row)
//		{
//		    $data = array(
//               'name' => $row->titel,
//               'datum_beginn' => $row->datum,
//               'datum_ende' => $row->datum2,
//               'uhrzeit_beginn' => $row->zeit,
//               'uhrzeit_ende' => $row->zeit2,              
//			   'lfd_nr' => $i ,
//			   'einsatz_nr' => $row->nr,
//			   'online'	=> 1
//			);
//			$this->db->insert('einsatz', $data);
//			$id = $this->db->insert_id();
//			
//			$this->db->where('id', $row->id);
//			$this->db->update('OLD_einsaetze', array('newid' => $id));
//			
//			$this->db->where('id', $row->id);
//			$this->db->update('OLD_einsatz_img', array('newid' => $id));
//            $i++;
//		}
//	}
//	
//	public function db_einsatzcontent()
//	{
//		$query = $this->db->get('OLD_einsaetze');
//		foreach ($query->result() as $row)
//		{	
//			$data = array(
//				'einsatzID' => $row->newid,
//                'typeID' => $row->art,
//				'lage' => $row->ausgang,
//				'bericht' => $row->bericht,
//                'ort' => $row->ort,
//				'weitere_kraefte' => $row->weitere,
//				'anzahl_kraefte' => $row->anzahl
//			);
//			$this->db->insert('einsatz_content', $data);
//		}
//	}
//    
//
//    public function db_map_fahrzeuge()
//    {
//		$this->db->where('fahrzeuge !=', ''); 
//		$query = $this->db->get('OLD_einsaetze');
//		foreach ($query->result() as $row)
//		{
//            $fahrzeuge = $row->fahrzeuge;
//		   	$arr_f = explode(',', $row->fahrzeuge);
//			foreach($arr_f as $f)
//			{
//			   $f = trim($f);
//                $this->db->insert('OLD_einsatz_fahrzeug',array('einsatzID' => $row->newid, 'fahrzeug' => $f));
//            }            
//        }
//    }
//    
//    public function db_correct_fahrzeug()
//   {
//        $this->db->where('fahrzeugID', 0);
//        $this->db->where('fahrzeug', 'ELW 1');
//        $query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsatz_fahrzeug', array('fahrzeugID' => 1));
//        }
//        $this->db->where('fahrzeugID', 0);
//        $this->db->where('fahrzeug', 'LF 16/2');
//        $query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsatz_fahrzeug', array('fahrzeugID' => 2));
//        }
//        $this->db->where('fahrzeugID', 0);
//        $this->db->where('fahrzeug', 'LF 16/1');
//        $query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsatz_fahrzeug', array('fahrzeugID' => 3));
//        }
//        $this->db->where('fahrzeugID', 0);
//        $this->db->where('fahrzeug', 'DLK 23/12');
//        $query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsatz_fahrzeug', array('fahrzeugID' => 4));
//        }
//        $this->db->where('fahrzeugID', 0);
//        $this->db->where('fahrzeug', 'MTF');
//        $query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsatz_fahrzeug', array('fahrzeugID' => 11));
//        }
//        $this->db->where('fahrzeugID', 0);
//        $this->db->where('fahrzeug', 'LF 16/3');
//        $query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsatz_fahrzeug', array('fahrzeugID' => 25));
//        }
//        $this->db->where('fahrzeugID', 0);
//        $this->db->where('fahrzeug', 'Pkw');
//        $query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsatz_fahrzeug', array('fahrzeugID' => 12));
//        }
//        $this->db->where('fahrzeugID', 0);
//        $this->db->where('fahrzeug', 'SBI-KdoW');
//        $query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsatz_fahrzeug', array('fahrzeugID' => 16));
//        }
//        $this->db->where('fahrzeugID', 0);
//        $this->db->where('fahrzeug', 'StBI-KdoW');
//        $query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsatz_fahrzeug', array('fahrzeugID' => 16));
//        }
//    }
////
//
//	public function db_fahrzeug()
//	{
//		$query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->insert('einsatz_fahrzeug_mapping', array('einsatzID' => $row->einsatzID, 'fahrzeugID' => $row->fahrzeugID));
//        }
//	}

}

?>