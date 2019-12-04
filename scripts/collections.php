<?php
function get_items()
{
    $user = "as2867";
    $input = "Nike";
    $database_connection = new mysqli("localhost", "user", "pass", "ramblers") ;
    $api_get_query = "select * from shoes where username = '$user' and brand = '$input'" ;
    //Executing SQL Query
    $query_result = mysqli_query($database_connection, $api_get_query)
                     or die(mysqli_error($database_connection)) ;
    //Counting Rows in our User Table
    $data = mysqli_fetch_array($query_result , MYSQLI_ASSOC) ;
    return $data;

}
?>

<?php //fetch 'em
$rows = get_items();
  //check to add to cart
handle_add_to_cart();
?>
    //check to add to cart
    <?php foreach($rows as $index => $row):?>
         <div><?php echo $row["title"]; ?> - <?php echo $row['price'];?></div>
         <form id="form_<?php echo $row['productID'];?>" method="POST">
               <input type="hidden" name="user" value="<?php echo $row['username'];?>"/>
               <input type="hidden" name="product_id" value="<?php echo $row['productID'];?>"/>
               <input type="hidden" name="brand" value="<?php echo $row['brand'];?>"/>
               <input type="hidden" name="title" value="<?php echo $row['title'];?>"/>
               <input type="hidden" name="price" value="<?php echo $row['price'];?>"/>
               <input type="hidden" name="image" value="<?php echo $row['image'];?>"/>



               <input type="submit" value="Add Item to Cart?"/>
         </form>
    <?php endforeach; ?>


<?php
function handle_add_to_cart()
{
$username = $_POST['user'];
    $product_id = $_POST['product_id'];
    $brand = $_POST['brand'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $image = $_POST['image'];

$database_connection = new mysqli("localhost", "user", "pass", "ramblers") ;

$query = "INSERT INTO collections (username, productID, brand,
             title, price, image ) VALUES ('$username','$product_id','$brand', '$title', '$price','$image') " ;

    //Executing SQL Query
    $query_result = mysqli_query($database_connection, $query)
                     or die(mysqli_error($database_connection)) ;

echo "Successfully added $id to my collection feature";

}
?>
