<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="menue">
	<ul>
<? foreach($menue as $m) { ?>
		<li><a href="<?=base_url($m['link'])?>" target="<?=$m['target']?>"><?=$m['name']?></a></li>   
<? } ?>
	</ul>
	<div class="logout">
	<span style="font-weight: normal;">eingelogged als:</span>&nbsp;&nbsp;<a href="<?=base_url('admin/edit_profile/')?>"><?=$userdata->first_name?> <?=$userdata->last_name?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=base_url('admin/logout')?>">Logout</a>
	</div>
</div>
<div id="contentBox">
