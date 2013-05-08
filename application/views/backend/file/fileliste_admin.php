<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');
    $i=1;
?>

<div id="content">
<p class="thirdMenue">
    <table>
        <tr>
            <td><a href="<?=base_url('admin/files/upload/'.$typeID)?>" class="button_gross"><span class="button_add"><?=$btn_create?></span></a></td>
        </tr>
    </table>
</p>

<h1><?=$headline?></h1>

<table cellpadding="0" cellspacing="1" id="file_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_titel">Name</th>
		<th class="headline_status">Status</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody> 
<? foreach($files as $item) { ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$item['pageName']?></td>
	<td style='text-align:center'>
	<?  if($item['online']==1) { ?>
		<span style='color: green;'>online</span>
	<?  } else { ?>
		<span style='color: red;'>offline</span>
	<?  } ?>
	</td>
<?	if($item['online']==1) {	?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/page/status/'.$item['pageID'].'/1')?>" class="button_mini" title="Seite offline schalten"><span class='button_online_small'></span></a></span></td>
<?	} else { ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/page/status/'.$item['pageID'].'/0')?>" class="button_mini" title="Seite online schalten"><span class='button_offline_small'></span></a></span></td>
<?	} ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/page/edit/'.$item['pageID'])?>" class="button_mini" title="Seite bearbeiten"><span class='button_edit_small'></span></a></span></td>
<? if($item['is_deletable']) { ?>
	<td class="button"><span id='jquery-tools-tooltip'><a id="confirm_link_<?=$item['pageID']?>" href="<?=base_url('admin/content/page/checkdelete/'.$item['pageID'])?>" class="button_mini" title="Seite l&ouml;schen"><span class='button_delete_small'></span></a></span></td>
<? } else { ?>
    <td class="button">><a class="button_mini" title="Seite kann nicht gel&ouml;scht werden.<br>Sie wird in einem Menüpunkt verwendet."><span class='button_lock_small'></span></a></span></td>
<? } ?>    
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