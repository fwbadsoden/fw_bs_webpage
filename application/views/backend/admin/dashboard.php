<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<? $this->load->helper('html'); ?>

<div id="content">

<h1>Willkommen <?=$userdata->first_name?> <?=$userdata->last_name?></h1>


<!-- This is first column -->
<div id="dashboard_column_1" class="dashboard_column">
 <!-- <div id="item_1" class="dashboard_dragbox">
    <div class="dashboard_dragbox-content">
    	<div class="adminTask">
			<h2 class="welcomeHead">
				Admin Nachricht: 
				<span style="margin-left: 230px;">
					<a href="<?=base_url('admin/admin/message')?>">
						<?=img(array('src' => 'images/admin/buttons/btn_newContent_kl.gif', 'style' => 'margin-bottom: -5px;', 'alt' => 'Nachricht bearbeiten'))?>
					</a>

				</span>
			</h2>
						
			<div id="task" style="background-color: <?=$message['rowColor']?>;">
				<h3><?=$message['datetime']?> - <?=$message['editor']?></h3>
				<h2><?=$message['titel']?></h2>
				<p><?=$message['message']?></p>
			</div>
		</div>    
    </div>
  </div>-->
  <div id="item_2" class="dashboard_dragbox">
    <!-- this one is third item of 1st column -->
    <div class="dashboard_dragbox-content">
    	<div class="adminTask2">
			<h2 class="welcomeHead">Quicklinks:
				<span style="margin-left: 265px;">
				</span>
			</h2>
			<p>
		<? foreach($qlink as $link) { ?>
				&nbsp;&raquo;&nbsp;&nbsp;&nbsp;<a href="<?=base_url($link['linkZiel'])?>"><?=$link['linkName']?></a><br>
		<? } ?>
			</p>
		</div>
    </div>
  </div>
</div>

<!-- 2nd Column -->
<div id="dashboard_column_2" class="dashboard_column">
  <div id="item_3" class="dashboard_dragbox">
    <!-- this one is 5th item of 2nd column -->
   <div class="dashboard_dragbox-content">
   		<div class="adminTask3">
			<h2 class="welcomeHead">
				Letzte Änderungen:
				<span style="margin-left: 193px;">
			<!--		<a href="<?=base_url('admin/admin/editLog')?>">
						<?=img(array('src' => 'images/admin/buttons/btn_newContent_kl.gif', 'style' => 'margin-bottom: -5px;', 'alt' => 'Log anzeigen'))?>
					</a>
				</span>-->
			</h2>
			<p>
			<div id="log_scroll" style="height: 200px; width: 350px; overflow:scroll">
				<table cellpadding="0" cellspacing="1" width="330">
		<? foreach($log as $l) { ?>
					<tr><td bgcolor="<?=$l['rowColor']?>" class="logfile_view"><?=$l['datetime']?> | <?=$l['vorname']?> <?=$l['nachname']?><br><?=$l['message']?></td></tr>
		<? } ?>
				</table>
			</div>
			</p>
		</div>
   </div>
  </div>
</div>
<div style="clear:both;"></div>
</div>