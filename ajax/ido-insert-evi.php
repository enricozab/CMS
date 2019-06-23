<?php
  session_start();
  require_once('../mysql_connect.php');

  if ($_POST['submittedBy'] == 0) {
    $newQry = "INSERT INTO SUBMITTED_EVIDENCE (SUBMITTED_BY_ID, EVIDENCE_TYPE, IDO_ID)
                    VALUES ({$_POST['submittedBy']}, {$_POST['evidence']}, {$_POST['idoID']});";

  }

  else {
    $newQry = "INSERT INTO SUBMITTED_EVIDENCE (SUBMITTED_BY_ID, UPLOADED_BY_NAME, EVIDENCE_TYPE, IDO_ID)
                    VALUES ({$_POST['submittedBy']}, '{$_POST['sName']}', {$_POST['evidence']}, '{$_POST['idoID']}');";
  }
  
  $newResult = mysqli_query($dbc,$newQry);

  if(!$newResult){
    echo mysqli_error($dbc);
  }

?>