
<?php

session_start();

//put this below in code ramblers main page and ebay front end
$badmessage = "<b>  LOGIN FIRST !!!
               <br> You are not authorized to access this page directly !!!
               <br> Sending you back to login page after 4 seconds !!!
               </b>";
$delay = 4;
$badtarget = "login_register_forms.html";
if ( ! isset ( $_SESSION["logged"] ) )
{
      echo "$badmessage";
      header ( "refresh: $delay url = $badtarget" );
      exit();
}

?>

<!DOCTYPE html>

<html>

<head>

<title>Ramblers Main Page</title>

<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for buttons */
button {
  color: white;
  padding: 17px 18px;
  font-size: 15px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}
button:hover {
  opacity: 0.6;
}

/* Positioning the login button on the page  */
.logout_Button {
  background-color: #fa0000;
}

.Shopping_Button {
  font-size: 15px;
  background-color:   #a30bec  ;
}

.my_collection {
  font-size: 15px;
  background-color: #25d600;
}

</style>

</head>

<body background= "shoes2.png" >

<form action = "scripts/logout.php">
<p align="right">
<button class="logout_Button"  style="width:auto;"> Logout
</button>
</p>
</form>

<form action = "scripts/view_collections.php">
<button class="my_collection"  style="width:auto;"> My Collection
</button>
</form>

<br><br><br>


<form action = "ebay_frontEnd.php">

<p id='page_text' > <font size="6" color=" #FFC300 ">  Check out 
our Exciting New Products </font> </p> 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button class="Shopping_Button" style="width:auto;"> Start Shopping
</button>

</form>

</body>

</html>









