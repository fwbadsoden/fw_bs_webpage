<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('form'); 
	$this->load->library('form_validation');
    $i=1;
    
    $form_edit = array(
        'id'    => 'file_edit',
        'name'    => 'file_edit'
    );
	$form_name = array(
		'name'	=> 'name',
		'id'	=> 'name',
		'class' => 'bild_details',
        'readonly' => 'readonly'
	);
	$form_description = array(
		'name'	=> 'description',
		'id'	=> 'description',
		'class' => 'bild_details',
	);
	$form_title = array(
		'name'	=> 'title',
		'id'	=> 'title',
		'class' => 'bild_details',
	);
	$form_mime = array(
		'name'	=> 'mime',
		'id'	=> 'mime',
		'class' => 'bild_details',
        'readonly' => 'readonly'
	);
?>

<script>     
    function imgPreview($fullpath, $ext, $alt, $desc, $name, $mime, $id) {
    	document.getElementById("imgDetailBtn").style.display = "";
    	var $fileName = $fullpath;
    
    	if ($fileName.length == 0) {
    		document.view_files.src = '<?=base_url('images/content/__nopreview.gif')?>';
    	} else {
    		document.view_files.width = 32;
            document.view_files.alt = $alt;
			document.view_files.title = $alt;
            var $src = '<?=base_url('images/icons/EXT_gr.gif')?>';
            $src = $src.replace('EXT', $ext);
			document.view_files.src = $src;
    
    		document.<?=$form_edit['name']?>.file_id.value = $id;
    		document.<?=$form_edit['name']?>.name.value = $name;
    		document.<?=$form_edit['name']?>.description.value = $desc;
    		document.<?=$form_edit['name']?>.title.value = $alt;
    		document.<?=$form_edit['name']?>.mime.value = $mime;
    	}
    }
    
	function openIMGManager($var) {
    	if($var=="upload") {	
    	   window.open('<?=base_url('admin/files/upload/'.$type)?>', 'Upload', 'width=425,height=300,scrollbars=yes');
    	}
//    	if($var=="newKat") {
//    	   window.open('popup/popup_imgManager_newKat.php', 'Neue Kategorie', 'width=325,height=300,scrollbars=yes');
//    	}
//    	if($var=="delKat") {
//    	   window.open('popup/popup_imgManager_delKat.php', 'Katgorie Löschen', 'width=270,height=200,scrollbars=yes');
//    	}
	}
</script>

<div id="content">
<p class="thirdMenue">
    <table>
        <tr>
            <td><a href="javascript:;" onClick="openIMGManager('upload');" class="button_gross"><span class="button_page_add"><?=$btn_create?></span></a></td>
        </tr>
    </table>
</p>

<h1><?=$headline?></h1>

<?=form_open(base_url('admin/files/'.$type.'/edit'), $form_edit);?>
<?=form_fieldset('&nbsp;&nbsp;&nbsp;Dateivorschau:&nbsp;&nbsp;&nbsp;');?>
<input type='hidden' name='file_id' value=''/>
			<p>
					<table>
						<tr>
							<td style="vertical-align:top; width: 250px;">
								<table>
									<tr><td><?=form_label('Dateiname:', $form_name['id']); ?></td><td><?=form_input($form_name); ?></td></tr>
									<tr><td><?=form_label('Beschreibung:', $form_description['id']); ?></td><td><?=form_input($form_description); ?></td></tr>
									<tr><td><?=form_label('Alt-Text:', $form_title['id']); ?></td><td><?=form_input($form_title); ?></td></tr>
									<tr><td colspan="2">&nbsp;</td></tr>
									<tr><td><?=form_label('Typ:', $form_mime['id']); ?></td><td><?=form_input($form_mime); ?></td></tr>
								</table>	
							</td>
							<td style="vertical-align:top; width: 210px;"><img src="" name="view_files" width="" alt="Vorschau" title="Vorschau" /></td>
						</tr>
					</table>	
					<br><br>
					
			</p>
			<p id="imgDetailBtn" style="display: none">
                <button type='submit' name='image_submit' id='image_submit' class='button_gross'><span class='button_save'>&Auml;nderung speichern</span></button>
			</p>
<?=form_fieldset_close();?>

<p></p>

<table cellpadding="0" cellspacing="1" id="file_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_cat">Kategorie</th>
		<th class="headline_titel">Name</th>
	</tr>
</thead>
<tbody> 
<? foreach($files as $item) { ?>	
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$categories[$item['categoryID']]['name']?></td>
	<td><a href="javascript:;" onClick="imgPreview('<?=$item["fullpath"]?>', '<?=$item["extension"]?>', '<?=$item["title"]?>', '<?=$item["description"]?>', '<?=$item["name"]?>', '<?=$item["mimetype"]?>, '<?=$item["fileID"]?>');"><?=$item['name']?></a></td> 
</tr>
<?
    $i++; 
  } 
?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>