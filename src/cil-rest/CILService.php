<?php
/**
 * This class is an implemenatation class for all the web services
 */
require_once('lib/RestService.php');

class CILService extends RestService{
    
    private static $data_directory = 'cil-rest';
    
    public function __construct() {
        parent::__construct();
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
            'getCustomerSubscriptions' => array(
                'reqType' => 'POST',
                'shortHelp' => 'get customer subscriptions',
            ),
        );
    }
  
    public static function getResponse($function, $url, $args, $payload) {
        
        $filePath = self::getDataPath($function, $payload);
        
        if(self::authenticate($payload)){
            return parent::getResponse($filePath, $payload);
        }
        else{
            return json_encode(array('error'=> 'Authentication failure'));
        }
    }
    
    public static function authenticate($payload) {
        return true;
        if(!isset($payload['csrLoginName']) && (!isset ($payload['csrEmail']) || !isset ($payload['csrPassword']))){
            return false;
        }else{
            return true;
        }
    }
    
    public static function getSourceSystemID($function, $payload){
        switch ($function){
            case 'getCustomerSubscriptions' :  
                $source_system_id = $payload['csrCustomerSearchCriteria']['customerAccessKey']['sourceSystemCustomerId'];
                break;
            default :
                $source_system_id = $payload['customerAccessKey']['sourceSystemCustomerId'];
        }

        return $source_system_id;
    }
    
    public static function getDataPath($function, $payload){
        
        $source_system_id = self::getSourceSystemID($function, $payload);
        
        return self::$mockedDataBasePath.self::$data_directory. '/' . $function . '/' .$source_system_id;
    }
    
} 

