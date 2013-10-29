<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    
    $url = current_url();
    $last_segment = '/'.$this->uri->segment($this->uri->total_segments());
    $url_back = str_replace($last_segment, '', $url);
?> 
<div class="backtooverview">
            	<a href="<?=$url_back?>" class="backlink">zurück zur Übersicht</a>
            </div>
            <div class="article">
                <h1 class="first"><?=$news->title?></h1>
                <p>
                	<strong>
                    <?=$news->teaser?>
               		</strong>
                </p>
                <p>
                    <?=$news->text?>
                </p>
            </div>
<? if(count($images) > 0) : ?>            
            <div class="slideshow">

                <div class="prevPic"><a href="#slideshow_car" id="slideshow_prev"><img src="<?=base_url('images/layout/button_detailShow_previous.png')?>" /></a></div>
                <div class="nextPic"><a href="#slideshow_car" id="slideshow_next"><img src="<?=base_url('images/layout/button_detailShow_next.png')?>" /></a></div>
                
                <ul id="slideshow_car">
<? foreach($images as $key => $image) : 
    if($key == 0) $class = ' class="active"';
    else          $class = ' class="noActive"';
?>                
                    <li id="slideshow_car_<?=$key+1?>"<?=$class?>>
                        <figure>
                        	<img src="<?=base_url($image['fullpath'])?>" alt="<?=$image['title']?>" />
                        	<div class="zoom"><a href="<?=base_url($image['fullpath'])?>" class="fancybox-gallery" rel="gallery1" title="<?=$image['title']?>"><img src="<?=base_url('images/layout/button_zoom.png')?>" /></a></div>
                        </figure>
                    </li>
<? endforeach; ?>                    
                </ul>
            </div>
<? endif; ?>            
        </div>
        
        <div id="SidebarContent">   
           	<div class="menueBox">
                <h1 class="first">Die 10 letzten News</h1>
                <ul>
<? foreach($liste as $news_latest) : 
    $url = $url_back.'/'.$news_latest->id;
    if($url == current_url()) $class = ' class="active"'; else $class = '';
?>                
                    <li><a href="<?=$url?>"<?=$class?>><?=$news_latest->title?></a></li>
<? endforeach; ?>                    
                </ul>
			</div>
		</div>
        <hr class="clear" />