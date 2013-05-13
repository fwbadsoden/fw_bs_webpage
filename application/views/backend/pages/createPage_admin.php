<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 => 'page',
	);
    
    $pageName = array(
        'name'  => 'pagename',
        'id'    => 'pagename',
        'class' => 'input_text',
        'value' => set_value('pagename')
    );
    
    $stage_options = array();
	$stage_attr = "class = 'input_dropdown' id = 'input_dropdown'";
    $stage_options[0] = 'keine Bildb&uuml;hne';
	foreach($stages as $stage)
	{  
		$stage_options[$stage['stageID']] = $stage['name'];	
	}
    
    $templ_options = array();
	$templ_attr = "class = 'input_dropdown' id = 'input_dropdown'";
	foreach($templates as $templ)
	{  
		$templ_options[$templ['templateID']] = $templ['templateName'];	
	}
    if(count($templates) == 1) $templ_attr .= ' disabled="disabled"';
?>
   
<div id='content'>
<div id='page_create'>
<?=form_open($this->session->userdata('pagecreate_submit').'/save', $form);?>

    <table>
        <tr>
            <td><button type='submit' name='page_submit' id='page_submit' class='button_gross'><span class='button_save'>Seite anlegen</span></button></td>
            <td><a href='<?=$this->session->userdata('pageliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zur&uuml;ck</span></a></td>
            <td><button type='reset' name='page_submit' id='page_submit' class='button_gross'><span class='button_reset'>Zur&uuml;cksetzen</span></button></td>
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
                        <td class='form_label'><?=form_label('Seitenname:', $pageName['id']); ?></td>
                        <td><?=form_input($pageName); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'>Vorlage:</td>
                        <td><?=form_dropdown('templateid', $templ_options, 0, $templ_attr); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
    <br />
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Layout-Elemente:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class='form_label'>Bildb&uuml;hne:</td>
                        <td><?=form_dropdown('stageid', $stage_options, 0, $stage_attr); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
</div>

<div style="clear:both;"></div>
</div>