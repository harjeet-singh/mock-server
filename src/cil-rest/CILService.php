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
                'shortHelp' => 'get all profiles',
            ),
            'getInvoiceSummary' => array(
                'reqType' => 'POST',
                'shortHelp' => 'get invoice summary',
            ),
            'getSubscriptions' => array(
                'reqType' => 'POST',
                'shortHelp' => 'get subscriptions',
            ),
            'getSubscriptionDetails' => array(
                'reqType' => 'POST',
                'shortHelp' => 'get subscription details',
            ),
            'getPreferences' => array(
                'reqType' => 'POST',
                'shortHelp' => 'get subscription details',
            ),
            'getPaymentProfile' => array(
                'reqType' => 'POST',
                'shortHelp' => 'get payment profile',
            ),
            'getTransactionHistory' => array(
                'reqType' => 'POST',
                'shortHelp' => 'get transaction history',
            ),
            'getRateChart' => array(
                'reqType' => 'POST',
                'shortHelp' => 'get rate chart',
            ),
        );
    }

    public static function getAllProfile($url, $query_parameters, $payload){	
        return self::getResponse('getAllProfile', $url, $query_parameters, $payload);
    }
    
    public static function getInvoiceSummary($url, $query_parameters, $request_body){	
        return self::getResponse('getInvoiceSummary' ,$url, $query_parameters, $request_body);
    }
    
    public static function getSubscriptions($url, $query_parameters, $request_body){	
        return self::getResponse('getSubscriptions' ,$url, $query_parameters, $request_body);
    }
    
    public static function getSubscriptionDetails($url, $query_parameters, $request_body){	
        return self::getResponse('getSubscriptionDetails' ,$url, $query_parameters, $request_body);
    }
    
    public static function getPreferences($url, $query_parameters, $request_body){	
        return self::getResponse('getPreferences' ,$url, $query_parameters, $request_body);
    }
    
    public static function getTransactionHistory($url, $query_parameters, $request_body){	
        return self::getResponse('getTransactionHistory' ,$url, $query_parameters, $request_body);
    }
    
    public static function getPaymentProfile($url, $query_parameters, $request_body){	
        return self::getResponse('getPaymentProfile' ,$url, $query_parameters, $request_body);
    }
    
    public static function getRateChart($url, $query_parameters, $request_body){	
        return self::getResponse('getRateChart' ,$url, $query_parameters, $request_body);
    }
    
    
    // Added parameter $cilUrl because some cil call have another element in their url endpoint after the function name
    public static function authenticate($payload) {
        return true;
        if(!isset($payload['csrLoginName']) && (!isset ($payload['csrEmail']) || !isset ($payload['csrPassword']))){
            return false;
        }else{
            return true;
        }
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

