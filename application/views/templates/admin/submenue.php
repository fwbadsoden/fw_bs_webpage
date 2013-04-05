<div id="submenue">
	<ul>
<? foreach($submenue as $menue) { ?>
		<li><a href='<?=base_url($menue['link'])?>' target='<?=$menue['target']?>'><?=$menue['name']?></a></li>		
<? } ?>				
	</ul>
</div>
			