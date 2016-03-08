<?php

//require_once('service/core/SoapHelperWebService.php');
//WebServiceImpl::$helperObject = new SoapHelperWebServices();

/**
 * This class is an implemenatation class for all the web services
 */

class WebServiceImpl{

	public static $helperObject = null;
        public static $base = './testdata/cil-rest/';

        public static function getResponse($url, $input=null)
        {
            // validate input and log the user in
            //do find response:
            if (!isset($url) ) {
                    throw new Exception(404, "Wrong Request: no url or data on POST");
            }

            $filePath=$url;

            //build MD5
            $tomd5 = (!empty($input) ? json_encode($input) : '');

            $md5=(!empty($tomd5) ? md5($tomd5) :'');

            $all = self::$base.(!empty($md5) ? (rtrim($filePath, '/').'/').$md5 :(rtrim($filePath, '/').'/get'));

            writeLog('RUNNING LOOKING FOR path=='.$all,0);

            if(file_exists($all))
            {
                    writeLog('RUNNING REQUEST FOUND!!! =='.$all,0);
                            return 	file_get_contents($all);
            }
            else{
                    writeLog('RUNNING REQUEST FOUND =='.$all,0);
                            throw new Exception(404, "No File Found: ".$all);
            }
        }


} 

