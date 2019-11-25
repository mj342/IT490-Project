
<?php
			     // RabbitMQ Server File 
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('APItest.php');

function api_data_server($input)
{
     // Calling the function from APItest.php 
     // file to get the data from api & 
     // storing it in a local variable
     $apiData = search($input);
      
     return $apiData;//returning this data to database server in server file 	   
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
	echo "Processing: " . var_export($request, true);
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['pass']);
    case "validate_session":
      return doValidate($request['sessionId']);
 
    case "Api_search";
      return api_data_server($request["brand"]);

  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

