<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('form'); 
	$this->load->library('form_validation');
    $i=1;
    
    $form_edit = array(
        'id'    => 'file_edit'
    );
?>

<!-- Ajax Formularübermittlung File_edit -->
<script> 
    $(function() {
    	$("#<?=$form_edit['id']?>").submit(function() {
    		dataString = $("#<?=$form_edit['id']?>").serialize();
    
    		$.ajax({
    			type: "POST",
    			url: "<?=$this->session->userdata('imageliste_redirect').'/save'?>",
    			data: dataString,
    
    			success: function(data) {
    				//    alert('Successful!);
    			}
    
    		});
    
    		return false; //stop the actual form post !important!
    
    	});
    });
    
    function imgPreview($path, $width, $height, $alt, $name, $id) {
    	document.getElementById("imgDetailBtn").style.display = "";
    	var $fileName = $path;
    
    	if ($fileName.length == 0) {
    		document.view_imagefiles.src = '../images/userImages/__nopreview.gif';
    	} else {
    		if (parseInt($width) <= 200) {
    			document.view_imagefiles.width = parseInt($width);
    		} else {
    			document.view_imagefiles.width = 200;
    		}
    		document.view_imagefiles.alt = $alt;
    		document.view_imagefiles.title = $alt;
    		$myimage = new Image();
    		$myimage.src = "../images/userImages/" + $fileName;
    		document.view_imagefiles.src = $myimage.src;
    
    		// -- Link werden gesetzt
    		document.getElementById("deleteLink").href = "index.php?op=delete_verify&op2=image_delete&wich=dieses_Bild&id=" + $id;
    
    		document.ImgDetails.id.value = $id;
    		document.ImgDetails.imageName.value = $name;
    		document.ImgDetails.altText.value = $alt;
    		document.ImgDetails.imageBreite.value = $width;
    		document.ImgDetails.imageHoehe.value = $height;
    	}
    }
    
    function showPicList($var) {
    	document.ImgList.katList.value = $var;
    	document.ImgList.submit();
    }
    
    function openIMGManager($var) {
    	if ($var == "upload") {
    		window.open('popup/popup_imgManager_upload.php', 'Upload', 'width=425,height=300,scrollbars=yes');
    	}
    	if ($var == "newKat") {
    		window.open('popup/popup_imgManager_newKat.php', 'Neue Kategorie', 'width=325,height=300,scrollbars=yes');
    	}
    	if ($var == "delKat") {
    		window.open('popup/popup_imgManager_delKat.php', 'Katgorie Löschen', 'width=270,height=200,scrollbars=yes');
    	}
    }
</script>

<div id="content">
<p class="thirdMenue">
    <table>
        <tr>
            <td><a href="<?=base_url('admin/files/upload/'.$typeID)?>" class="button_gross"><span class="button_add"><?=$btn_create?></span></a></td>
        </tr>
    </table>
</p>

<h1><?=$headline?></h1>

<?=form_open('', $form_edit);?>
<?=form_fieldset('&nbsp;&nbsp;&nbsp;Bildervorschau:&nbsp;&nbsp;&nbsp;');?>
			<p>
					<table>
						<tr>
							<td style="vertical-align:top; width: 250px;">
								<table>
									<tr><td>Bildname:</td><td><input type="text" name="name" class="bild_details" readonly /></td></tr>
									<tr><td>ALT-Text:</td><td><input type="text" name="title" class="bild_details" /></td></tr>
									<tr><td colspan="2">&nbsp;</td></tr>
									<tr><td>Breite:</td><td><input type="text" name="breite" class="bild_details" /></td></tr>
									<tr><td>Höhe:</td><td><input type="text" name="hoehe" class="bild_details" /></td></tr>
								</table>	
							</td>
							<td style="vertical-align:top; width: 210px;"><img src="" name="view_imagefiles" width="" alt="Vorschau" title="Vorschau" /></td>
						</tr>
					</table>	
					<br><br>
					
			</p>
			<p id="imgDetailBtn" style="display: none">
				<input type="image" src="images/buttons/btn_save.gif" />
				<a href="" id="deleteLink"><img src="images/buttons/btn_delete.gif" /></a>
			</p>
<?=form_fieldset_close();?>

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
	<td><a href="javascript:;" onClick="imgPreview('<?=$item["fullpath"]?>', '<?=$item["width"]?>', '<?=$item["height"]?>', '<?=$item["title"]?>', '<?=$item["name"]?>', '<?=$item["fileID"]?>');"><?=$item['name']?></a></td> 
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