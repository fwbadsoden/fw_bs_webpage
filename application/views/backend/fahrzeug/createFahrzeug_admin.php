<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');

	$form = array(
		'id'	 	=> 'fahrzeug'
	);	
	
	$fahrzeugName = array(
		'name'		=> 'fahrzeugname',
		'id'		=> 'fahrzeugname',
		'class' 	=> 'input_text',
		'value' 	=> set_value('fahrzeugname')
	);
	
	$fahrzeugNameLang = array(
		'name'		=> 'fahrzeugnamelang',
		'id'		=> 'fahrzeugnamelang',
		'class' 	=> 'input_text',
		'value' 	=> set_value('fahrzeugnamelang')
	);
	
	$fahrzeugRufname = array(
		'name'		=> 'fahrzeugrufname',
		'id'		=> 'fahrzeugrufname',
		'class' 	=> 'input_rufname',
		'value' 	=> set_value('fahrzeugrufname')
	);
	
	$prefix_options = array();
	if(isset($_POST['fahrzeugprefix'])) 			$prefix_selected = $_POST['fahrzeugprefix']; 
	else 											$prefix_selected = 'Florian Bad Soden';
	$prefix_attr 		= "class = 'input_dropdown' id = 'fahrzeugprefix'";
	$prefix_options['Florian Bad Soden'] 	= 'Florian Bad Soden';
	$prefix_options['Florian Main-Taunus'] 	= 'Florian Main-Taunus';	
	
	$fahrzeugText = array(
		'name' 		=> 'fahrzeugtext',
		'id'		=> 'fahrzeugtext',
		'class' 	=> 'tinymce',
		'value' 	=> set_value('fahrzeugtext')
	);
	
	$fahrzeugBesatzung = array(
		'name'		=> 'fahrzeugbesatzung',
		'id'		=> 'fahrzeugbesatzung',
		'class' 	=> 'input_leistung',
		'maxlength' => '3',
		'value' 	=> set_value('fahrzeugbesatzung')
	);
	
	$hersteller_options = array();
	if(isset($_POST['fahrzeughersteller'])) 			$hersteller_selected = $_POST['fahrzeughersteller'];
	else												$hersteller_selected = 0;	
	$hersteller_attr	= "class = 'input_dropdown' id = 'fahrzeughersteller'";
	$hersteller_options[0] 					= '';
	$hersteller_options['Mercedes-Benz'] 	= 'Mercedes-Benz';
	$hersteller_options['Volkswagen'] 		= 'Volkswagen';
	$hersteller_options['Iveco'] 			= 'Iveco';
	$hersteller_options['Mitsubishi'] 		= 'Mitsubishi';
	$hersteller_options['MAN'] 		          = 'MAN';
	
	$fahrzeugAufbau = array(
		'name'		=> 'fahrzeugaufbau',
		'id'		=> 'fahrzeugaufbau',
		'class' 	=> 'input_text',
		'maxlength' => '50',
		'value' 	=> set_value('fahrzeugaufbau')
	);
	
	$fahrzeugPumpe = array(
		'name'		=> 'fahrzeugpumpe',
		'id'		=> 'fahrzeugpumpe',
		'class' 	=> 'input_text',
		'value' 	=> set_value('fahrzeugpumpe')
	);
	
	$fahrzeugLoeschmittel = array(
		'name'		=> 'fahrzeugloeschmittel',
		'id'		=> 'fahrzeugloeschmittel',
		'class' 	=> 'input_text',
		'value' 	=> set_value('fahrzeugloeschmittel')
	);
	
	$fahrzeugBesonderheit = array(
		'name'		=> 'fahrzeugbesonderheit',
		'id'		=> 'fahrzeugbesonderheit',
		'class' 	=> 'input_text',
		'value' 	=> set_value('fahrzeugbesonderheit')
	);
	
	$fahrzeugLeistungKW = array(
		'name'		=> 'fahrzeugleistungkw',
		'id'		=> 'fahrzeugleistungkw',
		'class' 	=> 'input_leistung',
		'maxlength' => '4',
		'value' 	=> set_value('fahrzeugleistungkw')
	);
	
	$fahrzeugLeistungPS = array(
		'name'		=> 'fahrzeugleistungps',
		'id'		=> 'fahrzeugleistungps',
		'class' 	=> 'input_leistung',
		'maxlength' => '4',
		'value' 	=> set_value('fahrzeugleistungps')
	);
	
	$fahrzeugHoehe = array(
		'name'  	=> 'fahrzeughoehe',
		'id'		=> 'fahrzeughoehe',
		'class' 	=> 'input_leistung',
		'value'		=> set_value('fahrzeughoehe')
	); 
	
	$fahrzeugBreite = array(
		'name'  	=> 'fahrzeugbreite',
		'id'		=> 'fahrzeugbreite',
		'class'		=> 'input_leistung',
		'value'		=> set_value('fahrzeugbreite')
	); 
	
	$fahrzeugLaenge = array(
		'name'  	=> 'fahrzeuglaenge',
		'id'		=> 'fahrzeuglaenge',
		'class'		=> 'input_leistung',
		'value'		=> set_value('fahrzeuglaenge')
	); 
	
	$fahrzeugLeermasse = array(
		'name'  	=> 'fahrzeugleermasse',
		'id'		=> 'fahrzeugleermasse',
		'class'		=> 'input_leistung',
		'value'		=> set_value('fahrzeugleermasse')
	); 
	
	$fahrzeugGesamtmasse = array(
		'name'  	=> 'fahrzeuggesamtmasse',
		'id'		=> 'fahrzeuggesamtmasse',
		'class'		=> 'input_leistung',
		'value'		=> set_value('fahrzeuggesamtmasse')
	);
