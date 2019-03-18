<?php
  session_start();
  require_once('../mysql_connect.php');

  $rem = [];
  foreach ($_POST['dRemarks'] as $remark) {
    array_push($rem, $remark);
    $query="INSERT INTO DIRECTOR_REMARKS_LIST
              VALUES ({$_POST['caseID']},$remark)";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }

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

  $remdesc = [];
  foreach ($rem as $remark) {
    $query="SELECT DIRECTOR_REMARKS FROM REF_DIRECTOR_REMARKS WHERE DIRECTOR_REMARKS_ID = $remark";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
    else{
      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
      array_push($remdesc, $row['DIRECTOR_REMARKS']);
    }
  }

  echo implode(", ", $remdesc);
?>
