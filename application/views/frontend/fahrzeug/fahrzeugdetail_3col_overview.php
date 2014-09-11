<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?> 

<div class="SmallBox secondColumn">   
            <div class="menueBox">
                <h1><?=$headline?></h1>
                <ul>
<? foreach($fahrzeugliste as $key => $fahrzeug) : ?>      
<? if(count($fahrzeugliste) == ($key + 1)) : ?>
                    <li class="last">
<? else : ?>
                    <li>
<? endif; ?>                                                  
                        <a href="<?=base_url('technik/fahrzeug/'.$fahrzeug['fahrzeugID'])?>"><?=$fahrzeug['fahrzeugNameLang']?> - <span class="downlight"><?=$fahrzeug['fahrzeugName']?></span></a>
                    </li>
<? endforeach; ?>                    
                </ul>
                <h1 class="subnavi_opener_mobile">Alle Fahrzeuge</h1>
                <ul class="subnavi_content_mobile">
<? foreach($fahrzeugliste as $key => $fahrzeug) : ?>      
<? if(count($fahrzeugliste) == ($key + 1)) : ?>
                    <li class="last">
<? else : ?>
                    <li>
<? endif; ?>                                                  
                        <a href="<?=base_url('technik/fahrzeug/'.$fahrzeug['fahrzeugID'])?>"><?=$fahrzeug['fahrzeugNameLang']?> - <span class="downlight"><?=$fahrzeug['fahrzeugName']?></span></a>
                    </li>
<? endforeach; ?>   
                </ul>
            </div>
        </div >    
        <hr class="clear" />