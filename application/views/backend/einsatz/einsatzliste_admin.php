<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');

?>


<script type="text/javascript">

$(document).ready(function() {
 $("#einsatz_table").tablesorter({
 	// pass the headers argument and assing a object 
    headers: { 
        // (we start counting zero) 
        0:  { 
            // disable it by setting the property sorter to false 
            sorter: false 
            }, 
        3:  { 
            // disable it by setting the property sorter to false 
            sorter: false 
            }, 
        4:  { 
            // disable it by setting the property sorter to false 
            sorter: false 
            },
        6:  { 
            // disable it by setting the property sorter to false 
            sorter: false 
            },  
        7:  { 
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
<? foreach($einsatz as $item) :     ?>	
	case "confirm_link_<?=$item["einsatzID"]?>":	targetUrl = "<?=base_url('admin/content/einsatz/delete/'.$item['einsatzID'])?>"; 
													var $dialog = $('<div></div>')
													 .html('Wollen Sie den Einsatz wirklich löschen?')
													  .dialog({
													   autoOpen: false,
													   title: 'Einsatz löschen',
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
<? endforeach;                      ?>
}
 });
});
</script> 

<div id="content">
<? if($privileged['edit']) :        ?>
<p class="thirdMenue">
	<a href="<?=base_url('admin/content/einsatz/create')?>" class="button_gross"><span class="button_add">Neuen Einsatz anlegen</span></a>
</p>
<p>&nbsp;</p>
<? endif;                           ?>

<h1>Einsätze verwalten</h1>
<h2>Jahr wählen</h2>

<table cellpadding="0" cellspacing="1">
<tr>
<? foreach($years as $year)	:       ?>
	<td><a href="<?=base_url('admin/content/einsatz/'.$year)?>"><?=$year?></a></td>
<? endforeach;                      ?>
</tr>
</table>

<table cellpadding="0" cellspacing="1" id="einsatz_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_id">Nr.</th>
		<th class="headline_date">Datum</th>
		<th class="headline_date">Beginn</th>
		<th class="headline_date">Ende</th>
		<th class="headline_titel">Referenz</th>
		<th class="headline_id">Bilder</th>
		<th colspan="4" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($einsatz as $item) :     ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=str_pad($item['lfdNr'], 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=str_pad($item['einsatzNr'], 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$item['datum']?></td>
	<td><?=$item['beginn']?></td>
	<td><?=$item['ende']?></td>
	<td><?=$item['einsatzName']?></td>
	<td><?=str_pad($item['imgCount'], 5 ,'0', STR_PAD_LEFT);?></td> 

<?	if($item['online']==1) :        	
        if($privileged['edit']) :   ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/einsatz/status/'.$item['einsatzID'].'/1/'.$item['year'])?>" class="button_mini" title="Einsatz offline schalten"><span class='button_online_small'></span></a></span></td>
<?      else :                      ?>
    <td class="button"><span id='jquery-tools-tooltip'><a class="button_mini" title="Sie haben keine Berechtigung den Einsatzstatus zu bearbeiten"><span class='button_online_small'></span></a></span></td>
<?      endif;                          
  	 else :                         
        if($privileged['edit']) :   ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/einsatz/status/'.$item['einsatzID'].'/0/'.$item['year'])?>" class="button_mini" title="Einsatz online schalten"><span class='button_offline_small'></span></a></span></td>
<?      else :                      ?>
    <td class="button"><span id='jquery-tools-tooltip'><a class="button_mini" title="Sie haben keine Berechtigung den Einsatzstatus zu bearbeiten"><span class='button_offline_small'></span></a></span></td>
<?      endif;                      
	endif;                          
    if($privileged['edit']) :       ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/einsatz/edit/'.$item['einsatzID'])?>" class="button_mini" title="Einsatz bearbeiten"><span class='button_edit_small'></span></a></span></td>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/einsatz/image/edit/'.$item['einsatzID'])?>" class="button_mini" title="Einsatzbilder bearbeiten"><span class='button_image_edit_small'></span></a></span></td>
	<td class="button"><span id='jquery-tools-tooltip'><a id="confirm_link_<?=$item['einsatzID']?>" href="<?=base_url('admin/content/einsatz/delete/'.$item['einsatzID'])?>" class="button_mini" title="Einsatz löschen"><span class='button_delete_small'></span></a></span></td>
<?  else :                          ?>
    <td class="button"><span id='jquery-tools-tooltip'><a class="button_mini" title="Sie haben keine Berechtigung den Einsatz zu bearbeiten"><span class='button_lock_small'></span></a></span></td>
    <td class="button"><span id='jquery-tools-tooltip'><a class="button_mini" title="Sie haben keine Berechtigung die Einsatzbilder zu bearbeiten"><span class='button_lock_small'></span></a></span></td>
    <td class="button"><span id='jquery-tools-tooltip'><a class="button_mini" title="Sie haben keine Berechtigung den Einsatz zu löschen"><span class='button_lock_small'></span></a></span></td>
<?  endif;                          ?>    
</tr>
<? endforeach;                      ?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>