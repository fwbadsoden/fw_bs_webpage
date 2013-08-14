<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Module Model
 *
 * Mittels des Module Model werden die datenbankabhängigen Funktionen des Module Moduls gesteuert.
 *
 * @package		com.cp.feuerwehr.models.module
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 **/

class Module_model extends CI_Model {
	
	private $color = '';
	private $txt_length = 60;
	
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
	
	public function get_modules()
	{
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('module');	
		$modules = array();
		
		foreach($query->result() as $row)
		{
			$modules[$row->moduleID]['moduleID'] 	   =	$row->moduleID;
			$modules[$row->moduleID]['moduleName']	   =	$row->name;
		}
		return $modules;
	}
	
	public function get_settings()
	{
        $this->db->select('sys_constants.constantID as constantID, sys_constants.moduleID as moduleID, module.name as moduleName, sys_constants.name as name, sys_constants.value as value');
		$this->db->order_by('module.name', 'asc');		
		$this->db->order_by('sys_constants.name', 'asc');
        $this->db->join('module', 'module.moduleID = sys_constants.moduleID');
		$query = $this->db->get('sys_constants');
		$i = 0;
		$settings = array();
		
		foreach($query->result() as $row)
		{
			$settings[$i]['constantID']			= $row->constantID;
			$settings[$i]['moduleName']			= $row->moduleName;
			$settings[$i]['constantName']       = $row->name;
			$settings[$i]['constantValue']      = $row->value;
			$settings[$i]['row_color']          = $this->color = cp_get_color($this->color);
			$i++;
		}
		
		return $settings;
	}
	
	public function save_settings()
	{ 
		$update_batch = array();
		
		for($i = 0; $i <= $this->input->post('counter'); $i++)
		{
            $this->db->update('sys_constants', array('value' => $this->input->post($i.'_value')), array('constantID' => $this->input->post($i.'_constantID')));
		}	
	}
	
	public function write_setting_file()
	{
		$this->load->helper('file'); 
		
		$settings = $this->get_settings();
		
		$content = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  ";
		foreach($settings as $setting)
		{
			$content .=	'define("'.strtoupper($setting['constantName']).'", "'.$setting['constantValue'].'"); ';
		}
		$content .= '?>'; 
		
		write_file(APPPATH.'cache/db_constants.php', $content);	
	}	
	
    public function write_language_file()
    {
        $this->load->helper('file');
        
        $languages = $this->get_languages();
		
		$content = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  ";
		foreach($languages as $language)
		{
			$content .=	'$lang["'.$language["key"].'"] = "'.$language["text"].'";';
		}
		$content .= '?>'; 
		
		write_file(APPPATH.'cache/db_lang_DE.php', $content);	
    }
    
	public function get_languages()
	{
        $this->db->select('module.name as moduleName, sys_lang.langID, sys_lang.key, sys_lang.text, sys_lang.desc');
		$this->db->order_by('module.name', 'asc');		
		$this->db->order_by('sys_lang.key', 'asc');
        $this->db->join('module', 'module.moduleID = sys_lang.moduleID');
		$query = $this->db->get_where('sys_lang', array('lang' => 'de'));	
		$langs = array();
		$i = 0;
		
		foreach($query->result() as $row)
		{			
			$langs[$i]['langID']			= $row->langID;
			$langs[$i]['key'] 				= $row->key;
            $langs[$i]['moduleName']        = $row->moduleName;
			$langs[$i]['text'] 				= $row->text;
			$langs[$i]['desc'] 				= $row->desc;
			$langs[$i]['row_color']		    = $this->color = cp_get_color($this->color);
			$i++;
		}		
		return $langs;
	}	
	
	public function create_route()
	{
		if($this->input->post('protectedFlag')) $protectedFlag = 1; else $protectedFlag = 0;
		$route = array(
			'moduleID'		=> $this->input->post('modul'),
            'bereich'       => $this->input->post('bereich'),
			'internal_link'	=> $this->input->post('link'),
			'route'		    => $this->input->post('route'),
			'active'		=> 1
		);
		
		$this->db->insert('sys_routes', $route);
	}
	
	public function update_route($id)
	{ 
		if($this->input->post('protectedFlag')) $protectedFlag = 1; else $protectedFlag = 0;
		$route = array(
			'moduleID'       => $this->input->post('modul'),
            'bereich'        => $this->input->post('bereich'), 
			'internal_link'	 => $this->input->post('link'),
			'route'				  => $this->input->post('route')
		);
		$this->db->where('routeID', $id);
		$this->db->update('sys_routes', $route);
	}
	
	public function delete_route($id)
	{
		$this->db->where('routeID', $id);
		$this->db->delete('sys_routes');
	}
	
	public function get_routes($restrict = 'none')
	{
		if($restrict == 'active')	$this->db->where('sys_routes.active', 1);
        $this->db->order_by('bereich', 'asc');
		$this->db->order_by('name', 'asc');
		$this->db->order_by('route', 'asc');
        $this->db->join('module', 'module.moduleID = sys_routes.moduleID');
		$query = $this->db->get('sys_routes');
		$routes = array();
		$i = 0;
		
		foreach($query->result() as $row)
		{
			$routes[$i]['routeID']			= $row->routeID;
			$routes[$i]['moduleName']		= $row->name;
            $routes[$i]['bereich']          = $row->bereich;
			$routes[$i]['internalLink'] 	= $row->internal_link;
			$routes[$i]['route'] 			= $row->route;
			$routes[$i]['active'] 			= $row->active;
			$routes[$i]['row_color']		= $this->color = cp_get_color($this->color);
			$i++;
		}
		return $routes;
	}
	
	public function get_route($id)
	{
		$this->db->where('routeID', $id);
		$query = $this->db->get('sys_routes');
		$row = $query->row();
		
		$route['routeID'] = $id;
		$route['route']	    = $row->route;
        $route['bereich']   = $row->bereich;
		$route['internalLink']        = $row->internal_link;
		$route['moduleID'] = $row->moduleID;
		
		return $route;
	}
	
	public function write_route_file()
	{
		$this->load->helper('file'); 
		
		$routes = $this->get_routes('active');
		
		$content = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');";
		foreach($routes as $route)
		{
			$content .=	'$route["'.$route["route"].'"] = "'.$route["internalLink"].'";';
		}
		$content .= '?>'; 
		
		write_file(APPPATH.'cache/db_routes.php', $content);	
	}	
	
}
?>