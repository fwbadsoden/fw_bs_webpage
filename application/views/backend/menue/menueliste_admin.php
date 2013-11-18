<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');
	
	$menue             = $menue_arr['menue'];
	$menue_meta        = $menue_arr['menue_meta'];
	$menue_shortlink   = $menue_arr['menue_shortlink'];
?>

<div id="content">
<? if($privileged['edit']) :        ?>
<p class="thirdMenue">
	<a href="<?=base_url('admin/menue/create/'.$area.'')?>" class="button_gross"><span class="button_add">Neuen Men&uuml;punkt anlegen</span></a>
</p>
<p>&nbsp;</p>
<? endif;                           ?>

<h1>Hauptmen&uuml; verwalten</h1>

<table cellpadding="0" cellspacing="1" id="menue_table">
<thead>
	<tr>
		<th class="headline_text">Men&uuml;punkt</th>
		<th colspan="2" class="headline_pos">Position</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($menue as $item1) :      ?>		
<tr bgcolor="<?=$item1['row_color']?>">
	<td class="menuepunkt"><strong><?=$item1['name']?></strong></td>
<?  if($item1['orderID'] == 1) :    ?>
		<td class="button"><a class="button_mini"></a></span></td>
<?  else :                          
        if($privileged['edit']) :   ?>
		<td class="button"><a href="<?=base_url('admin/menue/order/up/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach oben schieben"><span class='button_up_small'></span></a></td>
<?      else :                      ?>
        <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Menüpunktposition zu bearbeiten"><span class='button_lock_small'></span></a></td>
<?      endif;                      ?>        
<?  endif;                          ?>
<?  if($item1['orderID'] == $menue_arr['count']) : ?>
		<td class="button"><a class="button_mini"></a></span></td>
<?  else :                          
        if($privileged['edit']) :   ?>		
		<td class="button"><a href="<?=base_url('admin/menue/order/down/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach unten schieben"><span class='button_down_small'></span></a></td>
<?      else :                      ?>
        <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Menüpunktposition zu bearbeiten"><span class='button_lock_small'></span></a></td>
<?      endif;                      ?> 
<?  endif;                          ?>
<?	if($item1['online']==1) :	    
        if($privileged['edit']) :   ?>
	<td class="button"><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/0')?>" class="button_mini" title="Men&uuml;punkt offline schalten"><span class='button_online_small'></span></a></td>
<?      else :                      ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunktstatus zu bearbeiten"><span class='button_online_small'></span></a></td>
<?      endif;
  	else :                          
        if($privileged['edit']) :   ?>
	<td class="button"><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/1')?>" class="button_mini" title="Men&uuml;punkt online schalten"><span class='button_offline_small'></span></a></td>
<?      else :                      ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunktstatus zu bearbeiten"><span class='button_offline_small'></span></a></td>
<?      endif;
	endif;                         
    if($privileged['edit']) :       ?>
	<td class="button"><a href="<?=base_url('admin/menue/edit/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt bearbeiten"><span class='button_edit_small'></span></a></td>
	<td class="button"><a id="confirm_link_<?=$item1['menueID']?>" href="<?=base_url('admin/menue/checkdel/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt löschen"><span class='button_delete_small'></span></a></td>
<?  else :                          ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunkt zu bearbeiten"><span class='button_lock_small'></span></a></td>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunkt zu löschen"><span class='button_lock_small'></span></a></td>
<?  endif;                          ?>
</tr> 
<!-- Unterpunkte -->
    <tr><td></td></tr>
	<tr>
		<td colspan="7" class="unterpunkt_bg" id="unterpunkt_<?=$item1['menueID']?>">
			<table width="100%" cellpadding="0" cellspacing="1">
<? if($item1['subItems'] != 0) :         ?>
<?      foreach($item1['submenue'] as $item2) : ?>	
				<tr bgcolor="<?=$item2['row_color']?>">				
					<td class="menuepunkt"><?=$item2['name']?></td> 
<?          if($item2['orderID'] == 1) : ?>
						<td class="button"><a class="button_mini"></a></span></td>
<?          else :                       
                if($privileged['edit']) : ?>
						<td class="button"><a href="<?=base_url('admin/menue/order/up/'.$item2['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach oben schieben"><span class='button_up_small'></span></a></td>
