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
	if(!$value = set_value('einsatzort')) $value = $einsatz['einsatzort'];
	$einsatzOrt = array(
		'name'	=> 'einsatzort',
		'id'	=> 'einsatzort',
		'class' => 'input_text',
		'value' => $value
	);
    
    $displayeinsatzOrt['formAttr']['name']  = 'display_einsatzort';
    $displayeinsatzOrt['formAttr']['id']    = 'display_einsatzort';
    $displayeinsatzOrt['formAttr']['class'] = '';
    $displayeinsatzOrt['formAttr']['value'] = '1';
    if(!$this->input->post($displayeinsatzOrt['formAttr']['id']))
    {
        if($einsatz['display_einsatzort'] == 1)
            $displayeinsatzOrt['formAttr']['checked'] = 'checked';
    }
    else
        $displayeinsatzOrt['formAttr']['checked'] = 'checked';
         
	if(!$value = set_value('einsatznr')) $value = $einsatz['einsatzNr'];
	$einsatzNr = array(
		'name'  => 'einsatznr',
		'id' 	=> 'einsatznr',
		'class' => 'input_small',
              'readonly'    => 'readonly',
		'value' => $value
	);
	if(!$value = set_value('einsatzdatum_beginn')) $value = $einsatz['datum_beginn'];
	$einsatzDatumBeginn = array(
		'name'	=> 'einsatzdatum_beginn',
		'id'	=> 'einsatzdatum_beginn',
		'type'	=> 'date',
		'class' => 'input_date',
		'value' => $value
	);
	if(!$value = set_value('einsatzdatum_ende')) $value = $einsatz['datum_ende'];
	$einsatzDatumEnde = array(
		'name'	=> 'einsatzdatum_ende',
		'id'	=> 'einsatzdatum_ende',
		'type'	=> 'date',
		'class' => 'input_date',
		'value' => $value
	);
	if(!$value = set_value('einsatzuhrzeit_beginn')) $value = $einsatz['uhrzeit_beginn'];
	$einsatzBeginn = array(
		'name'	=> 'einsatzuhrzeit_beginn',
		'id'	=> 'einsatzuhrzeit_beginn',
		'class' => 'input_time',
		'value' => $value
	);
	if(!$value = set_value('einsatzuhrzeit_ende')) $value = $einsatz['uhrzeit_ende'];
	$einsatzEnde = array(
		'name'	=> 'einsatzuhrzeit_ende',
		'id'	=> 'einsatzuhrzeit_ende',
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
	if(!$value = set_value('einsatzbericht')) $value = $einsatz['einsatzbericht'];
	$einsatzBericht = array(
		'name' 	=> 'einsatzbericht',
		'id'	=> 'einsatzbericht',
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
	if(!$value = set_value('anzahl_einsaetze')) $value = $einsatz['anzahl_einsaetze'];
    $einsatzAnzahlEinsaetze = array(
        'name'  => 'anzahl_einsaetze',
        'id'    => 'anzahl_einsaetze',
        'class' => 'input_time',
        'value' => $value
    );
	
	for($i = 0; $i < count($types); $i++)
	{
		$types[$i]['formAttr']['name'] 			= 'einsatztyp';
		$types[$i]['formAttr']['id']			= 't_'.$types[$i]['typeID'];
		$types[$i]['formAttr']['class']			= '';
		$types[$i]['formAttr']['value']			= $types[$i]['typeID'];
        
		if(!$this->input->post('einsatztyp') == $types[$i]['typeID'])
		{
			if(isset($einsatz['typeID']) && $einsatz['typeID'] == $types[$i]['formAttr']['value']) $types[$i]['formAttr']['checked'] = 'checked';	
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
    
    $ueberoertlich['formAttr']['name']  = 'ueberoertlich';
    $ueberoertlich['formAttr']['id']    = 'ueberoertlich';
    $ueberoertlich['formAttr']['class'] = '';
    $ueberoertlich['formAttr']['value'] = '1';
    if(!$this->input->post($ueberoertlich['formAttr']['id']))
    {
        if($einsatz['ueberoertlich'] == 1)
            $ueberoertlich['formAttr']['checked'] = 'checked';
    }
    else
        $ueberoertlich['formAttr']['checked'] = 'checked'; 
	
	if(isset($_POST['einsatzstichwort'])) 		       	$cues_selected = $_POST['einsatzstichwort'];
	else if(isset($einsatz['cueID']))	             	$cues_selected = $einsatz['cueID'];
	else												$cues_selected = 0;	
    $cues_options = array();
	$cues_options[0] = 'Stichwort wählen...';
    $cues_attr = "class = 'input_dropdown' id = 'input_dropdown'";
    foreach($cues as $cue)
    {
        $cues_options[$cue['cue_id']] = $cue['name'];
    }

?>

<script type="text/javascript">
$(function() { 
	$.timepicker.regional['de'] = {
                hourText: 'Stunde',
                minuteText: 'Minuten',
                amPmText: ['AM', 'PM'] ,
                closeButtonText: 'Beenden',
                nowButtonText: 'Jetzt',                
                deselectButtonText: 'Zur&uuml;cksetzen' }
    $.timepicker.setDefaults($.timepicker.regional['de']);
    $('.input_time').timepicker({
        showNowButton: true,
        showDeselectButton: true,
        showPeriodLabels: false,
        defaultTime: '',  // removes the highlighted time for when the input is empty.
        showCloseButton: true
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
                    <td><?=form_label('Einsatz-Nr.:', $einsatzNr['id']); ?></td>
                    <td colspan="2"><?=form_input($einsatzNr); ?></div></td>
                </tr>
				<tr>
					<td class='form_label'><?=form_label('Einsatzname:', $einsatzName['id']); ?></td>
					<td colspan="2"><?=form_input($einsatzName); ?></td>
				</tr>
                <tr>
                    <td><?=form_label('Datum, Uhrzeit (Beginn)', $einsatzDatumBeginn['id']); ?></td>
                    <td colspan="2"><?=form_input($einsatzDatumBeginn); ?>&nbsp;<?=form_input($einsatzBeginn); ?></td>
                </tr>
                <tr>
                    <td><?=form_label('Datum, Uhrzeit (Ende):', $einsatzDatumEnde['id']); ?></td>
                    <td colspan="2"><?=form_input($einsatzDatumEnde); ?>&nbsp;<?=form_input($einsatzEnde); ?></td>
                </tr>
                <tr>
                    <td><?=form_label('Anzahl Einsatzkräfte:', $einsatzAnzahl['id']); ?></td>
                    <td colspan="2"><?=form_input($einsatzAnzahl); ?></td>
                </tr>
                <tr>
                    <td><?=form_label('Anzahl Einsätze:', $einsatzAnzahlEinsaetze['id']); ?></td>
                    <td colspan="2"><?=form_input($einsatzAnzahlEinsaetze); ?> (tatsächliche Anzahl unter dieser Nummer geführter Einsätze)</td>
                </tr>
                <tr>
                    <td class='form_label'><?=form_label('Einsatzort:', $einsatzOrt['id']); ?></td>
                    <td><?=form_input($einsatzOrt); ?></td>
                    <td style="width: 180px"><?=form_checkbox($displayeinsatzOrt['formAttr']); ?> <?=form_label('im Frontend anzeigen', $displayeinsatzOrt['formAttr']['id']); ?></td>
                </tr>
                <!--<tr>
                    <td></td><td><?=form_checkbox($displayeinsatzOrt['formAttr']); ?> <?=form_label('anzeigen', $displayeinsatzOrt['formAttr']['id']); ?></td>
                </tr>-->
				<tr>
					<td><?=form_label('Kurze Lagemeldung:', $einsatzLage['id']); ?></td>
					<td colspan="2"><?=form_textarea($einsatzLage); ?></td>
				</tr>
				<tr>
					<td><?=form_label('Einsatzbericht:', $einsatzBericht['id']); ?></td>
					<td colspan="2"><?=form_textarea($einsatzBericht); ?></td>
				</tr>
				<tr>
					<td><?=form_label('Weitere Einsatzkräfte:', $einsatzKraefteW['id']); ?></td>
					<td colspan="2"><?=form_textarea($einsatzKraefteW); ?></td>
				</tr>
			</table>
		</td>
		<td>
			<table>	
                <tr>
                    <td colspan='2'><strong>Einsatzstichwort:</strong></td>
                </tr>
                <tr>
                    <td colspan='2'><?=form_dropdown('einsatzstichwort', $cues_options, $cues_selected, $cues_attr); ?></td>
                </tr>
                <tr><td colspan='2'>&nbsp;</td></tr>	
				<tr>
					<td colspan='2'><strong>Einsatzart:</strong></td>
				</tr>
			<? foreach($types as $t) { ?>
				<tr>
					<td colspan='2'><?=form_radio($t['formAttr']); ?> <?=form_label($t['typeName'], $t['formAttr']['id']); ?></td>
				</tr>
			<? } ?>
                    <tr>
                        <td colspan='2'><?=form_checkbox($ueberoertlich['formAttr']); ?> <?=form_label('Überörtlich', $ueberoertlich['formAttr']['id']); ?></td>
                    </tr>
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