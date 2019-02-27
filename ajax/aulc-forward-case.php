<?php
  session_start();
  require_once('../mysql_connect.php');

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=8 WHERE CASE_ID = {$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }

  // INSERT REFERRAL FORM TO DB

  else if($_POST['nature'] == "Formal Hearing") {

    $query="INSERT INTO CASE_REFERRAL_FORMS (CASE_ID, CASE_DECISION, REASON, PROCEEDINGS, AULC_REMARKS)
                 VALUES ('{$_POST['caseID']}', '{$_POST['decision']}',  '{$_POST['reason']}', 1, '{$_POST['remark']}')";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }

  }

  else if($_POST['nature'] == "Summary Proceedings") {

    $query="INSERT INTO CASE_REFERRAL_FORMS (CASE_ID, CASE_DECISION, REASON, PROCEEDINGS, AULC_REMARKS)
                 VALUES ('{$_POST['caseID']}', '{$_POST['decision']}',  '{$_POST['reason']}', 2, '{$_POST['remark']}')";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }

  }

  else if($_POST['nature'] == "University Panel for Case Conference") {

    $query="INSERT INTO CASE_REFERRAL_FORMS (CASE_ID, CASE_DECISION, REASON, PROCEEDINGS, AULC_REMARKS)
                 VALUES ('{$_POST['caseID']}', '{$_POST['decision']}',  '{$_POST['reason']}', 3, '{$_POST['remark']}')";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }

  }

  else {

    $query="INSERT INTO CASE_REFERRAL_FORMS (CASE_ID, CASE_DECISION, REASON, PROCEEDINGS, AULC_REMARKS)
                 VALUES ('{$_POST['caseID']}', '{$_POST['decision']}',  '{$_POST['reason']}', 4, '{$_POST['remark']}')";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }

  }
?>
