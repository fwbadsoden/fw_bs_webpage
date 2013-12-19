<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 => 'mofo',
	);	
	$mofoKeyword = array(
		'name'	=> 'keyword',
		'id'	=> 'keyword',
		'value' => AUTOSUGGEST_KEY_MOFO
	);
	if(!$value = set_value('value')) $value = $mofo->value;
	$mofoValue = array(
		'name'	=> 'value',
		'id'	=> 'value',
		'class' => 'input_text',
		'value' => $value
	);
?>

<div id='content'>
<div id='mofo_create'>
<?=form_open($this->session->userdata('mofoedit_submit').'/save', $form);?>
<?=form_hidden($mofoKeyword); ?>

    <table>
        <tr>
            <td><button type='submit' name='mofo_submit' id='mofo_submit' class='button_gross'><span class='button_save'>Speichern</span></button></td>
            <td><a href='<?=$this->session->userdata('mofoliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
        </tr>
    </table>
    <br>
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Daten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
    <table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
                    <tr>
                        <td class='form_label'><?=form_label('Wert', $mofoValue['id']); ?></td>
                        <td><?=form_input($mofoValue); ?></td>
                    </tr>

                <script type="text/javascript" language="JavaScript">
                    document.forms['<?=$form['id']?>'].elements['<?=$mofoValue['id']?>'].focus();
                </script>
        </tr>
    </table>
    </p>
    <?=form_fieldset_close();?>
</div>

<div style="clear:both;"></div>
</div>
