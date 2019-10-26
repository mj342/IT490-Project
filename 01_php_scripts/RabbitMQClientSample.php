
<?php
			     //RabbitMQ Client File
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//Getting the username and password from the Front End Login Page
$username = $_POST["username"];
$pass = $_POST["password"];
$type = "login";

$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');

$req = array("username"=>$username, "type"=>$type,"password"=>$pass);

//Client is sending request to the server
$response = $client->send_request($req);

//reply from the mq 
if ($response == 1)
{
    echo "<b> Your Login is Successfull !!! </b>";
}
else
{
    echo "Failed...!";
}

?>
