<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?>

            <div class="weather">
            	<h1>Wetter Aussichten</h1>
                <div class="wrapper">    
                   <!-- <div class="icon"><?=$weather['weather_img']?></div>-->
                    <div class="text">
                        <p class="grad"><?=$weather['weather_cond']['temp']?>&deg;<span class="celsius">Celsius</span></p>
                        <p class="status"><?=$weather['weather_cond']['text']?></p>
                    </div>
                </div>
                <hr class="clear" />
               <!-- <p class="more"><a href="#" class="button_white">Read more</a></p>-->
            </div>