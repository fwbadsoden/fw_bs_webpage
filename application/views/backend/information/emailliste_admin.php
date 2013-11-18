<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
?>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#email_table").tablesorter({
            headers: { 
                0:  { sorter: false },
                4:  { sorter: false }
            } 
        }); 
    } 
); 
</script> 

<div id="content">

<h1>Email-Liste</h1>

<table cellpadding="0" cellspacing="1" id="email_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_mail">Emailadresse</th>
		<th class="headline_cat">Zweck</th>
		<th class="headline_cat">Typ</th>
		<th class="headline_mail">Weiterleitung(en)</th>
		<th class="headline_status">Größe</th>
	</tr>
</thead>
<tbody>

<? foreach($emails as $i => $item) : ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=str_pad($i+1, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$item['email']?></td>
	<td><?=$item['purpose']?></td>
	<td><?=$item['type']?></td>   
	<td><?=$item['forwarded']?></td>     
	<td><?=$item['size']?></td>
</tr>
<? endforeach; ?>
</tbody>
</table>
<p>&nbsp;</p>
<div style="clear:both;"></div>
</div>