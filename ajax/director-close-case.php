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

  $pen = 'NULL';
  if($_POST['penalty'] == "Warning will be given") {
    $pen = 1;
  }
  elseif ($_POST['penalty'] == "Reprimand will be given") {
    $pen = 2;
  }
  elseif ($_POST['penalty'] == "Student will be referred to University Councelor") {
    $pen = 3;
  }
  elseif ($_POST['penalty'] == "No penalty will be given") {
    $pen = 4;
  }

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=3, REMARKS_ID=11, PENALTY_ID=$pen, DATE_CLOSED = CURRENT_TIMESTAMP() WHERE CASE_ID = {$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
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
