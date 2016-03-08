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
