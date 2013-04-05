<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? $this->load->helper('html'); ?>
<?=doctype('html5')?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de-de" lang="de-de">

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
	
  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<style>
		* {
			padding: 0;
			margin: 0;
		}
		body {
			margin: 0;
			padding: 0;
			background-color: #FFFFFF;
			text-align:center;
		}
		img {
			border: 0;
		}
		
		a {
			font: 11px Arial, Helvetica, sans-serif;
			color: #8B0A00;
			text-decoration: underline;
		}
		a:link {
			font: 11px Arial, Helvetica, sans-serif;
			color: #8B0A00;
			text-decoration: underline;
		}
		a:hover {
			font: 11px Arial, Helvetica, sans-serif;
			color: #FFE400;
			text-decoration: underline;
		}
		a:focus {
			font: 11px Arial, Helvetica, sans-serif;
			color: #FFE400;
			text-decoration: underline;
		}
		
		#footer_login {
			font: 11px Tahoma, Arial, Helvetica, sans-serif; 
			color: lightgrey;
			font-weight: bold;
		}
		
		#login_box {
			margin: auto;
			margin-top: 50px;
			width: 289px;
		}
		#logo {
			width: 289px;
			height: 77px;
			background-image:url(../../images/admin/layout/login_logo.gif);
		}
		#powered {
			width: 289px;
			height: 19px;
			margin-top: 5px;
			background-image:url(../../images/admin/layout/login_powered.gif);
		}
		
		.kasten_error {
			width: 289px;
			margin: 0;
			padding: 0;
			font: 11px Arial, Helvetica, sans-serif;
			font-weight: bold;
		}
		.kasten_oben {
			width: 289px;
			height: 30px;
			margin: 0;
			padding: 0;
		}
		.kasten_mitte {
			width: 269px;
			background-color: #C5C5C5;
			font: 11px Arial, Helvetica, sans-serif;
			color: #000000;
			padding: 0 10px 0 10px;
		}
		.kasten_unten {
			width: 289px;
			height: 15px;
			background-image:url(../../images/admin/layout/login_unten.gif);
			background-repeat:no-repeat;
		}
		
		.kasten_mitte .text {
			font: 11px Arial, Helvetica, sans-serif;
			text-align: left;
		}
		.kasten_mitte .login_text {
			font: 11px Arial, Helvetica, sans-serif;
			color: #8B0A00;
			margin-left: 60px;
			font-weight: bold;
			text-align: left;
		}
		.kasten_mitte .login_text_pw {
			font: 11px Arial, Helvetica, sans-serif;
			color: #8B0A00;
			margin-left: 32px;
			font-weight: bold;
			text-align: left;
		}
		.kasten_mitte .spacer {
			height: 10px;
		}
		
		.login_input {
			width: 145px;
			height: 15px;
			background-color:#FFFFFF;
			border: 2px solid #BDB5A7;
			font: 11px Arial, Helvetica, sans-serif;
			color: #000000;
			padding: 2px 4px 2px 4px;
		}
		.login_checkbox {
			width: 15px;
			height: 15px;
			background-color:#FFFFFF;
			border: 2px solid #BDB5A7;
			font: 11px Arial, Helvetica, sans-serif;
			color: #000000;
			padding: 2px 4px 2px 4px;
		}
		.login_input_pw {
			width: 200px;
			height: 15px;
			background-color:#FFFFFF;
			border: 2px solid #BDB5A7;
			font: 11px Arial, Helvetica, sans-serif;
			color: #000000;
			padding: 2px 4px 2px 4px;
		}
		.login_button {
			width: 85px;
			height: 21px;
			background-color:#8B0A00;
			border: 1px solid #FFFFFF;
			font: 11px Arial, Helvetica, sans-serif;
			font-weight: bold;
			color: #FFFFFF;
			padding: 0;
		}
		.login_button_pw {
			width: 210px;
			height: 21px;
			background-color:#8B0A00;
			border: 1px solid #FFFFFF;
			font: 11px Arial, Helvetica, sans-serif;
			font-weight: bold;
			color: #FFFFFF;
			padding: 0;
		}
	</style>
</head>
<body>