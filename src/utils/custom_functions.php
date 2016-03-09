<?php


function writeLog($message){
        $file = fopen("../../mockserver.log","a");
        $date = new DateTime('NOW');
        $date = $date->format("Y M d D h:g:i a");

        if(is_array($message) || is_object($message)){
            fwrite($file, '['.$date.'] '.print_r($message,true));
        }
        else{
            fwrite($file, '['.$date.'] '.$message);
        }
        fwrite($file, PHP_EOL);
        fclose($file);
    }

