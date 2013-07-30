<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $row_color = ''; $i = 0;
?>

<script type="text/javascript">

$(document).ready(function() {
 $("#priv_table").tablesorter({
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
	<a href="<?=base_url('admin/user/priv/create')?>" class="button_gross"><span class="button_priv_add">Neue Berechtigung anlegen</span></a>
</p>
<p>&nbsp;</p>

<h1>Berechtigungen verwalten</h1>

<table cellpadding="0" cellspacing="1" id="priv_table" class="tablesorter">
	<thead>
		<tr>
			<th class="headline_id"></td>
            <th class="headline_module">Modul</th>
			<th class="headline_name">Name</td>
			<th class="headline_text">Beschreibung</td>
			<th colspan="2" class="headline_edit">Edit</td>
		</tr>
	</thead>
	<tbody>
	<? foreach($priv as $p) { 
	       $row_color = cp_get_color($row_color);
           $i++;	   
    ?>
		<tr bgcolor="<?=$row_color?>">
			<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
			<td><?=$module[$p->moduleID]['moduleName']?></td>
			<td><?=$p->upriv_name?></td>
			<td><?=$p->upriv_desc?></td>
			<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/user/priv/edit/'.$p->upriv_id)?>" class="button_mini" title="Berechtigung bearbeiten"><span class='button_edit_small'></span></a></span></td>
			<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/user/priv/checkdelete/'.$p->upriv_id)?>" class="button_mini" title="Berechtigung löschen"><span class='button_delete_small'></span></a></span></td>
		</tr>
	<? } ?>
	</tbody>
</table>

<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>