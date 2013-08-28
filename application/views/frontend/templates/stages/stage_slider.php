<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
        <div id="slider">
            <ul>
    <? foreach($stage_images['images'] as $key => $item) { 
          if($key == 0) $class = ' first'; else $class = '';
    ?>             
                <li><a href="#<?=$key?>" class="changeStage<?=$class?>" id="slide-link-<?=$key?>"><?=$key+1?></a></li>
    <? } ?>                
            </ul>
    	</div>  