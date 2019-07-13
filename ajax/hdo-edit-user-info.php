<?php
  session_start();
  require_once('../mysql_connect.php');

  $query=
  " UPDATE USERS
    SET FIRST_NAME = '{$_POST['firstname']}', LAST_NAME = '{$_POST['lastname']}', EMAIL = '{$_POST['email']}', USER_TYPE_ID = '{$_POST['usertype']}', PHONE = '{$_POST['number']}', OFFICE_ID = '{$_POST['office']}'
    WHERE USER_ID = '{$_POST['idnum']}'
  ";

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
