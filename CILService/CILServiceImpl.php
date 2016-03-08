<?php
/**
 * This class is an implemenatation class for all the web services
 */
require_once('service/core/WebServiceImpl.php');

class CILServiceImpl extends WebServiceImpl{

    function __construct() {
        parent::$base = './testdata/cil-rest/';
    }


    public static function getAllProfile($input){	
                
                return parent::getResponse('getAllProfile', $input);
	}

} 

