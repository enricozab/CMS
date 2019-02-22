<?php
  session_start();
  require_once('../mysql_connect.php');

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=3 WHERE CASE_ID = {$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }

  if ($_POST['admission'] == "Full Admission") {
    $query="UPDATE CASES SET ADMISSION_TYPE_ID=1 WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }

  else if ($_POST['admission'] == "Full Denial") {
    $query="UPDATE CASES SET ADMISSION_TYPE_ID=3 WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }

  else {
    $query="UPDATE CASES SET ADMISSION_TYPE_ID=2 WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }

  if ($_POST['remarks'] == 4) { // IF FOR REVIEWW

    $query="UPDATE STUDENT_RESPONSE_FORMS SET RESPONSE = {$_POST['response']} WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }

  }

  else {

    $query="INSERT INTO STUDENT_RESPONSE_FORMS (CASE_ID, REPORTED_STUDENT_ID, TERM, SCHOOL_YEAR, RESPONSE)
              VALUES ('{$_POST['caseID']}', '{$_SESSION['user_id']}',  '{$_POST['term']}', '{$_POST['schoolyr']}', '{$_POST['response']}')";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }

  }
?>