?>

<div id='content'>
<div id='fahrzeug_create'>
<?=form_open($this->session->userdata('fahrzeugcreate_submit').'/save', $form);?>

	<table>
        <tr>
            <td><button type='submit' name='fahrzeug_submit' id='fahrzeug_submit' class='button_gross'><span class='button_save'>Fahrzeug anlegen</span></button></td>
            <td><a href='<?=$this->session->userdata('fahrzeugliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
            <td><button type='reset' name='fahrzeug_submit' id='fahrzeug_submit' class='button_gross'><span class='button_reset'>Zurücksetzen</span></button></td>
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
                        <td class='form_label'><?=form_label('Fahrzeugname (lang):', $fahrzeugNameLang['id']); ?></td>
                        <td><?=form_input($fahrzeugNameLang); ?></td>
                    </tr>
					<tr><td></td></tr>
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
					<tr><td></td></tr>
                    <tr>
                        <td class='form_label'><?=form_label('Hersteller:', 'fahrzeughersteller'); ?></td>
                        <td><?=form_dropdown('fahrzeughersteller', $hersteller_options, $hersteller_selected, $hersteller_attr)?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Aufbauhersteller:', $fahrzeugAufbau['id']); ?></td>
                        <td><?=form_input($fahrzeugAufbau); ?></td>
                    </tr>
					<tr><td></td></tr>
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
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Zusatzdaten Löschfahrzeug (nur bei Löschfahrzeugen pflegen):&nbsp;&nbsp;&nbsp;');?>
   	<p>
   	<table>
        <tr>
            <td>Bei mehreren Einträgen pro Feld sind die Einträge durch | zu trennen.</td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class='form_label'><?=form_label('Pumpe(n):', $fahrzeugPumpe['id']); ?></td>
                        <td><?=form_input($fahrzeugPumpe); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Löschmittel:', $fahrzeugLoeschmittel['id']); ?></td>
                        <td><?=form_input($fahrzeugLoeschmittel); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
	</p>
    <?=form_fieldset_close();?>
    <p></p>    
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Zusatzdaten sonstige Fahrzeuge (nicht bei Löschfahrzeugen pflegen):&nbsp;&nbsp;&nbsp;');?>
   	<p>
   	<table>
        <tr>
            <td>Bei mehreren Einträgen pro Feld sind die Einträge durch | zu trennen.</td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class='form_label'><?=form_label('Besonderheit:', $fahrzeugBesonderheit['id']); ?></td>
                        <td><?=form_input($fahrzeugBesonderheit); ?></td>
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
    <p></p>
    <script type="text/javascript" language="JavaScript">
    	document.forms['<?=$form['id']?>'].elements['<?=$fahrzeugName['id']?>'].focus();
    </script>
</div>

<div style="clear:both;"></div>
</div>