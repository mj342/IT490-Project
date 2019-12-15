

<?php

session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//Getting the brand name
$username = $_SESSION["username"];
$type = "view";

$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');

$req = array("username"=>$username, "type"=>$type);

//Client is sending request to the server
$response = $client->send_request($req);

$obj = json_decode($response, true);

//echo var_export($obj,true); 

?>

 	<form action = "../ramblers_main_page.html" >
               <input type="submit" value="Go to Ramblers Main Page"/> <br>
         </form>

<div>		
    <?php foreach($obj as $row):?>
       <div>	
         <div>
              <img src= <?php echo $row['image']; ?>  
                        height= "400" width = "400" > <br>
              <?php echo "<b>Shoes Name:</b> " . $row["title"]; ?> <br> 
              <?php echo "<b>Price:</b> $"     . $row['price'];?> <br>   
              <?php echo "<b>Product ID:</b> " . $row['productID'];?> <br>   
         </div>
         
         <form id="form_<?php echo $row['productID'];?>" 
               onsubmit = "add_to_cart(this); return false;"  method="POST">

               <input type="hidden" name="product_id" value="<?php echo 
			$row['productID'];?>"/>

               <input type="submit" value="Remove Item from Cart?"/> <br>
         </form>
       </div>
     

    <?php endforeach; ?>
</div>


<script>

// Working with Ajax 

function add_to_cart(form)
 {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function()
    {
	    if (this.readyState == 4 && this.status == 200) {
	     alert(this.responseText);
	     //var f = document.getElementById(form.id).parentNode;	     
	     form.parentNode.parentNode.removeChild(form.parentNode);
    }
  };
  
  xhttp.open("POST", "remove_from_collection.php", true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  var data = "product_id=" + form.product_id.value ;
  xhttp.send(data);
}

</script>








