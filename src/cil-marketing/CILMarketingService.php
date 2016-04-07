<?php
/**
 * This class is an implemenatation class for all the web services
 */
require_once('lib/RestService.php');

class CILMarketingService extends RestService{
    
    
    public function __construct() {
        parent::__construct();
        parent::$base = (rtrim(parent::$base, '/').'/cil-marketing/');

    }
    
    
    public function registerApiRest()
    {
        return array(
            'getDocumentation' => array(
                'reqType' => 'get',
                'path' => array('getDocumentation'),
                'pathVars' => array(''),
                'method' => 'getDocumentation',
                'shortHelp' => 'Get documentaton of the endpoints',
            ),
            'getMarketingOffers' => array(
                'reqType' => 'POST',
                'path' => array('getMarketingOffers'),
                'pathVars' => array(''),
                'method' => 'getMarketingOffers',
                'shortHelp' => 'Get Marketing Offers',
            ),
        );
    }
    
    //Endpoint Implementations
    public static function getMarketingOffers($arguments, $payload){	
        sleep(5);
        return parent::getResponse('getMarketingOffers', $arguments, $payload);
    }
} 

