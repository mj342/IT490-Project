
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

session_start();

//Getting the brand name
$brand = $_POST["brand"];
$type = "search";

$client = new RabbitMQClient('testRabbitMQ.ini', 'testServer');

$req = array("brand"=>$brand, "type"=>$type);

//Client is sending request to the server
$response = $client->send_request($req);

$obj = json_decode($response, true);

//echo var_export($obj,true); 

?>
   	 <form action = "../ramblers_main_page.html" >
               <input type="submit" value="Go to Ramblers Main Page"/> <br>
         </form>
	
    <?php foreach($obj as $row):?>
		
         <div>
              <img src= <?php echo $row['image']; ?> 
                   height= "400" width = "400" > <br>
              <?php echo "Shoes Name: " . $row["title"]; ?> <br> 
              <?php echo "Price: $"     . $row['price'];?> <br>      
         </div>
         
         <form id="form_<?php echo $row['productID'];?>" 
               onsubmit = "add_to_cart(this); return false;"  method="POST">

               <input type="hidden" name="product_id" value="<?php echo 
			$row['productID'];?>"/>

               <input type="submit" value="Add Item to my Collection?"/> <br>
         </form>

    <?php endforeach; ?>


<script>

// Working with Ajax 

function add_to_cart(form) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     alert(this.responseText);
    }
  };
  
  xhttp.open("POST", "add_to_collections.php", true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  var data = "product_id=" + form.product_id.value ;
  xhttp.send(data);
}

</script>












