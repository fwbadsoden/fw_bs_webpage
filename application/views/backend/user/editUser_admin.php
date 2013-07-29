<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 => 'user',
	);
	if(!$value = set_value('username')) $value = $userdata->uacc_username;
	$userUsername = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'class' => 'input_text',
		'value' => $value
	);
	if(!$value = set_value('email')) $value = $userdata->uacc_email;
	$userEmail = array(
		'name' 	=> 'email',
		'id'	=> 'email',
		'class'	=> 'input_text',
		'value'	=> $value
	);
	if(!$value = set_value('vorname')) $value = $userdata->first_name;
	$userVorname = array(
		'name' 	=> 'vorname',
		'id'	=> 'vorname',
		'class'	=> 'input_text',
		'value'	=> $value		
	);
	if(!$value = set_value('nachname')) $value = $userdata->last_name;
	$userNachname = array(
		'name' 	=> 'nachname',
		'id'	=> 'nachname',
		'class'	=> 'input_text',
		'value'	=> $value			
	);
    if(!$value = set_value('initialen')) $value = $userdata->initials;
	$userInitials = array(
		'name' 	=> 'initialen',
		'id'	=> 'initialen',
		'class'	=> 'input_text',
		'value'	=> $value			
	);
    $gender_options = array();
	if(isset($_POST['geschlecht'])) 	     		
        $gender_selected = $_POST['geschlecht']; 
	else 											
        $gender_selected = $userdata->gender;
	$gender_attr 		 = "class = 'input_dropdown' id = 'geschlecht'";
	$gender_options['m'] = 'Männlich';
	$gender_options['w'] = 'Weiblich';
    
    $group_options = array();
	if(isset($_POST['gruppe'])) 	     		
        $group_selected = $_POST['gruppe']; 
	else 											
        $group_selected = $userdata->uacc_group_fk;
	$group_attr 		= "class = 'input_dropdown' id = 'gruppe'";
    foreach($group as $g)
    {
	   $group_options[$g->ugrp_id] = $g->ugrp_name;
    }
?>

<script type="text/javascript">
$(function() {
	$('#<?=$userUsername['id']?>').bind('change', function(e) {
			$('span.error_username').html('');
			$.getJSON('<?=base_url('user/user_admin/json_userattr_unique')?>/<?=$userdata->uacc_id?>/' + $('#<?=$userUsername['id']?>').val(),
				function(data) {
					if(data == 0)
						$('span.error_username').html('<span style="color: red">Benutzername bereits vergeben!</span>');	
				}
			);
	});
	$('#<?=$userEmail['id']?>').bind('change', function(e) {
			$('span.error_email').html('');
			$.getJSON('<?=base_url('user/user_admin/json_userattr_unique')?>/<?=$userdata->uacc_id?>' + $('#<?=$userEmail['id']?>').val(),
				function(data) {
					if(data == 0)
						$('span.error_email').html('<span style="color: red">Emailadresse bereits in Benutzung!</span>');	
				}
			);
	});
});
</script>

<div id='content'>
<div id='user_edit'>
<?=form_open($this->session->userdata('useredit_submit').'/save', $form);?>

    <table>
		<tr>
			<td><button type='submit' name='user_submit' id='user_submit' class='button_gross'><span class='button_save'>Speichern</span></button></td>
			<td><a href='<?=$this->session->userdata('userliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
		</tr>
    </table>
    <br>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Benutzerdaten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
    	<tr>
            <td class='form_label'><?=form_label('Benutzername:', $userUsername['id']); ?></td>
            <td><?=form_input($userUsername); ?></td>
            <td class='error'><span class='error_username'></span></td>
        </tr>
    	<tr>
            <td class='form_label'><?=form_label('Emailadresse:', $userEmail['id']); ?></td>
            <td><?=form_input($userEmail); ?></td>
            <td class='error'><span class='error_email'></span></td>
        </tr>
    	<tr>
            <td class='form_label'><?=form_label('Vorname:', $userVorname['id']); ?></td>
            <td><?=form_input($userVorname); ?></td>
            <td class='error'></td>
        </tr>
    	<tr>
            <td class='form_label'><?=form_label('Nachname:', $userNachname['id']); ?></td>
            <td><?=form_input($userNachname); ?></td>
            <td class='error'></td>
        </tr>
        <tr>
            <td class='form_label'><?=form_label('Geschlecht:', 'geschlecht'); ?></td>
            <td><?=form_dropdown('geschlecht', $gender_options, $gender_selected, $gender_attr)?></td>
            <td class='error'></td>
        </tr>
    	<tr>
            <td class='form_label'><?=form_label('Initialen:', $userInitials['id']); ?></td>
            <td><?=form_input($userInitials); ?></td>
            <td class='error'></td>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
    <p></p>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Berechtigungsgruppe:&nbsp;&nbsp;&nbsp;');?>
    <p>
    <table>        
        <tr>
            <td class='form_label'><?=form_label('Gruppe:', 'gruppe'); ?></td>
            <td><?=form_dropdown('gruppe', $group_options, $group_selected, $group_attr)?></td>
            <td class='error'></td>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
    <script type="text/javascript" language="JavaScript">
        document.forms['<?=$form['id']?>'].elements['<?=$userUsername['id']?>'].focus();
    </script>
</div>

<div style="clear:both;"></div>
</div>