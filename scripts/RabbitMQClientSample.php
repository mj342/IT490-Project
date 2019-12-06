
<?php
			     //RabbitMQ Client File

session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//Getting the username and password from the Front End Login Page
$username = $_POST["username"];
$pass = $_POST["password"];
$type = "login";
$delay = 5;

$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');

$req = array("username"=>$username, "type"=>$type,"pass"=>$pass);

//Client is sending request to the server
$response = $client->send_request($req);

//reply from the mq 
if ($response == 1)
{
    $_SESSION["username"] = $username;
    $target = "../ramblers_main_page.html";
    echo " <b> Valid Credentials !!! </b> <br>";
    print "<b> Sending you to our Main Page to start shopping after $delay   
           seconds!!! </b>";
    header("refresh: $delay url = $target");
}
else
{
    $target = "../login_register_forms.html";
    echo " <b> Wrong User or Password !!! Try Again </b> ";
    print "<b> Sending you back to login page after $delay seconds !!! </b>";
    header("refresh: $delay url = $target");
}

?>


