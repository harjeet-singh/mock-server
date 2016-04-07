<?php
/**
 * This class is an implemenatation class for all the web services
 */
require_once('lib/RestService.php');

class CILService extends RestService{
    
    
    public function __construct($request) {
        parent::__construct($request);
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

    public static function getAllProfile($arguments, $payload){	
        return parent::getResponse('getAllProfile', $arguments, $payload);
    }
    
    public static function getInvoiceSummary($arguments, $payload){	
        return parent::getResponse('getInvoiceSummary', $arguments, $payload);
    }
} 

