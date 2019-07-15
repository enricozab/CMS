<?php
  session_start();
  require_once('../mysql_connect.php');

  $genquery=
            "SELECT 
              FIRST_NAME
              , LAST_NAME
              , EMAIL
              , USER_TYPE_ID
              , OFFICE_ID
            FROM USERS a
            WHERE USER_ID = '{$_POST['userid']}'
            ";
  $genresult=mysqli_query($dbc,$genquery);
  if(!$genresult){
    echo mysqli_error($dbc);
  }
  else{
    $response = mysqli_fetch_array($genresult,MYSQLI_ASSOC);
    echo json_encode($response);
  }
?>