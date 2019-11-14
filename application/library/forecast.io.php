<?php
/**
 * Helper Class for forecast.io webservice
 */

class ForecastIO{
  
  private $api_key;
  const API_ENDPOINT = 'https://api.forecast.io/forecast/'; 
  
  
  /**
   * Create a new instance
   * 
   * @param String $api_key
   */
  function __construct($api_key) {
    
    $this->api_key = $api_key;
    
        
  }
  

  function get_content($URL){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_URL, $URL);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
  }
  
  private function requestData($latitude, $longitude, $timestamp = false, $exclusions = false) {
    
    $request_url = self::API_ENDPOINT .
        $this->api_key . '/' .
        $latitude . ',' . $longitude .
        ( $timestamp ? ',' . $timestamp : '' ) .
        '?units=auto' .
        ( $exclusions ? '&exclude=' . $exclusions : '' );
    
    //$content = file_get_contents($request_url);
    $content = $this->get_content($request_url);

    //print_r( $content );
    
    if (!empty($content)) {
      
      //print_r( json_decode($content));
      return json_decode($content);
       
    } else {
      
      return false;
      
    }
    
    
  } 
  
  /**
   * Will return the current conditions
   * 
   * @param float $latitude
   * @param float $longitude
   * @return \ForecastIOConditions|boolean
   */
  function getCurrentConditions($latitude, $longitude) {
    
    $data = $this->requestData($latitude, $longitude);

    if ($data !== false) {
      
      return new ForecastIOConditions($data);
      
    } else {
      
      return false;
      
    }
  
  }
};



/**
 * Wrapper for get data by getters
 */
class ForecastIOConditions{
  
  private $raw_data;
  private $alerts;

  function __construct($raw_data) {
    
    $this->raw_data = $raw_data->currently;
    //$this->alerts = $raw_data->alerts;
    
  }
  
  /**
   * Will return the temperature
   * 
   * @return String
   */
  function getTemperature() {
    
    return $this->raw_data->temperature;
    
  }

  function getApparentTemperature(){

    return $this->raw_data->apparentTemperature;
    
  }
  
  /**
   * get the min temperature
   * 
   * only available for week forecast
   * 
   * @return type
   */
  function getMinTemperature() {
    
    return $this->raw_data->temperatureMin;
    
  }
  
  /**
   * get max temperature
   * 
   * only available for week forecast
   * 
   * @return type
   */
  function getMaxTemperature() {
    
    return $this->raw_data->temperatureMax;
    
  }
  
  /**
   * Get the summary of the conditions
   * 
   * @return String
   */
  function getSummary() {
    
    return $this->raw_data->summary;
    
  }

  /**
   * Get the icon of the conditions
   * 
   * @return String
   */
  function getIcon() {
    
    return $this->raw_data->icon;
    
  }
  
  /**
   * Get the time, when $format not set timestamp else formatted time
   * 
   * @param String $format
   * @return String
   */
  function getTime($format = null) {
    
    if (!isset($format)) {
      
      return $this->raw_data->time;
      
    } else {
      
      return date($format, $this->raw_data->time);
      
    }
    
  }
  
  /**
   * Get the pressure
   * 
   * @return String
   */
  function getPressure() {
    
    return $this->raw_data->pressure;
    
  }
  
  /**
   * get humidity
   * 
   * @return String
   */
  function getHumidity() {
    
    return $this->raw_data->humidity;
    
  }
  
  /**
   * Get the wind speed
   * 
   * @return String
   */
  function getWindSpeed() {
    
    return $this->raw_data->windSpeed;
    
  }
  
  /**
   * Get wind direction
   * 
   * @return type
   */
  function getWindBearing() {
    
    return $this->raw_data->windBearing;
    
  }
  
  /**
   * get precipitation type
   * 
   * @return type
   */
  function getPrecipitationType() {
    
    return $this->raw_data->precipType;
    
  }
  
  /**
   * get the probability 0..1 of precipitation type
   * 
   * @return type
   */
  function getPrecipitationProbability() {
    
    return $this->raw_data->precipProbability;
    
  }
  
  /**
   * Get the cloud cover
   * 
   * @return type
   */
  function getCloudCover() {
    
    return $this->raw_data->cloudCover;
    
  }
  

  
  /**
   * get sunrise time
   * 
   * only available for week forecast
   * 
   * @return type
   */
  function getSunrise() {
    
    return $this->raw_data->sunriseTime;
    
  }
  
  /**
   * get sunset time
   * 
   * only available for week forecast
   * 
   * @return type
   */
  function getSunset() {
    
    return $this->raw_data->sunsetTime;
    
  }
  
}
?>
