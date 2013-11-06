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
    private $api_key, $lat_lng_1, $lat_lng_2, $zoom;
    private $_config;
    
	/**
	 * Maps::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();        
        $this->api_key   = 'AIzaSyCIdNCnXP0RCrhpGxjGuS_qZEnz7QCLns4';
        $this->lat_lng_1 = '50.143521';
        $this->lat_lng_2 = '8.502216';
        $this->zoom      = '14';
        
        $this->set_config();
	}
    
    private function set_config()
    {
        $this->_config = array();
        $this->_config['api_key']            = $this->api_key;
        $this->_config['lat_lng_1']          = $this->lat_lng_1;
        $this->_config['lat_lng_2']          = $this->lat_lng_2;
        $this->_config['zoom']               = $this->zoom;
        $this->_config['visual_refresh']     = 'true';
        $this->_config['sensor']             = 'false';   
    }
    
    public function test_map()
    {
        $maps = $this->_config;
        $this->load->view('frontend/maps/test', $maps);
    }
 }
/* End of file maps.php */
/* Location: ./application/controllers/maps/maps.php */