<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Maintenance Model
 *
 * Model für den Wartungscontroller.
 *
 * @package		com.cp.feuerwehr.models.maintenance
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 */	
 
class Maintenance_Model extends CI_Model {
	
	private $arr_lang = array();
	
	/**
	 * Konstruktor
	 *
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
	}
	
	public function get_languages()
	{
		$query = $this->db->get_where('sys_lang', array('lang' => 'de'));
		
		if ($query->num_rows() > 0) 
		{			
			$i = 0;
			foreach($query->result() as $l)
			{
				$this->arr_lang[$i]['key'] = $l->key;
				$this->arr_lang[$i]['text'] = $l->text;		
				$i++;
			}
			return true;
		}
		else return false;
	}
	
	public function write_lang_tofile()
	{ 
		$this->load->helper('file'); 
		$content = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');";
		foreach($this->arr_lang as $lang)
		{
			$content .=	'$lang["'.$lang["key"].'"] = "'.$lang["text"].'";';
		}
		$content .= '?>'; 
		
		write_file(APPPATH.'cache/config/db_lang_DE.php', $content);
	}
	
	public function add_lang_entry($key, $text, $desc)
	{
		$data = array(
		   'key' => $key ,
		   'lang' => 'de' ,
		   'text' => $text ,
		   'desc' => $desc
		);
		
		$this->db->insert('sys_lang', $data); 
	}
}

/* End of file maintenance_model.php */
/* Location: ./application/models/maintenance/maintenance_model.php */