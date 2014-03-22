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
?>


<div id="content">
	
	<!-- Upload -->
	<h1>Bilderverwaltung für Mannschaftsmitglied "<?=$mitglied->vorname." ".$mitglied->name?>"</h1>
    
	<?=form_open_multipart($this->session->userdata('mitgliedimage_submit').'/save', $form_upload)?>
	<?=form_fieldset('&nbsp;&nbsp;&nbsp;Bild hochladen:&nbsp;&nbsp;&nbsp;');?>
 	<p>
		<table>
			<? if(isset($error)) { echo '<tr><td colspan="2"><p style="color: #FF0000;">'.$error.'</p></td></tr>'; } ?>
			<tr><td colspan='2'><?=form_upload($image_upload)?></td></tr>	            
			<tr><td colspan="2"></td></tr>
			<tr>
				<td><button type='submit' name='image_submit' id='image_submit' class='button_gross'><span class='button_save'>Hochladen</span></button></td>
				<td><a href='<?=$this->session->userdata('mannschaftliste_redirect')?>' target='_top' class="button_gross"><span class="button_cancel">Zurück</span></a></td>
			</tr>
		</table>
	</p>
	<?=form_fieldset_close();?>
    <?=form_close();?>

</div>