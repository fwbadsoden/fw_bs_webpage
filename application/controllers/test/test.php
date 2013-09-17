<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Termin
 * Controller für die Anzeige der Einsätze
 * 
 * @package com.cp.feuerwehr.frontend.einsatz  
 * @author Patrick Ritter <pa_ritter@arcor.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Test extends CP_Controller {

	 public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo 'Hello World!';                   
            die;
    }

	public function foo()
    {
        echo 'Hello World2!';                   
            die;
     }


}
?>
