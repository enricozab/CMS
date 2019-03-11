<?php
  session_start();
  require_once('../mysql_connect.php');

  if($_POST['decision'] == "File Case") {
    $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=3, REMARKS_ID=11, DATE_CLOSED=CURRENT_TIMESTAMP() WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }
  else {
    $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=7 WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }
?>
