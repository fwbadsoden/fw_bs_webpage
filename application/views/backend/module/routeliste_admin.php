<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');

?>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#route_table").tablesorter({
            headers: { 
                4:  { sorter: false }
            } 
        }); 
    } 
); 
</script> 

<div id="content">
<? if($privileged['edit']) :        ?>
<p class="thirdMenue">	
	<table>
        <tr>
            <td><a href="<?=base_url('admin/system/route/create')?>" class="button_gross"><span class="button_add">Neue Route anlegen</span></a></td>
            <td><a href="<?=base_url('admin/system/route/write')?>" class="button_gross"><span class="button_save">Routendatei neu schreiben</span></a></td>
        </tr>
    </table>
</p>
<? endif;                           ?>

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
<? foreach($route as $item) : ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=$item['bereich']?></td>
	<td><?=$item['moduleName']?></td>
	<td><?=$item['route']?></td>
	<td><?=$item['internalLink']?></td>
<?	if($item['active']==1) :	
        if($privileged['edit']) :        ?>
	<td class="button"><a href="<?=base_url('admin/system/route/status/'.$item['routeID'].'/1')?>" class="button_mini" title="Route offline schalten"><span class='button_online_small'></span></a></td>
<?      else:                            ?>

<?      endif;
	else : 
        if($privileged['edit']) :        ?>
	<td class="button"><a href="<?=base_url('admin/system/route/status/'.$item['routeID'].'/0')?>" class="button_mini" title="Route online schalten"><span class='button_offline_small'></span></a></td>
<?      else :                           ?>

<?      endif;                           
	endif;                           
    if($privileged['edit']) :            ?>
	<td class="button"><a href="<?=base_url('admin/system/route/edit/'.$item['routeID'])?>" class="button_mini" title="Route bearbeiten"><span class='button_edit_small'></span></a></td>
<?  else :                               ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Route zu bearbeiten"><span class='button_lock_small'></span></a></td>
<?  endif;                               ?>
</tr>
<? endforeach; ?>
</tbody>
</table>
<p>&nbsp;</p>
<div style="clear:both;"></div>
</div>