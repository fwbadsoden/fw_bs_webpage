<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$this->load->helper('form');

	$form = array(
		'id'	 => 'login',
	);

	$login = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'value' => $this->input->post('username'),
	'maxlength'	=> 80,
	'class' => 'login_input'
	);
	
	$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'maxlength'	=> 20,
	'class' => 'login_input'
	);
	
	$remember = array(
	'name'  => 'remember',
	'id'	=> 'remember',
	'value' => $this->input->post('remember'),
	'class' => 'login_checkbox'
	);
	
	$button = array(
	'value' => lang('view_admin_login_buttonlogin'),
	'type'  => 'submit',
	'name'  => 'login_button',
	'class' => 'login_button'
	);
	
	$formPW = array(
		'id'	 => 'pw',
	);
	
	$email = array(
	'name'  => 'email',
	'id'	=> 'email',
	'class' => 'login_input',
	'value' => $this->session->flashdata('email')
	);
	
	$buttonPW = array(
	'value' => 'Neues Passwort zusenden',
	'type'  => 'submit',
	'name'  => 'pw_button',
	'id'	=> 'pw_button',
	'class' => 'login_button_pw'
	);

?>

<script>
	$(function() {	
		$( "a.forgot_password" ).click(function() {
			$( "#pw-forgot-email" ).toggle();				
			$( "#pw-forgot-title" ).toggle();				
			document.forms['pw'].elements['email'].focus();
		});
	});
</script>

<?
	$password_forgotten_link = lang('view_admin_login_passwordforgotten_link');
	if(!$this->session->flashdata('email')) {
		$password_forgotten_txt = lang('view_admin_login_passwordforgotten_txt');	
	}
	else if($this->session->flashdata('pw_status') == 1) {
		$password_forgotten_txt = lang('view_admin_login_passwordforgotten_success_txt');
		$password_forgotten_link = '';
	}
	else {
		$password_forgotten_txt = lang('view_admin_login_passwordforgotten_failure_txt'); 
?>
		<script> $(document).ready(function() { $( "pw-forgot-email" ).show(); document.forms['pw'].elements['email'].focus(); }); </script>
	<? } ?>

<div id="login_box">
	<div id="logo"></div>
	<div class="kasten_oben">
		<img src="/images/admin/layout/login_login_oben.gif">
	</div>
	<div class="kasten_mitte">						
		<?=form_open('admin/check_login', $form);?>					
		<p class="login_text"><?=lang('view_admin_login_username')?></p>
		<p><?=form_input($login)?></p>		
		<p class="spacer"></p>						
		<p class="login_text"><?=lang('view_admin_login_password')?></p>
		<p><?=form_password($password)?></p>	
<!--		<p class="spacer"></p>						
		<p class="login_text"><?=lang('view_admin_login_remember')?> <?=form_checkbox($remember)?></p>							-->
		<p class="spacer"></p>						
		<p><?=form_input($button)?></p>								
		<script type="text/javascript" language="JavaScript">
			document.forms['login'].elements['username'].focus();
		</script>
		<?=form_close()?>
	</div>
	<div class="kasten_unten"></div>
<? if($error != '') { ?>
	<div style="height:10px;"></div> 
	<div class="kasten_oben"><img src="/images/admin/layout/login_login_oben.gif"></div>
	<div class="kasten_mitte">
		<p class="login_text"><?=$error?></p>
	</div>
	<div class="kasten_unten"></div>
<? } ?>
	<div style="height:10px;"></div>
	<div class="kasten_oben">
		<img src="/images/admin/layout/login_pw_oben.gif">
	</div>
	<div id="pw-forgot-title" class="kasten_mitte">
		<p class="text"><?=$password_forgotten_txt?></p>
		<p class="spacer"></p>						
		<p><a class="forgot_password"><?=$password_forgotten_link?></a></p>
	</div> 
	<div id="pw-forgot-email" style="display:none" class="kasten_mitte">	
		<p class="text">Bitte geben Sie die Emailadresse an, mit der Sie bei uns registriert sind.</p>
		<p class="spacer"></p>	
		<?=form_open('admin/forgot_password', $formPW);?>
		<p class="login_text">Emailadresse:</p>
		<p><?=form_input($email)?></p>	
		<p class="spacer"></p>	
		<p><?=form_input($buttonPW)?></p>
		<?=form_close()?>		
	</div> 
	<div class="kasten_unten"></div>
	<div id="powered"></div>
</div>