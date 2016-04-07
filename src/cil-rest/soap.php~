<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once('CILService.php');
require_once('cil_registry.php');
require_once('../service/core/SoapService2.php');
require_once('../Utils/custom_functions.php');  

$service = new SoapService2('http://localhost/MockServer/CILService/soap.php');
$service->registerClass("cil_registry");
$service->register();
$service->registerImplClass("CILService");

// set the service object in the global scope so that any error, if happens, can be set on this object
global $service_object;
$service_object = $service;

$service->serve();



?>