<?              else :                   ?>
                        <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Menüpunktposition zu bearbeiten"><span class='button_lock_small'></span></a></td>
<?              endif;
            endif;                       
            if($item2['orderID'] == $item1['subItems']) : ?>
						<td class="button"><a class="button_mini"></a></span></td>
<?          else :                       
                if($privileged['edit']) : ?>		
						<td class="button"><a href="<?=base_url('admin/menue/order/down/'.$item2['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach unten schieben"><span class='button_down_small'></span></a></td>
<?              else :                   ?>                        
                        <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Menüpunktposition zu bearbeiten"><span class='button_lock_small'></span></a></td>
<?              endif;
            endif;                 
	        if($item2['online']==1) :	
                if($privileged['edit']) : ?>
				<td class="button"><a href="<?=base_url('admin/menue/status/'.$item2['menueID'].'/0')?>" class="button_mini" title="Men&uuml;punkt offline schalten"><span class='button_online_small'></span></a></td>
<?              else :                   ?>       
                <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunktstatus zu bearbeiten"><span class='button_online_small'></span></a></td>
<?              endif;         
	        else :                       
                if($privileged['edit']) : ?>
				<td class="button"><a href="<?=base_url('admin/menue/status/'.$item2['menueID'].'/1')?>" class="button_mini" title="Men&uuml;punkt online schalten"><span class='button_offline_small'></span></a></td>
<?              else :                   ?>                 
                <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunktstatus zu bearbeiten"><span class='button_offline_small'></span></a></td>
<?              endif;         
	        endif;                       
            if($privileged['edit']) :    ?>
				<td class="button"><a href="<?=base_url('admin/menue/edit/'.$item2['menueID'])?>" class="button_mini" title="Men&uuml;punkt bearbeiten"><span class='button_edit_small'></span></a></td>
				<td class="button"><a id="confirm_link_<?=$item2['menueID']?>" href="<?=base_url('admin/menue/checkdel/'.$item2['menueID'])?>" class="button_mini" title="Men&uuml;punkt löschen"><span class='button_delete_small'></span></a></td>
<?          else :                       ?>
                <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunkt zu bearbeiten"><span class='button_lock_small'></span></a></td>
                <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunkt zu löschen"><span class='button_lock_small'></span></a></td>
<?          endif;                       ?>
				</tr>
<? endforeach;
   else :                                ?>
			<tr bgcolor="<?=$item1['row_color']?>"><td>keine Unterpunkte</td></tr>
<? endif;                                ?>
			</table>
		</td>
	</tr>
    <tr><td></td></tr>
    <tr><td></td></tr>
<? endforeach;  ?>
</tbody>
</table>

<? if($menue_arr['count_meta'] > 0) : ?>
<h1>Metanavigation verwalten</h1>

<table cellpadding="0" cellspacing="1" id="menue_table">
<thead>
	<tr>
		<th class="headline_text">Men&uuml;punkt</th>
		<th colspan="2" class="headline_pos">Position</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($menue_meta as $item1) : ?>		
<tr bgcolor="<?=$item1['row_color']?>">
	<td class="menuepunkt"><?=$item1['name']?></td>
	<? if($item1['orderID'] == 1) : ?>
		<td class="button"><a class="button_mini"></a></span></td>
	<? else : 
            if($privileged['edit']) : ?>	
		<td class="button"><a href="<?=base_url('admin/menue/order/up/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach oben schieben"><span class='button_up_small'></span></a></td>
<?          else :                    ?>
        <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Menüpunktposition zu bearbeiten"><span class='button_lock_small'></span></a></td>
<?          endif;        
	   endif; ?>
	<? if($item1['orderID'] == $menue_arr['count_meta']) : ?>
		<td class="button"><a class="button_mini"></a></span></td>
	<? else : 
            if($privileged['edit']) : ?>			
		<td class="button"><a href="<?=base_url('admin/menue/order/down/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach unten schieben"><span class='button_down_small'></span></a></td>
<?          else :                    ?>        
        <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Menüpunktposition zu bearbeiten"><span class='button_lock_small'></span></a></td>
<?          endif;
       endif; ?>
<?	if($item1['online']==1) :   	
        if($privileged['edit']) : ?>
	<td class="button"><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/1')?>" class="button_mini" title="Men&uuml;punkt offline schalten"><span class='button_online_small'></span></a></td>
