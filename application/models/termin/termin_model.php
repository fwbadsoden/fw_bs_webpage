<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Termin_model
 * 
 * @package com.cp.feuerwehr.models.termin
 * @author Habib Pleines
 * @copyright 2013
 * @access public
 */
class Termin_model extends CI_Model {
	
	private $color = '';
	
	/**
	 * Konstruktor
	 *
	 *
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->helper('html');
	}
    
    public function get_termin_v_list($limit = 10, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        $query = $this->db->get('v_termin');
        $termine = array();
        $i = 0;
        
        foreach($query->result() as $row)
        {
            $termine[$i]['terminID'] = $row->terminID;
            $termine[$i]['name'] = $row->name;
            $termine[$i]['datum'] = $row->datum;
            $termine[$i]['beginn'] = $row->beginn;
            $termine[$i]['dauer'] = $row->dauer;
            $termine[$i]['ort'] = $row->ort;
            $termine[$i]['category_name'] = $row->category_name;
            $termine[$i]['super_category_name'] = $row->super_category_name;
            $termine[$i]['super_category_id'] = $row->super_category_id;
            $i++;
        }
        
        return $termine;
    }
 }
 ?>