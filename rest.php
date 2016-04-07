<?php
chdir(__DIR__);

error_reporting(E_ALL);
ini_set('display_errors',0);
date_default_timezone_set('America/New_York');

require_once('lib/utils.php');  

require_once 'lib/Logger.php';

$log = new Logger("logs", "mockserver.log");
global $log;
$log->write("Sevice Started...");

// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}
try {
    
    if(strpos($_SERVER['SERVER_NAME'], 'cil-rest') !== false){
        require_once 'src/cil-rest/CILService.php';
        $class = 'CILService';
    }
    
    if(strpos($_SERVER['SERVER_NAME'], 'cil-marketing') !== false){
        require_once 'src/cil-marketing/CILMarketingService.php';
        $class = 'CILMarketingService';
    }
    
    if(empty($class)){
        throw new Exception("service does not exist");
    }
    
    $API = new $class($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    echo $API->serve();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}


?>
