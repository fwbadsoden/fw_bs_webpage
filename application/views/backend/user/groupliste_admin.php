<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $row_color = ''; $i=0;
?>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#grp_table").tablesorter({
            headers: { 
                0:  { sorter: false },
                3:  { sorter: false }
            } 
        }); 
    } 
); 
</script> 

<div id="content">
<? if($privileged['edit']) :        ?>
<p class="thirdMenue">
	<a href="<?=base_url('admin/user/group/create')?>" class="button_gross"><span class="button_group_add">Neue Berechtigungsgruppe anlegen</span></a>
</p>
<p>&nbsp;</p>
<? endif;                           ?>
<h1>Berechtigungsgruppen verwalten</h1>

<table cellpadding="0" cellspacing="1" id="grp_table" class="tablesorter">
	<thead>
		<tr>
			<th class="headline_id"></td>
			<th class="headline_name">Name</td>
			<th class="headline_text">Beschreibung</td>
			<th colspan="2" class="headline_edit">Edit</td>
		</tr>
	</thead>
	<tbody>
	<? foreach($group as $g) : 
	       $row_color = cp_get_color($row_color);
           $i++;	   
    ?>
		<tr bgcolor="<?=$row_color?>">
			<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
			<td><?=$g->ugrp_name?></td>
			<td><?=$g->ugrp_desc?></td>
<? if($privileged['edit']) :        ?>
			<td class="button"><a href="<?=base_url('admin/user/group/edit/'.$g->ugrp_id)?>" class="button_mini" title="Berechtigungsgruppe bearbeiten"><span class='button_edit_small'></span></a></td>          
			<td class="button"><a href="<?=base_url('admin/user/group/checkdelete/'.$g->ugrp_id)?>" class="button_mini" title="Berechtigungsgruppe löschen"><span class='button_delete_small'></span></a></td>
<? else :                           ?>
            <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Gruppe zu bearbeiten"><span class='button_lock_small'></span></a></td>
            <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Gruppe zu löschen"><span class='button_lock_small'></span></a></td>
<? endif;                           ?>
		</tr>
	<? endforeach; ?>
	</tbody>
</table>

<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>