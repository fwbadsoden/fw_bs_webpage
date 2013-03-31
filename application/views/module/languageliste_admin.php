<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');
?>

<script type="text/javascript">

$(document).ready(function() {
 $("#lang_table").tablesorter({
 	// pass the headers argument and assing a object 
    headers: { 
        3:  { 
            // disable it by setting the property sorter to false 
            sorter: false 
            }, 
        4:  { 
            // disable it by setting the property sorter to false 
            sorter: false 
            }
 });	
	
 $("#jquery-tools-tooltip a[title]").tooltip({
 	offset: [5, 2]
 	}).dynamic({ bottom: { direction: 'down', bounce: true } });;
 
 $('a.button_mini').click(function(e) {
 	 	
var ID = $(this).attr("id");
var targetUrl = ' ';

switch(ID) {
<? foreach($language as $item) { ?>	
	case "confirm_link_<?=$item["langID"]?>":	targetUrl = "<?=base_url('admin/system/language/delete/'.$item['langID'])?>"; 
													var $dialog = $('<div></div>')
													 .html('Wollen Sie diesen Text wirklich löschen?')
													  .dialog({
													   autoOpen: false,
													   title: 'Text löschen',
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
            <td><a href="<?=base_url('admin/system/language/create')?>" class="button_gross"><span class="button_add">Neuen Text anlegen</span></a></td>
            <td><a href="<?=base_url('admin/system/language/write')?>" class="button_gross"><span class="button_save">Textdatei neu schreiben</span></a></td>
        </tr>
    </table>
</p>

<h1>Texte verwalten</h1>

<table cellpadding="0" cellspacing="1" id="lang_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_name">Modulname</th>
		<th class="headline_titel">Schlüssel</th>
		<th class="headline_text">Text</th>
		<th class="headline_text">Beschreibung</th>
		<th colspan="2" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>

<? foreach($language as $item) { ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=$module[$item['moduleID']]['moduleName']?></td>
	<td><?=$item['key']?></td>
	<td><?=$item['text']?></td>
	<td><?=$item['desc']?></td>
	<td><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/system/language/edit/'.$item['langID'])?>" class="button_mini" title="Text bearbeiten"><span class='button_edit_small'></span></a></span></td>
	<td><a id="confirm_link_<?=$item['langID']?>" href="<?=base_url('admin/system/language/delete/'.$item['langID'])?>" class="button_mini" title="Text löschen"><span class='button_delete_small'></span></a></span></td>
</tr>
<? } ?>
</tbody>
</table>
<p>&nbsp;</p>
<div style="clear:both;"></div>
</div>