<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 => 'einsatz',
	);
	if(!$value = set_value('einsatzname')) $value = $einsatz['einsatzName'];
	$einsatzName = array(
		'name'	=> 'einsatzname',
		'id'	=> 'einsatzname',
		'class' => 'input_text',
		'value' => $value
	);
	if(!$value = set_value('einsatznr')) $value = $einsatz['einsatzNr'];
	$einsatzNr = array(
		'name'  => 'einsatznr',
		'id' 	=> 'einsatznr',
		'class' => 'input_small',
		'value' => $value
	);
	if(!$value = set_value('einsatzdatum')) $value = cp_get_ger_date($einsatz['datum']);
	$einsatzDatum = array(
		'name'	=> 'einsatzdatum',
		'id'	=> 'einsatzdatum',
		'class' => 'input_date',
		'type'	=> 'date',
		'value' => $value
	);
	if(!$value = set_value('einsatzbeginn')) $value = $einsatz['beginn'];
	$einsatzBeginn = array(
		'name'	=> 'einsatzbeginn',
		'id'	=> 'einsatzbeginn',
		'class' => 'input_time',
		'value' => $value
	);
	if(!$value = set_value('einsatzende')) $value = $einsatz['ende'];
	$einsatzEnde = array(
		'name'	=> 'einsatzende',
		'id'	=> 'einsatzende',
		'class' => 'input_time',
		'value' => $value
	);
	if(!$value = set_value('einsatzlage')) $value = $einsatz['einsatzlage'];
	$einsatzLage = array(
		'name' 	=> 'einsatzlage',
		'id'	=> 'einsatzlage',
		'class' => 'tinymce',
		'value' => $value
	);
	if(!$value = set_value('einsatzgeschehen')) $value = $einsatz['einsatzgeschehen'];
	$einsatzGeschehen = array(
		'name' 	=> 'einsatzgeschehen',
		'id'	=> 'einsatzgeschehen',
		'class' => 'tinymce',
		'value' => $value
	);
	if(!$value = set_value('weitereeinsatzkraefte')) $value = $einsatz['einsatzkraefteFreitext'];
	$einsatzKraefteW = array(
		'name' 	=> 'weitereeinsatzkraefte',
		'id'	=> 'weitereeinsatzkraefte',
		'class' => 'tinymce',
		'value' => $value
	);
	if(!$value = set_value('anzahl')) $value = $einsatz['anzahlEinsatzkraefte'];
	$einsatzAnzahl = array(
		'name'  => 'anzahl',
		'id'	=> 'anzahl',
		'class'	=> 'input_time',
		'value' => $value
	); 
	
	for($i = 0; $i < count($types); $i++)
	{
		$types[$i]['formAttr']['name'] 			= 't_'.$types[$i]['typeID'];
		$types[$i]['formAttr']['id']			= 't_'.$types[$i]['typeID'];
		$types[$i]['formAttr']['class']			= '';
		$types[$i]['formAttr']['value']			= $types[$i]['typeID'];
        
		if(!$this->input->post('t_'.$types[$i]['typeID']) == $types[$i]['typeID'])
		{
			if(isset($einsatz['type'][$types[$i]['typeID']])) $types[$i]['formAttr']['checked'] = 'checked';	
		}
		else $types[$i]['formAttr']['checked'] = 'checked';
	}
	
	for($i = 0; $i < count($fahrzeuge); $i++)
	{
		$fahrzeuge[$i]['formAttr']['name'] 		= 'f_'.$fahrzeuge[$i]['id'];
		$fahrzeuge[$i]['formAttr']['id'] 		= 'f_'.$fahrzeuge[$i]['id'];
		$fahrzeuge[$i]['formAttr']['class'] 	= '';
		$fahrzeuge[$i]['formAttr']['value'] 	= $fahrzeuge[$i]['id'];		
		if(!$this->input->post('f_'.$fahrzeuge[$i]['id']) == $fahrzeuge[$i]['id']) 
		{
			if(isset($einsatz['fahrzeug'][$fahrzeuge[$i]['id']])) $fahrzeuge[$i]['formAttr']['checked'] = 'checked'; 
		} 
		else $fahrzeuge[$i]['formAttr']['checked'] = 'checked';
	}

?>

<script type="text/javascript">
$(function() { 
	$(":date").dateinput({
		format: 'dd.mm.yyyy',	
	});
});          
</script>

<div id='content'>
<div id='einsatz_create'>
<?=form_open($this->session->userdata('einsatzedit_submit').'/save', $form);?>

<table>
	<tr>
		<td><button type='submit' name='einsatz_submit' id='einsatz_submit' class='button_gross'><span class='button_save'>Speichern</span></button></td>
		<td><a href='<?=$this->session->userdata('einsatzliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
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
								<td><?=form_label('Anzahl Einsatzkräfte:', $einsatzAnzahl['id']); ?><br><?=form_input($einsatzAnzahl); ?></td>
							</tr>
						</table>
					</td>
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
				document.forms['einsatz'].elements['einsatzname'].focus();
			</script>
		</td>
	</tr>
</table>
    </p>
    <?=form_fieldset_close();?>
</div>

<div style="clear:both;"></div>
</div>