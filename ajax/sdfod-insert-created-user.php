<?php
  session_start();
  require_once('../mysql_connect.php');

  $query=
  " INSERT INTO USERS (USER_ID, FIRST_NAME, LAST_NAME, EMAIL, USER_TYPE_ID, OFFICE_ID, ACTIVE)
    VALUES ('{$_POST['idnum']}', '{$_POST['firstname']}', '{$_POST['lastname']}', '{$_POST['email']}', '{$_POST['usertype']}', '{$_POST['office']}', 1)
  ";

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
