<?php

require_once('service/core/WebService.php');
require_once('service/core/RestServiceImpl.php');

/**
 * Base class for rest services
 *
 */
class RestService extends WebService{
	protected $implementationClass = 'RestServiceImpl';
	protected $restURL = "";
	protected $registeredFunc = array();

	/**
	 * Get Sugar REST class name for input/return type
	 *
	 * @param string $name
	 * @return string
	 */
	protected function _getTypeName($name)
	{
		if(empty($name)) return 'SugarRest';

		$name = clean_string($name, 'ALPHANUM');
		$type = '';
		switch(strtolower($name)) {
			case 'json':
				$type = 'JSON';
				break;
			case 'rss':
				$type = 'RSS';
				break;
			case 'serialize':
				$type = 'Serialize';
				break;
		}
		$classname = "SugarRest$type";
		if(!file_exists('service/core/REST/' . $classname . '.php')) {
			return 'SugarRest';
		}
		return $classname;
	}

	/**
	 * Constructor.
	 *
	 * @param String $url - REST url
	 */
	function __construct($url){
		writeLog('Begin: SugarRestService->__construct');
		$this->restURL = $url;

		$this->responseClass = $this->_getTypeName(@$_REQUEST['response_type']);
		$this->serverClass = $this->_getTypeName(@$_REQUEST['input_type']);
		writeLog('SugarRestService->__construct serverclass = ' . $this->serverClass);
		require_once('service/core/REST/'. $this->serverClass . '.php');
		writeLog('End: SugarRestService->__construct');
	} // ctor

	/**
	 * Its a no op method
	 *
	 * @access public
	 */
	public function registerType($name, $typeClass, $phpType, $compositor, $restrictionBase, $elements, $attrs, $arrayType){
  	} // fn

  	/**
  	 * This method registers all the functions you want to expose as services with REST
  	 *
  	 * @param String $function - name of the function
  	 * @param Array $input - assoc array of input values: key = param name, value = param type
  	 * @param Array $output - assoc array of output values: key = param name, value = param type
	 * @access public
  	 */
	function registerFunction($function, $input, $output){
		if(in_array($function, $this->excludeFunctions))return;
		$this->registeredFunc[$function] = array('input'=> $input, 'output'=>$output);
	} // fn

	/**
	 * It passes request data to REST server and sends response back to client
	 * @access public
	 */
	function serve(){
		writeLog('Begin: SugarRestService->serve');
		require_once('service/core/REST/'. $this->responseClass . '.php');
		$response  = $this->responseClass;

		$responseServer = new $response($this->implementation);
		$this->server->faultServer = $responseServer;
		$responseServer->faultServer = $responseServer;
		$responseServer->generateResponse($this->server->serve());
		writeLog('End: SugarRestService->serve');
	} // fn

	/**
	 * Enter description here...
	 *
	 * @param Array $excludeFunctions - All the functions you don't want to register
	 */
	function register($excludeFunctions = array()){

	} // fn

	/**
	 * This mehtod returns registered implementation class
	 *
	 * @return String - implementationClass
	 * @access public
	 */
	public function getRegisteredImplClass() {
		return $this->implementationClass;
	} // fn

	/**
	 * This mehtod returns registry class
	 *
	 * @return String - registryClass
	 * @access public
	 */
	public function getRegisteredClass() {
		return $this->registryClass;
	} // fn

	/**
	 * Sets the name of the registry class
	 *
	 * @param String $registryClass
	 * @access public
	 */
	function registerClass($registryClass){
		$this->registryClass = $registryClass;
	}

	/**
	 * This function registers implementation class name and creates an instance of rest implementation class
	 * it will be made on this class object
	 *
	 * @param String $implementationClass
	 * @access public
	 */
	function registerImplClass($className){
		writeLog('Begin: SugarRestService->registerImplClass');
		$this->implementationClass = $className;
		$this->implementation = new $this->implementationClass();
		$this->server = new $this->serverClass($this->implementation);
		$this->server->registerd = $this->registeredFunc;
		writeLog('End: SugarRestService->registerImplClass');
	} // fn

	/**
	 * This function sets the fault object on the REST
	 *
	 * @param SoapError $errorObject - This is an object of type SoapError
	 * @access public
	 */
	function error($errorObject){
		writeLog('Begin: SugarRestService->error');
		$this->server->fault($errorObject);
		writeLog('End: SugarRestService->error');
	} // fn

	/**
	 * This mehtod returns server
	 *
	 * @return String - server
	 * @access public
	 */
	function getServer(){
		return $this->server;
	} // fn


}
