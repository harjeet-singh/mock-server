<?php


require_once('service/core/REST/SugarRest.php');

/**
 * This class is a serialize implementation of REST protocol
 * @api
 */
class SugarRestSerialize extends SugarRest{

	/**
	 * It will serialize the input object and echo's it
	 *
	 * @param array $input - assoc array of input values: key = param name, value = param type
	 * @return String - echos serialize string of $input
	 */
	function generateResponse($input){
		ob_clean();
		if (isset($this->faultObject)) {
			$this->generateFaultResponse($this->faultObject);
		} else {
			echo serialize($input);
		}
	} // fn

	/**
	 * This method calls functions on the implementation class and returns the output or Fault object in case of error to client
	 *
	 * @return unknown
	 */
	function serve(){
		writeLog('Begin: SugarRestSerialize->serve');
		$data = !empty($_REQUEST['rest_data'])? $_REQUEST['rest_data']: '';
		if(empty($_REQUEST['method']) || !method_exists($this->implementation, $_REQUEST['method'])){
			$er = new SoapError();
			$er->set_error('invalid_call');
			$this->fault($er);
		}else{
			$method = $_REQUEST['method'];
			$data = unserialize(from_html($data));
			if(!is_array($data))$data = array($data);
			writeLog('End: SugarRestSerialize->serve');
			return call_user_func_array(array( $this->implementation, $method),$data);
		} // else
	} // fn

	/**
	 * This function sends response to client containing error object
	 *
	 * @param SoapError $errorObject - This is an object of type SoapError
	 * @access public
	 */
	function fault($errorObject){
		$this->faultServer->faultObject = $errorObject;
	} // fn

	function generateFaultResponse($errorObject){
		$error = $errorObject->number . ': ' . $errorObject->name . '<br>' . $errorObject->description;
		$GLOBALS['log']->error($error);
		ob_clean();
		echo serialize($errorObject);
	} // fn

} // clazz
