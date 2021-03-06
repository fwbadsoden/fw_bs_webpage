<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?> 

        <div class="BigBox firstColumn">  
            <div class="slideshow">

		<?php if(count($images) > 1) {?>
                <div class="prevPic"><a href="#slideshow_car" id="slideshow_prev"><img src="<?=base_url('images/layout/button_detailShow_previous.png')?>" /></a></div>
                <div class="nextPic"><a href="#slideshow_car" id="slideshow_next"><img src="<?=base_url('images/layout/button_detailShow_next.png')?>" /></a></div>
		<?php }?>                

                <ul id="slideshow_car">
<? foreach($images as $key => $img) : ?>           
<? if($key == 0) : ?>
                    <li id="slideshow_car_<?=$key+1?>" class="active">
<? else : ?>
                    <li id="slideshow_car_<?=$key+1?>" class="noActive">
<? endif; ?>
                        <figure>
                        	<img src="<?=base_url(CONTENT_IMG_FAHRZEUG_UPLOAD_PATH.$img['img_file'])?>" alt="<?=$img['description']?>" />
                        	<div class="zoom"><a href="<?=base_url(CONTENT_IMG_FAHRZEUG_UPLOAD_PATH.$img['img_file'])?>" title="<?=$img['description']?>" class="fancybox-gallery" rel="gallery1"><img src="<?=base_url('images/layout/button_zoom.png')?>" /></a></div>
                        </figure>
                        <p><?=$key+1?>: <?=$img['text']?></p>
                    </li>
<? endforeach; ?>             
                </ul>
            </div>
        </div>
