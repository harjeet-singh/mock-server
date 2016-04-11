<?php

/**
* The Logger class handles all the logging
**/
class Logger {
    
    /**
     * Path to the log file
     * @var string
     */
    private $logFilePath;
    
    /**
     * This holds the file handle for this instance's log file
     * @var resource
     */
    private $fileHandle;
    
    /**
    * the constructor function sets the data directory, config directory and logger object members
    * @param string $log_dir         Directory where log file should be written
    * @param string $log_file_name   Log file name
    * 
    * @throws Exception if unable to find log directory as argument then Exception code = 615
    */
    public function __construct($log_dir, $log_file_name="post_install.log") 
    {
        
        if(!isset($log_dir)){
            throw(new Exception('The log directory was not found ', 615));
        }
        
        $this->logFilePath = rtrim($log_dir,'/').'/'.$log_file_name;
        $this->createDir();
        //$this->clearLog();
        
        $this->setFileHandle('a');
        
    }

    /**
     * Class destructor
     */
    public function __destruct()
    {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
        }
    }
    
    /**
     * @param $writeMode
     *
     * @internal param resource $fileHandle
     */
    public function setFileHandle($writeMode) 
    {
        $this->fileHandle = fopen($this->logFilePath, $writeMode);
    }

    /**
    * The _write_ function writes log
    * 
    * @param string $message message to write in log file
     * 
     * @throws Exception if unable to write log file then then Exception code = 616
    */
    public function write($message) 
    {
        if(is_array($message) || is_object($message)){
            $message = print_r($message,true);
        }
        $message = date('Y/m/d H:i:s') ." ".  $message . "\n";
        
        //show in console
        //echo $message;
        
        fwrite($this->fileHandle, $message);
        
    }
    
    /**
    * The _createDir_ function creates directory for log file
    * 
    * @throws Exception if unable to create directory then Exception code = 617
    */
    private function createDir()
    {
        $pathname = dirname($this->logFilePath);
        
        try{
            if(!file_exists($pathname)){
                mkdir($pathname, 0775, true);
            }
        } catch (Exception $ex) {
            throw (new Exception($ex->getMessage(), 617));
        }
        
    }
    
    /**
    * The _clearLog_ function deletes the log file if exist
    */
    private function clearLog() 
    {
        if(file_exists($this->logFilePath)){
            unlink($this->logFilePath);
        }
        return true;
    }
}

