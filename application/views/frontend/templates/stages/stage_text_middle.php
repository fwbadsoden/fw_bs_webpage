<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section id="stage">

<? foreach($stage_images['images'] as $key => $item) {
    if($item['class_text'] != '') {
        $class_text = explode('|!!|', $item['class_text']);
        $class_1 = ' class="'.$class_text[0].'"';
        $class_2 = ' class="'.$class_text[1].'"'; 
    } else {
        $class_1 = '';
        $class_2 = '';
    }    
?>    
    <div class="<?=$item['class_outer']?>" id="pictures_<?=$key?>" style="background-image: url(<?=base_url($item['file'])?>); display: none;">
        <div id="stagewrapper">    
            <div class="<?=$item['class_inner']?>">
<? if(isset($item['text'][0])) : ?> <h1<?=$class_1?>><?=$item['text'][0]?></h1> <? endif; ?>
<? if(isset($item['text'][1])) : ?> <h2<?=$class_2?>><?=$item['text'][1]?></h2> <? endif; ?>
<? if(isset($item['text'][2])) : ?> <p><?=$item['text'][2]?></p> <? endif; ?>
<? if($item['link'] != '')     : ?> <h2 class="button"><a href="<?=base_url($item['link'])?>" class="button_white">weiter lesen</a></h2><? endif; ?>
            </div>
        </div>
    </div>
<? } ?>
      
</section>

 