<?php
/**
 * This class is an implemenatation class for all the web services
 */
require_once('../../service/core/WebServiceImpl.php');

class CILService extends WebServiceImpl{

    public static function getAllProfile($input){	
        return self::getResponse('getAllProfile', $input);
    }
    
    public static function getResponse($url, $input) {
        $url = 'cil-rest/'.$url;
        return parent::getResponse($url, $input);
    }

} 

