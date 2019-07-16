<?php
  session_start();
  require_once('../mysql_connect.php');

  $query=
  " UPDATE cases 
    SET 
      admission_type_id = '{$_POST['admission']}'
      , penalty_id = '{$_POST['penalty']}'
      , proceeding_decision = '{$_POST['pdesc']}'
      , verdict = '{$_POST['verdict']}'
      , if_new = 3
    WHERE case_id = '{$_POST['caseid']}';
  ";

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
