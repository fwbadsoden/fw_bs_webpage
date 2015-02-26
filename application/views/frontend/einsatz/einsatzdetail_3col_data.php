<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    $einsatzkraefte = explode(',', strip_tags($einsatz['einsatzkraefteFreitext'])); 
    $slide_count = 0;
?>

        <div id="MainContent">    
            
            <div class="article">
				<h1>Einsatzbericht</h1>
                <p><?=$einsatz['einsatzlage']?></p>
				<p><?=$einsatz['einsatzbericht']?></p>
            </div>
<? if(count($bilder) > 0) : ?>
            <div class="slideshow">
<? if(count($bilder) > 1) : ?>
                <div class="prevPic"><a href="#slideshow_car" id="slideshow_prev"><img src="<?=base_url('images/layout/button_detailShow_previous.png')?>" /></a></div>
                <div class="nextPic"><a href="#slideshow_car" id="slideshow_next"><img src="<?=base_url('images/layout/button_detailShow_next.png')?>" /></a></div>
<? endif; ?>                
                <ul id="slideshow_car">
<? foreach($bilder as $b) :
      $slide_count++;       ?>                
                    <li id="slideshow_car_<?=$slide_count?>" <? if($slide_count == 1) : ?> class="active" <? endif; ?> >
                        <figure>
                        	<img src="<?=base_url(CONTENT_IMG_EINSATZ_UPLOAD_PATH.$b['img_file'])?>" alt="" />
                        	<div class="zoom"><a href="<?=base_url(CONTENT_IMG_EINSATZ_UPLOAD_PATH.$b['img_file'])?>" class="fancybox-gallery" rel="gallery1"><img src="<?=base_url('images/layout/button_zoom.png')?>" /></a></div>
                        </figure>
                        <p><?=$slide_count?>: <?=$b['img_desc']?> <?=$b['photographer']?></p>
                    </li>
<? endforeach; ?>                    
                </ul>
            </div>
<? endif; ?>     
<? if($einsatz['display_einsatzort'] == 1) : ?>               
            <h1 class="module">Einsatzort</h1>
            <div class="googlemaps">
				<div class="Flexible-container">
                    <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.de/maps?q=<?=$einsatz['einsatzort']?>&ie=UTF8&t=m&z=13&output=embed"></iframe><br /><small><a href="https://maps.google.de/maps?q=Bad+Soden+am+Taunus" style="color:#0000FF;text-align:left">Größere Kartenansicht</a></small>
            	</div>
            </div>
<? endif; ?>            
        </div>	
        <div id="SidebarContent">  
<? if(count($fahrzeuge) > 0) : ?>        
    	    <div class="SBfahrzeugListe">
                <h1 class="first">Eingesetzte Fahrzeuge</h1>                
                <ul>
<? foreach ($fahrzeuge as $f) : ?>
                    <li>
<? if($f['online'] == 1) : ?>                    
                        <a href="<?=base_url('technik/fahrzeug/'.$f['fahrzeugID'])?>">
<? endif; ?>
                        <figure><img src="<?=base_url(CONTENT_IMG_FAHRZEUG_UPLOAD_PATH.$f['img'])?>" width="100" height="50" /></figure>
                        <div class="info">
                            <h2><?=$f['name']?></h2>
<? if($f['name_lang'] != '') : 
    if(mb_strlen($f['name_lang'],'utf-8') > 20) : $f['name_lang'] = mb_substr($f['name_lang'],0,17,'utf-8').'.'; endif;
?>                            
                            <h3><?=$f['name_lang']?></h3>
<? endif; ?>
						</div>
<? if($f['online'] == 1) : ?>  
                        </a>
<? endif; ?>
                        <hr class="clear" />
                    </li>
<? endforeach; ?>      
                </ul>
            </div>
<? endif; ?>            
<? if($einsatz['einsatzkraefteFreitext'] != '') : ?>           
            <div class="SBListe">
                <h1>Alarmierte Einsatzkräfte</h1>
                <ul>
<? foreach ($einsatzkraefte as $e) : ?>               
                    <li><?=trim($e);?></li>
<? endforeach; ?>
               </ul>
           	</div>    
<? else:  ?>
            <div class="SBListe">
                <h1>Alarmierte Einsatzkräfte</h1>
                <ul>          
                    <li>keine weiteren Kräfte</li>
               </ul>
           	</div> 
<? endif; ?>                       
        </div>
        <hr class="clear" />
    </div>