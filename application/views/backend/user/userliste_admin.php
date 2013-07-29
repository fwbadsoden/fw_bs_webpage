<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $row_color = '';
?>

<script type="text/javascript">

$(document).ready(function() {
 $("#user_table").tablesorter({
 	// pass the headers argument and assing a object 
    headers: { 
            // (we start counting zero) 
        0:  { 
            // disable it by setting the property sorter to false 
            sorter: false 
            },
        6:  { 
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
	<a href="<?=base_url('admin/user/create')?>" class="button_gross"><span class="button_user_add">Neuen Benutzer anlegen</span></a>
</p>
<p>&nbsp;</p>

<h1>Benutzer verwalten</h1>

<table cellpadding="0" cellspacing="1" id="user_table" class="tablesorter">
	<thead>
		<tr>
			<th class="headline_id">ID</td>
			<th class="headline_name">Benutzername</td>
			<th class="headline_mail">Email</td>
			<th class="headline_name">Nachname</td>
			<th class="headline_name">Vorname</td>
			<th class="headline_name">Gruppe</td>
			<th class="headline_status">Status</td>
			<th colspan="3" class="headline_edit">Edit</td>
		</tr>
	</thead>
	<tbody>
	<? foreach($user as $u) { 
	       $row_color = cp_get_color($row_color)	   
    ?>
		<tr bgcolor="<?=$row_color?>">
			<td><?=str_pad($u->uacc_id, 5 ,'0', STR_PAD_LEFT);?></td>
			<td><?=$u->uacc_username?></td>
			<td><?=$u->uacc_email?></td>
			<td><?=$u->last_name?></td>
			<td><?=$u->first_name?></td>
			<td><?=$group[$u->uacc_group_fk]->ugrp_name?></td>
			<td style='text-align:center'>
		<?  if($u->uacc_active==1) { ?>
				<span style='color: green;'>aktiv</span>
		<?  } else { ?>
				<span style='color: red;'>inaktiv</span>
		<?  } ?>
			</td>
		<?	if($u->uacc_active==1) {	?>
			<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/user/status/'.$u->uacc_id.'/1')?>" class="button_mini" title="Benutzer offline schalten"><span class='button_online_small'></span></a></span></td>
		<?	} else { ?>
			<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/user/status/'.$u->uacc_id.'/0')?>" class="button_mini" title="Benutzer online schalten"><span class='button_offline_small'></span></a></span></td>
		<?	} ?>
			<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/user/edit/'.$u->uacc_id)?>" class="button_mini" title="Benutzer bearbeiten"><span class='button_edit_small'></span></a></span></td>
			<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/user/checkdelete/'.$u->uacc_id)?>" class="button_mini" title="Benutzer löschen"><span class='button_delete_small'></span></a></span></td>
		</tr>
	<? } ?>
	</tbody>
</table>

<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>