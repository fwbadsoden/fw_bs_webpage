<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
    $color = "";
?>

<div id="content">
<? if($privileged['delete']) :        ?>
<p class="thirdMenue">
	<a href="<?=base_url('admin/content/cache/delete/all')?>" class="button_gross"><span class="button_delete">Gesamten Cache löschen</span></a>
</p>
<p>&nbsp;</p>
<? endif;                           ?>

<h1>Cache verwalten</h1>
<table cellpadding="0" cellspacing="1" id="setting_table">
<thead>
	<tr>
		<th class="headline_titel">Dateiname</th>
		<th class="headline_datetime">Erstellung</th>
		<th class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($files as $item) : 
    $color = cp_get_color($color);
?>		
<tr bgcolor="<?=$color?>">
	<td><?=$item['name']?></td>
	<td><?=date('d.m.Y H:i:s', $item['date'])?></td>
<? if($privileged['delete']) : ?>    
	<td><a id="delete_file" href="<?=base_url('admin/content/cache/delete/'.$item['name'])?>" class="button_mini" title="Datei löschen"><span class='button_delete_small'></span></a></td>
<? else : ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Datei zu löschen"><span class='button_lock_small'></span></a></td>
<? endif; ?>    
</tr>
<? endforeach; ?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>