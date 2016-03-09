<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once "service/nusoap/nusoap.php";
//$client = new nusoap_client("http://cil-soap.localhost");
$client = new nusoap_client("http://localhost/MockServer/src/cil-soap");

$error = $client->getError();
if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}



$request = array (
  'customerAccessKey' => array
  (
    'sourceSystemCustomerId' => '67497813',
    'sourceSystem' => 'DGT',
  ),
  'csrEmail' => 'testcsr-super-03-circ@nytimes.com',
  'csrPassword' => 'password123',
);

echo "<h2>Request</h2><pre>";
print_r($request);
echo "</pre>";

$result = $client->call("getAllProfile", array(json_encode($request)));


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
        print_r(json_decode($result,true));
        echo "</pre>";
    }
}
