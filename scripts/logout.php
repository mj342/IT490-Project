
<?php

session_start();

$_SESSION = array();   //MAKE $_SESSION empty so nobody can see any of my //////
//information

session_destroy();    //kills server session

$delay = 3;
$target = "../login_register_forms.html";

echo "<b>  YOUR SESSION IS TERMINATED !!! </b> <br>" ;
print "<b> Sending you to login page after $delay seconds !!! </b>";

header ( "refresh: $delay url = $target" );

?>
