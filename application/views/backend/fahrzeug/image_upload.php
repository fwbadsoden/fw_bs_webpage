<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$form_upload = array(
		'id'	=> 'image_upload',
		'name'	=> 'image_upload'
	);
	$image_upload = array(
		'name'	=> 'upload_image',
		'maxLength' => '4000'
	);
	$alt_upload = array(
		'name' 	=> 'alt',
		'class' => 'bild_details'
	);
    $small_pic['formAttr']['name'] 			= 'img_small_pic';
	$small_pic['formAttr']['id']			    = 'img_small_pic';
	$small_pic['formAttr']['class']			= '';			
	$form_preview = array(
		'id' 	=> 'img_details',
		'name' 	=> 'img_details'
	);
	$alt_preview = array(
		'name' 	=> 'img_alt',
		'id'	=> 'img_alt',
		'class' => 'bild_details'
	);
	$breite_preview = array(
		'name' 	=> 'img_breite',
		'id'	=> 'img_breite',
		'class' => 'bild_details',
		'readonly' => 'readonly'
	);
	$hoehe_preview = array(
		'name' 	=> 'img_hoehe',
		'id'	=> 'img_hoehe',
		'class' => 'bild_details',
		'readonly' => 'readonly'
	);
?>

<script>
$(document).ready(function() 
{
	var i = 0;
	
 	$('a.preview_img').click(function() 
 	{ 	
		var data			= $(this).attr("id");
		var attributes  	= data.split('||');
		var myimage 		= new Image();
		myimage.src    		= attributes[0];
		var width 			= myimage.width;
		var height			= myimage.height;
		var alt				= attributes[1];
		var imgid			= attributes[2];
        var small_pic       = attributes[3];
		
		$('#img_id').val(imgid);
		$('#img_alt').val(alt);
		$('#img_breite').val(width);
		$('#img_hoehe').val(height);
        if(small_pic == 1) {
            $('#img_small_pic').prop('checked', true);
        }
		
		document.view_imagefiles.src = myimage.src;
		document.view_imagefiles.alt = alt;
		document.view_imagefiles.height = height;
		document.view_imagefiles.width = width;        
        if(small_pic == 1) {
            document.view_imagefiles.small_pic.checked = true;
		}
        
		if(i == 0) { $('.span_img_preview').toggle(); }
		i = 1;
	});
});
</script> 

<div id="content">
	
	<!-- Upload -->
	<h1>Bilderverwaltung für Fahrzeug "<?=$fahrzeug['fahrzeugName']?>"</h1>
	<?=form_open_multipart($this->session->userdata('fahrzeugimage_submit').'/save', $form_upload)?>
	<?=form_hidden('img_manager', 'img_upload');?>
	<?=form_fieldset('&nbsp;&nbsp;&nbsp;Bild hochladen:&nbsp;&nbsp;&nbsp;');?>
	<p>
		<table>
			<? if(isset($error)) { echo '<tr><td colspan="2"><p style="color: #FF0000;">'.$error.'</p></td></tr>'; } ?>
			<tr><td colspan='2'><?=form_upload($image_upload)?></td></tr>	
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr><td>Beschreibung:</td><td><?=form_input($alt_upload)?></td></tr>
            <tr><td colspan='2'><?=form_checkbox($small_pic['formAttr']); ?> <?=form_label('Bild für Einsatz (klein)', $small_pic['formAttr']['id']); ?></td></tr>            
			<tr><td colspan="2"></td></tr>
			<tr>
				<td><button type='submit' name='image_submit' id='image_submit' class='button_gross'><span class='button_save'>Hochladen</span></button></td>
				<td><a href='<?=$this->session->userdata('fahrzeugliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
			</tr>
		</table>
	</p>
	<?=form_fieldset_close();?>
    <?=form_close();?>
	
<? if(count($images) > 0) : ?>
	<p>&nbsp;</p>
	<span class="span_img_preview" style="display:none">
	<!-- Bildervorschau -->
	<?=form_open($this->session->userdata('fahrzeugimage_submit').'/save', $form_preview)?>
	<?=form_hidden('img_manager', 'img_edit');?>
	<?=form_fieldset('&nbsp;&nbsp;&nbsp;Bildervorschau:&nbsp;&nbsp;&nbsp;');?>
	<p>
		<table>
			<tr>
				<td style="vertical-align:top; width: 250px;">
					<table>
						<input type='hidden' name='img_id' value='' id='img_id' />
						<tr><td>Bildbeschreibung:</td><td><?=form_input($alt_preview)?></td></tr>
                        <tr><td colspan='2'><?=form_checkbox($small_pic['formAttr']); ?> <?=form_label('Bild für Einsatz (klein)', $small_pic['formAttr']['id']); ?></td></tr>   
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td>Breite:</td><td><?=form_input($breite_preview)?></td></tr>
						<tr><td>Höhe:</td><td><?=form_input($hoehe_preview)?></td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td><button type='submit' name='image_submit' id='image_submit' class='button_gross' value='img_save'><span class='button_save'>Speichern</span></button></td>
							<td><button type='submit' name='image_submit' id='image_submit' class='button_gross' value='img_delete'><span class='button_cancel'>Löschen</span></button></td>
						</tr>
					</table>	
				</td>
				<td style="vertical-align:top; width: 210px;">
					<img src = '' name = 'view_imagefiles' id = 'previewimage' class = 'previewimage' width = '150' height = '120' alt = '' title = '' />
				</td>
			</tr>
		</table>	
		<br><br>					
	</p>
	<?=form_fieldset_close();?>
	</form>
	</span>
	<p>&nbsp;</p>
	
	<!-- Bilderliste -->
	<?=form_fieldset('&nbsp;&nbsp;&nbsp;Bilderliste:&nbsp;&nbsp;&nbsp;');?>
	<table style="width: 500px;">
		
		<? foreach($images as $img) : ?>
		<tr bgcolor="<?=$img['row_color']?>">
			<td style="vertical-align: top;">
				<a id="<?=base_url(CONTENT_IMG_FAHRZEUG_UPLOAD_PATH.$img['img_thumb'])?>||<?=$img['img_desc']?>||<?=$img['imageID']?>||<?=$img['img_small_pic']?>" class="preview_img"><?=$img["img_desc"]?></a>
			</td>
		</tr>
		<? endforeach; ?>
	</table></p>
	<?=form_fieldset_close();?>
	<?=form_close();?>   	
<? endif; ?>
</div>