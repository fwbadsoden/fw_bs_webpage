<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
define('WEATHER_IMAGE_PATH', 'images/weather/');

class Weather {
    /*
  * This gist utilizes Yahoo's Weather API to snag the current
  * weather conditions for any country given it's WOEID.
  *
  * - by Carwin Young
  */
 
    /* Set up some location WOEIDs */
    private $MTK = '12835281'; 
    private $condition_code_mapping = array();
 
    public function __construct()
    {
        $this->condition_code_mapping['0']['description_DE']      = 'Tornado';
        $this->condition_code_mapping['0']['img']                 = '';
        $this->condition_code_mapping['1']['description_DE']      = 'Tropensturm';
        $this->condition_code_mapping['1']['img']                 = '';
        $this->condition_code_mapping['2']['description_DE']      = 'Hurrikan';
        $this->condition_code_mapping['2']['img']                 = '';
        $this->condition_code_mapping['3']['description_DE']      = 'heftige Gewitter';
        $this->condition_code_mapping['3']['img']                 = '';
        $this->condition_code_mapping['4']['description_DE']      = 'Gewitter';
        $this->condition_code_mapping['4']['img']                 = '';
        $this->condition_code_mapping['5']['description_DE']      = $this->condition_code_mapping['6']['description_DE'] = $this->condition_code_mapping['7']['description_DE'] = 'Schneeregen';
        $this->condition_code_mapping['5']['img']                 = $this->condition_code_mapping['6']['img']            = $this->condition_code_mapping['7']['img']            = '';
        $this->condition_code_mapping['8']['description_DE']      = 'gefrierender Nieselregen';
        $this->condition_code_mapping['8']['img']                 = '';
        $this->condition_code_mapping['9']['description_DE']      = 'Nieselregen';
        $this->condition_code_mapping['9']['img']                 = 'weather_rainy.png';
        $this->condition_code_mapping['10']['description_DE']     = 'gefrierender Regen';
        $this->condition_code_mapping['10']['img']                = '';
        $this->condition_code_mapping['11']['description_DE']     = $this->condition_code_mapping['12']['description_DE'] = 'Regeng&uuml;sse';
        $this->condition_code_mapping['11']['img']                = $this->condition_code_mapping['12']['img']            = 'weather_rainy.png';
        $this->condition_code_mapping['13']['description_DE']     = 'Schneegest&ouml;ber';
        $this->condition_code_mapping['13']['img']                = '';
        $this->condition_code_mapping['14']['description_DE']     = 'leichter Schneeregen';
        $this->condition_code_mapping['14']['img']                = '';
        $this->condition_code_mapping['15']['description_DE']     = 'Schneegest&ouml;ber';
        $this->condition_code_mapping['15']['img']                = '';
        $this->condition_code_mapping['16']['description_DE']     = 'Schnee';
        $this->condition_code_mapping['16']['img']                = '';
        $this->condition_code_mapping['17']['description_DE']     = 'Hagel';
        $this->condition_code_mapping['17']['img']                = '';
        $this->condition_code_mapping['18']['description_DE']     = 'Graupelregen';
        $this->condition_code_mapping['18']['img']                = '';
        $this->condition_code_mapping['19']['description_DE']     = 'Staubwolke';
        $this->condition_code_mapping['19']['img']                = '';
        $this->condition_code_mapping['20']['description_DE']     = 'neblig';
        $this->condition_code_mapping['20']['img']                = '';
        $this->condition_code_mapping['21']['description_DE']     = 'dunstig';
        $this->condition_code_mapping['21']['img']                = '';
        $this->condition_code_mapping['22']['description_DE']     = 'verraucht';
        $this->condition_code_mapping['22']['img']                = '';
        $this->condition_code_mapping['23']['description_DE']     = 'st&uuml;rmisch';
        $this->condition_code_mapping['23']['img']                = '';
        $this->condition_code_mapping['24']['description_DE']     = 'windig';
        $this->condition_code_mapping['24']['img']                = '';
        $this->condition_code_mapping['25']['description_DE']     = 'kalt';
        $this->condition_code_mapping['25']['img']                = '';
        $this->condition_code_mapping['26']['description_DE']     = 'wolkig';
        $this->condition_code_mapping['26']['img']                = 'weather_cloudly.png';
        $this->condition_code_mapping['27']['description_DE']     = '&uuml;berwiegend wolkig';
        $this->condition_code_mapping['27']['img']                = 'weather_cloudly.png';
        $this->condition_code_mapping['28']['description_DE']     = '&uuml;berwiegend wolkig';
        $this->condition_code_mapping['28']['img']                = 'weather_cloudly.png';
        $this->condition_code_mapping['29']['description_DE']     = 'teilweise wolkig';
        $this->condition_code_mapping['29']['img']                = 'weather_cloudly.png';
        $this->condition_code_mapping['30']['description_DE']     = 'teilweise wolkig';
        $this->condition_code_mapping['30']['img']                = 'weather_cloudly.png';
        $this->condition_code_mapping['31']['description_DE']     = 'klar (nachts)';
        $this->condition_code_mapping['31']['img']                = '';
        $this->condition_code_mapping['32']['description_DE']     = 'sonnig';
        $this->condition_code_mapping['32']['img']                = '';
        $this->condition_code_mapping['33']['description_DE']     = 'heiter bis wolkig';
        $this->condition_code_mapping['33']['img']                = 'weather_cloudly.png';
        $this->condition_code_mapping['34']['description_DE']     = 'heiter bis wolkig';
        $this->condition_code_mapping['34']['img']                = 'weather_cloudly.png';
        $this->condition_code_mapping['35']['description_DE']     = 'Hagel und Regen';
        $this->condition_code_mapping['35']['img']                = '';
        $this->condition_code_mapping['36']['description_DE']     = 'hei&szlig;';
        $this->condition_code_mapping['36']['img']                = '';
        $this->condition_code_mapping['37']['description_DE']     = $this->condition_code_mapping['38']['description_DE'] = $this->condition_code_mapping['39']['description_DE'] = 'vereinzelte Gewitter';
        $this->condition_code_mapping['37']['img']                = $this->condition_code_mapping['38']['img']            = $this->condition_code_mapping['39']['img']            = 'weather_rainy.png';
        $this->condition_code_mapping['40']['description_DE']     = 'vereinzelte Regeng&uuml;sse';
        $this->condition_code_mapping['40']['img']                = 'weather_rainy.png';
        $this->condition_code_mapping['41']['description_DE']     = $this->condition_code_mapping['43']['description_DE'] = 'schwerer Schneefall';
        $this->condition_code_mapping['41']['img']                = $this->condition_code_mapping['43']['img']            = '';
        $this->condition_code_mapping['42']['description_DE']     = 'vereinzelt Schneeregen';
        $this->condition_code_mapping['42']['img']                = '';
        $this->condition_code_mapping['44']['description_DE']     = 'teils wolkig';
        $this->condition_code_mapping['44']['img']                = 'weather_cloudly.png';
        $this->condition_code_mapping['45']['description_DE']     = 'Gewitterregen';
        $this->condition_code_mapping['45']['img']                = 'weather_rainy.png';
        $this->condition_code_mapping['46']['description_DE']     = 'Schneeschauer';
        $this->condition_code_mapping['46']['img']                = '';
        $this->condition_code_mapping['47']['description_DE']     = 'vereinzelt Gewitterregen';
        $this->condition_code_mapping['47']['img']                = 'weather_rainy.png';
        $this->condition_code_mapping['3200']['description_DE']   = 'Wetterdienst nicht verf&uuml;gbar';
        $this->condition_code_mapping['3200']['img']              = '';
    }
 
