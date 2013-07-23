<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $row_color = ''; $i=0;
?>

<script type="text/javascript">

$(document).ready(function() {
 $("#grp_table").tablesorter({
 	// pass the headers argument and assing a object 
    headers: { 
            // (we start counting zero) 
        0:  { 
            // disable it by setting the property sorter to false 
            sorter: false 
            },
        4:  { 
            // disable it by setting the property sorter to false 
            sorter: false 
            } 
        } 	
 });
 
 $("#jquery-tools-tooltip a[title]").tooltip({
 	offset: [5, 2]
 	}).dynamic({ bottom: { direction: 'down', bounce: true } 
 });
});
</script>

<div id="content">
<p class="thirdMenue">
	<a href="<?=base_url('admin/user/group/create')?>" class="button_gross"><span class="button_group_add">Neue Berechtigungsgruppe anlegen</span></a>
</p>
<p>&nbsp;</p>

<h1>Berechtigungsgruppen verwalten</h1>

<table cellpadding="0" cellspacing="1" id="grp_table" class="tablesorter">
	<thead>
		<tr>
			<th class="headline_id">ID</td>
			<th class="headline_name">Name</td>
			<th class="headline_text">Beschreibung</td>
			<th colspan="2" class="headline_edit">Edit</td>
		</tr>
	</thead>
	<tbody>
	<? foreach($group as $g) { 
	       $row_color = cp_get_color($row_color);
           $i++;	   
    ?>
		<tr bgcolor="<?=$row_color?>">
			<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
			<td><?=$g->ugrp_name?></td>
			<td><?=$g->ugrp_desc?></td>
			<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/user/group/edit/'.$g->ugrp_id)?>" class="button_mini" title="Berechtigungsgruppe bearbeiten"><span class='button_edit_small'></span></a></span></td>
			<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/user/group/checkdelete/'.$g->ugrp_id)?>" class="button_mini" title="Berechtigungsgruppe löschen"><span class='button_delete_small'></span></a></span></td>
		</tr>
	<? } ?>
	</tbody>
</table>

<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>