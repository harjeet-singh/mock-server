<?php

require('SoapService.php');
require('../../../nusoap/nusoap.php');

/**
 * This is an abstract class for the soap implementation for using NUSOAP. This class is responsible for making
 * all NUSOAP call by passing the client's request to NUSOAP server and seding response back to client
 * @api
 */
abstract class NusoapSoap extends SoapService{
	/**
	 * This is the constructor. It creates an instance of NUSOAP server.
	 *
	 * @param String $url - This is the soap URL
	 * @access public
	 */
	public function __construct($url){
		writeLog('Begin: NusoapSoap->__construct');
		$this->server = new soap_server();
		$this->soapURL = $url;
		$this->server->configureWSDL('soap', $this->getNameSpace(), $url);
		if(!isset($GLOBALS['HTTP_RAW_POST_DATA']))$GLOBALS['HTTP_RAW_POST_DATA'] = file_get_contents('php://input');
		parent::__construct();
		writeLog('End: NusoapSoap->__construct');
	} // ctor

	/**
	 * Fallback function to catch unexpected failure in SOAP
	 */
	public function shutdown()
	{
		if($this->in_service) {
			$out = ob_get_contents();
			ob_end_clean();
			writeLog('NusoapSoap->shutdown: service died unexpectedly');
			$this->server->fault(-1, "Unknown error in SOAP call: service died unexpectedly", '', $out);
			$this->server->send_response();
		}
	}

	/**
	 * It passes request data to NUSOAP server and sends response back to client
	 * @access public
	 */
	public function serve(){
		writeLog('Begin: NusoapSoap->serve');
		ob_clean();
		$this->in_service = true;
		register_shutdown_function(array($this, "shutdown"));
		ob_start();
		$this->server->service($GLOBALS['HTTP_RAW_POST_DATA']);
		$this->in_service = false;
		ob_end_flush();
		flush();
		writeLog('End: NusoapSoap->serve');
	} // fn

	/**
	 * This method registers all the complex type with NUSOAP server so that proper WSDL can be generated
	 *
	 * @param String $name - name of complex type
	 * @param String $typeClass - (complexType|simpleType|attribute)
	 * @param String $phpType - array or struct
	 * @param String $compositor - (all|sequence|choice)
	 * @param String $restrictionBase - SOAP-ENC:Array or empty
	 * @param Array $elements - array ( name => array(name=>'',type=>'') )
	 * @param Array $attrs - array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'xsd:string[]'))
	 * @param String $arrayType - arrayType: namespace:name (xsd:string)
	 * @access public
	 */
	public function registerType($name, $typeClass, $phpType, $compositor, $restrictionBase, $elements, $attrs=array(), $arrayType=''){
		$this->server->wsdl->addComplexType($name, $typeClass, $phpType, $compositor, $restrictionBase, $elements, $attrs, $arrayType);
  	} // fn

  	/**
  	 * This method registers all the functions you want to expose as services with NUSOAP
  	 *
  	 * @param String $function - name of the function
  	 * @param Array $input - assoc array of input values: key = param name, value = param type
  	 * @param Array $output - assoc array of output values: key = param name, value = param type
	 * @access public
  	 */
	function registerFunction($function, $input, $output){
		if(in_array($function, $this->excludeFunctions))return;
		$use = false;
		$style = false;
		if (isset($_REQUEST['use']) && ($_REQUEST['use'] == 'literal')) {
			$use = "literal";
		} // if
		if (isset($_REQUEST['style']) && ($_REQUEST['style'] == 'document')) {
			$style = "document";
		} // if
		$this->server->register($function, $input, $output, $this->getNameSpace(), '',$style, $use);
	} // fn

	/**
	 * This function registers implementation class name with NUSOAP so when NUSOAP makes a call to a funciton,
	 * it will be made on this class object
	 *
	 * @param String $implementationClass
	 * @access public
	 */
	function registerImplClass($implementationClass){
		writeLog('Begin: NusoapSoap->registerImplClass');
		if (empty($implementationClass)) {
			$implementationClass = $this->implementationClass;
		} // if
		$this->server->register_class($implementationClass);
		writeLog('End: NusoapSoap->registerImplClass');
	} // fn

	/**
	 * Sets the name of the registry class
	 *
	 * @param String $registryClass
	 * @access public
	 */
	function registerClass($registryClass){
		writeLog('Begin: NusoapSoap->registerClass');
		$this->registryClass = $registryClass;
		writeLog('End: NusoapSoap->registerClass');
	} // fn

	/**
	 * This function sets the fault object on the NUSOAP
	 *
	 * @param SoapError $errorObject - This is an object of type SoapError
	 * @access public
	 */
	public function error($errorObject){
		writeLog('Begin: NusoapSoap->error');
		$this->server->fault($errorObject->getFaultCode(), $errorObject->getName(), '', $errorObject->getDescription());
		writeLog('Begin: NusoapSoap->error');
	} // fn

} // clazz
