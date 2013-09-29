<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    
    switch($listcount)
    {
        case '1': $class = ''; break;
        case '2': $class = ' class="second"'; break;
        case '3': $class = ' class="third"'; break;
    }
?> 
                <a href="<?=base_url('technik/fahrzeug/'.$fahrzeug['fahrzeugID'])?>">
                <li<?=$class?>>
                    <figure><img src="<?=base_url(CONTENT_IMG_FAHRZEUG_UPLOAD_PATH.$image['img'])?>" /></figure>
                  	<h1><?=$fahrzeug['fahrzeugNameLang']?></h1>
                    <h2><?=$fahrzeug['fahrzeugName']?></h2>
                </li>
                </a>