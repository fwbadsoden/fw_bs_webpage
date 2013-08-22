<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    $pumpe        = explode('|', $fahrzeug['fahrzeugPumpe']);
    $loeschmittel = explode('|', $fahrzeug['fahrzeugLoeschmittel']);
    $besonderheit = explode('|', $fahrzeug['fahrzeugBesonderheit']);
    $tab_index_1  = 1;
    $tab_index_2  = 1;
?> 

<div class="BigBox firstColumn">    
            <div class="TabBox">
                <ul class="tabNav_details">
                    <li><a href="#details_<?=$tab_index_1?>" func="tab" class="active">Beschreibung</a></li>
<? if($fahrzeug['fahrzeugGeschichte'] != '') : $tab_index_1++; ?>   
                    <li><a href="#details_<?=$tab_index_1?>" func="tab" class="noActive">Geschichte</a></li>
<? endif; ?>           
<? if($fahrzeug['fahrzeugStatistik'] != '') : $tab_index_1++; ?>           
                    <li><a href="#details_<?=$tab_index_1?>" func="tab" class="noActive">Einsatzstatistik</a></li>
<? endif; ?>                    
                </ul>
                <div class="TabBoxContent">                
                    <h1 class="reiter"><a href="#details_<?=$tab_index_2?>" func="tab" class="active">Beschreibung</a></h1>
                    <div id="box_details_<?=$tab_index_2?>" style="">
                        <h1><?=$tab_index_2?>: <?=$fahrzeug['fahrzeugRufnamePrefix'].' '.$fahrzeug['fahrzeugRufname']?></h1>
                        <p><?=$fahrzeug['fahrzeugText']?></p>                     
<? if($fahrzeug['fahrzeugPumpe'] != '' && $fahrzeug['fahrzeugLoeschmittel'] != '') : ?>                        
                        <div class="facttable">   
                            <div class="left">
                                <h1>Pumpe</h1>
                                <ul>
<? foreach($pumpe as $p) : ?>                                
                                    <li><?=trim($p)?></li>
<? endforeach; ?>                                    
                                </ul>
                            </div>                            
                            <div class="right">
                                <h1>Löschmittelvorrat</h1>
                                <ul>
<? foreach($loeschmittel as $l) : ?>                                
                                    <li><?=trim($l)?></li>
<? endforeach; ?>                                    
                                </ul>
                            </div>                         
                            <hr class="clear" />
                        </div>
<? elseif($fahrzeug['fahrzeugBesonderheit'] != '') : ?>   
                        <div class="facttable">   
                            <div class="left">
                                <h1>Besondere Ausrüstung</h1>
                                <ul>
<? foreach($besonderheit as $b) : ?>                                
                                    <li><?=trim($b)?></li>
<? endforeach; ?>          
                                </ul>
                            </div>                            
                            <div class="right">
                              <!--  <h1>Löschmittelvorrat</h1>
                                <ul>
                                    <li>2000 l Wasser</li>
                                    <li>150 l Schaummittel AFFF</li>
                                    <li>50 l Schaummittel Class A</li>
                                </ul>-->
                            </div>                         
                            <hr class="clear" />
                        </div>
<? endif; ?>                                             
                    </div>
<? if($fahrzeug['fahrzeugGeschichte'] != '') : $tab_index_2++; ?>        
                    <h1 class="reiter"><a href="#details_<?=$tab_index_2?>" func="tab" class="noActive">Geschichte</a></h1>
                    <div id="box_details_<?=$tab_index_2?>" style="display: none;">
                        <h1><?=$tab_index_2?>: <?=$fahrzeug['fahrzeugRufnamePrefix'].' '.$fahrzeug['fahrzeugRufname']?></h1>
                        <p><?=$fahrzeug['fahrzeugGeschichte']?></p>
                    </div>
<? endif; ?>
<? if($fahrzeug['fahrzeugStatistik'] != '') : $tab_index_2++; ?>                    
                    <h1 class="reiter"><a href="#details_<?=$tab_index_2?>" func="tab" class="noActive">Einsatzstatistik</a></h1>
                    <div id="box_details_<?=$tab_index_2?>" style="display: none;">
                        <h1><?=$tab_index_2?>: <?=$fahrzeug['fahrzeugRufnamePrefix'].' '.$fahrzeug['fahrzeugRufname']?></h1>
                        <p><?=$fahrzeug['fahrzeugStatistik']?></p>
                    </div>
<? endif; ?>                    
                </div>
            </div>
        </div>