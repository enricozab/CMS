<?php
  session_start();
  require_once('../mysql_connect.php');

  $query = "SELECT HANDLED_BY_ID
            FROM CASES
            WHERE CASE_ID = '{$_POST['case_id']}'";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else{
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    $prevHandler = $row['HANDLED_BY_ID'];

    $query = "UPDATE CASES 
              SET HANDLED_BY_ID = '{$_POST['ido_id']}'
              WHERE CASE_ID = '{$_POST['case_id']}'";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
    else {
      $query = "UPDATE IDO_CASES 
                SET HANDLE = 0
                WHERE CASE_ID = '{$_POST['case_id']}'
                      AND USER_ID = ".$prevHandler;
      $result=mysqli_query($dbc,$query);
      if(!$result){
        echo mysqli_error($dbc);
      }
      else {
        $query="SELECT *
                FROM IDO_CASES
                WHERE CASE_ID = '{$_POST['case_id']}' AND USER_ID = '{$_POST['ido_id']}'";
        $result=mysqli_query($dbc,$query);
        if(!$result){
          echo mysqli_error($dbc);
        }
        else{
          $count = $result->num_rows;
          
          if($count <= 0){
            $query="INSERT INTO IDO_CASES 
                      VALUES ('{$_POST['ido_id']}','{$_POST['case_id']}',1,1)";
            $result=mysqli_query($dbc,$query);
            if(!$result){
              echo mysqli_error($dbc);
            }
          }
          else{
            $query = "UPDATE IDO_CASES 
                      SET HANDLE = 1
                      WHERE CASE_ID = '{$_POST['case_id']}'
                            AND USER_ID = '{$_POST['ido_id']}'";
            $result=mysqli_query($dbc,$query);
            if(!$result){
              echo mysqli_error($dbc);
            }
          }
        }
      }
    }
  }
?>
