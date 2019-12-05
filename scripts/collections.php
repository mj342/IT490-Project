
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//Getting the product id
$product_ID = $_POST["product_id"];
$type = "collect";

$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');

$req = array("product_id"=>$product_ID, "type"=>$type);

//Client is sending request to the server
$response = $client->send_request($req);

echo $response;

?>

