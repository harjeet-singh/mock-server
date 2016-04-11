<?php
/**
 * This class is an implemenatation class for all the web services
 */
require_once('lib/RestService.php');

class CILService extends RestService{
    
    private $data_directory = 'cil-rest';
    
    public function __construct() {
        
        debug('CILService');
        parent::$base_path = 'cil-rest/';
        
        parent::$mockedDataBasePath = (rtrim(parent::$mockedDataBasePath, '/').'/'.$this->data_directory.'/');
        
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
        );
    }
    
    public static function getResponse($function, $url, $arguments = null, $payload = null) {
        
        unset($payload['callingSystem']);
        unset($payload['csrEmail']);
        unset($payload['csrPassword']);
        unset($payload['csrEmail']);
        debug($payload);
        
        if(self::authenticate($payload)){
            return parent::getResponse($function, $url, $arguments, $payload);
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

    
} 

