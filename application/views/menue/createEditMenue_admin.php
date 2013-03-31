<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 	=> 'menue'
	);
	
	if(!$value = set_value('menuename')) $value = $menue['menueName'];
	$menueName = array(
		'name'		=> 'menuename',
		'id'		=> 'menuename',
		'class' 	=> 'input_text',
		'value'		=> $value
	);
	
	if(!$value = set_value('menuelink')) $value = $menue['menueLink'];
	$menueLink = array(
		'name'		=> 'menuelink',
		'id'		=> 'menuelink',
		'class'		=> 'input_text',
		'value'		=> $value
	);
?>