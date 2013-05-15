<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 	=> 'route',
	);	
	
	$routeName = array(
		'name'		=> 'route',
		'id'		=> 'route',
		'class' 	=> 'input_text',
		'value' 	=> set_value('route')
	);
	
	$bereich_options = array();
	if(isset($_POST['bereich'])) 			$bereich_selected = $_POST['bereich']; 
	else $bereich_selected = 0;
	$bereich_attr 		= "class = 'input_dropdown' id = 'bereich'";	
	$bereich_options['Backend'] 	= 'Backend';
	$bereich_options['Frontend'] 	= 'Frontend';
    $bereich_selected = 'Backend';
	
	$modul_options = array();
	if(isset($_POST['modul'])) 			$modul_selected = $_POST['modul']; 
	else $modul_selected = 0;
	$modul_attr 		= "class = 'input_dropdown' id = 'modul'";	
	foreach($module as $item)
	{
		$modul_options[$item['moduleID']] 	= $item['moduleName'];
	}
	
	$linkName = array(
		'name'		=> 'link',
		'id'		=> 'link',
		'class' 	=> 'input_text',
		'value' 	=> set_value('link')
	);
	
?>

<div id='content'>
<div id='route_create'>
<?=form_open($this->session->userdata('routecreate_submit').'/save', $form);?>

	<table>
        <tr>
            <td><button type='submit' name='route_submit' id='route_submit' class='button_gross'><span class='button_save'>CI Route anlegen</span></button></td>
            <td><a href='<?=$this->session->userdata('routeliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
            <td><button type='reset' name='route_submit' id='route_submit' class='button_gross'><span class='button_reset'>Zurücksetzen</span></button></td>
        </tr>
    </table>
    <br>
    
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Routendaten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
   	<table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class='form_label'><?=form_label('Bereich:', 'bereich'); ?></td>
                        <td><?=form_dropdown('bereich', $bereich_options, $bereich_selected, $bereich_attr)?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Modul:', 'modul'); ?></td>
                        <td><?=form_dropdown('modul', $modul_options, $modul_selected, $modul_attr)?></td>
                    </tr>
					<tr><td></td></tr>
                    <tr>
                        <td class='form_label'><?=form_label('Route:', $routeName['id']); ?></td>
                        <td><?=form_input($routeName); ?></td>
                    </tr>
					<tr><td></td></tr>
                    <tr>
                        <td class='form_label'><?=form_label('Link:', $linkName['id']); ?></td>
                        <td><?=form_input($linkName); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
	</p>
    <?=form_fieldset_close();?>
    <p></p>
    <script type="text/javascript" language="JavaScript">
    	document.forms['<?=$form['id']?>'].elements['<?=$route['id']?>'].focus();
    </script>
</div>

<div style="clear:both;"></div>
</div>