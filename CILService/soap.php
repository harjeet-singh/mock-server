<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once('CILServiceImpl.php');
require_once('cil_registry.php');
require_once('service/core/SoapService2.php');
require_once('Logger.php');  

$log = new Logger();
$service = new SoapService2('http://localhost/MockServer/CILService/soap.php');
$service->registerClass("cil_registry");
$service->register();
$service->registerImplClass("CILServiceImpl");

// set the service object in the global scope so that any error, if happens, can be set on this object
global $service_object;
$service_object = $service;

$service->serve();



function writelog($message){
        $file = fopen("api.log","a");
        $date = new DateTime('NOW');
        $date = $date->format("Y M d D h:g:i a");

        if(is_array($message) || is_object($message)){
            fwrite($file, '['.$date.'] '.print_r($message,true));
        }
        else{
            fwrite($file, '['.$date.'] '.$message);
        }
        fwrite($file, PHP_EOL);
        fclose($file);
    }

?>
