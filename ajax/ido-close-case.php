<?php
  session_start();
  require_once('../mysql_connect.php');

  if(isset($_POST['admission'])) {
    $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=3, REMARKS_ID=11, PENALTY='{$_POST['penalty']}', ADMISSION_TYPE_ID={$_POST['admission']}, DATE_CLOSED=CURRENT_TIMESTAMP() WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }
  else {
    $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=3, REMARKS_ID=11, PENALTY='{$_POST['penalty']}', DATE_CLOSED = CURRENT_TIMESTAMP() WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }
?>
