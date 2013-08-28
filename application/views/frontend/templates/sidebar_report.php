<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?>

<div class="statistic">
            	<h1 class="first">Das sind wir in Zahlen</h1>
                <!--<p>
                <img src="<?=base_url('images/layout/statistic_einsatz.png')?>" width="95" height="105" />
            	<img src="<?=base_url('images/layout/statistic_fehlalarm.png')?>" width="95" height="105" />
                </p>-->
               
                <hr class="clear" />
                <table>
                	<tr><td>Mannschaft</td><td class="value"><?=$mannschaft->anzahl?></td></tr>
                	<tr><td>Frauen</td><td class="value"><?=$mannschaft->anzahl_w?></td></tr>
                	<tr><td>M&auml;nner</td><td class="value"><?=$mannschaft->anzahl_m?></td></tr>
                	<tr><td>Fahrzeuge</td><td class="value"><?=$fahrzeug_anzahl?></td></tr>
                </table>          
            </div>
           <hr class="clear" />