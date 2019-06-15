<?php
  session_start();
  require_once('../mysql_connect.php');

  // $newQry = "INSERT INTO SUBMITTED_EVIDENCE (CASE_ID, SUBMITTED_BY_ID, IDO_ID, COMMENTS)
  //                   VALUES			       (79, '11525045', '20121234', 'hveqfa')";

  $newQry = "INSERT INTO SUBMITTED_EVIDENCE (CASE_ID, SUBMITTED_BY_ID, IDO_ID, COMMENTS)
                VALUES ({$_POST['caseID']}, '{$_POST['submittedBy']}', '{$_POST['idoID']}', '{$_POST['comment']}');";

  $newResult = mysqli_query($dbc,$newQry);

  if(!$newResult){
    echo mysqli_error($dbc);
  }

?>