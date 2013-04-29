<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Custom form validation function v 0.1
 *
 * Add functionality : edit_unique (takes care of the currently edited database record)
 *
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
?>