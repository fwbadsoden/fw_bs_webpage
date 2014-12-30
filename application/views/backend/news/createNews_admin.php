<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 	=> 'news',
	);	
	
	$title = array(
		'name'		=> 'title',
		'id'		=> 'title',
		'class' 	=> 'input_text',
		'value' 	=> set_value('title')
	);
    
	$stage_title = array(
		'name'		=> 'stage_title',
		'id'		=> 'stage_title',
		'class' 	=> 'input_text',
		'value' 	=> set_value('stage_title')
	);
    
    $valid_from = array(
        'name'      => 'valid_from',
        'id'        => 'valid_from',
		'type'	    => 'date',
		'class'     => 'input_date',
        'readonly'  => 'readonly',
        'value'     => set_value('valid_from', date('Y-m-d'))
    );
    
    $valid_from_time = array(
        'name'      => 'valid_from_time',
        'id'        => 'valid_from_time',
		'class'     => 'input_time',
        'value'     => set_value('valid_from_time')
    );
    
    $valid_to = array(
        'name'      => 'valid_to',
        'id'        => 'valid_to',
		'type'	    => 'date',
		'class'     => 'input_date',
        'value'     => set_value('valid_to')
    );
    
    $valid_to_time = array(
        'name'      => 'valid_to_time',
        'id'        => 'valid_to_time',
		'class'     => 'input_time',
        'value'     => set_value('valid_to_time')
    );
	
	$teaser = array(
		'name'		=> 'teaser',
		'id'		=> 'teaser',
		'class' 	=> 'tinymce',
		'value' 	=> set_value('teaser')
	);
	
	$text = array(
		'name'		=> 'text',
		'id'		=> 'text',
		'class' 	=> 'tinymce',
		'value' 	=> set_value('text')
	);
    
    $teaser_options = array();
	$teaser_attr = "class = 'input_dropdown' id = 'input_dropdown'";
    $teaser_options[0] = 'kein Bild';
	foreach($teaser_images as $image)
	{
		$teaser_options[$image['fileID']] = $image['name'];	
	} 
    
    $ogimg_options = array();
    $ogimg_attr = "class = 'input_dropdown' id = 'input_dropdown'";
    $ogimg_options[0] = 'kein Bild';
	foreach($ogimg_images as $image)
	{
		$ogimg_options[$image['fileID']] = $image['name'];	
	} 
    
    $cat_options = array();
	$cat_attr = "class = 'input_dropdown' id = 'input_dropdown'";
	foreach($categories as $cat)
	{
		$cat_options[$cat['categoryID']] = $cat['title'];	
	} 
?>
<!-- Timepicker URL http://fgelinas.com/code/timepicker/ -->
<script src="<?=base_url('js/jquery.ui.timepicker.js')?>"></script>
<script type="text/javascript">
$(function() {
    $.timepicker.regional['de'] = {
                hourText: 'Stunde',
                minuteText: 'Minuten',
                amPmText: ['AM', 'PM'] ,
                closeButtonText: 'Beenden',
                nowButtonText: 'Jetzt',                
                deselectButtonText: 'Zur&uuml;cksetzen' }
    $.timepicker.setDefaults($.timepicker.regional['de']);
    $('.input_time').timepicker({
        showNowButton: true,
        showDeselectButton: true,
        showPeriodLabels: false,
        defaultTime: '',  // removes the highlighted time for when the input is empty.
        showCloseButton: true
    });
});        
</script>

<div id='content'>
<div id='news_create'>
<?=form_open($this->session->userdata('newscreate_submit').'/save', $form);?>

	<table>
        <tr>
            <td><button type='submit' name='news_submit' id='news_submit' class='button_gross'><span class='button_save'>News anlegen</span></button></td>
            <td><a href='<?=$this->session->userdata('newsliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
            <td><button type='reset' name='news_submit' id='news_submit' class='button_gross'><span class='button_reset'>Zurücksetzen</span></button></td>
        </tr>
    </table>
    <br>
    
    <?=form_fieldset('&nbsp;&nbsp;&nbsp;Newsdaten:&nbsp;&nbsp;&nbsp;');?>
   	<p>
   	<table>
        <tr><td colspan="2"><?=validation_errors();?></td></tr>
        <tr>
            <td>
                <table>
                	<tr>
                        <td class='form_label'><?=form_label('Kategorie:', 'category_id'); ?></td>
                    	<td><?=form_dropdown('category_id', $cat_options, 0, $cat_attr)?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Titel:', $title['id']); ?></td>
                        <td><?=form_input($title); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Titel für Bildbühne:', $stage_title['id']); ?></td>
                        <td><?=form_input($stage_title); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Gültig ab:', $valid_from['id']); ?></td>
                        <td><?=form_input($valid_from); ?><!--<?=form_input($valid_from_time)?>--></td>
                    </tr>
                	<tr>
                        <td class='form_label'><?=form_label('Teaserbild:', 'teaser_img'); ?></td>
                    	<td><?=form_dropdown('teaser_img', $teaser_options, 0, $teaser_attr)?></td>
                    </tr>
                	<tr>
                        <td class='form_label'><?=form_label('Facebookbild:', 'og_img'); ?></td>
                    	<td><?=form_dropdown('og_img', $ogimg_options, $ogimg_selected, $ogimg_attr)?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Teaser:', $teaser['id']); ?></td>
                        <td><?=form_textarea($teaser); ?></td>
                    </tr>
                    <tr>
                        <td class='form_label'><?=form_label('Text:', $text['id']); ?></td>
                        <td><?=form_textarea($text); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
	</p>
    <?=form_fieldset_close();?>
    <p></p>
    <script type="text/javascript" language="JavaScript">
    	document.forms['<?=$form['id']?>'].elements['<?=$title['id']?>'].focus();
    </script>
</div>

<div style="clear:both;"></div>
</div>