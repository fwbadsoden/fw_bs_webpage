<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?>

<div id="MainContent">
            <div class="BildTextTeaser">
            	<figure><img src="<?=base_url('images/content/YmYxYzNkZmQ5NmFmOTQxNWZiOTlhNzc4M2I2ZjUwYmRlMzdmNjcxMDY2OWQxODdiZDJlZjg4MjkzNjQ4YmEyZGZlYjA5NTExNGZiYTIxNTNiNjU5ZGNiNmFhN2NlNzU2ODk5MzY4ZGJhYzRkM2NhOGQ1ODExNTFjMWIyMjJmMzI.jpg')?>"></figure>
                <h1>Ein Blick hinter die Kulissen</h1>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, 
sed diam voluptua.</p>
				<p class="more"><a href="#" class="button_black">Read more</a></p>
            </div>
        	<div class="BildTextTeaser">
             	<figure><img src="<?=base_url('images/content/ZTQzZjRiZjY2YzcyZGI0ZjdkNzRkNjJiMTc0MjkwNzU2YzZiOTRmMmZlMjEyODgwNzhlODgwYWM0NjY3MmI5N2I1YzRhOTAyN2Y2MzJkNmMxZWI3OWYyMzgwYzg5YTRmYzVhM2FiNjY1ZmRkOTNiNTUzMzc3NWZkOTc5OTdhYTM.jpg')?>"></figure>
                <h1>Unser Neustes L&ouml;schfahrzeug</h1>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, 
sed diam voluptua.</p>
				<p class="more"><a href="#" class="button_black">Read more</a></p>
           </div>
           <hr class="clear" />
           
           <h1 class="module">Einsatz-Ticker</h1>           
           <ul class="news">
<? foreach($einsatz_overview as $einsatz) { ?>           
               <li>
                    <h2><span class="date"><?=cp_get_ger_date($einsatz['datum']).' '.$einsatz['beginn']?></span> / <?=$einsatz['type_name']?></h2>
                    <h1><?=$einsatz['name']?></h1>
                    <p><?=$einsatz['lage']?></p>
               </li>
<? } ?>
           </ul>
           
        </div>
        
        <div id="SidebarContent">
        
        	<div class="statistic">
            	<h1 class="first">Das sind wir in Zahlen</h1>
                <p>
                <img src="<?=base_url('images/layout/statistic_einsatz.png')?>" width="95" height="105" />
            	<img src="<?=base_url('images/layout/statistic_fehlalarm.png')?>" width="95" height="105" />
                </p>
               
                <hr class="clear" />
                <table>
                	<tr><td>Mannschaft</td><td class="value">58</td></tr>
                	<tr><td>Frauen</td><td class="value">7</td></tr>
                	<tr><td>M&auml;nner</td><td class="value">51</td></tr>
                	<tr><td>Fahrzeuge</td><td class="value">12</td></tr>
                </table>          
            </div>
            
            <div class="dates">
            	<h1>Termine</h1>
                <ul>    
<? foreach($termin_overview as $termin) { ?>                 
                    <li>    
                        <h3><span class="date"><?=cp_get_ger_date($termin['datum'])?> - <?=$termin['beginn']?> Uhr</span> / <?=$termin['ort']?></h3>
                        <h2><?=$termin['name']?></h2>
                    </li>
<? } ?>
                </ul>
                <p class="more"><a href="#" class="button_white">Read more</a></p>
            </div>
        
            <div class="weather">
            	<h1>Wetter Aussichten</h1>
                <div class="wrapper">    
                    <div class="icon"><img src="<?=base_url('images/layout/weather_cloudly.png')?>" width="107" height="106" /></div>
                    <div class="text">
                        <p class="grad">15&deg;<span class="celsius">Celsius</span></p>
                        <p class="status">Leicht bew&ouml;lkt</p>
                    </div>
                </div>
                <hr class="clear" />
                <p class="more"><a href="#" class="button_white">Read more</a></p>
            </div>

        </div>