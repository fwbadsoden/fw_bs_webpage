<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CP_Controller
 * Custom Controller Enhancement
 * 
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.system.controller
 */
Class CP_Controller extends CI_Controller
{
	/**
	 * CP_Controller::__construct()
     * Konstruktor erweitert um globale $auth Variable für die Flexi Auth Library
	 * 
	 * @return
	 */
	public function __construct()
	{ 
        $this->auth = new stdClass;
		parent::__construct();
	}
}
?>