<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    $this->load->helper('html'); 
?>

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