<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CP Auth
 *
 * Library mit Bildveränderungs- und bearbeitungsfunktionen.
 *
 * @package		com.cp.feuerwehr.libraries.image_lib
 * @subpackage	Library
 * @category	Library
 * @author		Habib Pleines
 */	
 
 define('NAME_PRE1', 'MGVmZDI4YgE1mYI');
 define('NAME_PRE2', 'MGkmZDI8YgE1mYI');

Class CP_Image_lib extends CI_Image_lib
{
	public function __construct()
	{
		parent::__construct();
	}
    
    public function generate_img_name($var1 = NAME_PRE1)
    {
        return substr(base64_encode(bin2hex(mhash(MHASH_SHA512,uniqid(rand(), true).$var1.microtime()))), 0, 200);
    }
}

/* End of file CP_Image_lib.php */
/* Location: ./application/libraries/CP_Image_lib.php */