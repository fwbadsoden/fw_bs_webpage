<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Custom controller function
 *
 * Add functionality : global $auth for flexi_auth
 *
 */

Class CP_Controller extends CI_Controller
{
	public function __construct()
	{
        $this->auth = new stdClass;
		parent::__construct();
	}
}
?>