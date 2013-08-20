<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 	=> 'newskategorie',
	);	
	
	$title = array(
		'name'		=> 'title',
		'id'		=> 'title',
		'class' 	=> 'input_text',
		'value' 	=> set_value('title')
	);
	
?>

<div id='content'>
<div id='kategorie_create'>
<?=form_open($this->session->userdata('kategoriecreate_submit').'/save', $form);?>

	<table>
        <tr>
            <td><button type='submit' name='kategorie_submit' id='kategorie_submit' class='button_gross'><span class='button_save'>News Kategorie anlegen</span></button></td>
            <td><a href='<?=$this->session->userdata('kategorieliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
            <td><button type='reset' name='kategorie_submit' id='kategorie_submit' class='button_gross'><span class='button_reset'>Zurücksetzen</span></button></td>
        </tr>
    </table>
    <br>
    
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Kategoriedaten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
   	<table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class='form_label'><?=form_label('Titel:', $title['id']); ?></td>
                        <td><?=form_input($title); ?></td>
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