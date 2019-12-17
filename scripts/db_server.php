
<?php
   			 // Database Server File
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

// Login Function
function doLogin($username, $password)
{
  //Database connection - database server ip, user, pass, database
  $database_connection = new mysqli("localhost", "user", "pass",    
                                    "ramblers") ;

  $password = sha1 ($password); //hashing the password

  //SQL Query running on the Registration Table
  $login_query = "select * from registration where username = '$username' and
                  pass = '$password' " ;

  //Executing SQL Query
  $query_result = mysqli_query($database_connection, $login_query) or      
                  die(mysqli_error($database_connection)) ;

  //Counting Rows in our Registration Table
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
	 
  //SQL Query running on the Registration Table
  $check_user_query = " select * from registration where
                        username = '$username' " ;
                                         
  //Executing SQL Query
  $query_result = mysqli_query($database_connection, $check_user_query) or      
                  die(mysqli_error($database_connection)) ;

  //Counting Rows in our Registration Table
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

       //SQL Query running on the Registration Table
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

function add_to_collection($product_id, $username)
{       
	//Database connection - database server ip, user, pass, database  
        $database_connection = new mysqli("localhost", "user", "pass",  
                                     "ramblers") ;

	//SQL Query running on the Collections Table
        $check_user_query = " select * from collections where
                        username = '$username' and
                        productID = '$product_id' " ;
                                         
        //Executing SQL Query
        $query_result = mysqli_query($database_connection, $check_user_query)   
                        or   die(mysqli_error($database_connection)) ;

        //Counting Rows in our Collections Table
        $count_rows = mysqli_num_rows($query_result) ;

        //Checking if product already added for specific user to my collection
        if ( $count_rows > 0 ) 
        {            
       	      return "This<b> $product_id </b>is already added to my collection feature for username:<b> $username </b> <br>Pick a different Product !!!";
        }
        //if this product is not already added to my collection
        // Adding product for specific user to my collection 
	$query = "INSERT INTO collections (username, productID ) VALUES 		('$username', '$product_id') " ;

    	//Executing SQL Query
    	$query_result = mysqli_query($database_connection, $query)
                     or die(mysqli_error($database_connection)) ;

	return "Successfully added product:<b> $product_id </b>to my collection feature for username:<b> $username </b>";
}

function view_collection($username)
{	
  	//Database connection - database server ip, user, pass, database
  	$database_connection = new mysqli("localhost", "user", "pass",
                                  "ramblers") ;

 	 //SQL Query running on the shoes and collections Tables
   	$query = "select * from shoes, collections where
            collections.productID = shoes.productID and
            collections.username = '$username'" ;

  	//Executing SQL Query
   	$query_result = mysqli_query($database_connection, $query)
                    or die(mysqli_error($database_connection)) ;

   	 $data = mysqli_fetch_all($query_result , MYSQLI_ASSOC);
	
   	 return json_encode($data);
}

function remove_from_collection($product_id, $username)
{ 	
  	//Database connection - database server ip, user, pass, database
  	$database_connection = new mysqli("localhost", "user", "pass",
                                  "ramblers") ;

  	//SQL Query running on the Collections Table
   	$query = "delete from collections where
                 username = '$username' and
                 productID = '$product_id'";

  	//Executing SQL Query
   	$query_result = mysqli_query($database_connection, $query)
                    or die(mysqli_error($database_connection)) ;

    	return "Successfully removed<b> $product_id </b>from my collection feature for username:<b> $username </b>";
}

function api_data($input) #input is shoes brand such as "nike"
{    
     //Database connection - database server ip, user, pass, database  
     $database_connection = new mysqli("localhost", "user", "pass",  
                                     "ramblers") ;

     //SQL Query running on the shoes Table
      $api_get_query = "select * from shoes where brand 
                         = '$input'" ;

     //Executing SQL Query
      $query_result = mysqli_query($database_connection, $api_get_query)    
                       or die(mysqli_error($database_connection)) ;

     //Counting Rows in our Shoes Table
     $count_rows = mysqli_num_rows($query_result) ;

     //Checking if the Brand is in our Database
     if ( $count_rows > 0 ) 
     {
        #storing all records from shoes table in local variable called data
	$data = mysqli_fetch_all($query_result , MYSQLI_ASSOC);
	
	return json_encode($data);     
     }
 
     else
     {
	   //type and $input is what user inputs on the front end
	   $type = "Api_search";

	   $client = new RabbitMQClient('testRabbitMQAPI.ini', 'testServer');

	   //Putting brand input from front end on the array
	   $req = array("brand"=>$input, "type"=>$type);

	   //Database Server is sending request
	   //to the MQ for API to respond back to DB Server
	    $response = $client->send_request($req);
	   
	   echo  var_export($response, true);
	   $apiData = $response; //storing api data

           // Parsing through the api data to extract specific data
	   $devices = array();

	   $apiXML = simplexml_load_string($apiData);
	   foreach ($apiXML -> Product as $item)
	   {
	        $device = array();
       
		foreach ($item as $key => $value)
		{
	            $device[(string) $key] = (string) $value;
                }
                $devices[] = $device;
           }
           print_r($devices);

	   foreach ($devices as $item)
	   {
		$price = rand(40,120);

		if ($item['DisplayStockPhotos'] == "true" &&    
                   (strpos($item['Title'], 'Shoes') == true or        
                    strpos($item['Title'], 'Sneakers') == true))
		{
			$product_id = $item ['ProductID'] ;
			$title = $item ['Title'];
			$title = str_replace ("'", "", $title);
			$image = $item ['StockPhotoURL'];
		       
			//SQL Query running on the shoes Table
	    		$api_query = "INSERT INTO shoes (productID, 
		                      brand, title, price, image ) VALUES
		                      ('$product_id','$input',
		                       '$title', '$price','$image' ) " ;
		         
	    		//Executing SQL Query
	    		$query_result = mysqli_query($database_connection, 
                                      $api_query) or  
                                      die(mysqli_error($database_connection)) ;

		}
	    }
  
	    //SQL Query running on the shoes Table
	    $api_get_query = "select * from shoes where brand 
		                 = '$input'" ;

	    //Executing SQL Query
	    $query_result = mysqli_query($database_connection, $api_get_query)  
                            or die(mysqli_error($database_connection)) ;
	    
	    #storing all records in local variable called data
	    $data = mysqli_fetch_all($query_result , MYSQLI_ASSOC);
		
	    return json_encode($data);
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
echo "Processing: " . var_export($request, true);
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['pass']);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "register":
      return doRegister($request['username'],$request['pass'],
                        $request['email']);
    case "collect";
      return add_to_collection($request["product_id"],$request['username']);
    case "view";
      return view_collection($request["username"]);
    case "remove";
      return remove_from_collection($request["product_id"],  
                                    $request['username']);
    case "search";
      return api_data($request["brand"]);

  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>
