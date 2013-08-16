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
//    public function write_settings()
//    {
//        $this->module->write_setting_file();
//    }
//    
//	public function show_icons()
//	{
//		
//		$header['title'] 		= 'Icons';		
//	
//		$this->load->view('maintenance/show_icons');
//		
//	}
//	
//	public function show_buttons()
//	{
//		$header['title'] 		= 'Buttons';		
//	
//		$this->load->view('backend/templates/admin/header', $header);
//		$this->load->view('backend/maintenance/show_icons');
//		$this->load->view('backend/templates/admin/footer');
//	}
//
//    
//	
//	public function get_einsatz_bilder()
//	{
//		$this->load->library('image_lib');
//		$this->load->helper('string');
//		$this->load->helper('file');
//		
//		
//		$this->db->where('processed !=', 'X');
//		$this->db->limit(60);
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
//			   'img_file' => $filename,
//			   'thumb_file' => $filenamekl,
//			   'fileType' => 'jpg'
//			);
//			$this->db->insert('einsatz_img', $image);
//			$this->db->where('id', $row->id);
//			$this->db->update('OLD_einsatz_img', array('processed' => 'X'));
//		}
//	}
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
//	public function db_fahrzeug()
//	{
//		$this->db->where('fahrzeuge !=', 'null'); 
//		$query = $this->db->get('OLD_einsatz');
//		foreach ($query->result() as $row)
//		{
//		   	$arr_f = explode(',', $row->fahrzeuge);
//			foreach($arr_f as $f)
//			{
//				$this->db->insert('einsatz_fahrzeug_mapping', array('einsatzID' => $row->newID, 'fahrzeugID' => $f));	
//
//			}
//		}
//	}
//    
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