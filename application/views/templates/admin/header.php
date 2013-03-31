<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? $this->load->helper('html'); ?>
<?=doctype('html5')?>
<html>

<?
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
?>

<head>

	<title>Feuerwehr Bad Soden am Taunus - <?=$title?></title>
	<?=meta($meta)?>
	
	<link rel="stylesheet" href="<?=base_url('css/admin/adm_layout.css')?>" type="text/css">
	<link rel="stylesheet" href="<?=base_url('css/admin/adm_buttons.css')?>" type="text/css">
	<link rel="stylesheet" href="<?=base_url('css/admin/adm_pagination.css')?>" type="text/css">
	<link rel="stylesheet" href="<?=base_url('css/admin/adm_forms.css')?>" type="text/css">
	<link rel="stylesheet" href="<?=base_url('css/admin/jquery-ui-1.10.2.custom.min.css')?>" type="text/css">
  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script src="http://cdn.jquerytools.org/1.2.7/all/jquery.tools.min.js"></script>
  	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	
	<script language="javascript" type="text/javascript" src="<?=base_url('js/tiny_mce/tiny_mce.js')?>"></script>
	<script language="javascript" type="text/javascript" src="<?=base_url('js/tiny_mce/jquery.tinymce.js')?>"></script>

</head>

<body>

<div id="header">
	<a href="<?=base_url('admin/admin')?>"><?=img(array('src' => 'images/admin/layout/logo_fw.jpg', 'width' => '246', 'height' => '50', 'alt' => 'Feuerwehr Bad Soden am Taunus'))?></a>
</div>