<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    
    switch($listcount)
    {
        case '1': $class = ''; break;
        case '2': $class = ' class="second"'; break;
        case '3': $class = ' class="third"'; break;
    }
?> 
                <li<?=$class?>>
                    <figure><a href="<?=base_url('fahrzeug/'.$fahrzeug['fahrzeugID'])?>"><img src="<?=CONTENT_IMG_FAHRZEUG_UPLOAD_PATH.$image['img']?>" /></a></figure>
                  	<h1><a href="<?=base_url('fahrzeug/'.$fahrzeug['fahrzeugID'])?>"><?=$fahrzeug['fahrzeugNameLang']?></a></h1>
                    <h2><a href="<?=base_url('fahrzeug/'.$fahrzeug['fahrzeugID'])?>"><?=$fahrzeug['fahrzeugName']?></a></h2>
                </li>