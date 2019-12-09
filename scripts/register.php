
<?php
			     //RabbitMQ Client Register File
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//Getting the username and password from the Front End Login Page
$username = $_POST["username"];
$pass = $_POST["password"];
$email = $_POST["email"];
$type = "register";

$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');

$req = array("username"=>$username, "type"=>$type,"pass"=>$pass,      
             "email"=>$email);

//Client is sending request to the server
$response = $client->send_request($req);

//reply from the mq 
if ($response == 1)
{
    $target = "../login_register_forms.html";
    $delay = 5;
    echo "<b> User already exists in our Database !!! </b>";
    echo  " <br> <b> Please pick a different username !! </b> " ;
    print "<br> <b> Sending you back to Registration page after $delay seconds !!! </b>";
    header("refresh: $delay url = $target");	
}
else
{
    $target = "../login_register_forms.html";
    $delay = 4;
    echo "<b> You are Successfully Registered $username !!! </b> <br> ";
    echo "<b> Please Login !!! </b> <br> ";
    print "<b> Sending you back to Login page after $delay seconds !!! </b>";
    header("refresh: $delay url = $target");
}

?>





