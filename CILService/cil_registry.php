<?php
require_once 'service/core/registry.php';
/**
 * This class is responsible for providing all the registration of all the functions and complex types
 *
 */
class cil_registry extends registry{

	protected function registerFunction() {
	
            parent::registerFunction();

            $this->serviceClass->registerFunction(
                'getAllProfile',
                array(
                    'source_system'=>'xsd:string', 
                    'source_system_id'=>'xsd:string'),
                array(
                            'return'=>'SOAP-ENC:Array'
                    )
                );

	} 
}
