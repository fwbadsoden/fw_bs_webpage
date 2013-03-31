<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');

	$form = array(
		'id'	 	=> 'fahrzeug'
	);	
	
	if(!$value = set_value('fahrzeugname')) $value = $fahrzeug['fahrzeugName'];
	$fahrzeugName = array(
		'name'		=> 'fahrzeugname',
		'id'		=> 'fahrzeugname',
		'class' 	=> 'input_text',
		'value' 	=> $value
	);
	
	if(!$value = set_value('fahrzeugrufname')) $value = $fahrzeug['fahrzeugRufname'];
	$fahrzeugRufname = array(
		'name'		=> 'fahrzeugrufname',
		'id'		=> 'fahrzeugrufname',
		'class' 	=> 'input_rufname',
		'value' 	=> $value
	);
	
	$prefix_options = array();
	if(isset($_POST['fahrzeugprefix'])) 				$prefix_selected = $_POST['fahrzeugprefix']; 
	else if(isset($fahrzeug['fahrzeugRufnamePrefix'])) 	$prefix_selected = $fahrzeug['fahrzeugRufnamePrefix'];	
	else 												$prefix_selected = 'Florian Bad Soden';
	$prefix_attr 		= "class = 'input_dropdown_fahrzeug' id = 'fahrzeugprefix'";
	$prefix_options['Florian Bad Soden'] 	= 'Florian Bad Soden';
	$prefix_options['Florian Main-Taunus'] 	= 'Florian Main-Taunus';	
	
	if(!$value = set_value('fahrzeugtext')) $value = $fahrzeug['fahrzeugText'];
	$fahrzeugText = array(
		'name' 		=> 'fahrzeugtext',
		'id'		=> 'fahrzeugtext',
		'class' 	=> 'tinymce',
		'value' 	=> $value
	);
	
	if(!$value = set_value('fahrzeugbesatzung')) $value = $fahrzeug['fahrzeugBesatzung'];
	$fahrzeugBesatzung = array(
		'name'		=> 'fahrzeugbesatzung',
		'id'		=> 'fahrzeugbesatzung',
		'class' 	=> 'input_leistung',
		'maxlength' => '3',
		'value' 	=> $value
	);
	
	$hersteller_options = array();
	if(isset($_POST['fahrzeughersteller'])) 			$hersteller_selected = $_POST['fahrzeughersteller'];
	else if(isset($fahrzeug['fahrzeugHersteller']))		$hersteller_selected = $fahrzeug['fahrzeugHersteller'];
	else												$hersteller_selected = 0;	
	$hersteller_attr	= "class = 'input_dropdown_fahrzeug' id = 'fahrzeughersteller'";
	$hersteller_options[0] 					= '';
	$hersteller_options['Mercedes-Benz'] 	= 'Mercedes-Benz';
	$hersteller_options['Volkswagen'] 		= 'Volkswagen';
	$hersteller_options['Iveco'] 			= 'Iveco';
	$hersteller_options['Mitsubishi'] 		= 'Mitsubishi';
	
	if(!$value = set_value('fahrzeugaufbau')) $value = $fahrzeug['fahrzeugAufbau'];
	$fahrzeugAufbau = array(
		'name'		=> 'fahrzeugaufbau',
		'id'		=> 'fahrzeugaufbau',
		'class' 	=> 'input_text',
		'maxlength' => '50',
		'value' 	=> $value
	);
	
	if(!$value = set_value('fahrzeugleistungkw')) $value = $fahrzeug['fahrzeugLeistungKW'];
	$fahrzeugLeistungKW = array(
		'name'		=> 'fahrzeugleistungkw',
		'id'		=> 'fahrzeugleistungkw',
		'class' 	=> 'input_leistung',
		'maxlength' => '4',
		'value' 	=> $value
	);
	
	if(!$value = set_value('fahrzeugleistungps')) $value = $fahrzeug['fahrzeugLeistungPS'];
	$fahrzeugLeistungPS = array(
		'name'		=> 'fahrzeugleistungps',
		'id'		=> 'fahrzeugleistungps',
		'class' 	=> 'input_leistung',
		'maxlength' => '4',
		'value' 	=> $value
	);
	
	if(!$value = set_value('fahrzeughoehe')) $value = $fahrzeug['fahrzeugHoehe'];
	$fahrzeugHoehe = array(
		'name'  	=> 'fahrzeughoehe',
		'id'		=> 'fahrzeughoehe',
		'class' 	=> 'input_leistung',
		'value'		=>$value
	); 
	
	if(!$value = set_value('fahrzeugbreite')) $value = $fahrzeug['fahrzeugBreite'];
	$fahrzeugBreite = array(
		'name'  	=> 'fahrzeugbreite',
		'id'		=> 'fahrzeugbreite',
		'class'		=> 'input_leistung',
		'value'		=> $value
	); 
	
	if(!$value = set_value('fahrzeuglaenge')) $value = $fahrzeug['fahrzeugLaenge'];
	$fahrzeugLaenge = array(
		'name'  	=> 'fahrzeuglaenge',
		'id'		=> 'fahrzeuglaenge',
		'class'		=> 'input_leistung',
		'value'		=> $value
	); 
	
	if(!$value = set_value('fahrzeugleermasse')) $value = $fahrzeug['fahrzeugLeermasse'];
	$fahrzeugLeermasse = array(
		'name'  	=> 'fahrzeugleermasse',
		'id'		=> 'fahrzeugleermasse',
		'class'		=> 'input_leistung',
		'value'		=> $value
	); 
	
	if(!$value = set_value('fahrzeuggesamtmasse')) $value = $fahrzeug['fahrzeugGesamtmasse'];
	$fahrzeugGesamtmasse = array(
		'name'  	=> 'fahrzeuggesamtmasse',
		'id'		=> 'fahrzeuggesamtmasse',
		'class'		=> 'input_leistung',
		'value'		=> $value
	);
