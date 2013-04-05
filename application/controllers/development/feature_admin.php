<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'/third_party/jpgraph/jpgraph.php');
require_once(APPPATH.'/third_party/jpgraph/jpgraph_bar.php');

/**
 * Feature Lab Controller
 *
 * Controller für den Test neuer Features
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.featurelab
 **/

class Feature_Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('einsatz/einsatz_model', 'einsatz');
		$this->load->model('fahrzeug/fahrzeug_model', 'fahrzeug');
		$this->load->model('module/module_model', 'module');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('admin/admin_model', 'admin');
		
		// CP Auth Konfiguration
		$this->cpauth->init('BACKEND');
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
		$this->session->set_flashdata('redirect', current_url()); 
	}
	
	public function lab()
	{
		$header['title'] 		= 'Reporting';	
		$menue['menue']		= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue(); 
		$data['userdata'] 	= $this->cp_auth->cp_get_userdata($this->session->userdata(CPAUTH_SESSION_BACKEND));
		
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/menue', $menue);
		$this->load->view('backend/templates/admin/submenue', $menue);
		$this->einsatz_graph();				
		$this->load->view('templates/admin/footer');
	}
	
	private function einsatz_graph()
	{
		$einsatzlist = $this->einsatz->get_einsatz_list('all');
		$types = $this->einsatz->get_einsatz_type_list();
		
		foreach($types as $t)
		{
			$einsatzarten_liste_temp[$t['typeID']] = 0;
			$einsatzarten_namen_temp[$t['typeID']] = $t['typeShortname'];
		}
		
		$query = $this->db->get('einsatz_type_mapping');
		
		foreach($query->result() as $row)
		{
			$einsatzarten_liste_temp[$row->typeID]++;
		}
		$i = 0;
		foreach($einsatzarten_liste_temp as $item)
		{
			$einsatzarten_liste[$i] = $item;
			$i++;	
		}
		$i = 0;
		foreach($einsatzarten_namen_temp as $item)
		{
			$einsatzarten_namen[$i] = $item;
			$i++;	
		}
		
		// Create the graph. These two calls are always required
		$graph = new Graph(600,400);
		$graph->SetScale('intlin');
		 
		// Add a drop shadow
		$graph->SetShadow();
		 
		// Adjust the margin a bit to make more room for titles
		$graph->SetMargin(40,30,20,40);
		 
		// Create a bar pot
		$bplot = new BarPlot($einsatzarten_liste);
		 
		// Adjust fill color
		$bplot->SetFillColor('orange');
		$graph->Add($bplot);
		 
		// Setup the titles
		$graph->title->Set('Einsatzverteilung -> Einsatzart (&uumlber alle Jahre)');
		$graph->xaxis->title->Set('Einsatzart');
		$graph->xaxis->SetTickLabels($einsatzarten_namen);
		$graph->yaxis->title->Set('Anzahl');
		 
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
		 
		// Display the graph
		$graph->Stroke();
	}	
}
?>