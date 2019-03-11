<?php
  session_start();
  require_once('../mysql_connect.php');

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=3, REMARKS_ID=11, PENALTY_ID={$_POST['penalty']}, DATE_CLOSED = CURRENT_TIMESTAMP() WHERE CASE_ID = {$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }

  $query="SELECT * FROM REF_PENALTIES WHERE PENALTY_ID={$_POST['penalty']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else{
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    echo $row['penalty_desc'];
  }
?>
