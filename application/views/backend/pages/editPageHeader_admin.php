<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 => 'page',
	);
    
	if(!$value = set_value('pagename')) $value = $page['pageName'];
    $pageName = array(
        'name'  => 'pagename',
        'id'    => 'pagename',
        'class' => 'input_text',
        'value' => $value
    );    
    
    $stage_options = array();
	$stage_attr = "class = 'input_dropdown' id = 'input_dropdown'";
    $stage_options[0] = 'keine Bildb&uuml;hne';
	foreach($stages as $stage)
	{  
		$stage_options[$stage['stageID']] = $stage['name'];	
	}
?>
   
<div id='content'>
<div id='page_edit'>
<?=form_open($this->session->userdata('pageedit_submit').'/save', $form);?>

<table>
    <tr>
        <td><button type='submit' name='page_submit' id='page_submit' class='button_gross'><span class='button_save'>Seite speichern</span></button></td>
<? if($page['is_deletable']) { ?>        
        <td><a href='<?=base_url('admin/content/page/checkdelete/'.$page['pageID'])?>' target='_top' class="button_gross"><span class="button_delete">L&ouml;schen</span></a></td>
<? } ?>        
        <td><a href='<?=$this->session->userdata('pageliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zur&uuml;ck</span></a></td>
    </tr>
</table>
<br/>
<?=form_fieldset('&nbsp;&nbsp;&nbsp;Grunddaten:&nbsp;&nbsp;&nbsp;');?>
<p>
    <table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class='form_label'><?=form_label('Seitenname:', $pageName['id']);?></td>
                        <td><?=form_input($pageName);?></td>
                    </tr>
                    <tr>
                        <td class='form_label'>Vorlage:</td>
                        <td><?=$content['templateName']?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</p>
<?=form_fieldset_close();?>
<br/>
<?=form_fieldset('&nbsp;&nbsp;&nbsp;Layout Elemente:&nbsp;&nbsp;&nbsp;');?>
<p>
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class='form_label'>Bildb&uuml;hne:</td>
                        <td><?=form_dropdown('stageid', $stage_options, set_value('stageid', $page['stageID']), $stage_attr)?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</p>
<?=form_fieldset_close();?>
<br/>
<?=form_fieldset('&nbsp;&nbsp;&nbsp;Inhaltselemente:&nbsp;&nbsp;&nbsp;');?>
<p>
<table>
    <tr>
        <td><a href="<?=base_url('admin/content/page/row/add/'.$page['pageID'])?>" class="button_gross" title="Zeile hinzuf&uuml;gen"><span class='button_add'>Zeile hinzuf&uuml;gen</span></a></td>
    </tr>
    
                