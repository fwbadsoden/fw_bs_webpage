<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?>

                <li>
                    <a href="#<?=$count?>" rel="js_terminopen">
                    <div class="row">
                        <div class="termin_date" id="js_termincolor_<?=$count?>">
                            <p class="day"><?=$tag_int?></p>
                            <p class="month"><?=$monat?></p>
                            <p class="year"><?=$jahr?></p>
                        </div>
                        <div class="termin_headline">
                            <h1><?=$name?></h1>
                            <h2><?=$beginn?> Uhr / <?=substr($description, 0, 60)?></h2>
                            <div class="termin_details" id="js_termin_<?=$count?>">
                                <p>
                                <?=$description?>
                                </p>
                                <div class="time">
                                    <p class="datum"><?=$tag?>, den <?=cp_get_ger_date($datum)?></p>
                                    <p class="clock">
                                    	<span style="white-space:nowrap;"><?=$beginn?> <span class="word">Uhr</span></span>
                                         <span class="trenner">/</span> 
                                    	<span style="white-space:nowrap;"><?=$ende?> <span class="word">Uhr</span></span>
                                    </p>
                                </div>
                                <div class="loction">
                                    <p>
                                        <?=$ort?>
                                    </p>
                                </div>
                            </div>
                            <div class="linkleiste">
                                <p class="link_open active" id="js_linkopen_<?=$count?>">Mehr lesen</p>
                                <p class="link_close" id="js_linkclose_<?=$count?>">Schließen</p>
                            </div>
                        </div>
                    </div>
                    </a>
                </li> 