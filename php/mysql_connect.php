<?php
$dbc=mysqli_connect("localhost:3306","root","","cms");
// Check connection
if (!$dbc)
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

// Change character set to utf8
// mysqli_set_charset($con,"utf8");
?>
