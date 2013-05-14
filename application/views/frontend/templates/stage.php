<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?>

<section id="stage">

<? foreach($stage_images['images'] as $key => $item) { ?>    
    <div class="pictures" id="pictures_<?=$key?>" style="background-image: url(<?=base_url($item['file'])?>); display: none;">
        <div class="<?=$item['class']?>">
<? if(isset($item['text'][0])) { ?> <p class="quote"><?=$item['text'][0]?></p> <? }?>
<? if(isset($item['text'][1])) { ?> <p class="quotePerson"><?=$item['text'][1]?></p> <? }?>
        </div>
    </div>
<? } ?>
      
</section>

<section id="content">
    <div class="slidewrapper">
<? if($stage_images['count_images'] > 1) { ?>
        <div id="slider">
            <ul>
    <? foreach($stage_images['images'] as $key => $item) { ?>             
                <li><a href="#<?=$key?>" class="changeStage" id="slide-link-<?=$key?>"><?=$key+1?></a></li>
    <? } ?>                
<? } ?>
            </ul>
    	</div>