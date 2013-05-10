<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 	

    $cat_options = '';
    foreach($categories as $cat) { $cat_options += '<option value="'.$cat['categoryID'].'">'.$cat["name"].'</option>'; }

    $meta = array(
        array('name' => 'keywords', 'content' => 'feuerwehr-bs.de, Feuerwehr, Freiwillige Feuerwehr, Bad Soden'),
        array('name' => 'description', 'content' => 'Alle Infos rund um die freiwillige Feuerwehr der Stadt Bad Soden am Taunus'),
        array('name' => 'page-topic', 'content' => 'feuerwehr-bs.de - Freiwillige Feuerwehr der Stadt Bad Soden am Taunus'),
        array('name' => 'revisit-after', 'content' => '1 days'),
        array('name' => 'language', 'content' => 'de'),
        array('name' => 'copyright', 'content' => 'feuerwehr-bs.de'),
        array('name' => 'author', 'content' => 'info[at]feuerwehr-bs.de'),
        array('name' => 'publisher', 'content' => 'Freiwillige Feuerwehr Bad Soden am Taunus'),
        array('name' => 'audience', 'content' => 'Alle'),
        array('name' => 'expires', 'content' => 'never'),
        array('name' => 'page-type', 'content' => 'Portal'),
        array('name' => 'robots', 'content' => 'INDEX,FOLLOW'),
        array('name' => 'rating', 'content' => 'General'),
        array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
        array('name' => 'imagetoolbar', 'content' => 'no', 'type' => 'equiv')
    );
    echo doctype('html5');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de-de" lang="de-de">
<head>
<title>Feuerwehr Bad Soden am Taunus - <?=$title?></title>
<?=meta($meta)?>	
<link rel="shortcut icon" href="<?=base_url('images/favicon.ico')?>" type="image/x-icon" />
<link rel="stylesheet" href="<?=base_url('css/backend/admin.css')?>" type="text/css" />
<style>
	body { background-color: #F5F5F5; background-image: url(); }
	#content { width: auto; margin: 0 10px 0 10px; padding: 10px 0 0 0; } 
	#content .upload { font-family: Arial, Helvetica, sans-serif; font-size: 11px; background-color: #FFFFFF; color: #000000; width: 550px; height: 22px; padding: 2px; border: 1px solid #; }
	#content .bild_details { width: 250px; height: 15px; background-color:#FFFFFF; border: 1px solid #BDB5A7; font: 11px Arial, Helvetica, sans-serif; color: #000000; padding: 2px 4px 2px 4px; }

</style>
</head>
<body>

    <div id="content">
		<? if($error!="") { echo '<p style="color: #FF0000;">'.$error.'</p>'; } ?>
		<h1>ImgManager Upload</h1>
		<form action="<?=base_url('admin/files/upload/image/save')?>" method="post" enctype="multipart/form-data">
		<p>Bild:<br/><input type="file" name="upload_image" maxlength="4000"/></p>		
		<p>Kategorie:<br/><select name="category"><?=$cat_options?></select></p>
		<p>Alt-Text:<br/><input type="text" name="title" class="bild_details"/></p>	
		<p>Beschreibung:<br/><input type="text" name="description" class="bild_details"/></p>		
		<p><button type='submit' name='image_submit' id='image_submit' class='button_gross'><span class='button_picture_add'>Hochladen</span></button></p>		
		</form>
	</div>

</body>
</html>