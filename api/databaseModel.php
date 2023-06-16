<?php error_reporting(0);
/************************* Configuring db Starts*************************************/
date_default_timezone_set('Asia/Kolkata');

 $conn = mysqli_connect("localhost", "root", "12345", "Website");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}else{
   
}

/************************* Configuring db Ends*************************************/

?>
