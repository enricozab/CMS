<?php
  session_start();
  require_once('../mysql_connect.php');

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=4, REMARKS_ID=10, PENALTY_ID=1, DATE_CLOSED = CURRENT_TIMESTAMP() WHERE CASE_ID = {$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
