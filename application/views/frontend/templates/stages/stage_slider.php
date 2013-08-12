<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
        <div id="slider">
            <ul>
    <? foreach($stage_images['images'] as $key => $item) { ?>             
                <li><a href="#<?=$key?>" class="changeStage" id="slide-link-<?=$key?>"><?=$key+1?></a></li>
    <? } ?>                
            </ul>
    	</div>  