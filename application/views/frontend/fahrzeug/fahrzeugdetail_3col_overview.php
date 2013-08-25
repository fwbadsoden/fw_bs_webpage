<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?> 

<div class="SmallBox secondColumn">   
            <div class="menueBox">
                <h1>Alle Fahrzeuge</h1>
                <ul>
<? foreach($fahrzeuge as $key => $fahrzeug) : ?>      
<? if(count($fahrzeuge) == ($key + 1)) : ?>
                    <li class="last">
<? else : ?>
                    <li>
<? endif; ?>                                                  
                        <a href="<?=base_url('fahrzeug/'.$fahrzeug['fahrzeugID'])?>"><?=$fahrzeug['fahrzeugNameLang']?> - <span class="downlight"><?=$fahrzeug['fahrzeugName']?></span></a>
                    </li>
<? endforeach; ?>                    
                </ul>
                <h1 class="subnavi_opener_mobile">Alle Fahrzeuge</h1>
                <ul class="subnavi_content_mobile">
<? foreach($fahrzeuge as $key => $fahrzeug) : ?>      
<? if(count($fahrzeuge) == ($key + 1)) : ?>
                    <li class="last">
<? else : ?>
                    <li>
<? endif; ?>                                                  
                        <a href="<?=base_url('fahrzeug/'.$fahrzeug['fahrzeugID'])?>"><?=$fahrzeug['fahrzeugNameLang']?> - <span class="downlight"><?=$fahrzeug['fahrzeugName']?></span></a>
                    </li>
<? endforeach; ?>   
                </ul>
            </div>
        </div >    
        <hr class="clear" />