<?php
  session_start();
  require_once('../mysql_connect.php');

  if ($_POST['checker'] == '1') {
    $query=
    " UPDATE USERS
      SET ACTIVE = 1
      WHERE USER_ID = '{$_POST['idnum']}'
    ";
  }
  else if ($_POST['checker'] == '2') {
    $query=
    " UPDATE USERS
      SET ACTIVE = 2
      WHERE USER_ID = '{$_POST['idnum']}'
    ";
  }

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
