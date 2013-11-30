<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
    public function __construct() {
        parent::__construct();
        $this->load->model('pages/pages_model', 'm_pages');
    }

    /**
     * Frontend::loader()
     * 
     * @return
     */
    public function loader() {
        $uri_segments = $this->uri->rsegment_array();
        // $uri_segments[0] fehlt, da des erste Segment der Ordner des Controller ist

        $controller = $uri_segments[3];
        $function = $uri_segments[4];

        if (count($uri_segments) > 4) {
            $j = 0;
            $args = array();
            for ($i = 5; $i <= (count($uri_segments)); $i++) {
                $args[$j] = $uri_segments[$i];
                $j++;
            }
        }

        if ($controller == $this->router->class) {
            // dynamisch Funktionen des Frontend Controllers laden
            $this->$function($args);
        } else {
            if ($controller == 'page') {
                // dynamisch Inhaltseiten laden  
                $this->load->helper('load_controller');
                //      $this->load->controller('pages/pages', 'c_pages');
                $c_pages = load_controller('pages/pages');
                $c_pages->{$function}($args[0]);
            } else {
                // dynamisch Modulseiten laden
            }
        }
    }

    /**
     * Frontend::send_email()
     * 
     * @return
     */
    public function send_email($originPage) {
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('captcha');

        $this->session->unset_userdata(array("form_name", "form_email", "form_message", "form_telefon", "form_redaktion", "form_telefon", 'form_validation_errors'));

        if (!$this->_validate_form()) {
            $this->_store_form();

            if ($originPage == "presse")
                redirect('aktuelles/presse/validierung');
            if ($originPage == "impressum")
                redirect('impressum/validierung');
            if ($originPage == "kontakt")
                redirect('kontakt/validierung');
        } else {
            if (!validate_captcha($this->input->post('captcha'), 7200)) {
                $this->_store_form();

                if ($originPage == "presse")
                    redirect('aktuelles/presse/captcha');
                if ($originPage == "impressum")
                    redirect('impressum/captcha');
                if ($originPage == "kontakt")
                    redirect('kontakt/captcha');
            }
            else {
                $this->load->library('email');
                $this->email->from($this->input->post('email'), $this->input->post('name'));
                $this->email->to(EMAIL_CONTACT_FORM_TO);
                $this->email->subject($this->input->post('betreff'));
                $message = 'Name: ' . $this->input->post('name') . '<br />';
                $message.= 'Redaktion: ' . $this->input->post('redaktion') . '<br />';
                $message.= 'Email-Adresse: ' . $this->input->post('email') . '<br />';
                $message.= 'Telefon: ' . $this->input->post('telefon') . '<br />';
                $message.= 'Nachricht: <br />' . $this->input->post('message') . '<br />';
                $this->email->message($message);
                $this->email->send();

                if ($originPage == "presse")
                    redirect('aktuelles/presse/gesendet');
                if ($originPage == "impressum")
                    redirect('impressum/gesendet');
                if ($originPage == "kontakt")
                    redirect('kontakt/gesendet');
            }
        }
    }

    /**
     * Frontend::_validate_form()
     * Validiert die Emailadresse und speichert die Validierungsfehler
     * 
     * @return
     */
    private function _validate_form() {
        $this->load->library('form_validation');
        $this->load->library('session');

        $this->form_validation->set_rules('message', 'Nachricht', 'xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'xss_clean');
        $this->form_validation->set_rules('redaktion', 'Redaktion / Organisation', 'xss_clean');
        $this->form_validation->set_rules('telefon', 'Telefon', 'xss_clean');
        $this->form_validation->set_rules('email', 'E-MAIL ADRESSE', 'required|valid_email|xss_clean');
        $this->form_validation->set_rules('captcha', 'Captcha', '');
        if ($this->form_validation->run()) {
            return true;
        } else {
            $this->session->set_userdata('form_validation_errors', validation_errors());
            return false;
        }
    }

    /**
     * Frontend::__store_form()
     * Speichert die POST-Data
     * 
     * @return
     */
    private function _store_form() {
        $this->load->library('session');

        $this->session->set_userdata('form_telefon', set_value('telefon'));
        $this->session->set_userdata('form_redaktion', set_value('redaktion'));
        $this->session->set_userdata('form_email', set_value('email'));
        $this->session->set_userdata('form_message', set_value('message'));
        $this->session->set_userdata('form_name', set_value('name'));
    }

}

/* End of file frontend.php */
/* Location: ./application/controllers/frontend/frontend.php */