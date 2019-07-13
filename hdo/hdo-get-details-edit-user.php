<?php
  session_start();
  require_once('../mysql_connect.php');

  $genquery=
            "SELECT 
              FIRST_NAME, LAST_NAME, EMAIL
              , USER_TYPE_ID
              -- , b.description as USER_TYPE
              , PHONE
              , OFFICE_ID
              -- , c.description as USER_OFFICE
            FROM USERS a
            -- INNER JOIN ref_user_types b on a.user_type_id = b.user_type_id
            -- INNER JOIN ref_user_office c on a.office_id = c.office_id
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