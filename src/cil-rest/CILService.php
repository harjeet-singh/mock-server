<?php
/**
 * This class is an implemenatation class for all the web services
 */
require_once('lib/RestService.php');

class CILService extends RestService{
    
    
    public function __construct() {
        parent::__construct();
        parent::$base = (rtrim(parent::$base, '/').'/cil-rest/');
    }
    
    public function registerApiRest()
    {
        return array(
            'getAllProfile' => array(
                'reqType' => 'POST',
                'path' => array('getAllProfile'),
                'pathVars' => array(''),
                'method' => 'getAllProfile',
                'shortHelp' => 'get all profiles',
            ),
            'getInvoiceSummary' => array(
                'reqType' => 'POST',
                'path' => array('getInvoiceSummary'),
                'pathVars' => array(''),
                'method' => 'getInvoiceSummary',
                'shortHelp' => 'get invoice summary',
            ),
        );
    }

    public static function getAllProfile($url, $query_parameters, $payload){	
        return self::getResponse('getAllProfile', $url, $query_parameters, $payload);
    }
    
    public static function getInvoiceSummary($url, $query_parameters, $request_body){	
        return self::getResponse($url, $query_parameters, $request_body);
    }
    
    // Added parameter $cilUrl because some cil call have another element in their url endpoint after the function name
    public static function authenticate($payload) {
        if(!isset($payload['csrLoginName']))
            return false;
        else
            return true;
    }
    
    public static function getResponse($function, $url, $arguments = null, $payload = null) {
        if(self::authenticate($payload)){
            return parent::getResponse($function, $url, $arguments, $payload);
        }
        else{
            return json_encode(array('error'=> 'Authentication failure'));
        }
    }
} 

