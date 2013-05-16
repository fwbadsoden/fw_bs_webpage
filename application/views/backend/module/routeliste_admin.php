<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');

?>

<script type="text/javascript">

$(document).ready(function() {
 $("#route_table").tablesorter({
 	// pass the headers argument and assing a object 
    headers: { 
        4:  { 
            // disable it by setting the property sorter to false 
            sorter: false 
            } 
        } 	
 });	
	
 $("#jquery-tools-tooltip a[title]").tooltip({
 	offset: [5, 2]
 	}).dynamic({ bottom: { direction: 'down', bounce: true } });;
 
 $('a.button_mini').click(function(e) {
 	 	
var ID = $(this).attr("id");
var targetUrl = ' ';

switch(ID) {
<? foreach($route as $item) { ?>	
	case "confirm_link_<?=$item["routeID"]?>":	targetUrl = "<?=base_url('admin/system/route/delete/'.$item['routeID'])?>"; 
													var $dialog = $('<div></div>')
													 .html('Wollen Sie die Route wirklich löschen?')
													  .dialog({
													   autoOpen: false,
													   title: 'Route löschen',
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
	
	<table>
        <tr>
            <td><a href="<?=base_url('admin/system/route/create')?>" class="button_gross"><span class="button_add">Neue Route anlegen</span></a></td>
            <td><a href="<?=base_url('admin/system/route/write')?>" class="button_gross"><span class="button_save">Routendatei neu schreiben</span></a></td>
        </tr>
    </table>
</p>

<h1>CI Routen verwalten</h1>

<table cellpadding="0" cellspacing="1" id="route_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_cat">Bereich</th>
		<th class="headline_name">Modulname</th>
		<th class="headline_titel">Route</th>
		<th class="headline_titel">Link</th>
		<th colspan="2" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($route as $item) { ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=$item['bereich']?></td>
	<td><?=$item['moduleName']?></td>
	<td><?=$item['route']?></td>
	<td><?=$item['internalLink']?></td>
<?	if($item['active']==1) {	?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/system/route/status/'.$item['routeID'].'/1')?>" class="button_mini" title="Route offline schalten"><span class='button_online_small'></span></a></span></td>
<?	} else { ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/system/route/status/'.$item['routeID'].'/0')?>" class="button_mini" title="Route online schalten"><span class='button_offline_small'></span></a></span></td>
<?	} ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/system/route/edit/'.$item['routeID'])?>" class="button_mini" title="Route bearbeiten"><span class='button_edit_small'></span></a></span></td>
<!--	<td class="button"><span id='jquery-tools-tooltip'>
<? if($item['protectedFlag'] != 1) { ?>
	<a id="confirm_link_<?=$item['routeID']?>" href="<?=base_url('admin/system/route/delete/'.$item['routeID'])?>" class="button_mini" title="Route löschen"><span class='button_delete_small'></span></a></span></td>
<?  } else { ?>
		<a class="button_mini" title="Route kann nicht gelöscht werden."><span class='button_lock_small'></span></a>
<? } ?>
	</span></td>-->
</tr>
<? } ?>
</tbody>
</table>
<p>&nbsp;</p>
<div style="clear:both;"></div>
</div>