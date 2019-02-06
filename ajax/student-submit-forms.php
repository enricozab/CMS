<?php
  session_start();
  require_once('../mysql_connect.php');

  echo "<script>console.log('kdfjsdkfjsdfjskdf');</script>";

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=3 WHERE CASE_ID = {$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo 'mysqli_error($dbc)';
  }
?>