<?      else :                    ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunktstatus zu bearbeiten"><span class='button_online_small'></span></a></td>
<?      endif;                    ?>
<?	else :   	
        if($privileged['edit']) : ?>
	<td class="button"><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/0')?>" class="button_mini" title="Men&uuml;punkt online schalten"><span class='button_offline_small'></span></a></td>
<?      else :                    ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunktstatus zu bearbeiten"><span class='button_offline_small'></span></a></td>
<?      endif;                    ?>
<?	endif;                        
    if($privileged['edit']) :     ?>
	<td class="button"><a href="<?=base_url('admin/menue/edit/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt bearbeiten"><span class='button_edit_small'></span></a></td>
	<td class="button"><a id="confirm_link_<?=$item1['menueID']?>" href="<?=base_url('admin/menue/checkdel/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt löschen"><span class='button_delete_small'></span></a></td>
<?  else :                        ?>
                <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunkt zu bearbeiten"><span class='button_lock_small'></span></a></td>
                <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunkt zu löschen"><span class='button_lock_small'></span></a></td>
<?  endif;                        ?>
</tr>
<? endforeach; ?>
</tbody>
</table>
<? endif;  ?>

<? if($menue_arr['count_shortlink'] > 0) : ?>
<h1>Shortlinknavigation verwalten</h1>

<table cellpadding="0" cellspacing="1" id="menue_table">
<thead>
	<tr>
		<th class="headline_text">Men&uuml;punkt</th>
		<th colspan="2" class="headline_pos">Position</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? foreach($menue_shortlink as $item1) : ?>		
<tr bgcolor="<?=$item1['row_color']?>">
	<td class="menuepunkt"><?=$item1['name']?></td>
<?  if($item1['orderID'] == 1) : ?>
		<td class="button"><a class="button_mini"></a></span></td>
<?  else :                     
        if($privileged['edit']) : ?>
		<td class="button"><a href="<?=base_url('admin/menue/order/up/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach oben schieben"><span class='button_up_small'></span></a></td>
<?      else :                  ?>
        <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Menüpunktposition zu bearbeiten"><span class='button_lock_small'></span></a></td>
<?      endif;
    endif;                      
    if($item1['orderID'] == $menue_arr['count_shortlink']) : ?>
		<td class="button"><a class="button_mini"></a></span></td>
<?  else :                    
        if($privileged['edit']) : ?>			
		<td class="button"><a href="<?=base_url('admin/menue/order/down/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt nach unten schieben"><span class='button_down_small'></span></a></td>
<?      else :                  ?>
        <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die Menüpunktposition zu bearbeiten"><span class='button_lock_small'></span></a></td>
<?      endif;
    endif;                        
	if($item1['online']==1) :	
        if($privileged['edit']) : ?>
	<td class="button"><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/1')?>" class="button_mini" title="Men&uuml;punkt offline schalten"><span class='button_online_small'></span></a></td>
<?      else :                  ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunktstatus zu bearbeiten"><span class='button_online_small'></span></a></td>
<?      endif;
    else :                      
        if($privileged['edit']) : ?>
	<td class="button"><a href="<?=base_url('admin/menue/status/'.$item1['menueID'].'/0')?>" class="button_mini" title="Men&uuml;punkt online schalten"><span class='button_offline_small'></span></a></td>
<?      else :                  ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunktstatus zu bearbeiten"><span class='button_offline_small'></span></a></td>
<?      endif;
    endif;
    if($privileged['edit']) :   ?>
	<td class="button"><a href="<?=base_url('admin/menue/edit/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt bearbeiten"><span class='button_edit_small'></span></a></td>
	<td class="button"><a id="confirm_link_<?=$item1['menueID']?>" href="<?=base_url('admin/menue/checkdel/'.$item1['menueID'])?>" class="button_mini" title="Men&uuml;punkt löschen"><span class='button_delete_small'></span></a></td>
<?  else :                      ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunkt zu bearbeiten"><span class='button_lock_small'></span></a></td>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Menüpunkt zu löschen"><span class='button_lock_small'></span></a></td>
<?  endif;                      ?>
</tr>
<? endforeach;                  ?>
</tbody>
</table>
<? endif;                       ?>

<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>