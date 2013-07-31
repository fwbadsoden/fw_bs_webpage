<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');
    $i = 1;
?>

<div id="content">
<? if($privileged['edit']) :        ?>
<p class="thirdMenue">
    <table>
        <tr>
            <td><a href="<?=base_url('admin/content/stage/create')?>" class="button_gross"><span class="button_layout_add">Neue Bildb&uuml;hne anlegen</span></a></td>
        </tr>
    </table>
</p>
<? endif;                           ?>

<h1>Bildb&uuml;hnen verwalten</h1>

<table cellpadding="0" cellspacing="1" id="stage_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_titel">Name</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody> 
<?  foreach($stage as $item) :  ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$item['name']?></td>
<?	if($item['online']==1) :	
        if($privileged['edit']) : ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/stage/status/'.$item['stageID'].'/1')?>" class="button_mini" title="Bildb&uuml;hne offline schalten"><span class='button_online_small'></span></a></span></td>
<?      else :                  ?>
    <td class="button"><span id='jquery-tools-tooltip'><a class="button_mini" title="Sie haben keine Berechtigung den Bildbühnenstatus zu bearbeiten"><span class='button_online_small'></span></a></span></td>
<?      endif;
	else : 
        if($privileged['edit']) : ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/stage/status/'.$item['stageID'].'/0')?>" class="button_mini" title="Bildb&uuml;hne online schalten"><span class='button_offline_small'></span></a></span></td>
<?      else :                  ?>
    <td class="button"><span id='jquery-tools-tooltip'><a class="button_mini" title="Sie haben keine Berechtigung den Bildbühnenstatus zu bearbeiten"><span class='button_offline_small'></span></a></span></td>
<?      endif;
	endif; 
    if($privileged['edit']) :   ?>
	<td class="button"><span id='jquery-tools-tooltip'><a href="<?=base_url('admin/content/stage/edit/'.$item['stageID'])?>" class="button_mini" title="Bildb&uuml;hne bearbeiten"><span class='button_edit_small'></span></a></span></td>
	<td class="button"><span id='jquery-tools-tooltip'><a id="confirm_link_<?=$item['stageID']?>" href="<?=base_url('admin/content/stage/checkdelete/'.$item['stageID'])?>" class="button_mini" title="Bildb&uuml;hne l&ouml;schen"><span class='button_delete_small'></span></a></span></td> 
<?  else :                      ?>
    <td class="button"><span id='jquery-tools-tooltip'><a class="button_mini" title="Sie haben keine Berechtigung die Bildbühne zu bearbeiten"><span class='button_lock_small'></span></a></span></td>
    <td class="button"><span id='jquery-tools-tooltip'><a class="button_mini" title="Sie haben keine Berechtigung die Bildbühne zu löschen"><span class='button_lock_small'></span></a></span></td>
<?  endif;                      ?>
</tr>
<?  $i++; 
    endforeach; ?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>