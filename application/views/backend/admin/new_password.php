<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="login_box">
	<div id="logo"></div>
	<div class="kasten_oben">
		<img src="<?=base_url("/images/admin/layout/login_pw_oben.gif")?>">
	</div>
	<div id="pw-forgot-title" class="kasten_mitte">
<? if($message['type'] == 'error') { ?>     
		<p class="text"><div id="message"><?=$message['error']?></div></p>
<? } else { ?>
		<p class="text"><?=$message['status']?></p>
<? } ?>        
		<p class="spacer"></p>						
		<p><a href="<?=base_url('admin')?>" class="forgot_password">Zurück zum Login</a></p>
	</div> 

	<div class="kasten_unten"></div>
	<div id="powered"></div>
</div>