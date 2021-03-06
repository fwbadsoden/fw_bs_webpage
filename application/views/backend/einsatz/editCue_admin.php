<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 => 'stichwort',
	);	
	if(!$value = set_value('stichwortname')) $value = $cue->name;
	$cueName = array(
		'name'	=> 'stichwortname',
		'id'	=> 'stichwortname',
		'class' => 'input_text',
		'value' => $value
	);
	if(!$value = set_value('stichwortbeschreibung')) $value = $cue->mimic;
	$cueBeschreibung = array(
		'name'	=> 'stichwortbeschreibung',
		'id'	=> 'stichwortbeschreibung',
		'class' => 'input_text',
		'value' => $value
	);
	if(!$value = set_value('stichwortbeispiel')) $value = $cue->example;
	$cueBeispiel = array(
		'name'	=> 'stichwortbeispiel',
		'id'	=> 'stichwortbeispiel',
		'class' => 'input_text',
		'value' => $value
	);
	if(!$value = set_value('stichwortaao')) $value = $cue->aao;
	$cueAAO = array(
		'name'	=> 'stichwortaao',
		'id'	=> 'stichwortaao',
		'class' => 'input_text',
		'value' => $value
	);
?>

<div id='content'>
<div id='cue_create'>
<?=form_open($this->session->userdata('cueedit_submit').'/save', $form);?>

    <table>
        <tr>
            <td><button type='submit' name='cue_submit' id='cue_submit' class='button_gross'><span class='button_save'>Speichern</span></button></td>
            <td><a href='<?=$this->session->userdata('cueliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
        </tr>
    </table>
    <br>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Daten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
                    <tr>
                        <td class='form_label'><?=form_label('Stichwort:', $cueName['id']); ?></td>
                        <td><?=form_input($cueName); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Beschreibung', $cueBeschreibung['id']); ?></td>
                        <td><?=form_input($cueBeschreibung); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Beispiel', $cueBeispiel['id']); ?></td>
                        <td><?=form_input($cueBeispiel); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('AAO', $cueAAO['id']); ?></td>
                        <td><?=form_input($cueAAO); ?></td>
                    </tr>

                <script type="text/javascript" language="JavaScript">
                    document.forms['<?=$form['id']?>'].elements['<?=$cueName['id']?>'].focus();
                </script>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
</div>

<div style="clear:both;"></div>
</div>
