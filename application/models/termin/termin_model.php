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
        $this->db->where('datum >=', date('Y-m-d'));
        $query = $this->db->get('v_termin');
        $termine = array();
        $i = 0;
        
        foreach($query->result() as $row)
        {
            $termine[$i]['terminID'] = $row->terminID;
            $termine[$i]['name'] = $row->name;
            $termine[$i]['description'] = $row->description;
            $termine[$i]['datum'] = $row->datum;
            $termine[$i]['beginn'] = $row->beginn;
            $termine[$i]['ende'] = $row->ende;
            $termine[$i]['ort'] = $row->ort;
            $termine[$i]['ort_short'] = $row->ort_short;
            $termine[$i]['category_name'] = $row->category_name;
            $termine[$i]['super_category_name'] = $row->super_category_name;
            $termine[$i]['super_category_id'] = $row->super_category_id;
            $i++;
        }
        
        return $termine;
    }
    
    public function get_termin_v_list_all_by_month()
    {
        $this->db->where('datum >=', date('Y-m-d'));
        $query = $this->db->get('v_termin');
        
        $termine = array();
        $i = 0;
        $month = '';      
        
        foreach($query->result() as $row)
        {
            if($month == '') $month = cp_get_month_name((int)substr($row->datum, 5, 2));
            if($month != cp_get_month_name((int)substr($row->datum, 5, 2)))
            {
                $month = cp_get_month_name((int)substr($row->datum, 5, 2));
                $i = 0;
            }
            $termine[$month][$i]['terminID']            = $row->terminID;
            $termine[$month][$i]['name']                = $row->name;
            $termine[$month][$i]['description']         = $row->description;
            $termine[$month][$i]['datum']               = $row->datum;
            $termine[$month][$i]['jahr']                = substr($row->datum, 0, 4);
            $termine[$month][$i]['monat']               = $month;
            $termine[$month][$i]['monat_int']           = substr($row->datum, 5, 2);
            $termine[$month][$i]['tag']                 = cp_get_day_name($row->datum);
            $termine[$month][$i]['tag_int']             = substr($row->datum, 8, 2);
            $termine[$month][$i]['beginn']              = $row->beginn;
            $termine[$month][$i]['ende']                = $row->ende;
            $termine[$month][$i]['ort']                 = $row->ort;
            $termine[$month][$i]['ort_short']           = $row->ort_short;
            $termine[$month][$i]['category_name']       = $row->category_name;
            $termine[$month][$i]['super_category_name'] = $row->super_category_name;
            $termine[$month][$i]['super_category_id']   = $row->super_category_id;
            $i++;
        }
        
        return $termine;
    }
    
    public function get_termin_months_for_filter()
    {   
        $this->db->select('datum');
        $this->db->where('datum >=', date('Y-m-d'));
        $this->db->order_by('datum', 'ASC');
        $query = $this->db->get('termin');
        $i=0;
        $months = array();
        $month = '';
        
        foreach($query->result() as $row)
        {
            if($month == '') $month = cp_get_month_name(substr($row->datum,5,2));    
            if($month != cp_get_month_name(substr($row->datum,5,2)))
            {
                $i++;
                $month = cp_get_month_name(substr($row->datum,5,2));
            }
            $months[$i] = $month;
        }
        
        return $months;
    }

	
	public function delete_termin($id)
	{	
		$tables = array('termin');
		$this->db->where('terminId', $id);
		$this->db->delete($tables);
	}
	

	public function create_termin($name, $description, $datum, $beginn, $ende)
	{
		$termin = array(
			'categoryID' => 2,
			'name' => $name,
			'description' => $description,
			'datum' => $datum,
			'beginn' => $beginn,
			'ende' => $ende,
            'ort_short' => 'Feuerwehr Bad Soden',
			'ort' => 'Freiwillige Feuerwehr Bad Soden am Taunus<br />Hunsrückstr. 5-7<br />65812 Bad Soden am Taunus',
			'online' => 1
		);
		
		$this->db->insert('termin',  $termin);
	}

 }

/* End of file termin_model.php */
/* Location: ./application/models/termin/termin_model.php */