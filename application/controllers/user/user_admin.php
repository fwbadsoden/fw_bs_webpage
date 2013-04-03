<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User Controller
 *
 * Controller für die Verwaltung und Anzeige der User ( Backend und Frontend )
 *
 * @author Habib Pleines <habib@familiepleines.de>
 * @version 1.0
 * @package com.cp.feuerwehr.backend.user
 **/

class User_Admin extends CI_Controller {

	private $userdata, $area, $login_link;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('CP_auth');
		$this->load->model('cpauth/cpauth_model', 'cpauth');
		$this->load->model('user/user_model', 'user');
		$this->load->model('admin/admin_model', 'admin');
		
		// Usermodel Konfiguration
		$this->cpauth->init('BACKEND');
		if(!$this->cpauth->is_logged_in()) redirect('admin', 'refresh');
		
		$segs = $this->uri->segment_array();		
		foreach ($segs as $segment)
		{
		    if($segment == 'frontend') 
		    {
		    	$this->user->init($segment);
		    	$this->area = $segment;
		    	$this->login_link = EMAIL_LINK_ACCOUNT_ACTIVATE;
		    }
		    if($segment == 'backend') 
		    {
		    	$this->user->init($segment);
		    	$this->area = $segment;
		    	$this->login_link = EMAIL_ADMINLINK_ACCOUNT_ACTIVATE;
		    }
		}			
		if($this->area != 'backend' && $this->area != 'frontend') redirect('admin');
	}
	
	public function user_liste()
	{		
		$this->session->set_userdata('userliste_redirect', current_url()); 
				
		$header['title'] = 'Benutzer im '.ucfirst($this->area);
		$menue['menue']	= $this->admin->get_menue();
		$menue['submenue']	= $this->admin->get_submenue();
		$data['user'] = $this->user->get_user_list($this->area);	
		$data['area'] = $this->area;
	
		$this->load->view('backend/templates/admin/header', $header);
		$this->load->view('backend/templates/admin/styles');
		$this->load->view('backend/user/styles_user');
		$this->load->view('backend/templates/admin/menue', $menue);	
		$this->load->view('backend/templates/admin/submenue', $menue);	
		$this->load->view('backend/templates/admin/jquery-tablesorter-cp');
		$this->load->view('backend/user/userliste_admin', $data);
		$this->load->view('backend/templates/admin/footer');		
	}
	
	public function create_user()
	{
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{
			if($verify = $this->verify_user())
			{
				$this->admin->insert_log(str_replace('%USER%', $this->input->post('username'), lang('log_admin_createUser')));
				$this->userdata = $this->user->create_user();
				/*	
				 *  $this->user['userdata'] = array(userID, username, email, vorname, nachname, creation_date)
				 *  $this->user['authdata'] = intial_password
				 */
				$this->send_initial_login();
			}
		}
		else
			$this->session->set_userdata('usercreate_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{			
			$header['title']		= 'User';
			$menue['menue']			= $this->admin->get_menue();
			$menue['submenue'] 		= $this->admin->get_submenue();
			
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/styles');
			$this->load->view('backend/user/styles_user');
			$this->load->view('backend/templates/admin/menue', $menue);
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/user/createUser_admin');
			$this->load->view('backend/templates/admin/footer');
		}
		else redirect($this->session->userdata('userliste_redirect'), 'refresh');
	}
	
	public function edit_user($id)
	{
		if($this->uri->segment($this->uri->total_segments()) == 'save')
		{
			if($verify = $this->verify_user($id))
			{
				$this->admin->insert_log(str_replace('%USER%', $this->input->post('username'), lang('log_admin_editUser')));
				$this->user->update_user($id);
			}
		}
		else
			$this->session->set_userdata('useredit_submit', current_url());
			
		if($this->uri->segment($this->uri->total_segments()) != 'save' || $verify == false)
		{
			$header['title'] 		= 'User';
			$menue['menue']			= $this->admin->get_menue();
			$menue['submenue']		= $this->admin->get_submenue();
			$user['user']			= $this->user->get_user($id);
			$user['id']				= $id;
			
			$this->load->view('backend/templates/admin/header', $header);
			$this->load->view('backend/templates/admin/styles');
			$this->load->view('backend/user/styles_user');
			$this->load->view('backend/templates/admin/menue', $menue);
			$this->load->view('backend/templates/admin/submenue', $menue);
			$this->load->view('backend/user/editUser_admin', $user);
			$this->load->view('backend/templates/admin/footer');	
		}
		else redirect($this->session->userdata('userliste_redirect'), 'refresh');
	}
	
	public function delete_user($id)
	{
		$userdata = $this->user->get_user_list($id);
		$this->admin->insert_log(str_replace('%USER%', $userdata[0]['username'], lang('log_admin_deleteUser')));
		
		$this->user->delete_user($id);
		
		redirect($this->session->userdata('userliste_redirect'), 'refresh');	
	}
	
	public function verify_user($id = 0)
	{
		$this->load->library('form_validation');
		$user_table = $this->user->get_user_table();
		
		$this->form_validation->set_error_delimiters('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>', '</p></div></div><div class="error">');
		
		if($id > 0)
		{
			$this->form_validation->set_rules('username', 'Benutzername', 'required|alpha_numeric|max_length[20]|xss_clean|edit_unique['.$user_table.'.username.'.$id.'.userID]');	
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]|xss_clean|edit_unique['.$user_table.'.email.'.$id.'.userID]');		
		}
		else
		{
			$this->form_validation->set_rules('username', 'Benutzername', 'required|alpha_numeric|max_length[20]|xss_clean|is_unique['.$user_table.'.username]');	
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[150]|xss_clean|is_unique['.$user_table.'.email]');
		}
		$this->form_validation->set_rules('vorname', 'Vorname', 'required|alpha|max_length[100]|xss_clean');
		$this->form_validation->set_rules('nachname', 'Nachname', 'required|alpha|max_length[100]|xss_clean');
		
		return $this->form_validation->run();
	}
	
	private function send_initial_login()
	{
		$this->load->library('email');
		
		// Accountdaten Email
		$this->email->from(EMAIL_FROM_ACCOUNT_ACTIVATE, EMAIL_FROMTXT_ACCOUNT_ACTIVATE);
		$this->email->to($this->userdata['userdata']['email']);
		$this->email->subject('feuerwehr-bs.de - Dein neuer Account für den '.ucfirst($this->area).' Bereich');		
		$message_html = EMAIL_HTML_HEADER;
		$message_html.= 'Hallo '.$this->userdata['userdata']['vorname'].'<br>';
		$message_html.= '<p>Dein neuer Account für den <strong>'.ucfirst($this->area).' Bereich</strong> unter <a href="'.$this->login_link.'" target="_blank">'.$this->login_link.'</a> wurde angelegt.</p>
		                 <p>Du kannst dich mit folgenden Daten anmelden:</p><br>
		                 <table>
		                 	<tr><td><strong>Benutzername:</strong></td><td>'.$this->userdata['userdata']['username'].'</td></tr>
		                 	<tr><td><strong>Passwort:</strong></td><td>Erhältst du aus Sicherheitsgründen mit einer separeten Email</td></tr>
		                 </table>';
		$message_html.= EMAIL_HTML_FOOTER;
		$this->email->message($message_html);
		$this->email->send();
		
		$this->email->clear();
		
		// Passwortdaten Email
		$this->email->from(EMAIL_FROM_ACCOUNT_ACTIVATE, EMAIL_FROMTXT_ACCOUNT_ACTIVATE);
		$this->email->to($this->userdata['userdata']['email']);
		$this->email->subject('feuerwehr-bs.de - Dein Initialpasswort für den '.ucfirst($this->area).' Bereich');
		$message_html = EMAIL_HTML_HEADER;
		$message_html.= 'Hallo '.$this->userdata['userdata']['vorname'].'<br>';
		$message_html.= '<p>Hiermit erhältst du das Initialpasswort. Beim ersten Anmelden wirst du aufgefordert, dieses Passwort zu ändern.</p><br>
		                 <table>
		                 	<tr><td><strong>Benutzername:</strong></td><td>Wurde dir in einer vorherigen Mail mitgeteilt</td></tr>
		                 	<tr><td><strong>Passwort:</strong></td><td>'.$this->userdata['authdata']['initial_pw'].'</td></tr>
		                 </table>';
		$message_html.= EMAIL_HTML_FOOTER;
		$this->email->message($message_html);
		$this->email->send();		
	}
	
	public function switch_online_state($id, $state)
	{
		if($state == 1) $online = 0; else $online = 1;
		
		$this->user->switch_online_state($id, $online);
		redirect($this->session->userdata('userliste_redirect'), 'refresh');	
	}
	
	// JSON Call Attribut eindeutig
	public function json_userattr_unique($area, $attr, $id, $value)
	{		
		echo json_encode($this->user->is_attr_unique($area, $attr, $value, $id));
	}
}
?>