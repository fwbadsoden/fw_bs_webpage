<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? 
	$this->load->helper('html'); 
	$this->load->library('CP_auth');	
    $i = $news_count;
	
	// set pagination var if page 1
	if( !is_numeric( $this->uri->segment( $this->uri->total_segments() ) ) )
		$pagination_start = 0;
	else $pagination_start = $this->uri->segment($this->uri->total_segments());
?>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#news_table").tablesorter({
            headers: { 
                0:  { sorter: false },
                5:  { sorter: false }
            } 
        }); 
    } 
); 
</script> 

<div id="content">
<? if($privileged['edit']) :        ?>
<p class="thirdMenue">
	<a href="<?=base_url('admin/content/news/create')?>" class="button_gross"><span class="button_add">Neue News anlegen</span></a>
</p>
<p>&nbsp;</p>
<? endif;                           ?>

<h1>News verwalten</h1>

<table cellpadding="0" cellspacing="1" id="news_table" class="tablesorter">
<thead>
	<tr>
		<th class="headline_id">ID</th>
		<th class="headline_cat">Kategorie</th>
		<th class="headline_titel">Titel</th>
		<th class="headline_name">Autor</th>
		<th class="headline_datetime">Gültig ab</th>
		<th colspan="3" class="headline_edit">Edit</th>
	</tr>
</thead>
<tbody>
<? 	foreach($news as $key => $item) :       ?>		
<tr bgcolor="<?=$item['row_color']?>">
	<td><?=str_pad($key+1, 5 ,'0', STR_PAD_LEFT);?></td>
	<td><?=$news_categories[$item['categoryID']]['title']?></td>
	<td><?=$item['title']?></td>
	<td><?=$item['created_by']?></td>
	<td><?=cp_get_ger_date($item['valid_from'])?></td>
<?	if($item['online']==1) :	
        if($privileged['edit']) :   ?>
	<td class="button"><a href="<?=base_url('admin/content/news/status/'.$item['newsID'].'/1/'.$pagination_start)?>" class="button_mini" title="News offline schalten"><span class='button_online_small'></span></a></td>
<?      else :                      ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Newsstatus zu bearbeiten"><span class='button_online_small'></span></a></td>
<?      endif;
    else :                          
        if($privileged['edit']) :   ?>
	<td class="button"><a href="<?=base_url('admin/content/news/status/'.$item['newsID'].'/0/'.$pagination_start)?>" class="button_mini" title="News online schalten"><span class='button_offline_small'></span></a></td>
<?      else :                      ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung den Newsstatus zu bearbeiten"><span class='button_offline_small'></span></a></td>
<?      endif;
	endif;                          
    if($privileged['edit']) :       ?>
	<td class="button"><a href="<?=base_url('admin/content/news/edit/'.$item['newsID'])?>" class="button_mini" title="News bearbeiten"><span class='button_edit_small'></span></a></td>
	<td class="button"><a id="confirm_link_<?=$item['newsID']?>" href="<?=base_url('admin/content/news/checkdel/'.$item['newsID'])?>" class="button_mini" title="News löschen"><span class='button_delete_small'></span></a></td>
<?  else :                          ?>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die News zu bearbeiten"><span class='button_lock_small'></span></a></td>
    <td class="button"><a class="button_mini" title="Sie haben keine Berechtigung die News zu löschen"><span class='button_lock_small'></span></a></td>
<?  endif;                          ?>
</tr>
<?  endforeach; ?>
</tbody>
</table>
<br>
<?=$news_pagination?>
<p>&nbsp;</p>
</div>
<div style="clear:both;"></div>