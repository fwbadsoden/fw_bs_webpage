<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?>

        <div class="oneColumnBox" id="submenue">
        
        	<div class="filter">
<? foreach($monate as $monat) : ?>
                <div class="thirdnavi_button"><a href="#anker_<?=strtolower($monat)?>" class="button_black" rel="nicescrolling"><?=ucfirst($monat)?></a></div>
<? endforeach; ?>
                <div><a href="#top" class="backToTop" rel="nicescrolling"></a></div>
	            <hr class="clear" />
            </div>
            
        
        </div>
       <div class="jsplatzhalter"></div>