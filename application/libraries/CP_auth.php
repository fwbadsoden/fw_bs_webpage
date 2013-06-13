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
    public function __construct()
    {
        $this->auth = new stdClass;
        parent::__construct();  
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

        return $userdata[0];
    }
}
?>