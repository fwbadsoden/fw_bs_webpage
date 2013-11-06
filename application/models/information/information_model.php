<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Information Model
 *
 * Mittels des Information Model werden die datenbankabhängigen Funktionen des Information Moduls gesteuert.
 *
 * @package		com.cp.feuerwehr.models.information
 * @subpackage	Model
 * @category	Model
 * @author		Habib Pleines
 **/

class Information_model extends CI_Model {
    
    private $color = '';
	
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
    
    public function get_email_list()
    {
        $this->db->order_by('purpose', 'ASC');
        $this->db->order_by('email', 'ASC');
        $query = $this->db->get('info_email');
        $emails = array();
        $i = 0;
        
        foreach($query->result() as $row)
        {
            $emails[$i]['id']           = $row->emailID;
            $emails[$i]['email']        = $row->email;
            $emails[$i]['forwarded']    = str_replace(',', '<br>', $row->forwarded_mails);
            $emails[$i]['purpose']      = $row->purpose;
            $emails[$i]['type']         = $row->type;
            if($row->size == '' || $row->size == 0) 
                $emails[$i]['size']     = '-';
            else
                $emails[$i]['size']     = $row->size.' MB';
			$emails[$i]['row_color']	= $this->color = cp_get_color($this->color);
            
            $i++;
        }
        
        return $emails;
    }
}

/* End of file information_model.php */
/* Location: ./application/models/information/information_model.php */