    public function get_weather() {
        /* Use cURL to query the API for some XML */
        $location = $this->MTK;
      //  echo 'http://weather.yahooapis.com/forecastrss?w='.$location.'&u=c';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://weather.yahooapis.com/forecastrss?w='.$location.'&u=c');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $weather_rss = curl_exec($ch);
        curl_close($ch);
     
        /* Create an object of the XML returned */
        $weather = new SimpleXMLElement($weather_rss);
      
        /* 
        * Since I don't want to figure out an image system, I'll use Weather.com's (what Yahoo does)
        * by pulling the image directly out of the returned API request. This could be done better.
        */
        $weather_contents = $weather->channel->item->description;
        preg_match_all('/<img[^>]+>/i',$weather_contents, $img);
        if(isset($img[0][0]))
        {
            $image_yahoo = $img[0][0];
            str_replace('<img src="', '', $image_yahoo);
            str_replace('"/>', '', $image_yahoo);    
         
            /* Get clean parts */
            $weather_unit                       = $weather->channel->xpath('yweather:units');
            $weather_cond                       = $weather->channel->item->xpath('yweather:condition');
            $weather_wind                       = $weather->channel->xpath('yweather:wind');
            
    //        $weather_unit_atts_object           = $weather_unit[0]->attributes();
    //        $weather_unit_atts_array            = (array) $weather_unit_atts_object;
    //        $weather_unit_atts_array            = $weather_unit_atts_array['@attributes'];
    //        $return['weather_unit']             = $weather_unit_atts_array;
    //        
    //        $weather_wind_atts_object           = $weather_wind[0]->attributes();
    //        $weather_wind_atts_array            = (array) $weather_wind_atts_object;
    //        $weather_wind_atts_array            = $weather_wind_atts_array['@attributes'];
    //        $return['weather_wind']             = $weather_wind_atts_array;
            
            $weather_cond_atts_object           = $weather_cond[0]->attributes();
            $weather_cond_atts_array            = (array) $weather_cond_atts_object;
            $weather_cond_atts_array            = $weather_cond_atts_array['@attributes'];
            $weather_cond_atts_array['text']    = $this->condition_code_mapping[$weather_cond_atts_array['code']]['description_DE'];
            $return['weather_cond']             = $weather_cond_atts_array;
            if($this->condition_code_mapping[$weather_cond_atts_array['code']]['img'] == '')
                $return['weather_img']          = $image_yahoo;
            else
                $return['weather_img']          = '<img id="'.$weather_cond_atts_array['code'].'" src="'.base_url(WEATHER_IMAGE_PATH.$this->condition_code_mapping[$weather_cond_atts_array['code']]['img']).'" title="'.$weather_cond_atts_array['text'].'">';                 
        }
        else
        {
            $weather_cond_atts_array['text']   = $this->condition_code_mapping['3200']['description_DE'];
            $weather_cond_atts_array['temp']    = '_';
            $return['weather_cond']             = $weather_cond_atts_array;
            $return['weather_img']              = '';
        }
        return $return;
    }
    
