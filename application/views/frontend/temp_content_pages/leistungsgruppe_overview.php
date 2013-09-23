<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="MainContent">
    <div class="article">
    
    </div>
    <hr class="clear" />  
    <div class="BigBox firstColumn">  
            <div class="slideshow">

                <div class="prevPic"><a href="#slideshow_car" id="slideshow_prev"><img src="<?=base_url('images/layout/button_detailShow_previous.png')?>" /></a></div>
                <div class="nextPic"><a href="#slideshow_car" id="slideshow_next"><img src="<?=base_url('images/layout/button_detailShow_next.png')?>" /></a></div>
                
                <ul id="slideshow_car">
<? foreach($images as $key => $img) : ?>                
<? if($key == 1) : ?>
                    <li id="slideshow_car_<?=$key+1?>" class="active">
<? else : ?>
                    <li id="slideshow_car_<?=$key+1?>">
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
    <hr class="clear" />        
</div>
<div id="SidebarContent">   
    <div class="address">
        <h1 class="first">Chronik</h1>
        <ul>
            <li>2012: Sieger auf Kreisebene; 13. Platz auf dem Bezirksentscheid in Lampertheim - Hüttenfeld</li>
            <li>2011: Sieger auf Kreisebene; 8. Platz auf dem Bezirksentscheid in Glauburg - Glauberg.</li>
            <li>2010: Sieger auf Kreisebene; 10. Platz auf dem Bezirksentscheid in Freigericht Horbach.</li>
            <li>2009: Erste Leistungsübung nach neuer Ausschreibung.</li>
            <li>2008: Keine Teilnahme aufgrund des 140. Jubiläums der Feuerwehr Bad Soden a.Ts.</li>
            <li>2007: Dritter Platz auf Kreisebene.</li>
            <li>2006: Sieger auf Kreisebene.</li>
            <li>2005: Sieger auf Kreisebene.</li>
            <li>2004: Sieger auf Kreisebene.</li>      
        </ul>
    </div>    
</div>
<hr class="clear" />