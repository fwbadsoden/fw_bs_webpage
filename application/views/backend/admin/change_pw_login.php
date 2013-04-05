<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	=> 'change_pw',
	);
	
	$password_old = array(
		'id'		=> 'password_old',
		'name'		=> 'password_old',
		'maxlength'	=> '20',
		'class'		=> 'login_input'
	);
	
	$password_new1 = array(
		'id'		=> 'password_new1',
		'name'		=> 'password_new1',
		'maxlength'	=> '20',
		'class'		=> 'login_input'
	);
	
	$password_new2 = array(
		'id'		=> 'password_new2',
		'name'		=> 'password_new2',
		'maxlength'	=> '20',
		'class'		=> 'login_input'
	);
	
	$button = array(
	'value' => lang('view_admin_login_buttonchangepw'),
	'type'  => 'submit',
	'name'  => 'pwchange_button',
	'class' => 'login_button_pw'
	);
?>

<div id="login_box">
	<div id="logo"></div>
	<div class="kasten_oben">
		<img src="/images/admin/layout/login_login_oben.gif">
	</div>
	<div class="kasten_mitte">						
		<?=form_open('admin/change_pw/check', $form);?>					
		<p class="login_text"><?=lang('view_admin_login_password_old')?></p>
		<p><?=form_password($password_old)?></p>		
		<p class="spacer"></p>			
		<p class="login_text"><?=lang('view_admin_login_password_new1')?></p>
		<p><?=form_password($password_new1)?></p>		
		<p class="spacer"></p>			
		<p class="login_text"><?=lang('view_admin_login_password_new2')?></p>
		<p><?=form_password($password_new2)?></p>		
		<p class="spacer"></p>						
		<p><?=form_input($button)?></p>								
		<script type="text/javascript" language="JavaScript">
			document.forms['change_pw'].elements['password_old'].focus();
		</script>
		<?=form_close()?>
     </div>	
	<div class="kasten_unten"></div>
<? if($error == 'error') { ?>
	<div style="height:10px;"></div> 
	<div class="kasten_oben"><img src="/images/admin/layout/login_login_oben.gif"></div>
	<div class="kasten_mitte">
		<p class="login_text"><?=form_error('password_old')?></p><p></p>
		<p class="login_text"><?=form_error('pw_old_is_not_correct')?></p><p></p>
		<p class="login_text"><?=form_error('pw_is_like_old')?></p><p></p>
		<p class="login_text"><?=form_error('password_new1')?></p><p></p>
		<p class="login_text"><?=form_error('password_new2')?></p><p></p>
	</div>
	<div class="kasten_unten"></div>
<? } ?>
	<div id="powered"></div>
</div>