<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 => 'einsatz',
	);	
	$einsatzName = array(
		'name'	=> 'einsatzname',
		'id'	=> 'einsatzname',
		'class' => 'input_text',
		'value' => set_value('einsatzname')
	);
	$einsatzNr = array(
		'name'  => 'einsatznr',
		'id' 	=> 'einsatznr',
		'class' => 'input_small',
		'value' => set_value('einsatznr')
	);
	$einsatzDatum = array(
		'name'	=> 'einsatzdatum',
		'id'	=> 'einsatzdatum',
		'type'	=> 'date',
		'class' => 'input_date',
		'value' => set_value('einsatzdatum')
	);
	$einsatzBeginn = array(
		'name'	=> 'einsatzbeginn',
		'id'	=> 'einsatzbeginn',
		'class' => 'input_time',
		'value' => set_value('einsatzbeginn')
	);
	$einsatzEnde = array(
		'name'	=> 'einsatzende',
		'id'	=> 'einsatzende',
		'class' => 'input_time',
		'value' => set_value('einsatzende')
	);
	$einsatzLage = array(
		'name' 	=> 'einsatzlage',
		'id'	=> 'einsatzlage',
		'class' => 'tinymce',
		'value' => set_value('einsatzlage')
	);
	$einsatzGeschehen = array(
		'name' 	=> 'einsatzgeschehen',
		'id'	=> 'einsatzgeschehen',
		'class' => 'tinymce',
		'value' => set_value('einsatzgeschehen')
	);
	$einsatzKraefteW = array(
		'name' 	=> 'weitereeinsatzkraefte',
		'id'	=> 'weitereeinsatzkraefte',
		'class' => 'tinymce',
		'value' => set_value('weitereeinsatzkraefte')
	);
	$einsatzAnzahl = array(
		'name'	=> 'anzahl',
		'id'	=> 'anzahl',
		'value' => 0,
		'type'	=> 'range',
		'max'	=> '40',
		'step'	=> '1',
		'keyboard' => 'true',
	);
	if($this->input->post('anzahl') > 0) $einsatzAnzahl['value'] = set_value('anzahl');
	
	for($i = 0; $i < count($types); $i++)
	{
		$types[$i]['formAttr']['name'] 			= 't_'.$types[$i]['typeID'];
		$types[$i]['formAttr']['id']			= 't_'.$types[$i]['typeID'];
		$types[$i]['formAttr']['class']			= '';
		$types[$i]['formAttr']['value']			= $types[$i]['typeID'];
		
		if($this->input->post('t_'.$types[$i]['typeID']) == $types[$i]['typeID']) 
		{
			$types[$i]['formAttr']['checked'] = 'checked'; 
		}
	}
	
	for($i = 0; $i < count($fahrzeuge); $i++)
	{
		$fahrzeuge[$i]['formAttr']['name'] = 'f_'.$fahrzeuge[$i]['id'];
		$fahrzeuge[$i]['formAttr']['id'] = 'f_'.$fahrzeuge[$i]['id'];
		$fahrzeuge[$i]['formAttr']['class'] = '';
		$fahrzeuge[$i]['formAttr']['value'] = $fahrzeuge[$i]['id'];		
		
		if($this->input->post('f_'.$fahrzeuge[$i]['id']) == $fahrzeuge[$i]['id']) 
		{
			$fahrzeuge[$i]['formAttr']['checked'] = 'checked'; 
		}
	}
	
	$templ_options = array();
	$templ_attr = "class = 'input_dropdown_einsatz' id = 'input_dropdown_einsatz'";
	$templ_options[0] = 'Vorlage wählen...';
	foreach($templates as $templ)
	{
		$templ_options[$templ['template_id']] = $templ['template_name'];	
	}
?>

