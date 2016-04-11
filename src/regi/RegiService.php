<?php
/**
 * This class is an implemenatation class for all the web services
 */
require_once('lib/RestService.php');

class RegiService extends RestService{
    
    private $data_directory = 'cil-rest';
    
    public function __construct() {
        
        
        parent::$base_path = 'svc/profile/v2';
        
        parent::$base = (rtrim(parent::$base, '/').'/'.$this->data_directory.'/');
        
        parent::__construct();
    }
    
    public function registerApiRest()
    {
        return array(
            'email' => array(
                'reqType' => 'GET',
                'shortHelp' => 'get all profiles',
                'path' => array('prefs', 'regi_id'),
                'path_var' => array('', '?'),
            ),
        );
    }

    public static function email($url, $query_parameters, $payload){	
        return self::getResponse('email', $url, $query_parameters, $payload);
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

