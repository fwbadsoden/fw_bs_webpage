<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?> 

<div class="SmallBox secondColumn">  
    	    <div class="dateBox">
                <h1>Die letzten Einsätze</h1>
                <ul>
<? foreach($einsaetze as $einsatz) : ?>                
                    <li>
                        <a href="<?=base_url('aktuelles/einsatz/'.$einsatz['einsatzID'])?>">
                        <h2><?=cp_get_ger_date($einsatz['datum'])?></h2>
                        <p><?=$einsatz['lage']?></p>
                        </a>
                    </li>
<? endforeach; ?>                    
                </ul>
            </div>
        </div>
        <hr class="clear" />