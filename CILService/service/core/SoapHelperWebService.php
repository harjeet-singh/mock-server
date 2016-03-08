<?php

global $disable_date_format;
$disable_date_format = true;

class SoapHelperWebServices {

	function setFaultObject($errorObject) {
		if ($this->isLogLevelDebug()) {
			$GLOBALS['log']->debug('SoapHelperWebServices->setFaultObject - ' . var_export($errorObject, true));
		}
		global $service_object;
		$service_object->error($errorObject);
	} // fn

	/**
	 * Use the same logic as in SugarAuthenticate to validate the ip address
	 *
	 * @param string $session_var
	 * @return bool - true if the ip address is valid, false otherwise.
	 */
	function is_valid_ip_address($session_var){
		global $sugar_config;
		// grab client ip address
		$clientIP = query_client_ip();
		$classCheck = 0;
		// check to see if config entry is present, if not, verify client ip
		if (!isset ($sugar_config['verify_client_ip']) || $sugar_config['verify_client_ip'] == true) {
			// check to see if we've got a current ip address in $_SESSION
			// and check to see if the session has been hijacked by a foreign ip
			if (isset ($_SESSION[$session_var])) {
				$session_parts = explode(".", $_SESSION[$session_var]);
				$client_parts = explode(".", $clientIP);
	            if(count($session_parts) < 4) {
	             	$classCheck = 0;
	            }else {
	    			// match class C IP addresses
	    			for ($i = 0; $i < 3; $i ++) {
	    				if ($session_parts[$i] == $client_parts[$i]) {
	    					$classCheck = 1;
	    						continue;
	    				} else {
	    					$classCheck = 0;
	    					break;
	    					}
	    				}
	                }
					// we have a different IP address
					if ($_SESSION[$session_var] != $clientIP && empty ($classCheck)) {
						$GLOBALS['log']->fatal("IP Address mismatch: SESSION IP: {$_SESSION[$session_var]} CLIENT IP: {$clientIP}");
						return false;
					}
				} else {
					return false;
				}
		}
		return true;
	}


} // clazz

?>
