
<?php
			     // RabbitMQ Server File 
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('APItest.php');

// Login Function 
function doLogin($username, $password)
{
  //Database connection - database server ip, user, pass, database 
  $database_connection = new mysqli("localhost", "user", "pass",     
                                    "ramblers") ;

  //SQL Query running on the User Table
  $login_query = "select * from login where username = '$username' and 
                  password = '$password' " ;

  //Executing SQL Query
  $query_result = mysqli_query($database_connection, $login_query) or      
                  die(mysqli_error($database_connection)) ; 

  //Counting Rows in our User Table 
  $count_rows = mysqli_num_rows($query_result) ; 

  //Checking if User is in our Database 
  if ($count_rows > 0) // if user is in our database return 1
  {
      return 1 ;
  }
  else                // else user is not in our database return 0
  {
      return 0 ;
  }
}

// Registration Function 
function doRegister($username, $password, $email)
{
  //Database connection - database server ip, user, pass, database 
  $database_connection = new mysqli("localhost", "user", "pass",     
                                    "ramblers") ;

  //SQL Query running on the User Table
  $check_user_query = " select * from registration where 
                        username = '$username' " ; 
                                         
  //Executing SQL Query
  $query_result = mysqli_query($database_connection, $check_user_query) or      
                  die(mysqli_error($database_connection)) ; 

  //Counting Rows in our User Table 
  $count_rows = mysqli_num_rows($query_result) ; 

  //Checking if the User is in our Database 
  if ( $count_rows > 0 ) //if user exists in our database 
  {
       //echo  " User already exists in our Database !!! " ;
       return 1 ;
  }
  else
  {
       //If the user is not registered - Getting the user Registered !!!

       $password = sha1 ($password); //hashing the password

       //SQL Query running on the User Table
       $register_query = " INSERT INTO registration (username, pass,         
                           email) VALUES ('$username','$password', 
                           '$email') " ;

       //Executing SQL Query
       $query_result = mysqli_query($database_connection, $register_query)     
                       or die(mysqli_error($database_connection)) ; 

       //echo " You are Successfully Registered !!! " ;
       return 0 ;
  }	

}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "register":
      return doRegister($request['username'],$request['pass'], 
                        $request['email']);
    case "search";
      return search($request["search"]);

  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

