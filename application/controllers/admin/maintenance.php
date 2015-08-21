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
		
	/**
	 * Maintenance::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('maintenance/maintenance_model', 'maintain');
		$this->load->model('module/module_model', 'module');
		$this->load->library('CP_auth');
		$this->load->model('admin/admin_model', 'admin');
        $this->load->model('einsatz/einsatz_model', 'einsatz');        
	}

    /**
     * Maintenance::optimize_db()
     * CRON für DB Optimierung
     * 
     * @return
     */
    public function optimize_db()
    {
        // Load the DB utility class
        $this->load->dbutil();
        $result = $this->dbutil->optimize_database();
    }
    
    /**
     * Maintenance::minify()
     * erstellt die min Dateien von CSS und JS
     * 
     * @return
     */
    public function minify()
    {
        $this->load->driver('minify');
        
        $contents = $this->minify->css->min('css/frontend/styles.css');
        $this->minify->save_file($contents, 'css/frontend/styles.min.css');
        
        $contents = $this->minify->css->min('css/backend/admin.css');
        $this->minify->save_file($contents, 'css/backend/admin.min.css');
        
        $contents = $this->minify->css->min('css/backend/login.css');
        $this->minify->save_file($contents, 'css/backend/login.min.css');
        
        $contents = $this->minify->css->min('css/frontend/styles.css');
        $this->minify->save_file($contents, 'css/frontend/styles.min.css');
        
        $contents = $this->minify->css->min('css/frontend/styles.css');
        $this->minify->save_file($contents, 'css/frontend/styles.min.css');
    }
    
    public function recalc($year)
    {
        // Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');
        $this->einsatz->recalc_maintain($year);   
    }
    
    public function cache_liste()
    {
        // Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin()) redirect('admin', 'refresh');        
        if(!$this->cp_auth->is_privileged(CACHE_PRIV_DISPLAY)) redirect('admin/401', 'refresh');
        
        $this->load->helper('file');
        $files = get_dir_file_info($this->config->item('cache_path'));
		$this->session->set_userdata('cacheliste_redirect', current_url()); 
        
        $header['title']                = "Cache anzeigen";
		$menue['menue']	                = $this->admin->get_menue();
        $menue['userdata']              = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	            = $this->admin->get_submenue(); 
        $data['files']                  = $files;
        $data['privileged']['delete']   = $this->cp_auth->is_privileged(CACHE_PRIV_DELETE);
		
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
		$this->load->view('backend/maintenance/cache_liste', $data);
		$this->load->view('backend/templates/admin/footer');
    }
    
    public function delete_cache($file)
    {
        if($file == 'all')
        {
            delete_files($this->config->item('cache_path')); 
        }
        else
        {
            unlink($this->config->item('cache_path').$file);
            
        }
        redirect($this->session->userdata('cacheliste_redirect'), 'refresh');
    }
    
    public function phpinfo()
    {
        // Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin() or ENVIRONMENT != 'development') redirect('admin', 'refresh');
        phpinfo();   
    }
        
    public function show_buttons()
    {
        // Berechtigungsprüfung TEIL 1: eingelogged und Admin
		if(!$this->cp_auth->is_logged_in_admin() or ENVIRONMENT != 'development') redirect('admin', 'refresh');
        
        $header['title']                = 'Buttons';       
		$menue['menue']	                = $this->admin->get_menue();
        $menue['userdata']              = $this->cp_auth->cp_get_user_by_id();
		$menue['submenue']	            = $this->admin->get_submenue();          
    
        $this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
        $this->load->view('backend/maintenance/show_icons');
        $this->load->view('backend/templates/admin/footer');
    }
    
    public function migrate_vehicles() {
        
        $this->db->join('fahrzeug_content', 'fahrzeug.fahrzeugID = fahrzeug_content.fahrzeugID');
		$query = $this->db->get('fahrzeug');
       
        foreach($query->result() as $row) {
            
            $this->db->where(array('small_pic' => 1, 'fahrzeugID' => $row->fahrzeugID));
            $query_img = $this->db->get('fahrzeug_img');
            $row_img = $query_img->row();
            
            $f = array();
            $f["id"] = $row->fahrzeugID;
            $f['name'] = $row->name;
            $f["name_lang"] = $row->name_lang;
            $f["prefix_rufname"] = $row->prefix_rufname;
            $f["rufname"] =$row->rufname;
            $f["text_stage"] = $row->short_text;
            $f["text"] = $row->text;
          $f["besatzung"] = $row->besatzung;
          $f["hersteller"] = $row->hersteller;
          $f["aufbau"] = $row->aufbau;
          $f["pumpe"] = $row->pumpe;
          $f["loeschmittel"] = $row->loeschmittel;
          $f["besonderheit"] = $row->besonderheit;
          $f["baujahr"] = $row->baujahr;
          $f["kw"] = $row->kw;
          $f["ps"] = $row->ps;
          $f["laenge"] = str_replace(",",".",$row->laenge);
          $f["breite"] = str_replace(",",".",$row->breite);
          $f["hoehe"] = str_replace(",",".",$row->hoehe);
          $f["leermasse"] = str_replace(",",".",$row->leermasse);
          $f["gesamtmasse"] = str_replace(",",".",$row->gesamtmasse);
          if($row_img->img_file != null) {
            $f["setcard_image"] = $row_img->img_file;
          } else {
            $f["setcard_image"] = "";
          }
          $f["einsaetze_zeigen"] = $row->show_einsaetze;
          $f["precedence"] = $row->orderID;
          if($row->retired == 1) $f["retired"] = 'yes';
          else $f["retired"] = 'no';
          if($row->online == 1) $f["published"] = 'yes';
          else $f["published"] = 'no';
          
          $this->db->insert('fahrzeuge_fuel', $f);
          
          $this->db->where(array("fahrzeugID" => $row->fahrzeugID, 'small_pic' => 0));
          $query2 = $this->db->get("fahrzeug_img");
          
          foreach($query2->result() as $row2) {
            $i = array();
            $i["fahrzeug_id"] = $row->fahrzeugID;
            $i["description"] = $row2->description;
            $i["text"] = $row2->text;
            $i["image"] = $row2->img_file;
            $i["image_thumbnail"] = $row2->thumb_file;
            
            $this->db->insert("fahrzeug_images_fuel", $i);
            
            $r["candidate_table"] = "fw_fahrzeuge";
            $r["candidate_key"] = $row->fahrzeugID;
            $r["foreign_table"] = "fw_fahrzeug_images";
            $r["foreign_key"] = $this->db->insert_id();
            
            $this->db->insert("relationships_fuel", $r);
          }
        }
        
    }
    
    public function migrate_einsatz() {
        
        $this->db->join("einsatz_content", "einsatz.einsatzID = einsatz_content.einsatzID");
        $query = $this->db->get("einsatz");
        
        foreach($query->result() as $row) {
            
            $e = array();
            $e["id"] = $row->einsatzID;
            $e["type_id"] = $row->typeID;
            $e["cue_id"] = $row->cueID;
            $e["name"] = $row->name;
            $e["datum_beginn"] = $row->datum_beginn;
            $e["datum_ende"] = $row->datum_ende;
            $e["uhrzeit_beginn"] = $row->uhrzeit_beginn;
            $e["uhrzeit_ende"] = $row->uhrzeit_ende;
            $e["lfd_nr"] = $row->lfd_nr;
            $e["einsatz_nr"] = $row->einsatz_nr;
            $e["bericht"] = $row->bericht;
            $e["lage"] = $row->lage;
            $e["ort"] = $row->ort;
            $e["weitere_kraefte"] = $row->weitere_kraefte;
            $e["anzahl_kraefte"] = $row->anzahl_kraefte;
            $e["anzahl_einsaetze"] = $row->anzahl_einsaetze;
            if($row->ueberoertlich == 1) {
                $e["ueberoertlich"] = "yes";
            } else {
                $e["ueberoertlich"] = "no";
            }
            if($row->display_ort == 1) {
                $e["ort_zeigen"] = "yes";
            } else {
                $e["ort_zeigen"] = "no";
            }
            if($row->online ==  1) {
                $e["published"] = "yes";
            } else {
                $e["published"] = "no";
            }
            $this->db->insert("missions_fuel", $e);
        }
        
        $query = $this->db->get("einsatz_fahrzeug_mapping");
        foreach($query->result() as $row) {
            
            $r = array();
            
            $r["candidate_table"] = "fw_missions";
            $r["candidate_key"] = $row->einsatzID;
            $r["foreign_table"] = "fw_fahrzeuge";
            $r["foreign_key"] = $row->fahrzeugID;
            
            $this->db->insert("relationships_fuel", $r);
        }
    }
    
    public function migrate_news() {
        
        $this->db->join("news_content", "news.newsID = news_content.newsID");
        $query = $this->db->get("news");
        
        foreach($query->result() as $row) {
            
            $n = array();
            switch($row->categoryID) {
                case 1: $n["category_id"] = 13; break;
                case 2: $n["category_id"] = 14; break;
                case 3: $n["category_id"] = 15; break;
                case 4: $n["category_id"] = 16; break;
            }
            
            $n["title"] = $row->title;
            $n["id"] = $row->newsID;
            $n["stage_title"] = $row->stage_title;
            $n["valid_from"] = $row->valid_from;
            $n["valid_from_time"] = $row->valid_from_time;
            $n["valid_to"] = $row->valid_to;
            $n["valid_to_time"] = $row->valid_to_time;
            $n["last_modified"] = $row->modified;
            $n["last_modified_by"] = 1;
            if($row->online ==  1) {
                $n["published"] = "yes";
            } else {
                $n["published"] = "no";
            }
            $n["link"] = $row->link;
            $n["text"] = $row->text;
            $n["teaser"] = $row->teaser;
            
            $this->db->where("fileID", $row->teaser_image);
            $query2 = $this->db->get("file");
            $row2 = $query2->row();
            $n["teaser_image"] = $row2->filename;
            
            $this->db->where("fileID", $row->og_image);
            $query2 = $this->db->get("file");
            $row2 = $query2->row();
            $n["og_image"] = $row2->filename;
            
            $this->db->insert("news_fuel", $n);
        }
        
        $this->db->join("file", "news_images.fileID = file.fileID");
        $query = $this->db->get("news_images");
        
        foreach($query->result() as $row) {
            
            $ni = array();
            $ni["news_id"] = $row->newsID;
            $ni["image"] = $row->filename;
            
            $this->db->insert("news_images_fuel", $ni);
        }
    }
    
    public function migrate_presse() {
        
        $this->db->join("file", "file.fileID = press_article.fileID", 'left');
        $this->db->select("press_article.name as name, press_article.source as source, press_article.datum as datum, press_article.online as online, press_article.link as link, file.filename as filename");
        $query = $this->db->get("press_article");
        
        foreach($query->result() as $row) {
            
            $a = array();
            $a["name"] = $row->name;
            $a["category_id"] = 17;
            switch($row->source) {
                case "Bad Sodener Zeitung": $a["source_id"] = 2; break;
                case "Frankfurter Neue Presse": $a["source_id"] = 1; break;
                case "Rhein-Main Extratipp": $a["source_id"] = 5; break;
                case "Sulzbacher Anzeiger":  $a["source_id"] = 6; break;
                case "Hessenschau": $a["source_id"] = 4; break;
            }
            $a["datum"] = $row->datum;
            $a["online_article"] = $row->link;
            if($row->online == 1) $a["published"] = "yes";
            else $a["published"] = "no";
            if($row->filename != NULL)
                $a["asset"] = $row->filename;
            
            $this->db->insert("pressarticles", $a);
        }
    }
}

/* End of file maintenance.php */
/* Location: ./application/controllers/admin/maintenance.php */