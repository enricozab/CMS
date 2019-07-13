<?php
  session_start();
  require_once('../mysql_connect.php');

  $query=
  " INSERT INTO REF_DETAILS
    VALUES ('{$_POST['offenseid']}', '{$_POST['details']}')
  ";

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
