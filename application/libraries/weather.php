<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Weather {
    /*
  * This gist utilizes Yahoo's Weather API to snag the current
  * weather conditions for any country given it's WOEID.
  *
  * - by Carwin Young
  */
 
    /* Set up some location WOEIDs */
    private $MTK = 12835281; 
 
    public function get_weather() {
        /* Use cURL to query the API for some XML */
        $location = $this->MTK;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://weather.yahooapis.com/forecastrss?w='.$location.'&u=f');
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
        $return['weather_img'] = $img[0][0];
     
        /* Get clean parts */
        $return['weather_unit'] = $weather->channel->xpath('yweather:units');
        $return['weather_cond'] = $weather->channel->item->xpath('yweather:condition');
        $return['weather_wind'] = $weather->channel->xpath('yweather:wind');
        
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
?>