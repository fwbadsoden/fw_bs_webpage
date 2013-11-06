<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Frontend
 * zentraler Controller für den Frontendbereich
 * 
 * @package com.cp.feuerwehr.frontend.frontend  
 * @author Habib Pleines <habib@familiepleines.de>
 * @copyright 
 * @version 2013
 * @access public
 */
class Frontend extends CP_Controller {
    
	/**
	 * Frontend::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
        $this->load->model('pages/pages_model', 'm_pages');      
	}
    
    /**
     * Frontend::loader()
     * 
     * @return
     */
    public function loader()
    {
        $uri_segments = $this->uri->rsegment_array();
        // $uri_segments[0] fehlt, da des erste Segment der Ordner des Controller ist
        
        $controller = $uri_segments[3];
        $function   = $uri_segments[4];
            
        if(count($uri_segments) > 4) {
            $j = 0;
            $args = array();
            for($i = 5; $i <= (count($uri_segments)); $i++) {
                $args[$j] = $uri_segments[$i];
                $j++;
            }
        } 
        
        if($controller == $this->router->class) {
            // dynamisch Funktionen des Frontend Controllers laden
            $this->$function($args);
        }
        else {
            if($controller == 'page') {
                // dynamisch Inhaltseiten laden  
		        $this->load->helper('load_controller');
          //      $this->load->controller('pages/pages', 'c_pages');
                $c_pages = load_controller('pages/pages');
                $c_pages->{$function}($args[0]);
            }
            else {
                // dynamisch Modulseiten laden
            }
        }
    }
    
    /**
     * Frontend::send_email()
     * sendet eine Email nach Validierung der Emailadresse und des Captchas.
     * 
     * @return
     */
    public function send_email()
    {
        $result = $this->_validate_form();
        
        if($result == true)
        {
            $this->load->library('email');
            $this->email->from($this->input->post('email'), $this->input->post('name'));
            $this->email->to(EMAIL_CONTACT_FORM_TO);
            $this->email->subject($this->input->post('betreff'));
            $message = 'Name: '.$this->input->post('name').'<br />';
            $message.= 'Email-Adresse: '.$this->input->post('email').'<br />';
            $message.= 'Telefon: '.$this->input->post('telefon').'<br />';
            $message.= 'Nachricht: <br />'.$this->input->post('message').'<br />';
            $this->email->message($message);
            $this->email->send();
            //echo $this->email->print_debugger();
            
            $this->session->set_userdata('contact_send','send');
        }
        
        $this->session->set_userdata('contact_send',$result);
        redirect($this->input->server('HTTP_REFERER', TRUE)); 
    }
    
    /**
     * Frontend::_validate_form()
     * Validiert die Emailadresse und das Captcha
     * 
     * @return
     */
    private function _validate_form()
    {
        $this->load->library('form_validation');
        $this->load->helper('captcha');
        
        $this->form_validation->set_error_delimiters('', '');		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');	
		$result = $this->form_validation->run(); 
        
        if(!$result) return 'validation_error';
        $expiration = time()-7200;
        $this->db->where('captcha_time <', $expiration);
        $this->db->query->delete('captcha');
        
        $this->db->where(array('word' => $_POST['captcha'], 'ip_address' => $this->input->ip_address(), 'captcha_time >' => $expiration));
        $count = $this->db->count_all_results();
        
        if($count == 0) return 'captcha_false'; else return true;
    }
 }
/* End of file frontend.php */
/* Location: ./application/controllers/frontend/frontend.php */