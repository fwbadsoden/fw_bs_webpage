<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?> 

        <div class="oneColumnBox">
            <div class="factSheet">
                <div class="table">
                    <div class="row">
                        <div class="black">Funkrufname:</div>
<? if($fahrzeug['fahrzeugRufname'] == 'n/a') : $rufname = 'n/a'; else : $rufname = $fahrzeug['fahrzeugRufnamePrefix'].' '.$fahrzeug['fahrzeugRufname']; endif; ?>                      
                        <div class="red"><?=$rufname?></div>
                    </div>
                    <div class="row">
                        <div class="black">Hersteller:</div>
                        <div class="red"><?=$fahrzeug['fahrzeugHersteller']?></div>
                    </div>
                    <div class="row">
                        <div class="black">Aufbau:</div>
                        <div class="red"><?=$fahrzeug['fahrzeugAufbau']?></div>
                    </div>
                    <div class="row">
                        <div class="black lastRow">Baujahr:</div>
                        <div class="red lastRow"><?=$fahrzeug['fahrzeugBaujahr']?></div>
                    </div>
                </div>        
                <div class="data">
                    <h1>Leistung:</h1>
                    <h2><?=$fahrzeug['fahrzeugLeistungKW']?> KW</h2>
                    <div class="icon">
                        <img src="<?=base_url('images/icons/icon_ps.png')?>">
                        <span><?=$fahrzeug['fahrzeugLeistungPS']?> ps</span>
                        <hr class="clear" />
                    </div>
                </div>
                <div class="data">
                    <h1>L&auml;nge:</h1>
                    <h2><?=$fahrzeug['fahrzeugLaenge']?> m</h2>
                    <div class="icon">
                        <img src="<?=base_url('images/icons/icon_length.png')?>">
                        <hr class="clear" />
                    </div>
                </div>
                <div class="data">
                    <h1>H&ouml;he:</h1>
                    <h2><?=$fahrzeug['fahrzeugHoehe']?> m</h2>
                    <div class="icon">
                        <img src="<?=base_url('images/icons/icon_height.png')?>">
                        <hr class="clear" />
                    </div>
                </div>
                <div class="data">
                    <h1>Breite:</h1>
                    <h2><?=$fahrzeug['fahrzeugBreite']?> m</h2>
                    <div class="icon">
                        <img src="<?=base_url('images/icons/icon_width.png')?>" />
                        <hr class="clear" />
                    </div>
                </div>
                <div class="data">
                    <h1>Leermasse:</h1>
                    <h2><?=$fahrzeug['fahrzeugLeermasse']?> t</h2>
                    <div class="icon">
                        <img src="<?=base_url('images/icons/icon_weight.png')?>" />
                        <span><?=str_replace(',', '.', $fahrzeug['fahrzeugLeermasse'])*1000?> kg</span>
                        <hr class="clear" />
                    </div>
                </div>
                <div class="data">
                    <h1>Besatzung:</h1>
                    <h2><?=$fahrzeug['fahrzeugBesatzung']?></h2>
                    <div class="icon">
                        <img src="<?=base_url('images/icons/icon_people.png')?>" />
                        <hr class="clear" />
                    </div>
                </div>
            </div>
        </div>
        <hr class="clear" />