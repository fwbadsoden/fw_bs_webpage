<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');
	
	$menue             = $menue_arr['menue'];
	$menue_meta        = $menue_arr['menue_meta'];
	$menue_shortlink   = $menue_arr['menue_shortlink'];
?>

<script type="text/javascript">

$(document).ready(function() {
	
 $("#jquery-tools-tooltip a[title]").tooltip({
 	offset: [5, 2]
 	}).dynamic({ bottom: { direction: 'down', bounce: true } });;
 
 $('a.button_mini').click(function(e) {
 	 	
var ID = $(this).attr("id");
var targetUrl = ' ';

switch(ID) {
<? foreach($menue as $item1) { ?>	
	case "confirm_link_<?=$item1["menueID"]?>":	targetUrl = "<?=base_url('admin/menue/delete/'.$item1['menueID'])?>"; 
													var $dialog = $('<div></div>')
													 .html('Wollen Sie den Men&uuml;punkt wirklich l&ouml;schen?<br>Bei Hauptpunkten werden alle Unterpunkte mitgel&ouml;scht!')
													  .dialog({
													   autoOpen: false,
													   title: 'Men&uuml;punkt l&ouml;schen',
													   width: '600px',
													   modal: true,
													   buttons: {
													    "L&ouml;schen": function() {
													             window.location.href = targetUrl;
													    },
													    "Zur&uuml;ck": function() {
													     $( this ).dialog( "close" );
													    }
													   }
													  });
													$dialog.dialog('open'); return false; 
													break;
<? 
	if($item1['subItems'] != 0) {
	foreach($item1['submenue'] as $item2) { 
?>
	case "confirm_link_<?=$item2["menueID"]?>":	targetUrl = "<?=base_url('admin/menue/delete/'.$item2['menueID'])?>"; 
													var $dialog = $('<div></div>')
													 .html('Wollen Sie den Men&uuml;punkt wirklich l&ouml;schen?')
													  .dialog({
													   autoOpen: false,
													   title: 'Men&uuml;punkt l&ouml;schen',
													   width: '600px',
													   modal: true,
													   buttons: {
													    "L&ouml;schen": function() {
													             window.location.href = targetUrl;
													    },
													    "Zur&uuml;ck": function() {
													     $( this ).dialog( "close" );
													    }
													   }
													  });
													$dialog.dialog('open'); return false; 
													break;
<? } } } ?>
<? foreach($menue_meta as $item3) { ?>	
    case "confirm_link_<?=$item3["menueID"]?>":	targetUrl = "<?=base_url('admin/menue/delete/'.$item3['menueID'])?>"; 
													var $dialog = $('<div></div>')
													 .html('Wollen Sie den Men&uuml;punkt wirklich l&ouml;schen?')
													  .dialog({
													   autoOpen: false,
													   title: 'Men&uuml;punkt l&ouml;schen',
													   width: '600px',
													   modal: true,
													   buttons: {
													    "L&ouml;schen": function() {
													             window.location.href = targetUrl;
													    },
													    "Zur&uuml;ck": function() {
													     $( this ).dialog( "close" );
													    }
													   }
													  });
													$dialog.dialog('open'); return false; 
													break;
<? } ?>
<? foreach($menue_shortlink as $item4) { ?>	
    case "confirm_link_<?=$item4["menueID"]?>":	targetUrl = "<?=base_url('admin/menue/delete/'.$item4['menueID'])?>"; 
													var $dialog = $('<div></div>')
													 .html('Wollen Sie den Men&uuml;punkt wirklich l&ouml;schen?')
													  .dialog({
													   autoOpen: false,
													   title: 'Men&uuml;punkt l&ouml;schen',
													   width: '600px',
													   modal: true,
													   buttons: {
													    "L&ouml;schen": function() {
													             window.location.href = targetUrl;
													    },
													    "Zur&uuml;ck": function() {
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
	<a href="<?=base_url('admin/menue/create/'.$area.'')?>" class="button_gross"><span class="button_add">Neuen Men&uuml;punkt anlegen</span></a>
</p>
<p>&nbsp;</p>

<h1>Hauptmen&uuml; verwalten</h1>

<table cellpadding="0" cellspacing="1" id="menue_table">
<thead>
	<tr>
		<th class="headline_text">Men&uuml;punkt</th>
		<th colspan="2" class="headline_pos">Position</th>
		<th class="headline_status">Status</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($menue as $item1) { ?>		
<tr bgcolor="<?=$item1['row_color']?>">
	<td class="menuepunkt"><strong><?=$item1['name']?></strong></td>
	<? if($item1['orderID'] == 1) { ?>
		<td class="button"><span id='jquery-tools-tooltip'><a class="button_mini"></a></span></td>
	<? } else { ?>	
		<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/order/up/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach oben schieben"><span class='button_up_small'></span></a></span></td>
	<? } ?>
	<? if($item1['orderID'] == $menue_arr['count']) { ?>
		<td class="button"><span id='jquery-tools-tooltip'><a class="button_mini"></a></span></td>
	<? } else { ?>			
		<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/order/down/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach unten schieben"><span class='button_down_small'></span></a></span></td>
	<? } ?>
	<td style='text-align:center'>
	<strong>
	<?  if($item1['online']==1) { ?>
		<span style='color: green;'>online</span>
	<?  } else { ?>
		<span style='color: red;'>offline</span>
	<?  } ?>
    </strong>
	</td>
<?	if($item1['online']==1) {	?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/0')?>" class="button_mini" title="Men&uuml;punkt offline schalten"><span class='button_online_small'></span></a></span></td>
<?	} else { ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/1')?>" class="button_mini" title="Men&uuml;punkt online schalten"><span class='button_offline_small'></span></a></span></td>
<?	} ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/edit/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt bearbeiten"><span class='button_edit_small'></span></a></span></td>
	<td class="button"><span id='jquery-tools-tooltip'><a id="confirm_link_<?=$item1['menueID']?>" href="<?=base_url('admin/menue/delete/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt löschen"><span class='button_delete_small'></span></a></span></td>
</tr> 
<!-- Unterpunkte -->
	<tr>
		<td colspan="7" class="unterpunkt_bg" id="unterpunkt_<?=$item1['menueID']?>">
			<table width="100%" cellpadding="0" cellspacing="1">
<? if($item1['subItems'] != 0) { ?>
<? foreach($item1['submenue'] as $item2) { ?>	
				<tr bgcolor="<?=$item2['row_color']?>">				
					<td class="menuepunkt"><?=$item2['name']?></td> 
					<? if($item2['orderID'] == 1) { ?>
						<td class="button"><span id='jquery-tools-tooltip'><a class="button_mini"></a></span></td>
					<? } else { ?>	
						<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/order/up/'.$item2['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach oben schieben"><span class='button_up_small'></span></a></span></td>
					<? } ?>
					<? if($item2['orderID'] == $item1['subItems']) { ?>
						<td class="button"><span id='jquery-tools-tooltip'><a class="button_mini"></a></span></td>
					<? } else { ?>			
						<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/order/down/'.$item2['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach unten schieben"><span class='button_down_small'></span></a></span></td>
					<? } ?>
					<td style='text-align:center'>
					<?  if($item2['online']==1) { ?>
						<span style='color: green;'>online</span>
					<?  } else { ?>
						<span style='color: red;'>offline</span>
					<?  } ?>
				</td>
			<?	if($item2['online']==1) {	?>
				<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/status/'.$item2['menueID'].'/0')?>" class="button_mini" title="Men&uuml;punkt offline schalten"><span class='button_online_small'></span></a></span></td>
			<?	} else { ?>
				<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/status/'.$item2['menueID'].'/1')?>" class="button_mini" title="Men&uuml;punkt online schalten"><span class='button_offline_small'></span></a></span></td>
			<?	} ?>
				<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/edit/'.$item2['menueID'])?>" class="button_mini" title="Men&uuml;punkt bearbeiten"><span class='button_edit_small'></span></a></span></td>
				<td class="button"><span id='jquery-tools-tooltip'><a id="confirm_link_<?=$item2['menueID']?>" href="<?=base_url('admin/menue/delete/'.$item2['menueID'])?>" class="button_mini" title="Men&uuml;punkt löschen"><span class='button_delete_small'></span></a></span></td>
				</tr>
<? } } else { ?>
			<tr bgcolor="<?=$item1['row_color']?>"><td>keine Unterpunkte</td></tr>
<? } ?>
			</table>
		</td>
	</tr>
    <tr><td></td></tr>
<? }  ?>
</tbody>
</table>

<? if($menue_arr['count_meta'] > 0) { ?>
<h1>Metanavigation verwalten</h1>

<table cellpadding="0" cellspacing="1" id="menue_table">
<thead>
	<tr>
		<th class="headline_text">Men&uuml;punkt</th>
		<th colspan="2" class="headline_pos">Position</th>
		<th class="headline_status">Status</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($menue_meta as $item1) { ?>		
<tr bgcolor="<?=$item1['row_color']?>">
	<td class="menuepunkt"><?=$item1['name']?></td>
	<? if($item1['orderID'] == 1) { ?>
		<td class="button"><span id='jquery-tools-tooltip'><a class="button_mini"></a></span></td>
	<? } else { ?>	
		<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/order/up/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach oben schieben"><span class='button_up_small'></span></a></span></td>
	<? } ?>
	<? if($item1['orderID'] == $menue_arr['count_meta']) { ?>
		<td class="button"><span id='jquery-tools-tooltip'><a class="button_mini"></a></span></td>
	<? } else { ?>			
		<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/order/down/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach unten schieben"><span class='button_down_small'></span></a></span></td>
	<? } ?>
	<td style='text-align:center'>
	<?  if($item1['online']==1) { ?>
		<span style='color: green;'>online</span>
	<?  } else { ?>
		<span style='color: red;'>offline</span>
	<?  } ?>
	</td>
<?	if($item1['online']==1) {	?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/1')?>" class="button_mini" title="Men&uuml;punkt offline schalten"><span class='button_online_small'></span></a></span></td>
<?	} else { ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/0')?>" class="button_mini" title="Men&uuml;punkt online schalten"><span class='button_offline_small'></span></a></span></td>
<?	} ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/edit/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt bearbeiten"><span class='button_edit_small'></span></a></span></td>
	<td class="button"><span id='jquery-tools-tooltip'><a id="confirm_link_<?=$item1['menueID']?>" href="<?=base_url('admin/menue/delete/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt löschen"><span class='button_delete_small'></span></a></span></td>
</tr>
<? }  ?>
</tbody>
</table>
<? }  ?>

<? if($menue_arr['count_shortlink'] > 0) { ?>
<h1>Shortlinknavigation verwalten</h1>

<table cellpadding="0" cellspacing="1" id="menue_table">
<thead>
	<tr>
		<th class="headline_text">Men&uuml;punkt</th>
		<th colspan="2" class="headline_pos">Position</th>
		<th class="headline_status">Status</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($menue_shortlink as $item1) { ?>		
<tr bgcolor="<?=$item1['row_color']?>">
	<td class="menuepunkt"><?=$item1['name']?></td>
	<? if($item1['orderID'] == 1) { ?>
		<td class="button"><span id='jquery-tools-tooltip'><a class="button_mini"></a></span></td>
	<? } else { ?>	
		<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/order/up/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach oben schieben"><span class='button_up_small'></span></a></span></td>
	<? } ?>
	<? if($item1['orderID'] == $menue_arr['count_shortlink']) { ?>
		<td class="button"><span id='jquery-tools-tooltip'><a class="button_mini"></a></span></td>
	<? } else { ?>			
		<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/order/down/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach unten schieben"><span class='button_down_small'></span></a></span></td>
	<? } ?>
	<td style='text-align:center'>
	<?  if($item1['online']==1) { ?>
		<span style='color: green;'>online</span>
	<?  } else { ?>
		<span style='color: red;'>offline</span>
	<?  } ?>
	</td>
<?	if($item1['online']==1) {	?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/1')?>" class="button_mini" title="Men&uuml;punkt offline schalten"><span class='button_online_small'></span></a></span></td>
<?	} else { ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/0')?>" class="button_mini" title="Men&uuml;punkt online schalten"><span class='button_offline_small'></span></a></span></td>
<?	} ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/menue/edit/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt bearbeiten"><span class='button_edit_small'></span></a></span></td>
	<td class="button"><span id='jquery-tools-tooltip'><a id="confirm_link_<?=$item1['menueID']?>" href="<?=base_url('admin/menue/delete/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt löschen"><span class='button_delete_small'></span></a></span></td>
</tr>
<? }  ?>
</tbody>
</table>
<? }  ?>

<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>