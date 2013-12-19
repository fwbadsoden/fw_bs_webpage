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
            <td><a href="<?=base_url('admin/content/einsatz/mofo/create')?>" class="button_gross"><span class="button_add">Neuen Vorschlagswert anlegen</span></a></td>
        </tr>
    </table>
</p>
<? endif;                           ?>

<h1>Vorschlagswerte für weitere Einsatzkräfte verwalten</h1>

<table cellpadding="0" cellspacing="1" id="mofo_table">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_titel">Wert</th>
		<th colspan="2" class="headline_edit2">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($mofos as $mofo) :     ?>		
<tr bgcolor="<?=$mofo->row_color?>">
	<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$mofo->value?></td>
                         
<?  if($privileged['edit']) :       ?>
	<td class="button"><a href="<?=base_url('admin/content/einsatz/mofo/edit/'.$mofo->id)?>" class="button_mini" title="Vorschlagswert bearbeiten"><span class='button_edit_small'></span></a></td>
    <td class="button"><a id="confirm_link_<?=$mofo->id?>" href="<?=base_url('admin/content/einsatz/mofo/checkdel/'.$mofo->id)?>" class="button_mini" title="Vorschlagswert löschen"><span class='button_delete_small'></span></a></td>  
<?  else :                          ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Vorschlagswert zu bearbeiten"><span class='button_lock_small'></span></a></td>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Vorschlagswert zu löschen"><span class='button_lock_small'></span></a></td>
<?  endif;                          ?>    
</tr>
<?  $i++;
   endforeach;                      ?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>
