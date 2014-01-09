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
		'value' => set_value('geburtstag')
	);
	$beruf = array(
		'name'	=> 'beruf',
		'id'	=> 'beruf',
		'class' => 'input_text',
		'value' => set_value('beruf')
	);
	
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
	$funktion_options[0] = 'Vorlage wählen...';
	foreach($funktionen as $funktion)
	{
		$funktion_options[$funktion->id] = $funktion->name;	
	}
	
	$abteilung_options = array();
	$abteilung_attr = "class = 'input_dropdown' id = 'input_dropdown'";
	foreach($abteilungen as $abteilung)
	{
		$abteilung_options[$abteilung->id] = $abteilung->name;	
	}
	
	$team_options = array();
	$team_attr = "class = 'input_dropdown' id = 'input_dropdown'";
	foreach($teams as $team)
	{
		$team_options[$team->id] = $team->name;	
	}
?>

<div id='content'>
<div id='mannschaft_create'>
<?=form_open($this->session->userdata('mannschaftcreate_submit').'/save', $form);?>

    <table>
        <tr>
            <td><button type='submit' name='mannschaft_submit' id='mannschaft_submit' class='button_gross'><span class='button_save'>Mitglied anlegen</span></button></td>
            <td><a href='<?=$this->session->userdata('mannschaftliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
            <td><button type='reset' name='mannschaft_submit' id='mannschaft_submit' class='button_gross'><span class='button_reset'>Zurücksetzen</span></button></td>
        </tr>
    </table>
    <br>
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
                        <td class='form_label'><?=form_label('AAO', $mannschaftAAO['id']); ?></td>
                        <td><?=form_input($mannschaftAAO); ?></td>
                    </tr>

                <script type="text/javascript" language="JavaScript">
                    document.forms['<?=$form['id']?>'].elements['<?=$mannschaftName['id']?>'].focus();
                </script>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
</div>

<div style="clear:both;"></div>
</div>
