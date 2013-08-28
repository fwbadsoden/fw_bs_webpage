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
    
//    // Anlegen von Usern ohne die Adminoberfläche
//    public function create_user()
//    {
//        $user_data = array(
//        	'created_by' => '1'
//        );
//        $userID = $this->cp_auth->insert_user('habib.pleines@objective-partner.de', 'tarzan', 'q9mlb015', $user_data);
//        $this->cp_auth->activate_user($userID, FALSE, FALSE);
//    }
//	
//
//    public function set_einsatz_ort()
//    {
//        $query = $this->db->get('OLD_einsaetze');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('einsatzID', $row->newid);
//            $this->db->update('einsatz_content', array('ort' => $row->ort));
//        }
//    }
////    
////	
//	public function get_einsatz_bilder()
//	{
//		$this->load->library('image_lib');
//		$this->load->helper('string');
//		$this->load->helper('file');
//		//$this->db->where('id', 209);
//		$this->db->where('processed !=', 'X');
//		$this->db->limit(200);
//        
//		$query = $this->db->get('OLD_einsatz_img');
//        echo $query->num_rows();
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
//        //    echo $filename.'<br>'.$filenamekl;
//			$this->db->insert('einsatz_img', $image);
//			$this->db->where('id', $row->id);
//			$this->db->update('OLD_einsatz_img', array('processed' => 'X'));
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
//        $this->db->limit(100,0);
//        $where = 'zeit2 < zeit';
//        $this->db->where($where);
//        $this->db->where('done', '');
//        $query = $this->db->get('OLD_einsaetze');
//        echo $query->num_rows();
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsaetze', array('done' => 1, 'datum2' => date("Y-m-d", strtotime($row->datum) + (3600 * 24))));
//        }
//    }
//    
//    public function set_type_id()
//    {
//        $this->db->limit(100,0);
//        $this->db->where('done', '0');
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
//				'weitere_kraefte' => $row->weitere,
//				'anzahl_kraefte' => $row->anzahl
//			);
//			$this->db->insert('einsatz_content', $data);
//		}
//	}
//    
//    public function set_ort()
//    {
//        $this->db->where('done', '0');
//        $this->db->where('ort', '');
//        $query = $this->db->get('OLD_einsaetze');
//            echo $query->num_rows();
//        foreach($query->result() as $row)
//        {
//                $this->db->where('id', $row->id);
//                $this->db->update('OLD_einsaetze', array('done' => 1, 'ort' => 'Bad Soden am Taunus'));
//        }
//    }
//	
//
//    public function db_map_fahrzeuge()
//    {
////        $this->db->where('done', 0);
////		$this->db->where('fahrzeuge !=', 'null'); 
////		$query = $this->db->get('OLD_einsaetze');
////        echo $query->num_rows();
////        echo $this->db->last_query();
////		foreach ($query->result() as $row)
////		{
////            $fahrzeuge = $row->fahrzeuge;
////		   	$arr_f = explode(',', $row->fahrzeuge);
////			foreach($arr_f as $f)
////			{
////			   $f = trim($f);
////                $this->db->insert('OLD_einsatz_fahrzeug',array('einsatzID' => $row->newid, 'fahrzeug' => $f));
////            }            
////        }
//        $this->db->where('fahrzeugID', 0);
//    //    $this->db->where('id <', 5291);
//        $this->db->like('fahrzeug', 'LF');
//        $query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->where('id', $row->id);
//            $this->db->update('OLD_einsatz_fahrzeug', array('fahrzeugID' => 14));
//        }
//    }
//
//
//	public function db_fahrzeug()
//	{
//		$query = $this->db->get('OLD_einsatz_fahrzeug');
//        foreach($query->result() as $row)
//        {
//            $this->db->insert('einsatz_fahrzeug_mapping', array('einsatzID' => $row->einsatzID, 'fahrzeugID' => $row->fahrzeugID));
//        }
//	}
////    
//    public function db_switch_types()
//    {
//        $query = $this->db->get('einsatz_content');
//        foreach($query->result() as $row)
//        {
//            $this->db->limit(1);
//            $query2 = $this->db->get_where('einsatz_type_mapping', array('einsatzID' => $row->einsatzID));
//            $row2 = $query2->row();
//            
//            $this->db->where('einsatzID', $row->einsatzID);
//            $this->db->update('einsatz_content', array('typeID' => $row2->typeID));
//        }
//    }
}

?>