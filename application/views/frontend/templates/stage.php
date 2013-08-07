<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section id="stage">

<? foreach($stage_images['images'] as $key => $item) { ?>    
    <div class="pictures" id="pictures_<?=$key?>" style="background-image: url(<?=base_url($item['file'])?>); display: none;">
        <div id="stagewrapper">    
            <div class="<?=$item['class']?>">
<? if(isset($item['text'][0])) : ?> <p class="quote"><?=$item['text'][0]?></p> <? endif; ?>
<? if(isset($item['text'][1])) : ?> <p class="quotePerson"><?=$item['text'][1]?></p> <? endif; ?>
            </div>
        </div>
    </div>
<? } ?>
      
</section>

 