    /* Function to convert Wind Direction from given degree units into Cardinal units */
    public function cardinalize($degree) {
        if($degree == 0) $direction = '';
        if($degree >= 348.75 && $degree <= 11.25) $direction = 'N';
        if($degree > 11.25 && $degree <= 33.75) $direction = 'NNE';
        if($degree > 33.75 && $degree <= 56.25) $direction = 'NE';
        if($degree > 56.25 && $degree <= 78.75) $direction = 'ENE';
        if($degree > 78.75 && $degree <= 101.25) $direction = 'E';
        if($degree > 101.25 && $degree <= 123.75) $direction = 'ESE';
        if($degree > 123.75 && $degree <= 146.25) $direction = 'SE';
        if($degree > 146.25 && $degree <= 168.75) $direction = 'SSE';
        if($degree > 168.75 && $degree <= 191.25) $direction = 'S';
        if($degree > 191.25 && $degree <= 213.75) $direction = 'SSW';
        if($degree > 213.75 && $degree <= 236.25) $direction = 'SW';
        if($degree > 236.25 && $degree <= 258.75) $direction = 'WSW';
        if($degree > 258.75 && $degree <= 281.25) $direction = 'W';
        if($degree > 281.25 && $degree <= 303.75) $direction = 'WNW';
        if($degree > 303.75 && $degree <= 326.25) $direction = 'NW';
        if($degree > 326.25 && $degree < 348.75) $direction = 'NNW';
        return $direction;
    }    
}

/* End of file Weather.php */
/* Location: ./application/libraries/Weather.php */