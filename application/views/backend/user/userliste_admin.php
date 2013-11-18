<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $row_color = ''; $i = 0;
?>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#user_table").tablesorter({
            headers: { 
                0:  { sorter: false },
                7:  { sorter: false }  
            } 
        }); 
    } 
); 
</script> 

<div id="content">
<? if($privileged['edit']) :        ?>
<p class="thirdMenue">
	<a href="<?=base_url('admin/user/create')?>" class="button_gross"><span class="button_user_add">Neuen Benutzer anlegen</span></a>
</p>
<p>&nbsp;</p>
<? endif;                           ?>

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
	<? foreach($user as $u) : 
	       $row_color = cp_get_color($row_color);
           $i++;	   
    ?>
		<tr bgcolor="<?=$row_color?>">
			<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
			<td><?=$u->uacc_username?></td>
			<td><?=$u->uacc_email?></td>
			<td><?=$u->last_name?></td>
			<td><?=$u->first_name?></td>
			<td><?=$group[$u->uacc_group_fk]->ugrp_name?></td>
			<td style='text-align:center'>
		<?  if($u->uacc_active==1) : ?>
				<span style='color: green;'>aktiv</span>
		<?  else : ?>
				<span style='color: red;'>inaktiv</span>
		<?  endif; ?>
			</td>
		<?	if($u->uacc_active==1) :	?>
<? if($privileged['edit']) :        ?>        
			<td class="button"><a href="<?=base_url('admin/user/status/'.$u->uacc_id.'/1')?>" class="button_mini" title="Benutzer offline schalten"><span class='button_online_small'></span></a></td>
<? else :                           ?>
            <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Benutzerstatus zu bearbeiten"><span class='button_online_small'></span></a></td>
<? endif;                           ?>            
		<?	else : ?>
<? if($privileged['edit']) :        ?>                
			<td class="button"><a href="<?=base_url('admin/user/status/'.$u->uacc_id.'/0')?>" class="button_mini" title="Benutzer online schalten"><span class='button_offline_small'></span></a></td>
<? else :                           ?>
            <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Benutzerstatus zu bearbeiten"><span class='button_offline_small'></span></a></td>
<? endif;                           ?>
		<?	endif; ?>
<? if($privileged['edit']) :        ?>        
			<td class="button"><a href="<?=base_url('admin/user/edit/'.$u->uacc_id)?>" class="button_mini" title="Benutzer bearbeiten"><span class='button_edit_small'></span></a></td>           
			<td class="button"><a href="<?=base_url('admin/user/checkdelete/'.$u->uacc_id)?>" class="button_mini" title="Benutzer löschen"><span class='button_delete_small'></span></a></td>
<? else :                           ?> 
            <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Benutzer zu bearbeiten"><span class='button_lock_small'></span></a></td>           
            <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Benutzer zu löschen"><span class='button_lock_small'></span></a></td>
<? endif;                           ?>            
		</tr>
	<? endforeach; ?>
	</tbody>
</table>

<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>