<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');
    $i=1;
?>

<div id="content">
<p class="thirdMenue">
    <table>
        <tr>
            <td><a href="<?=base_url('admin/files/upload/'.$typeID)?>" class="button_gross"><span class="button_add"><?=$btn_create?></span></a></td>
        </tr>
    </table>
</p>

<h1><?=$headline?></h1>

<table cellpadding="0" cellspacing="1" id="file_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_cat">Kategorie</th>
		<th class="headline_titel">Name</th>
	</tr>
</thead>
<tbody> 
<? foreach($files as $item) { ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=str_pad($i, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$categories[$item['categoryID']]['name']?></td>
	<td><?=$item['name']?></td> 
</tr>
<?
    $i++; 
  } 
?>
</tbody>
</table>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>
</div>