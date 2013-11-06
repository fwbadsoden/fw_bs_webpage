<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Presse_model
 * 
 * @package com.cp.feuerwehr.models.presse
 * @author Habib Pleines
 * @copyright 2013
 * @access public
 */
class Presse_model extends CI_Model {
	
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
    
    public function get_articles($limit = null, $offset = null)
    {
        if(is_numeric($limit) && is_numeric($offset)) 
            $this->db->limit($limit, $offset);
        $query = $this->db->get('v_press_article');
        $articles = array();
        $i=0;
        foreach($query->result() as $row)
        {
            $articles[$i]['articleID']  = $row->articleID;
            $articles[$i]['name']       = $row->name;
            $articles[$i]['source']     = $row->source;
            $articles[$i]['datum']      = $row->datum;
            $articles[$i]['link']       = $row->link;
            $articles[$i]['fileID']     = $row->fileID;
            $articles[$i]['fullpath']  = $row->fullpath;
            $articles[$i]['size']       = $row->size;
            $articles[$i]['extension']  = $row->extension;
            $i++;
        }
        return $articles;
    }
}

/* End of file presse_model.php */
/* Location: ./application/models/presse/presse_model.php */