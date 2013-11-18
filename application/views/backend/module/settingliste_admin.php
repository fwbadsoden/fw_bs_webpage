<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->helper('form');
	
	$this->load->library('form_validation');
	
	$form = array(
		'id'	 	=> 'route',
	);		

?>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#setting_table").tablesorter({
            headers: { 
                2:  { sorter: false }  
            } 
        }); 
    } 
); 
</script> 

<div id="content">

<?=form_open($this->session->userdata('settingliste_redirect').'/save', $form);?>

<p class="thirdMenue">
<? if($privileged['edit']) :        ?>
<table>
        <tr>
            <td><button type='submit' name='setting_submit' id='setting_submit' class='button_gross'><span class='button_save'>Speichern</span></button></td>
            <td><a href="<?=base_url('admin/system/setting/write')?>" class="button_gross"><span class="button_save">Einstellungsdatei neu schreiben</span></a></td>
        </tr>
</table>
<? endif;                           ?>
</p>
<h1>Einstellungen verwalten</h1>
<table cellpadding="0" cellspacing="1" id="setting_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_name">Modulname</th>
		<th class="headline_titel">Konstante</th>
		<th class="headline_titel">Wert</th>
	</tr>
</thead>
<tbody>
<?
	$i = 0;
	foreach($setting as $item) :	 
		$constantValue = array(
			'name'		=> $i.'_value',
			'id'		=> $i.'_value',
			'class' 	=> 'input_text',
			'value' 	=> $item['constantValue']
		);	
		echo form_hidden($i.'_constantID', $item['constantID']);
		$i++;
?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=$item['moduleName']?></td>
	<td><?=$item['constantName']?></td>
	<td><?=form_input($constantValue); ?></td>
</tr>
<? endforeach; 
	 echo form_hidden('counter', $i);
?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>