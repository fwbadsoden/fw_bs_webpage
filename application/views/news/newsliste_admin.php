<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');	
	
	// set pagination var if page 1
	if( !is_numeric( $this->uri->segment( $this->uri->total_segments() ) ) )
		$pagination_start = 0;
	else $pagination_start = $this->uri->segment($this->uri->total_segments());
?>

<script type="text/javascript">

$(document).ready(function() {
 $("#news_table").tablesorter({
 	// pass the headers argument and assing a object 
    headers: { 
        // (we start counting zero) 
        0:  { 
            // disable it by setting the property sorter to false 
            sorter: false 
            }, 
        8:  { 
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
<? foreach($news as $item) { ?>	
	case "confirm_link_<?=$item["newsID"]?>":	targetUrl = "<?=base_url('admin/content/news/delete/'.$item['newsID'])?>"; 
													var $dialog = $('<div></div>')
													 .html('Wollen Sie die News wirklich löschen?')
													  .dialog({
													   autoOpen: false,
													   title: 'News löschen',
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
	<a href="<?=base_url('admin/content/news/create')?>" class="button_gross"><span class="button_add">Neue News anlegen</span></a>
</p>
<p>&nbsp;</p>
<h1>News verwalten</h1>

<table cellpadding="0" cellspacing="1" id="news_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_datetime">Datum</th>
		<th class="headline_cat">Kategorie</th>
		<th class="headline_titel">Titel</th>
		<th class="headline_edit2">Autor</th>
		<th class="headline_datetime">Gültig ab</th>
		<th class="headline_datetime">Gültig bis</th>
		<th class="headline_status">Status</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? 
	foreach($news as $item) { 
?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=str_pad($id_counter, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$item['datetime']?></td>
	<td><?=$news_cat[$item['catID']]['title']?></td>
	<td><?=$item['title']?></td>
	<td><?=$item['editor']?></td>
	<td><?=$item['valid_from']?></td>
	<td><?=$item['valid_to']?></td>
	<td style='text-align:center'>
	<?  if($item['online']==1) { ?>
		<span style='color: green;'>online</span>
	<?  } else { ?>
		<span style='color: red;'>offline</span>
	<?  } ?>
	</td>
<?	if($item['online']==1) {	?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/news/status/'.$item['newsID'].'/1/'.$pagination_start)?>" class="button_mini" title="News offline schalten"><span class='button_online_small'></span></a></span></td>
<?	} else { ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/news/status/'.$item['newsID'].'/0/'.$pagination_start)?>" class="button_mini" title="News online schalten"><span class='button_offline_small'></span></a></span></td>
<?	} ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/news/edit/'.$item['newsID'])?>" class="button_mini" title="News bearbeiten"><span class='button_edit_small'></span></a></span></td>
	<td class="button"><span id='jquery-tools-tooltip'><a id="confirm_link_<?=$item['newsID']?>" href="<?=base_url('admin/content/news/delete/'.$item['newsID'])?>" class="button_mini" title="News löschen"><span class='button_delete_small'></span></a></span></td>
</tr>
<? $id_counter--; } ?>
</tbody>
</table>
<br>
<?=$news_pagination?>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>