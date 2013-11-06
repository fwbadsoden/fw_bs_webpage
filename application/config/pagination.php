<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$config['uri_segment'] = 4;
	$config['num_links'] = 2;
	$config['use_page_numbers'] = FALSE;
	$config['page_query_string'] = FALSE;
	$config['per_page'] = 20; 

	$config['full_tag_open'] = '<div id="pagination-flickr">';
	$config['full_tag_close'] = '</div>';
	$config['first_link'] = 'Anfang';
	$config['first_tag_open'] = '<div>';
	$config['first_tag_close'] = '</div>';
	$config['last_link'] = 'Ende';
	$config['last_tag_open'] = '<div>';
	$config['last_tag_close'] = '</div>';
	$config['next_link'] = '&gt;';
	$config['next_tag_open'] = '<div>';
	$config['next_tag_close'] = '</div>';
	$config['prev_link'] = '&lt;';
	$config['prev_tag_open'] = '<div>';
	$config['prev_tag_close'] = '</div>';
	$config['cur_tag_open'] = '<b class="active">';
	$config['cur_tag_close'] = '</b>';
	$config['num_tag_open'] = '<div>';
	$config['num_tag_close'] = '</div>';
/* End of file pagination.php */
/* Location: ./application/config/pagination.php */