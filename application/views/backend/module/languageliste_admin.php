<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');
?>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#lang_table").tablesorter({
            headers: { 
                3:  { sorter: false },  
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
            <td><a href="<?=base_url('admin/system/language/create')?>" class="button_gross"><span class="button_add">Neuen Text anlegen</span></a></td>
            <td><a href="<?=base_url('admin/system/language/write')?>" class="button_gross"><span class="button_save">Textdatei neu schreiben</span></a></td>
        </tr>
    </table>
</p>
<? endif;                           ?>

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

<? foreach($language as $item) : ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=$item['moduleName']?></td>
	<td><?=$item['key']?></td>
	<td><?=$item['text']?></td>
	<td><?=$item['desc']?></td>
<?  if($privileged['edit']) :       ?>
	<td><a href="<?=base_url('admin/system/language/edit/'.$item['langID'])?>" class="button_mini" title="Text bearbeiten"><span class='button_edit_small'></span></a></td>
	<td><a id="confirm_link_<?=$item['langID']?>" href="<?=base_url('admin/system/language/delete/'.$item['langID'])?>" class="button_mini" title="Text löschen"><span class='button_delete_small'></span></a></td>
<?  else :                          ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Text zu bearbeiten"><span class='button_lock_small'></span></a></td>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Text zu löschen"><span class='button_lock_small'></span></a></td>
<?  endif;                          ?>
</tr>
<? endforeach; ?>
</tbody>
</table>
<p>&nbsp;</p>
<div style="clear:both;"></div>
</div>