<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');	
    $i = 1;
?>

<div id="content">
<p class="thirdMenue">
	<a href="<?=base_url('admin/content/news/kategorie/create')?>" class="button_gross"><span class="button_add">Neue Kategorie anlegen</span></a>
</p>
<p>&nbsp;</p>
<h1>News-Kategorien verwalten</h1>

<table cellpadding="0" cellspacing="1" id="news_category_table">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_cat">Kategorie</th>
		<th colspan="2" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? 
	foreach($categories as $item) { 
?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$item['title']?></td>
	<td class="button"><a href="<?=base_url('admin/content/news/kategorie/edit/'.$item['categoryID'])?>" class="button_mini" title="Kategorie bearbeiten"><span class='button_edit_small'></span></a></td>
	<td class="button"><a href="<?=base_url('admin/content/news/kategorie/checkdel/'.$item['categoryID'])?>" class="button_mini" title="Kategorie l&ouml;schen"><span class='button_delete_small'></span></a></td>
</tr>
<? $i++; } ?>
</tbody>
</table>
</div>
<div style="clear:both;"></div>