<script type="text/javascript">
$(function() {
	$('#input_dropdown_einsatz').bind('change', function(e) {
			$.getJSON('<?=base_url('einsatz/einsatz_admin/json_get_einsatz_template')?>/' + $('#input_dropdown_einsatz').val(),
				function(data) {
					$.each(data, function(i,item) {
						if (item.field == "einsatzname") {
							$('#einsatzname').val(item.value);
						}
						else if (item.field == "einsatzlage") {
							$('#einsatzlage').val(item.value);
						}
						else if (item.field == "einsatzgeschehen") {
							$('#einsatzgeschehen').val(item.value);
						}
						else if (item.field == "einsatzart") {
							var arten = item.value.split('|');
							$.each(arten, function(index, value) {
								$('#t_' + value).attr('checked', true);
							});
						}
						else if (item.field == "einsatzfahrzeug") {
							var fahrzeuge = item.value.split('|');	
							$.each(fahrzeuge, function(index, value) {
								$('#f_' + value).attr('checked', true);
							});					
						}
					});
				}
			);
	});

	$(":range").rangeinput();
	$(":date").dateinput({
		format: 'dd.mm.yyyy',	
	});
});

        
</script>


<div id='content'>
<div id='einsatz_create'>
<?=form_open($this->session->userdata('einsatzcreate_submit').'/save', $form);?>

    <table>
        <tr>
            <td><button type='submit' name='einsatz_submit' id='einsatz_submit' class='button_gross'><span class='button_save'>Einsatz anlegen</span></button></td>
            <td><a href='<?=$this->session->userdata('einsatzliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
            <td><button type='reset' name='einsatz_submit' id='einsatz_submit' class='button_gross'><span class='button_reset'>Zurücksetzen</span></button></td>
        </tr>
    </table>
    <br>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Einsatzdaten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class='form_label'><?=form_label('Einsatzname:', $einsatzName['id']); ?></td>
                        <td><?=form_input($einsatzName); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <table>
                                <tr>
                                    <td><?=form_label('Einsatz-Nr.:', $einsatzNr['id']); ?><br><?=form_input($einsatzNr); ?></td>
                                    <td><?=form_label('Datum:', $einsatzDatum['id']); ?><br><?=form_input($einsatzDatum); ?></td>
                                    <td><?=form_label('Beginn:', $einsatzBeginn['id']); ?><br><?=form_input($einsatzBeginn); ?></td>
                                    <td><?=form_label('Ende:', $einsatzEnde['id']); ?><br><?=form_input($einsatzEnde); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td><?=form_label('Anzahl Einsatzkräfte:', $einsatzAnzahl['id']); ?></td>
                        <td><?=form_input($einsatzAnzahl); ?></td>
                    </tr>
                    <tr>
                        <td><?=form_label('Einsatzlage:', $einsatzLage['id']); ?></td>
                        <td><?=form_textarea($einsatzLage); ?></td>
                    </tr>
                    <tr>
                        <td><?=form_label('Einsatzgeschehen:', $einsatzGeschehen['id']); ?></td>
                        <td><?=form_textarea($einsatzGeschehen); ?></td>
                    </tr>
                    <tr>
                        <td><?=form_label('Weitere Einsatzkräfte:', $einsatzKraefteW['id']); ?></td>
                        <td><?=form_textarea($einsatzKraefteW); ?></td>
                    </tr>
                </table>
            </td>
            <td>
                <table>		
                	<tr>
                    	<td colspan='2'><strong>Vorlage wählen:</strong></td>
                    </tr>
                	<tr>
                    	<td colspan='2'><?=form_dropdown('einsatz_template', $templ_options, 0, $templ_attr)?></td>
                    </tr>
                    <tr>
                        <td colspan='2'><strong>Einsatzart:</strong></td>
                    </tr>
                <? foreach($types as $t) { ?>
                    <tr>
                        <td colspan='2'><?=form_checkbox($t['formAttr']); ?> <?=form_label($t['typeName'], $t['formAttr']['id']); ?></td>
                    </tr>
                <? } ?>	
                    <tr><td colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td colspan='2'><strong>Fahrzeuge im Einsatz:</strong></td>
                    </tr>
                <? foreach($fahrzeuge as $f) { ?>
                    <tr>
                        <td colspan='2'><?=form_checkbox($f['formAttr']); ?> <?=form_label($f['name'], $f['formAttr']['id']); ?></td>
                    </tr>
                <? } ?>
                </table>
                <script type="text/javascript" language="JavaScript">
                    document.forms['<?=$form['id']?>'].elements['<?=$einsatzName['id']?>'].focus();
                </script>
            </td>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
</div>

<div style="clear:both;"></div>
</div>