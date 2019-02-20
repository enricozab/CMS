<?php
  session_start();
  require_once('../mysql_connect.php');

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=3 WHERE CASE_ID = {$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }

  $query="INSERT INTO STUDENT_RESPOSE_FORMS (CASE_ID, REPORTED_STUDENT_ID, ADMISSION_TYPE, TERM, SCHOOL_YEAR, RESPONSE)
            VALUES ('{$_POST['caseID']}', '{$_SESSION['user_id']}',  '{$_POST['admission']}', '{$_POST['term']}', '{$_POST['schoolyr']}', '{$_POST['response']}')";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
