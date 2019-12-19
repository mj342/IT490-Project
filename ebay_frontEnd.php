
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

<title>Start Shopping</title>

<style>
body {font-family: Arial, Helvetica, sans-serif;}

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

.Main_Page_Button {
  background-color: #ff6d05;
}

.search {
  font-size: 15px;
  background-color:   #0d16e4  ;
}

</style>

</head>
<body background = "shoes3.jpg">

<form action = "scripts/logout.php">
  <p align="right">
  <button class="logout_Button"  style="width:auto;"> Logout
  </button>
  </p>
</form>

<form action = "ramblers_main_page.php">
 <p align="left">
  <button class="Main_Page_Button"  style="width:auto;">Go to Ramblers Main Page
  </button>
 </p>
</form>


<center>
 
<p id='page_text' > <font size="10" color=" #c2d1e6 ">
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  
 Start Shopping </font> </p> 
</center>

<center>

<form action="scripts/ebay_backEnd.php" method = "POST">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  <b>Enter Shoes Brand</b><br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  <input type="text" name="brand" >
  <br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;
  <button class="search" style="width:auto;" type="submit"> Search </button>

</form>

</center>

</body>

</html>











