<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Maps
 * Controller für die Google Maps API
 * 
 * @package com.cp.feuerwehr.frontend.maps  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Maps extends CP_Controller {
    
	/**
	 * Maps::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();        
        define('API_KEY', 'AIzaSyCIdNCnXP0RCrhpGxjGuS_qZEnz7QCLns4');
	}
    
    public function test_map()
    {
        $config['maps'] = array(
            'visual_refresh'    => 'true',
        );
        $this->load->view('frontend/maps/test', $config);
    }
 }
 
 ?>