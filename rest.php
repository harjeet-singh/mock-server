<?php
chdir(__DIR__);

error_reporting(E_ALL);
ini_set('display_errors',0);
date_default_timezone_set('America/New_York');

require_once('lib/utils.php');  
debug("----------Mock Service Accessed-------------");
//debug($_SERVER);
// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}
try {
    
    if(strpos($_SERVER['REQUEST_URI'], 'cil-rest') !== false){
        require_once 'src/cil-rest/CILService.php';
        $class = 'CILService';
    }
    
    if(strpos($_SERVER['REQUEST_URI'], 'cil-marketing') !== false){
        require_once 'src/cil-marketing/CILMarketingService.php';
        $class = 'CILMarketingService';
    }
    
    if(strpos($_SERVER['REQUEST_URI'], 'regi') !== false){
        require_once 'src/cil-marketing/RegiService.php';
        $class = 'CILMarketingService';
    }
    
    if(empty($class)){
        throw new Exception("service does not exist");
    }
    
    $API = new $class();
    echo $API->serve();
} catch (Exception $e) {
    header("HTTP/1.1 " . $e->getCode() . " " );
    echo json_encode(Array('error' => $e->getMessage(), 'status' => $e->getCode()));
}


?>
