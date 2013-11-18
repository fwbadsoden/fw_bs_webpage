<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<html>
<head>
	<title>Suche</title>
</head>
<body>
 
<h1>Suche</h1>
 
	<?php if (count($results)):?>
<p><?php echo count($results) ?> Ergebnis(se) f&uuml;r die Suchanfrage <b><?php echo $_POST['search_query'];?></b></p>
<ul>
	<?php foreach($results as $result):?>
	<li><?=anchor($result->path, html_entity_decode($result->title));?> (<?php echo round($result->score, 2) * 100;?>%) - <?=$result->content_type?></li>
	<?php endforeach;?>
</ul>
	<?php else:?>
<p>Keine Ergebnisse f&uuml;r die Suchanfrage <b><?php echo $_POST['search_query'];?></b></p>
	<?php endif;?>
 
</body>