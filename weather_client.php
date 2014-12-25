<?php
error_reporting(E_ALL);
ini_set('display_error',1);
require_once "nusoap/lib/nusoap.php";
$client = new nusoap_client("http://localhost/weather/weather_service.php");
 
$error = $client->getError();
$result = $client->call("GetWeatherInformation", array());
print_r($result);