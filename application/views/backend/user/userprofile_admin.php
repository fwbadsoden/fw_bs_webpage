<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');

	$form = array(
		'id'	 => 'user',
	);
	$userUsername = array(
		'name'	   => 'username',
		'id'	   => 'username',
		'class'    => 'input_text',
		'value'    => $userdata->uacc_username,
        'readonly' => 'readonly'
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
	if(!$value = set_value('initials')) $value = $userdata->initials;
    $userInitials = array(
        'name'  => 'initials',
        'id'    => 'initials',
        'class' => 'input_time',
        'value' => $value
    );
?>

<script type="text/javascript">
$(function() {
	$('#<?=$userEmail['id']?>').bind('change', function(e) {
			$.getJSON('<?=base_url('user/user_admin/json_userattr_unique')?>/<?=$userdata->uacc_id?>/' + $('#<?=$userEmail['id']?>').val(),
				function(data) {
					if(data == 0)
						$('span.error_email').html('<span style="color: red">Emailadresse bereits in Benutzung!</span>');	
				}
			);
	});
});
</script>

<div id='content'>
<div id='user_profile'>

<h1>Benutzerprofil</h1>

<?=form_open($this->session->userdata('userprofile_redirect').'/save', $form);?>

    <table>
		<tr>
            <td><button type='submit' name='profile_submit' id='profile_submit' class='button_gross'><span class='button_save'>Speichern</span></button></td>
        </tr>
    </table>
    <br>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Profildaten:&nbsp;&nbsp;&nbsp;');?>
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
            <td class='form_label'><?=form_label('Initialen:', $userInitials['id']); ?></td>
            <td><?=form_input($userInitials); ?></td>
            <td class='error'></td>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
</div>

<div style="clear:both;"></div>
</div>