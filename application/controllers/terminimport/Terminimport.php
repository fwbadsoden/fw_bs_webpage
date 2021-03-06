<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * TerminImport
 * Controller als Schnittstelle für den Import der Termine aus dem Informationsportal
 * 
 * @package com.cp.feuerwehr.terminImport.TerminImport  
 * @author Patrick Ritter <pa_ritter@arcor.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Terminimport extends CP_Controller {

	 /**
	  * Terminimport::__construct()
	  * 
	  * @return
	  */
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('termin/termin_model', 'm_termin');  
    }

	/**
	 * Terminimport::fetch()
	*	Provides list of stored future appointments
	 * 
	 * @return
	 */
	public function fetch()
    {
		//Check if remote host is in IP4-Whitelist
		if(in_array($_SERVER['HTTP_HOST'], explode(";",TERMIN_IMPORT_WHITELIST))){
			echo "NOT AUTHENTICATED: ".$_SERVER['HTTP_HOST'];
			exit;
		}

		//Print for each future appointment id and md5-hash of relevant data
		$termine = $this->m_termin->get_termin_v_list(10000, 0);
        foreach($termine as $termin)
        {
			$md5 = md5($termin['name'] . $termin['description'] . $termin['datum']. $termin['beginn'] . $termin['ende']);
			echo $termin['terminID'].";".$md5."\n";
        }
		echo "FETCH_OK";
     }

	/**
	 * Terminimport::update()
	*	Insert additional and removes obsolete appointments
	 * 
	 * @return
	 */
	public function update()
    {
		//Check if remote host is in IP4-Whitelist
		if(in_array($_SERVER['HTTP_HOST'], explode(";",TERMIN_IMPORT_WHITELIST))){
			echo "NOT AUTHENTICATED: ".$_SERVER['HTTP_HOST'];
			exit;
		}

		if(isset($_GET['toDelete']) && isset($_GET['toInsert'])){

			//Delete obsolete appointments 
			if(strlen($_GET['toDelete'])>0){
		    	foreach(explode(";", $_GET['toDelete']) as $idToDelete)
		    	{
					$this->m_termin->delete_termin(intval($idToDelete));	
					echo "Deleted id ".$idToDelete." in db\n";
		    	}
			}

			//Insert additional appointments
			if(strlen($_GET['toInsert'])>0){
				foreach(explode("\n", $_GET['toInsert']) as $lineToInsert)
				{
					list($name,$description,$datum,$beginn,$ende,$md5) = explode(";",$lineToInsert);
					$this->m_termin->create_termin($name,$description,$datum,$beginn,$ende);
					echo "Inserted ".$lineToInsert." into db\n";
				}
			}

			echo "INSERT_OK";
		}
     }
}

/* End of file Terminimport.php */
/* Location: ./application/controllers/terminimport/Terminimport.php */