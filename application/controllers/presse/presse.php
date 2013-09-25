<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Presse
 * Controller für die Anzeige der Presseartikel
 * 
 * @package com.cp.feuerwehr.frontend.presse  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Presse extends CP_Controller {

	/**
	 * Presse::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
        $this->load->model('presse/presse_model', 'm_presse');  
	}
    
    public function get_presse_overview()
    {
        return $this->m_presse->get_articles($limit = PRESSE_DEFAULT_LIMIT, $offset = PRESSE_DEFAULT_OFFSET);
    }
    
    public function overview_2col()
    {
        $presse['articles'] = $this->m_presse->get_articles();
		
		$this->load->view('frontend/presse/overview_2col_contact');
		$this->load->view('frontend/presse/overview_2col_articles', $presse);
    }
    
    public function overview_sidebar()
    {
		$this->load->view('frontend/presse/overview_2col_sidebar');        
    }
    
    public function send_email()
    {
        $this->load->library('email');
        $this->email->from($this->input->post('email'), $this->input->post('name'));
        $this->email->to('pressestelle@feuerwehr-bs.de');
        $this->email->subject($this->input->post('betreff'));
        $message = 'Name: '.$this->input->post('name').'<br />';
        $message.= 'Redaktion: '.$this->input->post('redaktion').'<br />';
        $message.= 'Email-Adresse: '.$this->input->post('email').'<br />';
        $message.= 'Telefon: '.$this->input->post('telefon').'<br />';
        $message.= 'Nachricht: <br />'.$this->input->post('message').'<br />';
        $this->email->message($message);
        $this->email->send();
        //echo $this->email->print_debugger();
        redirect($this->input->server('HTTP_REFERER', TRUE).'gesendet'); 
    }
}
?>