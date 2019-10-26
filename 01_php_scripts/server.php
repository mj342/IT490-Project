
<?php
			     // RabbitMQ Server File 
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

// Login Function 
function doLogin($username, $password)
{
  //Database connection - database server ip, user, pass, database 
  $database_connection = new mysqli("192.168.86.126", "myuser", "mypass",     
                                    "smart") ;

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
  $database_connection = new mysqli("192.168.86.126", "myuser", "mypass",     
                                    "smart") ;

  //SQL Query running on the User Table
  $check_user_query = " select * from user where username = '$username' " ; 
                                         
  //Executing SQL Query
  $query_result = mysqli_query($database_connection, $check_user_query) or      
                  die(mysqli_error($database_connection)) ; 

  //Counting Rows in our User Table 
  $count_rows = mysqli_num_rows($query_result) ; 

  //Checking if the User is in our Database 
  if ( $count_rows > 0 ) //if user exists in our database 
  {
       echo  " User already exists in our Database !!! " ;
       echo  " Please pick a different username " ;	
       return 0 ;
  }
  else
  {
       //If the user is not registered - Getting the user Registered !!!

       //SQL Query running on the User Table
       $register_query = " INSERT INTO user (username, email, password)  
                          VALUES ('$username', '$email', '$password') " ;

       //Executing SQL Query
       $query_result = mysqli_query($database_connection, $register_query)     
                       or die(mysqli_error($database_connection)) ; 

       echo " You are Successfully Registered !!! " ;
       return 1 ;
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
      return doRegister($request['username'],$request['password'], 
                        $request['email']);

  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>
