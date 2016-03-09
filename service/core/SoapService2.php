<?php

/**
 * This is a service class for version 2
 */
require_once('NusoapSoap.php');
class SoapService2 extends NusoapSoap{
		
	/**
	 * This method registers all the functions which you want to be available for SOAP.
	 *
	 * @param array $excludeFunctions - All the functions you don't want to register
	 */
	public function register($excludeFunctions = array()){
		writeLog('Begin: SugarSoapService2->register');
		$this->excludeFunctions = $excludeFunctions;
		$registryObject = new $this->registryClass($this);
		$registryObject->register();
		$this->excludeFunctions = array();
		writeLog('End: SugarSoapService2->register');
	} // fn
			
} // clazz
?>
