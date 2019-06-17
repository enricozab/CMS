<?php
  session_start();
  require_once('../mysql_connect.php');

  $comment = 'NULL';
  if($_POST['comment'] != null){
    $comment = "'".$_POST['comment']."'";
  }

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=4, COMMENT=$comment WHERE CASE_ID = {$_POST['caseID']}";
  echo $query;
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }

  $query2="INSERT INTO CASE_AUDIT (CASE_ID,ACTION_DONE_ID,ACTION_DONE_BY_ID)
              VALUES ({$_POST['caseID']},5,'{$_SESSION['user_id']}')";
  $result2=mysqli_query($dbc,$query2);
  if(!$result2){
    echo mysqli_error($dbc);
  }
?>
