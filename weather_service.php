<?php
error_reporting(E_ALL&~E_NOTICE);
ini_set('display_error',1);
require_once "nusoap/lib/nusoap.php";

function GetWeatherInformation()
{
  // ganti menggunakan database
  return array(
    'GetWeatherInformationResult' => 
      array(
        array('WheatherID' => '1','Description' => 'Thunder Storms', 'PictureURL' => 'http://ws.cdyne.com/WeatherWS/Images/thunderstorms.gif'),
        array('WheatherID' => '2','Description' => 'Partly Cloudy', 'PictureURL' => 'http://ws.cdyne.com/WeatherWS/Images/partlycloudy.gif'),
        array('WheatherID' => '3','Description' => 'Mostly Cloudy', 'PictureURL' => 'http://ws.cdyne.com/WeatherWS/Images/mostlycloudy.gif')
      )
  );
}


$namespace  = 'http://ws.cdyne.com/WeatherWS/';
$server     = new nusoap_server();

/*
configureWSDL(  $serviceName,
                $namespace  = false,
                $endpoint   = false,
                $style      = 'rpc',
                $transport  = 'http://schemas.xmlsoap.org/soap/http',
                $schemaTargetNamespace = false)*/
$server->configureWSDL( 'Weather',
                        $namespace,
                        '',
                        'document');



//---------------------------------------------------------------------
// GetWeatherInformation
$server->register(
    'GetWeatherInformation',
    array(),
    array('GetWeatherInformationResult'  => 'tns:ArrayOfWeatherDescription'),
    $namespace,
    "$namespace#GetWeatherInformation", 'document', 'literal', 'Get some GetWeatherInformationResponse');

// GetWeatherInformationResponse
$server->wsdl->addComplexType(
    'GetWeatherInformationResult',       // name
    'complexType',  // typeClass: complexType, simpleType, attribute
    'struct',       // phpType: array, struct (php assoc array)
    'sequence',     // compositor: all, sequence, choice
    '',             // restrictionBase e.g.: SOAP-ENC:Array
    array
    (
        'WheatherID' => array('name' => 'WheatherID', 'type' => 'xsd:string'),
        'Description' => array('name' => 'Description', 'type' => 'xsd:string'),
        'PictureURL' => array('name' => 'PictureURL', 'type' => 'xsd:string'),
    )
);
$server->wsdl->addComplexType(
    'ArrayOfWeatherDescription',
    'complexType',
    'array',
    '',
    '',
    array(),
    array(),
    'tns:GetWeatherInformationResult'
);


//---------------------------------------------------------------------
 $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : ''; $server->service($HTTP_RAW_POST_DATA);


