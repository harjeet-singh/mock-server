<?php
/**
 * This class is an implemenatation class for all the web services
 */
require_once('service/core/WebServiceImpl.php');
class CILServiceImpl extends WebServiceImpl{

	function getAllProfile($source_system, $source_system_id){	
                writelog('getAllProfile called');
		return array('he33ee' => '123');
	}

} 

