<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?> 
                <div class="TeaserListeBox">
                    <figure><a href="<?=base_url('fahrzeug/'.$fahrzeug['fahrzeugID'])?>"><img src="<?=CONTENT_IMG_FAHRZEUG_UPLOAD_PATH.$image['img']?>" /></a></figure>
                  	<h1><a href="<?=base_url('fahrzeug/'.$fahrzeug['fahrzeugID'])?>"><?=$fahrzeug['fahrzeugNameLang']?></a></h1>
                    <h2><a href="<?=base_url('fahrzeug/'.$fahrzeug['fahrzeugID'])?>"><?=$fahrzeug['fahrzeugName']?></a></h2>
                </div>