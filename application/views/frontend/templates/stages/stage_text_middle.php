<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section id="stage">

<? foreach($stage_images['images'] as $key => $item) { ?>    
    <div class="pictures" id="pictures_<?=$key?>" style="background-image: url(<?=base_url($item['file'])?>); display: none;">
        <div id="stagewrapper">    
            <div class="<?=$item['class']?>">
<? if(isset($item['text'][0])) : ?> <h1 class="quote"><?=$item['text'][0]?></h1> <? endif; ?>
<? if(isset($item['text'][1])) : ?> <h2 class="quotePerson"><?=$item['text'][1]?></h2> <? endif; ?>
<? if(isset($item['text'][2])) : ?> <p><?=$item['text'][2]?></p> <? endif; ?>
            </div>
        </div>
    </div>
<? } ?>
      
</section>

 