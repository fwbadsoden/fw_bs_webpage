<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 => 'stichwort',
	);	
	$name = array(
		'name'	=> 'name',
		'id'	=> 'name',
		'class' => 'input_text',
		'value' => set_value('name')
	);
	$vorname = array(
		'name'	=> 'vorname',
		'id'	=> 'vorname',
		'class' => 'input_text',
		'value' => set_value('vorname')
	);
	$geburtstag = array(
		'name'	=> 'geburtstag',
		'id'	=> 'geburtstag',
		'class' => 'input_date',
        'type'  => 'date',
		'value' => set_value('geburtstag')
	);
	$beruf = array(
		'name'	=> 'beruf',
		'id'	=> 'beruf',
		'class' => 'input_text',
		'value' => set_value('beruf')
	);
    
    $show_img['formAttr']['name']  = 'show_img';
    $show_img['formAttr']['id']    = 'show_img';
    $show_img['formAttr']['class'] = '';
    $show_img['formAttr']['value'] = '1';
    if($this->input->post($show_img['formAttr']['id']))
        $show_img['formAttr']['checked'] = 'checked';
    else
        $show_img['formAttr']['checked'] = '';  
    
    $show_beruf['formAttr']['name']  = 'show_beruf';
    $show_beruf['formAttr']['id']    = 'show_beruf';
    $show_beruf['formAttr']['class'] = '';
    $show_beruf['formAttr']['value'] = '1';
    if($this->input->post($show_beruf['formAttr']['id']))
        $show_beruf['formAttr']['checked'] = 'checked';
    else
        $show_beruf['formAttr']['checked'] = '';
    
    $show_geburtstag['formAttr']['name']  = 'show_geburtstag';
    $show_geburtstag['formAttr']['id']    = 'show_geburtstag';
    $show_geburtstag['formAttr']['class'] = '';
    $show_geburtstag['formAttr']['value'] = '1';
    if($this->input->post($show_geburtstag['formAttr']['id']))
        $show_geburtstag['formAttr']['checked'] = 'checked';
    else
        $show_geburtstag['formAttr']['checked'] = '';
    
    
	
    $gender_options = array();
    $gender_attr = "class = 'input_dropdown' id = 'input_dropdown'";
	$gender_options['m'] = 'männlich';
	$gender_options['w'] = 'weiblich';
	
	$dienstgrad_options = array();
	$dienstgrad_attr = "class = 'input_dropdown' id = 'input_dropdown'";
	foreach($dienstgrade as $dienstgrad)
	{
		$dienstgrad_options[$dienstgrad->id] = $dienstgrad->name;	
	}
	
	$funktion_options = array();
	$funktion_attr = "class = 'input_dropdown' id = 'input_dropdown'";
	$funktion_options[0] = 'keine';
	foreach($funktionen as $funktion)
	{
		$funktion_options[$funktion->id] = $funktion->name;	
	}
?>

<div id='content'>
<div id='mitglied_create'>
<?=form_open($this->session->userdata('mitgliedcreate_submit').'/save', $form);?>

    <table>
        <tr>
            <td><button type='submit' name='mitglied_submit' id='mitglied_submit' class='button_gross'><span class='button_save'>Mitglied anlegen</span></button></td>
            <td><a href='<?=$this->session->userdata('mannschaftliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
            <td><button type='reset' name='mitglied_submit' id='mitglied_submit' class='button_gross'><span class='button_reset'>Zurücksetzen</span></button></td>
        </tr>
    </table>
    <br/>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Persönliche Daten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
                    <tr>
                        <td class='form_label'><?=form_label('Nachname:', $name['id']); ?></td>
                        <td><?=form_input($name); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Vorname:', $vorname['id']); ?></td>
                        <td><?=form_input($vorname); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Geschlecht:'); ?></td>
                    	<td><?=form_dropdown('geschlecht', $gender_options, 'm', $gender_attr)?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Geburtstag', $geburtstag['id']); ?></td>
                        <td><?=form_input($geburtstag); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Beruf', $beruf['id']); ?></td>
                        <td><?=form_input($beruf); ?></td>
                    </tr>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
    <br />
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Dienstgrad usw.:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
                    <tr>
                        <td class='form_label'>Führungsfunktion:</td>
                    	<td><?=form_dropdown('funktionID', $funktion_options, 0, $funktion_attr)?></td>
                    </tr>
                    <tr>
                        <td class='form_label'>Dienstgrad:</td>
                    	<td><?=form_dropdown('dienstgradID', $dienstgrad_options, 0, $dienstgrad_attr)?></td>
                    </tr>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
    <br/>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Anzeigesteuerung:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
                    <tr>
                        <td>Bild anzeigen?</td>
                        <td><?=form_checkbox($show_img['formAttr']); ?></td>
                    </tr>
                    <tr>
                        <td>Geburtstag anzeigen?</td></td>
                        <td><?=form_checkbox($show_geburtstag['formAttr']); ?></td>
                    </tr>
                    <tr>
                        <td>Beruf anzeigen?</td></td>
                        <td><?=form_checkbox($show_beruf['formAttr']); ?></td>
                    </tr>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>

                <script type="text/javascript" language="JavaScript">
                    document.forms['<?=$form['id']?>'].elements['<?=$name['id']?>'].focus();
                </script>
</div>

<div style="clear:both;"></div>
</div>
