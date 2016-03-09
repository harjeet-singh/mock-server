<?php


/**
 * This class is an implemenatation class for all the rest services
 */
require_once('service/core/WebServiceImpl.php');
class RestServiceImpl extends WebServiceImpl {
	
	function md5($string){
		return md5($string);
	}
}
require_once('service/core/RestUtils.php');
RestServiceImpl::$helperObject = new RestUtils();
