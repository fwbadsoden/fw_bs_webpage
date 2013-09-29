<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $beginn = $einsatz['datum_beginn'].' '.$einsatz['uhrzeit_beginn']; 
    $ende   = $einsatz['datum_ende'].' '.$einsatz['uhrzeit_ende'];
    $dauer  = cp_time_diff($ende, $beginn);
    $dauer_minuten = $dauer['minuten'];
    $dauer_stunden = $dauer['stunden'];
?>
<div class="oneColumnBox">
            <div class="factSheet_einsatz">
                <div class="table">
<? if($einsatz['einsatzort'] == '') : $einsatz['einsatzort'] = 'n/a'; endif; ?>                
                    <div class="row">
                        <div class="black">Einsatzort:</div>
                        <div class="red"><?=$einsatz['einsatzort']?></div>
                    </div>   
<? if($einsatz['cueID'] == 0 or $einsatz['cueID'] == '') : $cue = 'n/a'; else : $cue = $einsatz['cue_name'].' - '.$einsatz['cue_mimic']; endif; ?>                  
                    <div class="row">
                        <div class="black">Alarmstichwort:</div>
                        <div class="red"><?=$cue?></div>
                    </div>   
                    <div class="row">
                        <div class="black lastRow">Einsatzart:</div>
<? if($einsatz['type_name'] == '') : $einsatz['type_name'] = 'n/a'; endif; ?>      
                        <div class="red lastRow">
<? if($einsatz['ueberoertlich'] == 1) : echo 'Überörtlicher '; endif; ?>                             
                        <?=$einsatz['type_name']?>                   
                        </div>
                    </div>
                </div>        
                <div class="data">
                    <h1>Einsatzbeginn:</h1>
                    <div class="icon showIcon">
                        <img src="<?=base_url('images/icons/icon_cal.png')?>">
                    </div>
                    <div class="info showInfo">     
                        <h3><?=cp_get_ger_date($einsatz['datum_beginn'])?></h3>
                        <h4><?=$einsatz['uhrzeit_beginn']?> Uhr</h4>
                    </div>    
	                <hr class="clear" />
                </div>
                <div class="data">
                    <h1>Einsatzende:</h1>
                    <div class="icon showIcon">
                        <img src="<?=base_url('images/icons/icon_cal_red.png')?>">
                    </div>
                    <div class="info showInfo">    
                        <h3><?=cp_get_ger_date($einsatz['datum_ende'])?></h3>
                        <h4><?=$einsatz['uhrzeit_ende']?> Uhr</h4>
                    </div>
                    <hr class="clear" />
                </div>
                <div class="data">
                    <h1>Einsatzdauer:</h1>
                    <div class="icon">
                        <img src="<?=base_url('images/icons/icon_clock.png')?>">
                    </div>
                    <div class="info"> 
                        <h3><?=$dauer_stunden?> h</h3>
                        <h4><?=$dauer_minuten?> Min</h4>
                    </div>
	                <hr class="clear" />
                </div>
                <div class="data">
                    <h1>Fahrzeuge:</h1>
                    <div class="icon">
                        <img src="<?=base_url('images/icons/icon_cars.png')?>">
                    </div>
                    <div class="info">    
<? if(isset($einsatz['fahrzeug'])) : $count = count($einsatz['fahrzeug']); else : $count = 0; endif; ?>                  
                        <h2><?=$count?></h2>
                    </div>
	                <hr class="clear" />
                </div>
                <div class="data">
                    <h1>Einsatzkr&auml;fte:</h1>
                    <div class="icon">
                        <img src="<?=base_url('images/icons/icon_people.png')?>">
                    </div>
                    <div class="info">    
	                    <h2><?=$einsatz['anzahlEinsatzkraefte']?></h2>
    				</div>
	                <hr class="clear" />
                </div>
            </div>
        </div>
        <hr class="clear" />