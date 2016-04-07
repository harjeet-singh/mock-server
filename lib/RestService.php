<?php
/**
 * This class is an implemenatation class for all the web services
 */

abstract class RestService {
    
    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';
    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';
    /**
     * Property: verb
     * An optional additional descriptor about the endpoint, used for things that can
     * not be handled by the basic methods. eg: /files/process
     */
    protected $verb = '';
    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    protected $args = Array();
    /**
     * Property: file
     * Stores the input of the PUT request
     */
     protected $file = Null;
     
     protected $headers = null;
     
     protected $payload = null;


    protected static $base = 'testdata/';
    
    protected $map = array();
    
    protected $url;


    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     */
    public function __construct() {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        parse_str($_SERVER['QUERY_STRING'], $this->args);
        $this->verb = explode('/', rtrim($_REQUEST['request'], '/'));
        $this->endpoint = array_shift($this->args);
        $this->method = $_SERVER['REQUEST_METHOD'];
        
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }
        
        $this->headers = getallheaders();
        
        switch($this->method) {
        case 'DELETE':
        case 'POST':
            $this->request = $this->_cleanInputs($_REQUEST);
            $this->payload = json_decode(file_get_contents('php://input'), true);
            break;
        case 'GET':
            $this->request = $this->_cleanInputs($_GET);
            break;
        case 'PUT':
            $this->request = $this->_cleanInputs($_GET);
            $this->payload = json_decode(file_get_contents('php://input'), true);
            break;
        default:
            $this->_response('Invalid Method', 405);
            break;
        }
        
        //endpoints added in extended classes
        $this->map = $this->registerApiRest();
        $this->url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    }
    
    public function serve() {

        if (
                $this->endpoint == 'getDocumentation' || (
                method_exists($this, $this->endpoint) && 
                array_key_exists($this->endpoint, $this->map) &&
                strcasecmp($this->map[$this->endpoint]['reqType'], $this->method) == 0)
            ) {
            return $this->_response($this->{$this->endpoint}($this->url, $this->args, $this->payload));
        }
        
        $error_response = array('error' => "No Endpoint : $this->endpoint");
        return $this->_response(json_encode($error_response), 404);
    }

    private function _response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return $data;
    }

    private function _cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    private function _requestStatus($code) {
        $status = array(  
            200 => 'OK',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ); 
        return ($status[$code])?$status[$code]:$status[500]; 
    }

    protected static function getResponse($function, $url, $arguments=null, $payload=null)
    {
        // validate input and log the user in
        //do find response:
        if (!isset($url) ) {
                throw new Exception("404, Wrong Request: no url or data on POST");
        }

        $filePath=$function;
        
        $input = array_merge($arguments, $payload);
        
        //build MD5
        $tomd5 = (!empty($input) ? json_encode($input) : '');

        $md5=(!empty($tomd5) ? md5($tomd5) :'');

        $all = self::$base.(!empty($md5) ? (rtrim($filePath, '/').'/').$md5 :(rtrim($filePath, '/')));

        debug('Requset URL : '. $url);
        debug('Requset Body : '.  json_encode($payload));
        $fullPath = $_SERVER['DOCUMENT_ROOT'].'/'.$all;
        
        if(file_exists($fullPath))
        {
            return file_get_contents($fullPath);
        }
        else{
            throw new Exception("No data found on server for [".$url."]". " [".$md5."]");
        }
    }
    
    protected function getDocumentation($arguments, $payload){
        
        $response = "[". get_class($this)."]";
        $response .= "\n\n";
        
        $response .= "---------Documentation----------\n\n";
        
        foreach ($this->map as $endpoint => $data){
            $response .= "[".$endpoint."] \n method: ".$data['reqType'] . "\n description: ". $data['shortHelp']."\n\n" ;
        }
        
        return $response;
    }
    
    protected function registerApiRest(){
        return array();
    }
} 

