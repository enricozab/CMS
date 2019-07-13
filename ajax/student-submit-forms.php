<?php
  session_start();
  require_once('../mysql_connect.php');

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, ADMISSION_TYPE_ID={$_POST['admission']}, REMARKS_ID=2 WHERE CASE_ID = {$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  
  if ($_POST['remarks'] == 4) { // IF FOR REVIEWW
    $query="UPDATE STUDENT_RESPONSE_FORMS SET SCHOOL_YEAR = '{$_POST['schoolyr']}', TERM = {$_POST['term']}, RESPONSE = '{$_POST['response']}' WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
    else {
      $query2="INSERT INTO CASE_AUDIT (CASE_ID,ACTION_DONE_ID,ACTION_DONE_BY_ID)
              VALUES ({$_POST['caseID']},6,'{$_SESSION['user_id']}')";
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo mysqli_error($dbc);
      }
    }
  }
  else {
    $query="INSERT INTO STUDENT_RESPONSE_FORMS (CASE_ID, REPORTED_STUDENT_ID, TERM, SCHOOL_YEAR, RESPONSE)
              VALUES ('{$_POST['caseID']}', '{$_SESSION['user_id']}', '{$_POST['term']}', '{$_POST['schoolyr']}', '{$_POST['response']}')";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
    else {
      $query2="INSERT INTO CASE_AUDIT (CASE_ID,ACTION_DONE_ID,ACTION_DONE_BY_ID)
              VALUES ({$_POST['caseID']},3,'{$_SESSION['user_id']}')";
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo mysqli_error($dbc);
      }
    }
  }
?>
