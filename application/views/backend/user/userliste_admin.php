<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

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
 
 $('a.button_mini').click(function(e) {
	var ID = $(this).attr("id");
	var targetUrl = ' ';

	switch(ID) {
	<? foreach($user as $u) { ?>	
		case "confirm_link_<?=$u["userID"]?>":	targetUrl = "<?=base_url('admin/user/backend/delete/'.$u['userID'])?>"; 
														var $dialog = $('<div></div>')
														 .html('Wollen Sie den Benutzer wirklich löschen?')
														  .dialog({
														   autoOpen: false,
														   title: 'Benutzer löschen',
														   width: '600px',
														   modal: true,
														   buttons: {
														    "Löschen": function() {
														             window.location.href = targetUrl;
														    },
														    "Zurück": function() {
														     $( this ).dialog( "close" );
														    }
														   }
														  }); 
														$dialog.dialog('open'); return false; 
														break;
	<? } ?>
	}
 });

});
</script>

<div id="content">
<p class="thirdMenue">
	<a href="<?=base_url('admin/user/backend/create')?>" class="button_gross"><span class="button_user_add">Neuen <?=ucfirst($area)?>-Benutzer anlegen</span></a>
</p>
<p>&nbsp;</p>

<h1>Benutzer im <?=ucfirst($area)?> verwalten</h1>

<table cellpadding="0" cellspacing="1" id="user_table" class="tablesorter">
	<thead>
		<tr>
			<th class="headline_id">ID</td>
			<th class="headline_name">Benutzername</td>
			<th class="headline_mail">Email</td>
			<th class="headline_name">Nachname</td>
			<th class="headline_name">Vorname</td>
			<th class="headline_status">Status</td>
			<th colspan="3" class="headline_edit">Edit</td>
		</tr>
	</thead>
	<tbody>
	<? foreach($user as $u) { ?>
		<tr bgcolor="<?=$u['row_color']?>">
			<td><?=str_pad($u['id'], 5 ,'0', STR_PAD_LEFT);?></td>
			<td><?=$u['username']?></td>
			<td><?=$u['email']?></td>
			<td><?=$u['nachname']?></td>
			<td><?=$u['vorname']?></td>
			<td style='text-align:center'>
		<?  if($u['active']==1) { ?>
				<span style='color: green;'>aktiv</span>
		<?  } else { ?>
				<span style='color: red;'>inaktiv</span>
		<?  } ?>
			</td>
		<?	if($u['active']==1) {	?>
			<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/user/backend/status/'.$u['userID'].'/1')?>" class="button_mini" title="Benutzer offline schalten"><span class='button_online_small'></span></a></span></td>
		<?	} else { ?>
			<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/user/backend/status/'.$u['userID'].'/0')?>" class="button_mini" title="Benutzer online schalten"><span class='button_offline_small'></span></a></span></td>
		<?	} ?>
			<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/user/backend/edit/'.$u['userID'])?>" class="button_mini" title="Benutzer bearbeiten"><span class='button_edit_small'></span></a></span></td>
			<td class="button"><span id='jquery-tools-tooltip'><a id="confirm_link_<?=$u['userID']?>" href="<?=base_url('admin/user/backend/delete/'.$u['userID'])?>" class="button_mini" title="Benutzer löschen"><span class='button_delete_small'></span></a></span></td>
		</tr>
	<? } ?>
	</tbody>
</table>

<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>