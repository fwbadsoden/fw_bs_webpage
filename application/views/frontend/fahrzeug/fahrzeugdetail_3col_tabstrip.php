<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
    $tab_index_1  = 1;
    $tab_index_2  = 1;
    if($fahrzeug['fahrzeugRufname'] == 'n/a') : $rufname = 'n/a'; 
    else : $rufname = $fahrzeug['fahrzeugRufnamePrefix'].' '.$fahrzeug['fahrzeugRufname']; endif; 
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
<?     if($fahrzeug['fahrzeugRufname'] == 'n/a') : $rufname = $fahrzeug['fahrzeugNameLang']; else : $rufname = $fahrzeug['fahrzeugRufnamePrefix'].' '.$fahrzeug['fahrzeugRufname']; endif; ?>
                        <h1><?=$tab_index_2?>: <?=$rufname?></h1>
                        <p><?=$fahrzeug['fahrzeugText']?></p>                     
<? if($fahrzeug['fahrzeugPumpe'] != '' && $fahrzeug['fahrzeugLoeschmittel'] != '') : ?>                        
                        <div class="facttable">   
                            <div class="left">
                                <h1>Pumpe</h1>
                                <ul>               
                                    <li><?=str_replace("\n", "<br />", trim($fahrzeug['fahrzeugPumpe']));?></li>                                 
                                </ul>
                            </div>                            
                            <div class="right">
                                <h1>Löschmittelvorrat</h1>
                                <ul>     
                                    <li><?=str_replace("\n", "<br />", trim($fahrzeug['fahrzeugLoeschmittel']));?></li>                          
                                </ul>
                            </div>                         
                            <hr class="clear" />
                        </div>
<? elseif($fahrzeug['fahrzeugBesonderheit'] != '') : ?>   
                        <div class="facttable">   
                            <div class="left">
                                <h1>Besondere Ausrüstung</h1>
                                <ul>                              
                                    <li><?=str_replace("\n", "<br />", trim($fahrzeug['fahrzeugBesonderheit']));?></li>       
                                </ul>
                            </div>                           
                            <hr class="clear" />
                        </div>
<? endif; ?>                                             
                    </div>
<? if($fahrzeug['fahrzeugGeschichte'] != '') : $tab_index_2++; ?>        
                    <h1 class="reiter"><a href="#details_<?=$tab_index_2?>" func="tab" class="noActive">Geschichte</a></h1>
                    <div id="box_details_<?=$tab_index_2?>" style="display: none;">                     
                        <h1><?=$tab_index_2?>: <?=$rufname?></h1>
                        <p><?=$fahrzeug['fahrzeugGeschichte']?></p>
                    </div>
<? endif; ?>
<? if($fahrzeug['fahrzeugStatistik'] != '') : $tab_index_2++; ?>                    
                    <h1 class="reiter"><a href="#details_<?=$tab_index_2?>" func="tab" class="noActive">Einsatzstatistik</a></h1>
                    <div id="box_details_<?=$tab_index_2?>" style="display: none;">
                        <h1><?=$tab_index_2?>: <?=$rufname?></h1>
                        <p><?=$fahrzeug['fahrzeugStatistik']?></p>
                    </div>
<? endif; ?>                    
                </div>
            </div>
        </div>