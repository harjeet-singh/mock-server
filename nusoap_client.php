<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once "CILService/service/nusoap/nusoap.php";
$client = new nusoap_client("http://localhost/MockServer/CILService/soap.php");

$error = $client->getError();
if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}

echo '<pre>';


$result = $client->call("getAllProfile", array("source_system" => "CIS", "source_system_id" => "123456"));


if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Result</h2><pre>";
        print_r($result);
        echo "</pre>";
    }
}
