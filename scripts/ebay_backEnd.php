
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//Getting the brand name
$brand = $_POST["brand"];
$type = "search";

$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');

$req = array("brand"=>$brand, "type"=>$type);

//Client is sending request to the server
$response = $client->send_request($req);

//$obj = json_decode($response, true);

//$resp = var_export($obj);

//echo $resp;

echo var_export($response,true); 

?>

