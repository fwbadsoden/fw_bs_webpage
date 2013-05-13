<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');
    $i = 1;
?>

<div id="content">
<p class="thirdMenue">
    <table>
        <tr>
            <td><a href="<?=base_url('admin/content/stage/create')?>" class="button_gross"><span class="button_layout_add">Neue Bildb&uuml;hne anlegen</span></a></td>
        </tr>
    </table>
</p>

<h1>Bildb&uuml;hnen verwalten</h1>

<table cellpadding="0" cellspacing="1" id="stage_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_titel">Name</th>
		<th class="headline_status">Status</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody> 
<? foreach($stage as $item) { ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$item['name']?></td>
	<td style='text-align:center'>
	<?  if($item['online']==1) { ?>
		<span style='color: green;'>online</span>
	<?  } else { ?>
		<span style='color: red;'>offline</span>
	<?  } ?>
	</td>
<?	if($item['online']==1) {	?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/stage/status/'.$item['stageID'].'/1')?>" class="button_mini" title="Bildb&uuml;hne offline schalten"><span class='button_online_small'></span></a></span></td>
<?	} else { ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/stage/status/'.$item['stageID'].'/0')?>" class="button_mini" title="Bildb&uuml;hne online schalten"><span class='button_offline_small'></span></a></span></td>
<?	} ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/stage/edit/'.$item['stageID'])?>" class="button_mini" title="Bildb&uuml;hne bearbeiten"><span class='button_edit_small'></span></a></span></td>
	<td class="button"><span id='jquery-tools-tooltip'><a id="confirm_link_<?=$item['stageID']?>" href="<?=base_url('admin/content/stage/checkdelete/'.$item['stageID'])?>" class="button_mini" title="Bildb&uuml;hne l&ouml;schen"><span class='button_delete_small'></span></a></span></td> 
</tr>
<?
    $i++; 
  } 
?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>