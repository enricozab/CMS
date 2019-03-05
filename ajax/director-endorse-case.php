<?php
  session_start();
  require_once('../mysql_connect.php');

  $penalty = 'NULL';
  if($_POST['penalty'] != null){
    $penalty = $_POST['penalty'];
  }

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=6, PENALTY_ID=$penalty WHERE CASE_ID = {$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }

  $query="INSERT INTO CASE_REFERRAL_FORMS (CASE_ID,PROCEEDINGS)
            VALUES ({$_POST['caseID']},{$_POST['proceeding']})";

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }

  $prquery = "SELECT *
              FROM   REF_CASE_PROCEEDINGS RCP
              WHERE  RCP.CASE_PROCEEDINGS_ID = {$_POST['proceeding']}";
  $prres=mysqli_query($dbc,$prquery);
  if(!$prres){
    echo mysqli_error($dbc);
  }
  else{
    $prrow=mysqli_fetch_array($prres,MYSQLI_ASSOC);
    echo $prrow['proceedings_desc'];
  }
?>
