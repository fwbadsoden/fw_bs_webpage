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

class Maintenance extends CI_Controller {
		
	public function __construct()
	{
		parent::__construct();
		$this->load->model('maintenance/maintenance_model', 'maintain');
		$this->load->library('CP_auth');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('admin/admin_model', 'admin');
		
		// CP Auth Konfiguration für Admin Controller
		$this->cpauth->init('BACKEND');
	}
	
	public function show_icons()
	{
		
		$header['title'] 		= 'Icons';		
	
		$this->load->view('maintenance/show_icons');
		
	}
	
	public function show_buttons()
	{
		$header['title'] 		= 'Buttons';		
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/styles');
		$this->load->view('backend/admin/styles_admin');
		$this->load->view('backend/maintenance/show_icons');
		$this->load->view('backend/templates/admin/footer');
	}
	
	public function get_einsatz_bilder()
	{
		$this->load->library('CP_auth');
		$this->load->helper('string');
		$this->load->helper('file');
		
		
		$this->db->where('processed !=', 'X');
		$this->db->limit(40);
		$query = $this->db->get('OLD_einsatz_img');
		foreach($query->result() as $row)
		{
			$contents = file_get_contents('http://www.feuerwehr-bs.de/data/einsaetze/'.$row->id.'gr.jpg');
			setlocale(LC_TIME, 'de_DE');
			$filename = $this->cp_auth->cp_generate_hash('GR'.$row->id.$this->cp_auth->cp_generate_salt());
			$savename = $filename.".jpg";
			$savefile = fopen($savename, "w");
			#fwrite($savefile, $contents);
			#fclose($savefile);
			
			write_file('images/content/einsaetze/'.$savename, $contents);
			$savename = ""; $savefile = ""; $contents = ""; 
			
			$contentskl = file_get_contents('http://www.feuerwehr-bs.de/data/einsaetze/'.$row->id.'.jpg');
			setlocale(LC_TIME, 'de_DE');
			$filenamekl = $this->cp_auth->cp_generate_hash('KL'.$row->id.$this->cp_auth->cp_generate_salt());
			$savenamekl =$filenamekl.".jpg";
			$savefilekl = fopen($savenamekl, "w");
			write_file('images/content/einsaetze/'.$savenamekl, $contentskl);
			$savenamekl = ""; $savefilekl = ""; $contentskl = ""; 
			$image = array(
			   'einsatzID' => $row->newID ,
			   'imgDesc' => $row->pic ,
			   'imgFile' => $filename,
			   'imgFileThumbnail' => $filenamekl,
			   'fileType' => 'jpg'
			);
			$this->db->insert('einsatz_img', $image);
			$this->db->where('id', $row->id);
			$this->db->update('OLD_einsatz_img', array('processed' => 'X'));
		}
	}
	
	public function db_einsatz()
	{
		$query = $this->db->get('OLD_einsatz');
		foreach ($query->result() as $row)
		{
		    $data = array(
			   'lfdNr' => $row->nr ,
			   'datum' => $row->datum ,
			   'beginn' => $row->zeit ,
			   'ende' => $row->zeit2 ,
			   'einsatzName' => $row->titel ,
			   'online'	=> 1
			);
			$this->db->insert('einsatz', $data);
			$id = $this->db->insert_id();
			
			$this->db->where('id', $row->id);
			$this->db->update('OLD_einsatz', array('newID' => $id));
		}
	}
	
	public function db_einsatzcontent()
	{
		$query = $this->db->get('OLD_einsatz');
		foreach ($query->result() as $row)
		{	
			$data = array(
				'einsatzID' => $row->newID,
				'einsatzlage' => $row->ausgang,
				'einsatzgeschehen' => $row->bericht,
				'einsatzkraefteFreitext' => $row->weitere,
				'anzahlEinsatzkraefte' => $row->anzahl
			);
			$this->db->insert('einsatz_content', $data);
		}
	}
	
	public function db_einsatztype()
	{
		$query = $this->db->get('OLD_einsatz');
		foreach ($query->result() as $row)
		{
			$arr_art = explode(',', $row->art);
			foreach($arr_art as $art) 
			{
				$this->db->insert('einsatz_type_mapping', array('einsatzID' => $row->newID, 'typeID' => $art));
			}
		}
	}
	
	public function db_fahrzeug()
	{
		$this->db->where('fahrzeuge !=', 'null'); 
		$query = $this->db->get('OLD_einsatz');
		foreach ($query->result() as $row)
		{
		   	$arr_f = explode(',', $row->fahrzeuge);
			foreach($arr_f as $f)
			{
				$this->db->insert('einsatz_fahrzeug_mapping', array('einsatzID' => $row->newID, 'fahrzeugID' => $f));	

			}
		}
	}
}

?>