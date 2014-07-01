<?php
$con=mysqli_connect("localhost","sonovate_user","OzzyElmo$1","baselist");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>