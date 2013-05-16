<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
 //  echo "<pre>"; var_dump($weather); echo "</pre>";
?>

            <div class="weather">
            	<h1>Wetter Aussichten</h1>
                <div class="wrapper">    
                    <div class="icon">
                    <?=$weather['weather_img']?>
                    <!--<img src="<?=base_url('images/layout/weather_cloudly.png')?>" width="107" height="106" />-->
                    </div>
                    <div class="text">
                        <p class="grad"><?=$weather['weather_cond'][0]['temp']?>&deg;<span class="celsius">Celsius</span></p>
                        <p class="status"><?=$weather['weather_cond'][0]['text']?></p>
                    </div>
                </div>
                <hr class="clear" />
                <p class="more"><a href="#" class="button_white">Read more</a></p>
            </div>