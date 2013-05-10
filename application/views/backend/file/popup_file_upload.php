<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 	
	$this->load->helper('form'); 
	$this->load->library('form_validation');
    
    $form_upload = array(
        'id'    => 'file_uploader',
        'name'    => 'file_uploader'
    );
	$form_file = array(
		'name'	=> 'upload_file',
		'id'	=> 'upload_file',
	);
	$form_name = array(
		'name'	=> 'name',
		'id'	=> 'name',
		'class' => 'bild_details',
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
    
    $cat_options = array();
	$cat_attr = "class = 'input_dropdown' id = 'input_dropdown'";
	foreach($categories as $cat)
	{
		$cat_options[$cat['categoryID']] = $cat['name'];	
	}

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
		<? if(isset($error)) { echo '<p style="color: #FF0000;">'.$error.'</p>'; } ?>
		<h1>FileManager Upload</h1>
        <?=form_open_multipart(base_url('admin/files/upload/file/save'), $form_upload)?>
		<p><?=form_label('Datei:', $form_file['id']); ?><br/><?=form_upload($form_file)?></p>		
		<p>Kategorie:<br/><?=form_dropdown('category', $cat_options, 0, $cat_attr)?></p>
		<p><?=form_label('Alt-Text:', $form_title['id']); ?><br/><?=form_input($form_title); ?></p>	
		<p><?=form_label('Beschreibung:', $form_description['id']); ?><br/><?=form_input($form_description); ?></p>	
		<p><button type='submit' name='image_submit' id='image_submit' class='button_gross'><span class='button_page_add'>Hochladen</span></button></p>		
		</form>
	</div>

</body>
</html>