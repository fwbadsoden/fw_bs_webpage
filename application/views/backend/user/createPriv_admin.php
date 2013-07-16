<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 => 'priv',
	);
	$privName = array(
		'name'	=> 'name',
		'id'	=> 'name',
		'class' => 'input_text',
		'value' => set_value('name')
	);
	$privDescription = array(
		'name' 	=> 'description',
		'id'	=> 'description',
		'class'	=> 'input_text',
		'value'	=> set_value('description')
	);
	$modul_options = array();
	if(isset($_POST['modul'])) 			$modul_selected = $_POST['modul']; 
	else $modul_selected = 0;
	$modul_attr 		= "class = 'input_dropdown' id = 'modul'";	
	foreach($module as $item)
	{
		$modul_options[$item['moduleID']] 	= $item['moduleName'];
	}
?>

<div id='content'>
<div id='priv_create'>
<?=form_open($this->session->userdata('privcreate_submit').'/save', $form);?>

    <table>
		<tr>
            <td><button type='submit' name='priv_submit' id='priv_submit' class='button_gross'><span class='button_save'>Berechtigung anlegen</span></button></td>
            <td><a href='<?=$this->session->userdata('privliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
            <td><button type='reset' name='priv_submit' id='priv_submit' class='button_gross'><span class='button_reset'>Zurücksetzen</span></button></td>
        </tr>
    </table>
    <br>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Berechtigungsdaten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
    	<tr>
            <td class='form_label'><?=form_label('Berechtigungsname:', $privName['id']); ?></td>
            <td><?=form_input($privName); ?></td>
        </tr>
        <tr>
            <td class='form_label'><?=form_label('Modul:', 'modul'); ?></td>
            <td><?=form_dropdown('modul', $modul_options, $modul_selected, $modul_attr)?></td>
        </tr>
    	<tr>
            <td class='form_label'><?=form_label('Beschreibung:', $privDescription['id']); ?></td>
            <td><?=form_input($privDescription); ?></td>
            
        </tr>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
    <script type="text/javascript" language="JavaScript">
        document.forms['<?=$form['id']?>'].elements['<?=$privName['id']?>'].focus();
    </script>
</div>

<div style="clear:both;"></div>
</div>