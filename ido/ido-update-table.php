<?php
  session_start();
  require_once('../mysql_connect.php');

  $updateQry = 'UPDATE FORM_UPLOADING
                   SET CLOSURE_UPLOADED = 1
                 WHERE CASE_ID = '.$_POST['caseID'];

  $update = mysqli_query($dbc,$updateQry);
  if(!$update){
    echo mysqli_error($dbc);
  }
?>
