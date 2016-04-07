<?php
require_once 'lib/Logger.php';

$log = new Logger("logs", "mockserver.log");
global $log;

function debug($msg)
{
    $GLOBALS['log']->write($msg);
}