<?php
  session_start();
  require_once('../mysql_connect.php');

  $comment = 'NULL';
  if($_POST['comment'] != null){
    $comment = "'".$_POST['comment']."'";
  }

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=4 WHERE CASE_ID = {$_POST['caseID']}";
  echo $query;
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
