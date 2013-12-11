<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');

?>

<div id="content">
<? if($privileged['edit']) :        ?>
<p class="thirdMenue">
	<table>
        <tr>
            <td><a href="<?=base_url('admin/content/einsatz/cue/create')?>" class="button_gross"><span class="button_add">Neues Stichwort anlegen</span></a></td>
        </tr>
    </table>
</p>
<? endif;                           ?>

<h1>Einsatzstichwörter verwalten</h1>

<table cellpadding="0" cellspacing="1" id="cue_table">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_cue">Stichwort</th>
		<th class="headline_titel">Beschreibung</th>
		<th colspan="2" class="headline_edit2">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($cues as $cue) :     ?>		
<tr bgcolor="<?=$cue->row_color?>">
	<td><?=str_pad($cue->id, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$cue->name?></td>
	<td><?=$cue->mimic?></td>
                         
<?  if($privileged['edit']) :       ?>
	<td class="button"><a href="<?=base_url('admin/content/einsatz/cue/edit/'.$cue->id)?>" class="button_mini" title="Einsatzstichwort bearbeiten"><span class='button_edit_small'></span></a></td>
<?  if($cue->deletable == 1) :      ?>    
	<td class="button"><a id="confirm_link_<?=$cue->id?>" href="<?=base_url('admin/content/einsatz/cue/checkdel/'.$cue->id)?>" class="button_mini" title="Einsatzstichwort löschen"><span class='button_delete_small'></span></a></td>
<?  else :                          ?>
    <td class="button"><a class="button_mini" title="Einsatzstichwort kann nicht gelöscht werden. Es wird bereits in mindestens einem Einsatz verwendet."><span class='button_lock_small'></span></a></td>
<?  endif;                          ?>    
<?  else :                          ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung das Einsatzstichwort zu bearbeiten"><span class='button_lock_small'></span></a></td>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung das Einsatzstichwort zu löschen"><span class='button_lock_small'></span></a></td>
<?  endif;                          ?>    
</tr>
<? endforeach;                      ?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>
