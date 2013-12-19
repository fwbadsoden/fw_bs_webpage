<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');

?>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#einsatz_table").tablesorter({
            headers: { 
                0:  { sorter: false },
                5:  { sorter: false },  
                6:  { sorter: false }  
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
            <td><a href="<?=base_url('admin/content/einsatz/create')?>" class="button_gross"><span class="button_add">Neuen Einsatz anlegen</span></a></td>
            <? if($this->cp_auth->is_privileged(EINSATZCUE_PRIV_DISPLAY)) : ?> <td><a href="<?=base_url('admin/content/einsatz/cue')?>" class="button_gross"><span class="button_key">Einsatzstichwörter</span></a></td> <? endif; ?>
            <? if($this->cp_auth->is_privileged(EINSATZMOFO_PRIV_DISPLAY)) : ?><td><a href="<?=base_url('admin/content/einsatz/mofo')?>" class="button_gross"><span class="button_page_white_text">Vorschlagswerte weitere Einsatzkräfte</span></a></td> <? endif; ?>
        </tr>
    </table>
</p>
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
		<th class="headline_datetime">Beginn</th>
		<th class="headline_datetime">Ende</th>
		<th class="headline_titel">Referenz</th>
		<th class="headline_id">Bilder</th>
		<th colspan="4" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($einsatz as $item) :     ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=str_pad($item['einsatzID'], 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=str_pad($item['einsatzNr'], 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$item['datum_beginn']?> <?=$item['uhrzeit_beginn']?></td>
	<td><?=$item['datum_ende']?> <?=$item['uhrzeit_ende']?></td>
	<td><?=$item['einsatzName']?></td>
	<td class="centered"><?=$item['imgCount']?></td> 

<?	if($item['online']==1) :        	
        if($privileged['edit']) :   ?>
	<td class="button"><a href="<?=base_url('admin/content/einsatz/status/'.$item['einsatzID'].'/1/'.$item['year'])?>" class="button_mini" title="Einsatz offline schalten"><span class='button_online_small'></span></a></td>
<?      else :                      ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Einsatzstatus zu bearbeiten"><span class='button_online_small'></span></a></td>
<?      endif;                          
  	 else :                         
        if($privileged['edit']) :   ?>
	<td class="button"><a href="<?=base_url('admin/content/einsatz/status/'.$item['einsatzID'].'/0/'.$item['year'])?>" class="button_mini" title="Einsatz online schalten"><span class='button_offline_small'></span></a></td>
<?      else :                      ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Einsatzstatus zu bearbeiten"><span class='button_offline_small'></span></a></td>
<?      endif;                      
	endif;                          
    if($privileged['edit']) :       ?>
	<td class="button"><a href="<?=base_url('admin/content/einsatz/edit/'.$item['einsatzID'])?>" class="button_mini" title="Einsatz bearbeiten"><span class='button_edit_small'></span></a></td>
	<td class="button"><a href="<?=base_url('admin/content/einsatz/image/edit/'.$item['einsatzID'])?>" class="button_mini" title="Einsatzbilder bearbeiten"><span class='button_image_edit_small'></span></a></td>
	<td class="button"><a id="confirm_link_<?=$item['einsatzID']?>" href="<?=base_url('admin/content/einsatz/checkdel/'.$item['einsatzID'])?>" class="button_mini" title="Einsatz löschen"><span class='button_delete_small'></span></a></td>
<?  else :                          ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Einsatz zu bearbeiten"><span class='button_lock_small'></span></a></td>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Einsatzbilder zu bearbeiten"><span class='button_lock_small'></span></a></td>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Einsatz zu löschen"><span class='button_lock_small'></span></a></td>
<?  endif;                          ?>    
</tr>
<? endforeach;                      ?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>
