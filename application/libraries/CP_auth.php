<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CP Auth
 *
 * Library mit Authentifizierungsfunktionen.
 * kapselt die Flexi_auth library
 *
 * @package		com.cp.feuerwehr.libraries.auth
 * @subpackage	Library
 * @category	Library
 * @author		Habib Pleines
 */	

// Load the flexi auth library to allow it to be extended.
load_class('Flexi_auth', 'libraries', FALSE);

class CP_auth extends Flexi_auth
{
    private $area;
    
    public function __construct()
    {
        parent::__construct();  
    }
    
    public function set_area($area)
    {
        $this->area = $area;
    }
    
    public function is_logged_in_admin()
    {
        if(!$this->is_logged_in())
            return false;
        if(!$this->is_admin())
            return false;
        return true;
    }
    
    public function cp_get_user_by_id($userID = NULL)
    {
        // returns an object user
        $userdata = $this->get_user_by_id_query($userID)->result();
        if(isset($userdata[0]))
            return $userdata[0];
        else return null;
    }
    
    public function cp_get_user_by_identity($identity)
    {
        $userdata = $this->get_user_by_identity_query($identity)->result();
        if(isset($userdata[0]))
            return $userdata[0];
        else return null;
    }
    
    public function cp_get_group_names()
    {
        $groups = $this->get_groups_query()->result();
        foreach($groups as $g)
        {
            $groups_ret[$g->ugrp_id] = $g;
        }
        return $groups_ret;
    }
}

/* End of file CP_auth.php */
/* Location: ./application/libraries/CP_auth.php */