<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');
?>

<div id="content">
<? if($privileged['edit']) :        ?>
<p class="thirdMenue">
	<a href="<?=base_url('admin/content/fahrzeug/create')?>" class="button_gross"><span class="button_car_add">Neues Fahrzeug anlegen</span></a>
</p>
<p>&nbsp;</p>
<? endif;                           ?>

<h1>Fahrzeuge verwalten</h1>

<table cellpadding="0" cellspacing="1" id="fahrzeug_table">
<thead>
	<tr>
		<th class="headline_funkrufname">Funkrufname</th>
		<th class="headline_titel">Fahrzeugname</th>
		<th colspan="2" class="headline_pos">Position</th>
		<th colspan="4" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($fahrzeug as $item) :    ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=$item['fahrzeugRufnamePrefix']." ".$item['fahrzeugRufname'];?></td>
	<td><?=$item['fahrzeugName']?></td>
<?  if($item['orderID'] == 1) :    ?>
		<td class="button"><a class="button_mini"></a></span></td>
<?  else :                          
        if($privileged['edit']) :   ?>
		<td class="button"><a href="<?=base_url('admin/content/fahrzeug/order/up/'.$item['fahrzeugID'])?>" class="button_mini" title="Fahrzeug nach oben schieben"><span class='button_up_small'></span></a></td>
<?      else :                      ?>
        <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Fahrzeugposition zu bearbeiten"><span class='button_lock_small'></span></a></td>
<?      endif;                      ?>        
<?  endif;                          ?>
<?  if($item['orderID'] == (count($fahrzeug))) : ?>
		<td class="button"><a class="button_mini"></a></span></td>
<?  else :                          
        if($privileged['edit']) :   ?>		
		<td class="button"><a href="<?=base_url('admin/content/fahrzeug/order/down/'.$item['fahrzeugID'])?>" class="button_mini" title="Fahrzeug nach unten schieben"><span class='button_down_small'></span></a></td>
<?      else :                      ?>
        <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Fahrzeugposition zu bearbeiten"><span class='button_lock_small'></span></a></td>
<?      endif;                      ?> 
<?  endif;                          ?>
<?	if($item['online']==1) :        	
        if($privileged['edit']) :   ?>
	<td class="button"><a href="<?=base_url('admin/content/fahrzeug/status/'.$item['fahrzeugID'].'/1')?>" class="button_mini" title="Fahrzeug offline schalten"><span class='button_online_small'></span></a></td>
<?      else :                      ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Fahrzeugstatus zu bearbeiten"><span class='button_online_small'></span></a></td>
<?      endif;                      
 	else :                         
        if($privileged['edit']) :           
            if($item['ready']==1) :?>
	<td class="button"><a href="<?=base_url('admin/content/fahrzeug/status/'.$item['fahrzeugID'].'/0')?>" class="button_mini" title="Fahrzeug online schalten"><span class='button_offline_small'></span></a></td>
<?          else :                  ?>
    <td class="button"><a class="button_mini" title="Fahrzeug kann nicht online geschaltet werden. Das kleine Bild für die Fahrzeugübersicht fehlt noch!"><span class='button_offline_small'></span></a></td>
<?          endif; 
        else:                       ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Fahrzeugstatus zu bearbeiten"><span class='button_offline_small'></span></a></td>
<?      endif;
  	endif;             
    if($privileged['edit']) :       ?>
	<td class="button"><a href="<?=base_url('admin/content/fahrzeug/edit/'.$item['fahrzeugID'])?>" class="button_mini" title="Fahrzeug bearbeiten"><span class='button_edit_small'></span></a></td>
    <td class="button"><a href="<?=base_url('admin/content/fahrzeug/image/edit/'.$item['fahrzeugID'])?>" class="button_mini" title="Fahrzeugbilder bearbeiten"><span class='button_image_edit_small'></span></a></td>
    <td class="button">
<?      if($item['delete']==1) :	?>	
		<a id="confirm_link_<?=$item['fahrzeugID']?>" href="<?=base_url('admin/content/fahrzeug/checkdel/'.$item['fahrzeugID'])?>" class="button_mini" title="Fahrzeug löschen"><span class='button_delete_small'></span></a>
<?      else :                      ?>
		<a class="button_mini" title="Fahrzeug kann nicht gelöscht werden. Wird bereits verwendet."><span class='button_lock_small'></span></a>
<?      endif;                      ?>
    </td>
<?  else :                          ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung das Fahrzeug zu bearbeiten"><span class='button_lock_small'></span></a></td>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Fahrzeugbilder zu bearbeiten"><span class='button_lock_small'></span></a></td>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung das Fahrzeug zu löschen"><span class='button_lock_small'></span></a></td>
<?  endif;                          ?>
</tr>
<? endforeach;                      ?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
