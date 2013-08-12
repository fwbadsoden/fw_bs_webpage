<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Frontend
 * zentraler Controller für den Frontendbereich
 * 
 * @package com.cp.feuerwehr.frontend.frontend  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Frontend extends CP_Controller {
    
	/**
	 * Frontend::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
        $this->load->model('pages/pages_model', 'm_pages');      
	}
    
    /**
     * Frontend::loader()
     * Loader
     * 
     * @return void
     */
    public function loader()
    {
        $uri_segments = $this->uri->rsegment_array();
        // $uri_segments[0] fehlt, da des erste Segment der Ordner des Controller ist
        
        $controller = $uri_segments[3];
        $function   = $uri_segments[4];
            
        if(count($uri_segments) > 4) {
            $j = 0;
            $args = array();
            for($i = 5; $i <= (count($uri_segments)); $i++) {
                $args[$j] = $uri_segments[$i];
                $j++;
            }
        } 
        
        if($controller == $this->router->class) {
            // dynamisch Funktionen des Frontend Controllers laden
            $this->$function($args);
        }
        else {
            if($controller == 'page') {
                // dynamisch Inhaltseiten laden  
		        $this->load->helper('load_controller');
          //      $this->load->controller('pages/pages', 'c_pages');
                $c_pages = load_controller('pages/pages');
                $c_pages->{$function}($args[0]);
            }
            else {
                // dynamisch Modulseiten laden
            }
        }
    }
 }
 ?>