?>

<div id='content'>
<div id='fahrzeug_edit'>
<?=form_open($this->session->userdata('fahrzeugedit_submit').'/save', $form);?>

	<table>
        <tr>
            <td><button type='submit' name='fahrzeug_submit' id='fahrzeug_submit' class='button_gross'><span class='button_save'>Speichern</span></button></td>
            <td><a href='<?=$this->session->userdata('fahrzeugliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
        </tr>
    </table>
    <br>
    
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Grunddaten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
   	<table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class='form_label'><?=form_label('Fahrzeugname:', $fahrzeugName['id']); ?></td>
                        <td><?=form_input($fahrzeugName); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Präfix Funkrufname:', 'fahrzeugprefix'); ?></td>
                        <td><?=form_dropdown('fahrzeugprefix', $prefix_options, $prefix_selected, $prefix_attr)?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Funkrufname:', $fahrzeugRufname['id']); ?></td>
                        <td><?=form_input($fahrzeugRufname); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
	</p>
    <?=form_fieldset_close();?>
    <p></p>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Fahrzeugdaten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td><?=form_label('Beschreibung:', $fahrzeugText['id']); ?></td>
                        <td><?=form_textarea($fahrzeugText); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Hersteller:', 'fahrzeughersteller'); ?></td>
                        <td><?=form_dropdown('fahrzeughersteller', $hersteller_options, $hersteller_selected, $hersteller_attr)?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Aufbauhersteller:', $fahrzeugAufbau['id']); ?></td>
                        <td><?=form_input($fahrzeugAufbau); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Besatzung:', $fahrzeugBesatzung['id']); ?></td>
                        <td><?=form_input($fahrzeugBesatzung); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
	</p>
    <?=form_fieldset_close();?>
    <p></p>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Fahrzeugwerte:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class='form_label'><?=form_label('Leistung in KW:', $fahrzeugLeistungKW['id']); ?></td>
                        <td><?=form_input($fahrzeugLeistungKW); ?> KW</td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Leistung in PS:', $fahrzeugLeistungPS['id']); ?></td>
                        <td><?=form_input($fahrzeugLeistungPS); ?> PS</td>
                    </tr>
					<tr><td></td></tr>
                    <tr>
                        <td class='form_label'><?=form_label('Höhe:', $fahrzeugHoehe['id']); ?></td>
                        <td><?=form_input($fahrzeugHoehe); ?> m</td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Breite:', $fahrzeugBreite['id']); ?></td>
                        <td><?=form_input($fahrzeugBreite); ?> m</td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Länge:', $fahrzeugLaenge['id']); ?></td>
                        <td><?=form_input($fahrzeugLaenge); ?> m</td>
                    </tr>
					<tr><td></td></tr>
                    <tr>
                        <td class='form_label'><?=form_label('zulässige Gesamtmasse:', $fahrzeugGesamtmasse['id']); ?></td>
                        <td><?=form_input($fahrzeugGesamtmasse); ?> t</td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Leermasse:', $fahrzeugLeermasse['id']); ?></td>
                        <td><?=form_input($fahrzeugLeermasse); ?> t</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>   	
	</p>
    <?=form_fieldset_close();?>
    <script type="text/javascript" language="JavaScript">
    	document.forms['<?=$form['id']?>'].elements['<?=$fahrzeugName['id']?>'].focus();
    </script>
</div>

<div style="clear:both;"></div>
</div>