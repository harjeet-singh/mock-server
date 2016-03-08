<?php

require_once('service/core/SoapHelperWebService.php');
WebServiceImpl::$helperObject = new SoapHelperWebServices();

/**
 * This class is an implemenatation class for all the web services
 */

class WebServiceImpl{

	public static $helperObject = null;


} // clazz

