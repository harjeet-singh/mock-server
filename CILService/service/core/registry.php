<?php
/**
 * This class is responsible for providing all the registration of all the functions and complex types
 *
 */
class registry {
	
	protected $serviceClass = null;
	
	/**
	 * Constructor.
	 *
	 * @param Class - $serviceClass
	 */
	public function __construct($serviceClass) {
		$this->serviceClass = $serviceClass;
	} // fn
			
	/**
	 * It registers all the functions and types by doign a call back method on service object
	 *
	 */
	public function register() {
		$this->registerFunction();
	}
        
        protected function registerTypes()
	{
           $this->serviceClass->registerType(
		    'paramter_list',
			'complexType',
		   	 'struct',
		   	 '',
		  	  'SOAP-ENC:Array',
			array(),
		    array(
		        array('ref'=>'SOAP-ENC:arrayType', 'wsdl:arrayType'=>'xsd:string[]')
		    ),
			'xsd:string'
		);
           
           $this->serviceClass->registerType(
		   	 'cil_request_parameters',
		   	 'complexType',
		   	 'struct',
		   	 'all',
		  	  '',
			array(
				"customerAccessKey" => array('name'=>"customerAccessKey", 'type' => 'tns:paramter_list'),
				'csrEmail' => array('name' => 'csrEmail', 'type'=>'xsd:string'),
                                'csrPassword' => array('name' => 'csrPassword', 'type'=>'xsd:string'),
                            )

			);
		
        }
	
	/**
	 * This mehtod registers all the functions on the service class
	 *
	 */
	protected function registerFunction() {
	// START OF REGISTER FUNCTIONS

	$GLOBALS['log']->info('Begin: registry->registerFunction');

		
	$GLOBALS['log']->info('END: registry->registerFunction');
	        
		// END OF REGISTER FUNCTIONS
	} // fn	

	
} // clazz
