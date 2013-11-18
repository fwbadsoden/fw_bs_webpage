<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $row_color = ''; $i = 0;
?>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#priv_table").tablesorter({
            headers: { 
                0:  { sorter: false },
                4:  { sorter: false }
            } 
        }); 
    } 
); 
</script> 

<div id="content">
<? if($privileged['edit']) :        ?>
<p class="thirdMenue">
	<a href="<?=base_url('admin/user/priv/create')?>" class="button_gross"><span class="button_priv_add">Neue Berechtigung anlegen</span></a>
</p>
<p>&nbsp;</p>
<? endif;                           ?>

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
<? if($privileged['edit']) :        ?>            
			<td class="button"><a href="<?=base_url('admin/user/priv/edit/'.$p->upriv_id)?>" class="button_mini" title="Berechtigung bearbeiten"><span class='button_edit_small'></span></a></td>
			<td class="button"><a href="<?=base_url('admin/user/priv/checkdelete/'.$p->upriv_id)?>" class="button_mini" title="Berechtigung löschen"><span class='button_delete_small'></span></a></td>
<? else :                           ?>            
            <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Berechtigung zu bearbeiten"><span class='button_lock_small'></span></a></td>              
            <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Berechtigung zu löschen"><span class='button_lock_small'></span></a></td>
<? endif;                           ?>
		</tr>
	<? } ?>
	</tbody>
</table>

<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>