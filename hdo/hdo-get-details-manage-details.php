<?php
  session_start();
  require_once('../mysql_connect.php');

  $genquery=
            "SELECT DETAILS
            FROM REF_DETAILS
            WHERE OFFENSE_ID = '{$_POST['offense']}'
            ";
  $genresult=mysqli_query($dbc,$genquery);
  if(!$genresult){
    echo mysqli_error($dbc);
  }
  else{
    while($row=mysqli_fetch_array($genresult,MYSQLI_ASSOC)){
      $rows['detailsarray'][] = $row;
    }
    echo json_encode($rows);
  }
?>