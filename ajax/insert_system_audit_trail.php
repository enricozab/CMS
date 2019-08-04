<?php
    session_start();
    require_once('../mysql_connect.php');
  
    $query=
    " INSERT INTO SYSTEM_AUDIT_TRAIL (USER_ID, ACTION_DONE, TIMESTAMP)
      VALUES ('{$_POST['userid']}', '{$_POST['actiondone']}', CURRENT_TIMESTAMP())
    ";
  
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }

?>