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
    
    $templ_options = array();
	$templ_attr = "class = 'input_dropdown' id = 'input_dropdown'";
	foreach($templates as $templ)
	{  
		$templ_options[$templ['templateID']] = $templ['templateName'];	
	}
    if(count($templates) == 1 || count($content) > 0) $templ_params = 'disabled="disabled"';
    else $templ_params = '';
    if(isset($_POST['templateID'])) $selected = $_POST['templateid']; 
    else if(isset($page['templateID'])) $selected = $page['templateID'];
    else $selected = 0;
?>
   
<div id='content'>
<div id='page_edit'>
<?=form_open($this->session->userdata('pageedit_submit').'/save', $form);?>

<table>
    <tr>
        <td><button type='submit' name='page_submit' id='page_submit' class='button_gross'><span class='button_save'>Seite speichern</span></button></td>
        <td><a href='<?=base_url('admin/content/page/checkdelete/'.$page['pageID'])?>' target='_top' class="button_gross"><span class="button_delete">L&ouml;schen</span></a></td>
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
                        <td class='form_label'><?=form_label('Seitenname:', $pageName['id']); ?></td>
                        <td><?=form_input($pageName); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'>Vorlage w&auml;hlen:</td>
                        <td><?=form_dropdown('templateid', $templ_options, $selected, $templ_params); ?></td>
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
            <td>
                <table>
                    <tr>
                        <td><a href="<?=base_url('admin/content/page/addrow/'.$page['pageID'])?>" class="button_mini" title="Zeile hinzuf&uuml;gen"><span class='button_add_small'></span></a></td><td>Zeile hinzuf&uuml;gen</td>
                    </tr>
                </table>
                <br />