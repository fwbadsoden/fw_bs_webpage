<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');

?>


<script type="text/javascript">

$(document).ready(function() {
 $("#fahrzeug_table").tablesorter({
 	// pass the headers argument and assing a object 
    headers: { 
        2:  { 
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
<? foreach($fahrzeug as $item) { ?>	
	case "confirm_link_<?=$item["fahrzeugID"]?>":	targetUrl = "<?=base_url('admin/content/fahrzeug/delete/'.$item['fahrzeugID'])?>"; 
													var $dialog = $('<div></div>')
													 .html('Wollen Sie das Fahrzeug wirklich löschen?')
													  .dialog({
													   autoOpen: false,
													   title: 'Fahrzeug löschen',
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
	<a href="<?=base_url('admin/content/fahrzeug/create')?>" class="button_gross"><span class="button_car_add">Neues Fahrzeug anlegen</span></a>
</p>
<p>&nbsp;</p>

<h1>Fahrzeuge verwalten</h1>

<table cellpadding="0" cellspacing="1" id="fahrzeug_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_funkrufname">Funkrufname</th>
		<th class="headline_titel">Fahrzeugname</th>
		<th colspan="4" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($fahrzeug as $item) { ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=$item['fahrzeugRufnamePrefix']." ".$item['fahrzeugRufname'];?></td>
	<td><?=$item['fahrzeugName']?></td>
<?	if($item['online']==1) {	?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/fahrzeug/status/'.$item['fahrzeugID'].'/1')?>" class="button_mini" title="Fahrzeug offline schalten"><span class='button_online_small'></span></a></span></td>
<?	} else { ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/fahrzeug/status/'.$item['fahrzeugID'].'/0')?>" class="button_mini" title="Fahrzeug online schalten"><span class='button_offline_small'></span></a></span></td>
<?	} ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/fahrzeug/edit/'.$item['fahrzeugID'])?>" class="button_mini" title="Fahrzeug bearbeiten"><span class='button_edit_small'></span></a></span></td>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/fahrzeug/image/edit/'.$item['fahrzeugID'])?>" class="button_mini" title="Fahrzeugbilder bearbeiten"><span class='button_image_edit_small'></span></a></span></td>
	<td class="button"><span id='jquery-tools-tooltip'>
<?  if($item['delete']==1) {	?>	
		<a id="confirm_link_<?=$item['fahrzeugID']?>" href="<?=base_url('admin/content/fahrzeug/delete/'.$item['fahrzeugID'])?>" class="button_mini" title="Fahrzeug löschen"><span class='button_delete_small'></span></a></span>
<?  } else { ?>
		<a class="button_mini" title="Fahrzeug kann nicht gelöscht werden.<br>Wird bereits verwendet."><span class='button_lock_small'></span></a></span>
<?  } ?>
	</td>
</tr>
<? } ?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>