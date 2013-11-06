<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once('third_party/vendor/autoload.php');

class Searchengine extends CP_Controller 
{
    private $search_index, $client;
    
	/**
	 * Searchengine::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
        
        $url = str_replace('http://', '', base_url());
        $params = array();
        $params['hosts'] = array ( $url );
        $this->client = new ElasticSearch\Client($params);
        
	}   
    
    
}
/* End of file searchengine.php */
/* Location: ./application/controllers/searchengine/searchengine.php */