<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');
    $i=0;
?>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#mannschaft_table").tablesorter({
            headers: { 
                0:  { sorter: false },
                3:  { sorter: false }
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
            <td><a href="<?=base_url('admin/content/mannschaft/create')?>" class="button_gross"><span class="button_add">Neues Mannschaftsmitglied anlegen</span></a></td>
       </tr>
    </table>
</p>
<? endif;                           ?>

<h1>Mannschaft verwalten</h1>

<table cellpadding="0" cellspacing="1" id="mannschaft_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_name">Beginn</th>
		<th class="headline_name">Ende</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($mannschaft as $item) :     
    $i++;
?>		
<tr bgcolor="<?=$item->row_color?>">
	<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$item->name?></td>
	<td><?=$item->vorname?></td>

<?	if($item->online==1) :        	
        if($privileged['edit']) :   ?>
	<td class="button"><a href="<?=base_url('admin/content/mannschaft/status/'.$item->mannschaftID.'/1')?>" class="button_mini" title="Mitglied offline schalten"><span class='button_online_small'></span></a></td>
<?      else :                      ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Mannschaft zu bearbeiten"><span class='button_online_small'></span></a></td>
<?      endif;                          
  	 else :                         
        if($privileged['edit']) :   ?>
	<td class="button"><a href="<?=base_url('admin/content/mannschaft/status/'.$item->mannschaftID.'/0')?>" class="button_mini" title="Mitglied online schalten"><span class='button_offline_small'></span></a></td>
<?      else :                      ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Mannschaft zu bearbeiten"><span class='button_offline_small'></span></a></td>
<?      endif;                      
	endif;                          
    if($privileged['edit']) :       ?>
	<td class="button"><a href="<?=base_url('admin/content/mannschaft/edit/'.$item->mannschaftID)?>" class="button_mini" title="Mitglied bearbeiten"><span class='button_edit_small'></span></a></td>
	<td class="button"><a id="confirm_link_<?=$item->mannschaftID?>" href="<?=base_url('admin/content/mannschaft/checkdel/'.$item->mannschaftID)?>" class="button_mini" title="Mitglied löschen"><span class='button_delete_small'></span></a></td>
<?  else :                          ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Mannschaft zu bearbeiten"><span class='button_lock_small'></span></a></td>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung das Mitglied zu löschen"><span class='button_lock_small'></span></a></td>
<?  endif;                          ?>    
</tr>
<? endforeach;                      ?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>
